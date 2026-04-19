package controllers

import (
	"net/http"

	"github.com/fagiantz/InkSpire/backend/dto"
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

// Create handles POST requests to insert new products (requires staff)
func (c *ProdukController) Create(ctx *gin.Context) {
	var req dto.CreateProdukRequest
	if err := ctx.ShouldBindJSON(&req); err != nil {
		ctx.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}

	produk, err := c.produkService.CreateProduk(req)
	if err != nil {
		ctx.JSON(http.StatusInternalServerError, gin.H{"error": "Failed to create product"})
		return
	}

	ctx.JSON(http.StatusCreated, gin.H{
		"message": "Product created successfully",
		"data":    produk,
	})
}

// Update handles PUT requests to modify existing products (requires staff)
func (c *ProdukController) Update(ctx *gin.Context) {
	id := ctx.Param("id")
	var req dto.UpdateProdukRequest
	if err := ctx.ShouldBindJSON(&req); err != nil {
		ctx.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}

	produk, err := c.produkService.UpdateProduk(id, req)
	if err != nil {
		ctx.JSON(http.StatusInternalServerError, gin.H{"error": "Failed to update product"})
		return
	}

	ctx.JSON(http.StatusOK, gin.H{
		"message": "Product updated successfully",
		"data":    produk,
	})
}

// Delete handles DELETE requests to remove a product (requires staff)
func (c *ProdukController) Delete(ctx *gin.Context) {
	id := ctx.Param("id")

	err := c.produkService.DeleteProduk(id)
	if err != nil {
		ctx.JSON(http.StatusInternalServerError, gin.H{"error": "Failed to delete product"})
		return
	}

	ctx.JSON(http.StatusOK, gin.H{
		"message": "Product deleted successfully",
	})
}
