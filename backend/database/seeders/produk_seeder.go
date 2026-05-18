package seeders

import (
	"log"

	"github.com/fagiantz/InkSpire/backend/database/models"
	"gorm.io/gorm"
)

// SeedProduk generates 10 initial dummy products if they don't already exist
func SeedProduk(db *gorm.DB) {
	dummyProduk := []models.Produk{
		{Nama_produk: "Custom Mug", Harga: 25000, Kategori: "mug", Image_produk: "custom_mug.webp"},
		{Nama_produk: "Stiker", Harga: 10000, Kategori: "sticker", Image_produk: "custom_sticker.jpg"},
		{Nama_produk: "Custom Banner", Harga: 85000, Kategori: "banner", Image_produk: "custom_banner.jpg"},
		{Nama_produk: "Custom Undangan", Harga: 5000, Kategori: "paper", Image_produk: "custom_undangan.jpg"},
		{Nama_produk: "Custom 3D Model", Harga: 300000, Kategori: "model", Image_produk: "custom_3d.webp"},
		{Nama_produk: "Jasa Print 3D Model", Harga: 100000, Kategori: "service", Image_produk: "3d_print_service.webp"},
		{Nama_produk: "Kalender", Harga: 20000, Kategori: "paper", Image_produk: "custom_calendar.jpg"},
		{Nama_produk: "Pin Gantungan Kunci", Harga: 5000, Kategori: "keychain", Image_produk: "custom_ganci.jpg"},
		{Nama_produk: "ID Card / Kartu Pelajar", Harga: 5000, Kategori: "card", Image_produk: "custom_id_card.webp"},
		{Nama_produk: "Name Tag / Nametag", Harga: 5000, Kategori: "card", Image_produk: "custom_nametag.jpg"},
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
