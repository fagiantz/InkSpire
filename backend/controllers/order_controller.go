package controllers

import (
	"net/http"
	"strconv"

	"github.com/fagiantz/InkSpire/backend/dto"
	"github.com/fagiantz/InkSpire/backend/services"
	"github.com/gin-gonic/gin"
)

type OrderController struct {
	orderService *services.OrderService
}

func NewOrderController(orderService *services.OrderService) *OrderController {
	return &OrderController{orderService: orderService}
}

func (c *OrderController) Create(ctx *gin.Context) {
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

	ctx.JSON(http.StatusOK, gin.H{"message": "Order status updated successfully"})
}
