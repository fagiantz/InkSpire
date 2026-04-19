package database

import (
	"log"
	"os"

	"github.com/fagiantz/InkSpire/backend/database/models"
	"gorm.io/driver/mysql"
	"gorm.io/gorm"
)

var DB *gorm.DB

func ConnectDB() {
	dsn := "root:@tcp(127.0.0.1:3306)/inkspire?charset=utf8mb4&parseTime=True&loc=Local"
	if dbURL := os.Getenv("DATABASE_URL"); dbURL != "" {
		dsn = dbURL
	}

	database, err := gorm.Open(mysql.Open(dsn), &gorm.Config{})
	if err != nil {
		log.Fatalf("Failed to connect to database: %v", err)
	}

	err = database.AutoMigrate(
		&models.Akun{},
		&models.Produk{},
		&models.Order{},
		&models.OrderItem{},
	)
	if err != nil {
		log.Fatalf("Failed to migrate database: %v", err)
	}

	DB = database
	log.Println("Database connection established")
}
