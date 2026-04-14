package services

import (
	"errors"

	"gorm.io/gorm"

	"github.com/fagiantz/InkSpire/backend/database/models"
	"github.com/fagiantz/InkSpire/backend/dto"
	"github.com/fagiantz/InkSpire/backend/utils"
)

type AuthService struct {
	db *gorm.DB
}

func NewAuthService(db *gorm.DB) *AuthService {
	return &AuthService{db: db}
}

func (s *AuthService) Register(req dto.RegisterRequest) (*dto.UserResponse, error) {
	user := &models.Akun{
		Email:    req.Email,
		Password: req.Password,
		Name:     req.Name,
		Role:     req.Role,
	}

	if user.Role == "" {
		user.Role = "user"
	}

	if err := user.HashPassword(); err != nil {
		return nil, err
	}

	if err := user.Register(s.db); err != nil {
		return nil, err
	}

	response := dto.UserResponse{}.ToResponse(user)
	return &response, nil
}

func (s *AuthService) Login(req dto.LoginRequest) (string, *dto.UserResponse, error) {
	user := &models.Akun{Email: req.Email}

	isValid, err := user.Login(s.db, req.Password)
	if err != nil || !isValid {
		return "", nil, errors.New("invalid credentials")
	}

	token, err := utils.GenerateJWT(user.ID, user.Email, user.Role)
	if err != nil {
		return "", nil, err
	}

	response := dto.UserResponse{}.ToResponse(user)
	return token, &response, nil
}

func (s *AuthService) Logout(token string) error {
	user := &models.Akun{}
	return user.Logout(token)
}
