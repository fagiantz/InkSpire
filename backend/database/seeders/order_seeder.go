package seeders

import (
	"log"
	"time"

	"github.com/fagiantz/InkSpire/backend/database/models"
	"gorm.io/gorm"
)

// SeedOrder generates initial dummy orders and their items if none exist
func SeedOrder(db *gorm.DB) {
	var count int64
	db.Model(&models.Order{}).Count(&count)
	if count > 0 {
		return // Skip if orders already exist
	}

	var products []models.Produk
	if err := db.Limit(2).Find(&products).Error; err != nil || len(products) == 0 {
		log.Println("Cannot seed orders: No products available")
		return
	}

	harga1 := products[0].Harga * 2
	totalHarga := harga1

	orderItems := []models.OrderItem{
		{
			ProdukID:   products[0].Id_produk,
			Kuantitas:  2,
			HargaOrder: harga1,
		},
	}

	if len(products) > 1 {
		harga2 := products[1].Harga * 1
		totalHarga += harga2
		orderItems = append(orderItems, models.OrderItem{
			ProdukID:   products[1].Id_produk,
			Kuantitas:  1,
			HargaOrder: harga2,
		})
	}

	dummyOrders := []models.Order{
		{
			TotalHarga:   totalHarga,
			Status:       "process",
			EmailPembeli: "user1@example.com",
			OrderDate:    time.Now().Add(-24 * time.Hour), // yesterday
			OrderItems:   orderItems,
		},
		{
			TotalHarga:   products[0].Harga * 5,
			Status:       "unpaid",
			EmailPembeli: "user2@example.com",
			OrderDate:    time.Now().Add(-2 * time.Hour),
			OrderItems: []models.OrderItem{
				{
					ProdukID:   products[0].Id_produk,
					Kuantitas:  5,
					HargaOrder: products[0].Harga * 5,
				},
			},
		},
	}

	for _, order := range dummyOrders {
		if err := db.Create(&order).Error; err != nil {
			log.Printf("Failed to seed order for %s: %v", order.EmailPembeli, err)
		} else {
			log.Printf("Seeded new order for %s with total Rp%.2f", order.EmailPembeli, order.TotalHarga)
		}
	}
}
