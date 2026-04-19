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

	orderService := services.NewOrderService(database.DB)
	orderController := controllers.NewOrderController(orderService)

	api := r.Group("/api")

	auth := api.Group("/auth")
	auth.POST("/login", authController.Login)

	protectedAuth := auth.Group("")
	protectedAuth.Use(middleware.AuthMiddleware())
	protectedAuth.POST("/logout", authController.Logout)

	produk := api.Group("/produk")
	produk.GET("", produkController.GetAll)
	produk.GET("/:id", produkController.GetById)

	produkProtected := produk.Group("")
	produkProtected.Use(middleware.AuthMiddleware(), middleware.StaffOnly(database.DB))
	produkProtected.POST("", produkController.Create)
	produkProtected.PUT("/:id", produkController.Update)
	produkProtected.DELETE("/:id", produkController.Delete)

	orderRoute := api.Group("/order")
	orderRoute.Use(middleware.AuthMiddleware())
	{
		orderRoute.POST("", orderController.Create)

		staffProtectedOrder := orderRoute.Group("")
		staffProtectedOrder.Use(middleware.StaffOnly(database.DB))
		{
			staffProtectedOrder.PUT("/:id/status", orderController.UpdateStatus)
		}
	}

	return r
}
