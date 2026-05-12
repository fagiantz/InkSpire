package controllers

import (
	"net/http"
	"os"
	"path/filepath"
	"strconv"

	"github.com/fagiantz/InkSpire/backend/dto"
	"github.com/fagiantz/InkSpire/backend/services"
	"github.com/gin-gonic/gin"

	"github.com/fagiantz/InkSpire/backend/database"
	"github.com/fagiantz/InkSpire/backend/database/models"
)

type OrderController struct {
	orderService *services.OrderService
}

func NewOrderController(orderService *services.OrderService) *OrderController {
	return &OrderController{orderService: orderService}
}

func (c *OrderController) CreateOrder(ctx *gin.Context) {
	userIDVal, exists := ctx.Get("userID")
	if !exists {
		ctx.JSON(http.StatusUnauthorized, gin.H{"error": "Unauthorized missing user context"})
		return
	}
	userID := userIDVal.(uint)

	var req dto.CreateOrderRequest
	if err := ctx.ShouldBindJSON(&req); err != nil {
		ctx.JSON(http.StatusBadRequest, gin.H{"error": "Invalid JSON format: " + err.Error()})
		return
	}

	order, err := c.orderService.CreateOrder(userID, req)
	if err != nil {
		ctx.JSON(http.StatusInternalServerError, gin.H{"error": "Data execution halted: " + err.Error()})
		return
	}

	ctx.JSON(http.StatusCreated, gin.H{
		"message": "Order created successfully",
		"data":    order,
	})
}

func (c *OrderController) UpdateStatus(ctx *gin.Context) {
	idParam := ctx.Param("id")
	id, err := strconv.ParseUint(idParam, 10, 32)
	if err != nil {
		ctx.JSON(http.StatusBadRequest, gin.H{"error": "The targeted 'id' segment must be formatted numerically"})
		return
	}

	var req dto.UpdateStatusRequest
	if err := ctx.ShouldBindJSON(&req); err != nil {
		ctx.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}

	if err := c.orderService.UpdateOrderStatus(uint(id), req.Status); err != nil {
		ctx.JSON(http.StatusInternalServerError, gin.H{"error": "A fatal exception prevented status override application"})
		return
	}

	ctx.JSON(http.StatusOK, gin.H{"message": "Order status changed cleanly"})
}

func (c *OrderController) GetActiveOrders(ctx *gin.Context) {
	orders, err := c.orderService.GetActiveOrders()
	if err != nil {
		ctx.JSON(http.StatusInternalServerError, gin.H{"error": "Failed to retrieve active orders"})
		return
	}

	ctx.JSON(http.StatusOK, gin.H{
		"message": "Active orders retrieved successfully",
		"data":    orders,
	})
}

func (c *OrderController) GetMyActiveOrders(ctx *gin.Context) {
	userIDVal, exists := ctx.Get("userID")
	if !exists {
		ctx.JSON(http.StatusUnauthorized, gin.H{"error": "Unauthorized user context"})
		return
	}
	userID := userIDVal.(uint)

	orders, err := c.orderService.GetActiveOrdersByUserID(userID)
	if err != nil {
		ctx.JSON(http.StatusInternalServerError, gin.H{"error": "Failed to retrieve your active orders"})
		return
	}

	ctx.JSON(http.StatusOK, gin.H{
		"message": "Your active orders retrieved successfully",
		"data":    orders,
	})
}

// func (c *OrderController) GetAdminStats(ctx *gin.Context) {
// 	stats, err := c.orderService.GetAdminStats()
// 	if err != nil {
// 		ctx.JSON(http.StatusInternalServerError, gin.H{"error": "Failed to retrieve stats"})
// 		return
// 	}
// 	ctx.JSON(http.StatusOK, gin.H{"data": stats})
// }

func (c *OrderController) UploadReceipt(ctx *gin.Context) {
	idParam := ctx.Param("id")
	orderID, err := strconv.ParseUint(idParam, 10, 32)
	if err != nil {
		ctx.JSON(http.StatusBadRequest, gin.H{"error": "Invalid order ID format"})
		return
	}

	order, err := c.orderService.GetOrderById(uint(orderID))
	if err != nil {
		ctx.JSON(http.StatusNotFound, gin.H{"error": "Order not found"})
		return
	}

	file, err := ctx.FormFile("receipt")
	if err != nil {
		ctx.JSON(http.StatusBadRequest, gin.H{"error": "Receipt image is required"})
		return
	}

	ext := filepath.Ext(file.Filename)
	filename := order.NoPesanan + ext
	savePath := filepath.Join("transaction_receipts", filename)

	if err := os.MkdirAll("transaction_receipts", os.ModePerm); err != nil {
		ctx.JSON(http.StatusInternalServerError, gin.H{"error": "Failed to create directory"})
		return
	}

	if err := ctx.SaveUploadedFile(file, savePath); err != nil {
		ctx.JSON(http.StatusInternalServerError, gin.H{"error": "Failed to save file"})
		return
	}

	if _, err := c.orderService.CreatePaymentRecord(uint(orderID), savePath); err != nil {
		ctx.JSON(http.StatusInternalServerError, gin.H{"error": "Failed to save payment record"})
		return
	}

	ctx.JSON(http.StatusOK, gin.H{
		"message": "Transaction receipt uploaded successfully",
	})
}

func (c *OrderController) UpdateItemQuantity(ctx *gin.Context) {
	orderIDParam := ctx.Param("id")
	orderID, err := strconv.ParseUint(orderIDParam, 10, 32)
	if err != nil {
		ctx.JSON(http.StatusBadRequest, gin.H{"error": "Invalid order ID"})
		return
	}

	itemIDParam := ctx.Param("itemId")
	itemID, err := strconv.ParseUint(itemIDParam, 10, 32)
	if err != nil {
		ctx.JSON(http.StatusBadRequest, gin.H{"error": "Invalid item ID"})
		return
	}

	var req struct {
		Quantity int `json:"quantity" binding:"required,gt=0"`
	}
	if err := ctx.ShouldBindJSON(&req); err != nil {
		ctx.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}

	userIDVal, exists := ctx.Get("userID")
	if !exists {
		ctx.JSON(http.StatusUnauthorized, gin.H{"error": "Unauthorized"})
		return
	}
	userID := userIDVal.(uint)

	// Ambil user
	var user models.Akun
	if err := database.DB.First(&user, userID).Error; err != nil {
		ctx.JSON(http.StatusUnauthorized, gin.H{"error": "User not found"})
		return
	}

	// Ambil order via service
	order, err := c.orderService.GetOrderById(uint(orderID))
	if err != nil {
		ctx.JSON(http.StatusNotFound, gin.H{"error": "Order not found"})
		return
	}

	if order.EmailPembeli != user.Email {
		ctx.JSON(http.StatusForbidden, gin.H{"error": "You can only edit your own orders"})
		return
	}

	if err := c.orderService.UpdateOrderItemQuantity(uint(orderID), uint(itemID), req.Quantity); err != nil {
		ctx.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
		return
	}

	ctx.JSON(http.StatusOK, gin.H{"message": "Quantity updated successfully"})
}
