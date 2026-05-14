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

