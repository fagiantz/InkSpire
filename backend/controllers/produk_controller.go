package controllers

import (
	"net/http"

	"github.com/fagiantz/InkSpire/backend/services"
	"github.com/gin-gonic/gin"
)

type ProdukController struct {
	produkService *services.ProdukService
}

func NewProdukController(produkService *services.ProdukService) *ProdukController {
	return &ProdukController{produkService: produkService}
}

// GetAll handles the request to fetch all available products
func (c *ProdukController) GetAll(ctx *gin.Context) {
	produks, err := c.produkService.GetAllProduk()
	if err != nil {
		ctx.JSON(http.StatusInternalServerError, gin.H{"error": "Failed to retrieve products"})
		return
	}

	ctx.JSON(http.StatusOK, gin.H{
		"message": "Products retrieved successfully",
		"data":    produks,
	})
}

// GetById intercepts dynamic paths like /:id to query a single item
func (c *ProdukController) GetById(ctx *gin.Context) {
	id := ctx.Param("id")

	produk, err := c.produkService.GetProdukById(id)
	if err != nil {
		ctx.JSON(http.StatusNotFound, gin.H{"error": "Product not found"})
		return
	}

	ctx.JSON(http.StatusOK, gin.H{
		"message": "Product retrieved successfully",
		"data":    produk,
	})
}
