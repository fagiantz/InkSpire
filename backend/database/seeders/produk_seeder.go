package seeders

import (
	"log"

	"github.com/fagiantz/InkSpire/backend/database/models"
	"gorm.io/gorm"
)

// SeedProduk generates 10 initial dummy products if they don't already exist
func SeedProduk(db *gorm.DB) {
	dummyProduk := []models.Produk{
		{Nama_produk: "Premium Black Ink 50ml", Harga: 75000},
		{Nama_produk: "Ocean Blue Ink 50ml", Harga: 75000},
		{Nama_produk: "Crimson Red Ink 50ml", Harga: 75000},
		{Nama_produk: "Classic Fountain Pen - Silver", Harga: 250000},
		{Nama_produk: "Classic Fountain Pen - Gold", Harga: 300000},
		{Nama_produk: "Calligraphy Pen Set with 3 Nibs", Harga: 150000},
		{Nama_produk: "A5 Leather Bound Journal", Harga: 120000},
		{Nama_produk: "High-Grade Calligraphy Paper Pad", Harga: 45000},
		{Nama_produk: "Pen Cleaning Solution 100ml", Harga: 55000},
		{Nama_produk: "Vintage Wooden Pen Rest", Harga: 35000},
	}

	for _, produk := range dummyProduk {
		var existing models.Produk

		// Check if product already exists via name to avoid duplicates on re-runs
		if err := db.Where("nama_produk = ?", produk.Nama_produk).First(&existing).Error; err != nil {
			// Id_produk will be generated automatically by the BeforeCreate hook
			if err := db.Create(&produk).Error; err != nil {
				log.Printf("Failed to seed product '%s': %v", produk.Nama_produk, err)
			} else {
				log.Printf("Seeded new product: %s - Rp%.2f", produk.Nama_produk, produk.Harga)
			}
		}
	}
}
