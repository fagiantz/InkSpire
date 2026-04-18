package main

import (
	"log"

	"github.com/fagiantz/InkSpire/backend/api"
	"github.com/fagiantz/InkSpire/backend/database"
)

func main() {
	database.ConnectDB()

	r := api.SetupRouter()

	log.Println("Starting Gin server on :8080...")
	if err := r.Run(":8080"); err != nil {
		log.Fatalf("Server forced to shutdown with error: %v", err)
	}
}
