package dto

import (
	"time"

	"github.com/fagiantz/InkSpire/backend/database/models"
)

type RegisterRequest struct {
	Email    string `json:"email" binding:"required,email"`
	Password string `json:"password" binding:"required,min=6"`
	Name     string `json:"name" binding:"required"`
	Role     string `json:"role" binding:"omitempty,oneof=user admin"`
}

type LoginRequest struct {
	Email    string `json:"email" binding:"required,email"`
	Password string `json:"password" binding:"required"`
}

type LoginResponse struct {
	Token string       `json:"token"`
	User  UserResponse `json:"user"`
}

type UserResponse struct {
	ID        uint      `json:"id"`
	Email     string    `json:"email"`
	Name      string    `json:"name"`
	Role      string    `json:"role"`
	CreatedAt time.Time `json:"created_at"`
}

func (r UserResponse) ToResponse(akun *models.Akun) UserResponse {
	return UserResponse{
		ID:        akun.ID,
		Email:     akun.Email,
		Name:      akun.Name,
		Role:      akun.Role,
		CreatedAt: akun.CreatedAt,
	}
}
