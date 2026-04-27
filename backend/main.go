package main

import (
	"log"
	"os"

	"github.com/fagiantz/InkSpire/backend/api"
	"github.com/fagiantz/InkSpire/backend/database"
	"github.com/joho/godotenv"
)

func main() {
	if err := godotenv.Load(); err != nil {
		log.Println("No .env file found, using system environment variables")
	}

	database.ConnectDB()

	port := os.Getenv("PORT")
	if port == "" {
		port = "8080"
	}
	r := api.SetupRouter()

	log.Printf("Starting Gin server on :%s\n", port)
	if err := r.Run(":" + port); err != nil {
		log.Fatalf("Server forced to shutdown with error: %v", err)
	}
}
