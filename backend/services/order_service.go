package services

import (
	"errors"
	"time"

	"github.com/fagiantz/InkSpire/backend/database/models"
	"github.com/fagiantz/InkSpire/backend/dto"
	"gorm.io/gorm"
)

type OrderService struct {
	db *gorm.DB
}

func NewOrderService(db *gorm.DB) *OrderService {
	return &OrderService{db: db}
}

// CreateOrder safely calculates items using a Gorm transaction block
func (s *OrderService) CreateOrder(userID uint, req dto.CreateOrderRequest) (*models.Order, error) {
	var finalOrder models.Order

	err := s.db.Transaction(func(tx *gorm.DB) error {
		var user models.Akun
		if err := tx.First(&user, userID).Error; err != nil {
			return errors.New("user context invalid or not found")
		}

		var totalHarga float64
		var orderItems []models.OrderItem

		for _, item := range req.Items {
			var produk models.Produk
			if err := tx.First(&produk, item.IdProduk).Error; err != nil {
				return errors.New("a product mapped in the cart does not exist")
			}

			hargaOrder := produk.Harga * float64(item.Kuantitas)
			totalHarga += hargaOrder

			orderItems = append(orderItems, models.OrderItem{
				IdProduk:   produk.Id_produk,
				Kuantitas:  item.Kuantitas,
				HargaOrder: hargaOrder,
			})
		}

		newOrder := models.Order{
			TotalHarga:   totalHarga,
			Status:       "unpaid",
			EmailPembeli: user.Email,
			OrderDate:    time.Now(),
		}

		if err := tx.Create(&newOrder).Error; err != nil {
			return err
		}

		for _, oi := range orderItems {
			oi.IdPesanan = newOrder.IdPesanan
			if err := tx.Create(&oi).Error; err != nil {
				return err
			}
		}

		finalOrder = newOrder
		return nil
	})

	if err != nil {
		return nil, err
	}

	return &finalOrder, nil
}

func (s *OrderService) UpdateOrderStatus(orderID uint, status string) error {
	orderModel := &models.Order{}
	return orderModel.UpdateStatus(s.db, orderID, status)
}

func (s *OrderService) GetActiveOrders() ([]models.Order, error) {
	var orders []models.Order
	if err := s.db.Preload("OrderItems").Where("status IN ?", []string{"unpaid", "process"}).Order("order_date desc").Find(&orders).Error; err != nil {
		return nil, err
	}
	return orders, nil
}

func (s *OrderService) GetActiveOrdersByUserID(userID uint) ([]models.Order, error) {
	var user models.Akun
	if err := s.db.First(&user, userID).Error; err != nil {
		return nil, err
	}

	var orders []models.Order
	if err := s.db.Preload("OrderItems").Where("email_pembeli = ? AND status IN ?", user.Email, []string{"unpaid", "process"}).Order("order_date desc").Find(&orders).Error; err != nil {
		return nil, err
	}
	return orders, nil
}

func (s *OrderService) GetAdminStats() (map[string]interface{}, error) {
	var stats = make(map[string]interface{})

	var totalOrders int64
	s.db.Model(&models.Order{}).Count(&totalOrders)
	stats["total_orders"] = totalOrders

	var doneOrders int64
	s.db.Model(&models.Order{}).Where("status = ?", "done").Count(&doneOrders)
	stats["done_orders"] = doneOrders

	today := time.Now().Format("2006-01-02")
	var newOrders int64
	s.db.Model(&models.Order{}).
		Where("status IN ?", []string{"unpaid", "process"}).
		Where("DATE(order_date) = ?", today).
		Count(&newOrders)
	stats["new_orders_today"] = newOrders

	var unpaidToday int64
	s.db.Model(&models.Order{}).
		Where("status = ?", "unpaid").
		Where("DATE(order_date) = ?", today).
		Count(&unpaidToday)
	stats["unpaid_today"] = unpaidToday

	var totalRevenue struct {
		Sum float64
	}
	s.db.Model(&models.Order{}).
		Select("COALESCE(SUM(total_harga), 0) as sum").
		Where("status = ?", "done").
		Scan(&totalRevenue)
	stats["total_revenue"] = totalRevenue.Sum

	return stats, nil
}

func (s *OrderService) GetOrderById(orderID uint) (*models.Order, error) {
	var order models.Order
	if err := s.db.First(&order, orderID).Error; err != nil {
		return nil, err
	}
	return &order, nil
}

func (s *OrderService) CreatePaymentRecord(orderID uint, imagePath string) (*models.Payment, error) {
	payment := &models.Payment{
		IdPesanan: orderID,
		ImagePath: imagePath,
	}

	if err := payment.Create(s.db); err != nil {
		return nil, err
	}

	return payment, nil
}

func (s *OrderService) UpdateOrderItemQuantity(orderID uint, itemID uint, newQuantity int) error {
	if newQuantity < 1 {
		return errors.New("quantity must be at least 1")
	}

	return s.db.Transaction(func(tx *gorm.DB) error {
		var item models.OrderItem
		if err := tx.Where("id_order_item = ? AND id_pesanan = ?", itemID, orderID).First(&item).Error; err != nil {
			return errors.New("order item not found")
		}

		var produk models.Produk
		if err := tx.First(&produk, item.IdProduk).Error; err != nil {
			return errors.New("product not found")
		}

		item.Kuantitas = newQuantity
		item.HargaOrder = produk.Harga * float64(newQuantity)
		if err := tx.Save(&item).Error; err != nil {
			return err
		}

		var total float64
		if err := tx.Model(&models.OrderItem{}).
			Where("id_pesanan = ?", orderID).
			Select("COALESCE(SUM(harga_order), 0)").
			Scan(&total).Error; err != nil {
			return err
		}

		if err := tx.Model(&models.Order{}).Where("id_pesanan = ?", orderID).
			Update("total_harga", total).Error; err != nil {
			return err
		}

		return nil
	})
}