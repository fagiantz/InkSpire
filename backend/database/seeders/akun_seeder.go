package seeders

import (
	"log"

	"github.com/fagiantz/InkSpire/backend/database/models"
	"gorm.io/gorm"
)

// SeedAkun generates the initial dummy accounts if they don't already exist
func SeedAkun(db *gorm.DB) {
	dummyAccounts := []models.Akun{
		{
			Name:     "Staff Member",
			Email:    "staff@example.com",
			Password: "password123",
			Role:     "staff",
		},
		{
			Name:     "First User",
			Email:    "user1@example.com",
			Password: "password123",
			Role:     "user",
		},
		{
			Name:     "Second User",
			Email:    "user2@example.com",
			Password: "password123",
			Role:     "user",
		},
	}

	for _, account := range dummyAccounts {
		var existing models.Akun

		// Check if account already exists via email to avoid duplicate entry errors
		if err := db.Where("email = ?", account.Email).First(&existing).Error; err != nil {
			// Hash the password so the dummy users can actually log in
			account.HashPassword()

			if err := db.Create(&account).Error; err != nil {
				log.Printf("Failed to seed account %s: %v", account.Email, err)
			} else {
				log.Printf("Seeded new account: %s (%s)", account.Email, account.Role)
			}
		}
	}
}
