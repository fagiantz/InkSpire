package seeders

import (
	"log"

	"gorm.io/gorm"
)

// RunAll executes all required database seeders
func RunAll(db *gorm.DB) {
	log.Println("Starting database seeding...")

	SeedAkun(db)
	SeedProduk(db)
	SeedOrder(db)

	log.Println("Database seeding finished.")
}
