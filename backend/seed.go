package main

import (
	"log"

	"github.com/fagiantz/InkSpire/backend/database"
	"github.com/fagiantz/InkSpire/backend/database/seeders"
)

func main() {
	// 1. Initialize DB connection
	// This will use your existing database.ConnectDB logic which includes AutoMigrate
	database.ConnectDB()

	// 2. Run the seeders using the global database.DB connection
	log.Println("Standalone seeding process started...")

	if database.DB == nil {
		log.Fatalf("Database connection is nil. Ensure database.ConnectDB() is working correctly.")
	}

	seeders.RunAll(database.DB)

	log.Println("Database seeding completed successfully!")
}
