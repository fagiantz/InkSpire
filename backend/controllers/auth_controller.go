package controllers

import (
	"net/http"

	// "github.com/fagiantz/InkSpire/backend/database/models"
	"github.com/fagiantz/InkSpire/backend/dto"
	"github.com/fagiantz/InkSpire/backend/services"
	"github.com/gin-gonic/gin"
)

type AuthController struct {
	authService *services.AuthService
}

func NewAuthController(authService *services.AuthService) *AuthController {
	return &AuthController{
		authService: authService,
	}
}

// func (c *AuthController) Register(ctx *gin.Context) {
//     var req dto.RegisterRequest

//     if err := ctx.ShouldBindJSON(&req); err != nil {
//         ctx.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
//         return
//     }

//     user, err := c.authService.Register(req)
//     if err != nil {
//         ctx.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
//         return
//     }

//     ctx.JSON(http.StatusCreated, gin.H{
//         "message": "User registered successfully",
//         "user":    user,
//     })
// }
// func (s *AuthService) Register(req dto.RegisterRequest) (*dto.UserResponse, error) {
//     user := &models.Akun{
//         Email:    req.Email,
//         Password: req.Password,
//         Name:     req.Name,
//         Role:     req.Role,
//     }

//     if user.Role == "" {
//         user.Role = "user"
//     }

//     if err := user.HashPassword(); err != nil {
//         return nil, err
//     }

//     // ✅ Pastikan method ini aktif dan return errornya diambil
//     if err := user.Register(s.db); err != nil {
//         return nil, err
//     }

//     response := dto.UserResponse{}.ToResponse(user)
//     return &response, nil
// }

func (c *AuthController) Login(ctx *gin.Context) {
	var req dto.LoginRequest

	if err := ctx.ShouldBindJSON(&req); err != nil {
		ctx.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}

	token, user, err := c.authService.Login(req)
	if err != nil {
		ctx.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
		return
	}

	ctx.JSON(http.StatusOK, gin.H{
		"message": "User logged in successfully",
		"token":   token,
		"user":    user,
	})
}

func (c *AuthController) Logout(ctx *gin.Context) {
	token := ctx.GetHeader("Authorization")

	if token == "" {
		ctx.JSON(http.StatusBadRequest, gin.H{"error": "No token provided"})
	}

	if len(token) > 7 && token[:7] == "Bearer " {
		token = token[:7]
	}

	if err := c.authService.Logout(token); err != nil {
		ctx.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
	}

	ctx.JSON(http.StatusOK, gin.H{"message": "Logout out successfully"})
}
