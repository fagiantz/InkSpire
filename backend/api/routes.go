package api

import (
	"github.com/fagiantz/InkSpire/backend/controllers"
	"github.com/fagiantz/InkSpire/backend/database"
	"github.com/fagiantz/InkSpire/backend/middleware"
	"github.com/fagiantz/InkSpire/backend/services"
	"github.com/gin-gonic/gin"
)

func SetupRouter() *gin.Engine {
	r := gin.Default()

	r.SetTrustedProxies([]string{"127.0.0.1"})

	authService := services.NewAuthService(database.DB)
	authController := controllers.NewAuthController(authService)

	produkService := services.NewProdukService(database.DB)
	produkController := controllers.NewProdukController(produkService)

	api := r.Group("/api")

	auth := api.Group("/auth")
	auth.POST("/login", authController.Login)

	protectedAuth := auth.Group("")
	protectedAuth.Use(middleware.AuthMiddleware())
	protectedAuth.POST("/logout", authController.Logout)

	produk := api.Group("/produk")
	produk.GET("", produkController.GetAll)
	produk.GET("/:id", produkController.GetById)

	return r
}
