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
