package services

import (
	"github.com/fagiantz/InkSpire/backend/database/models"
	"github.com/fagiantz/InkSpire/backend/dto"
	"gorm.io/gorm"
)

type ProdukService struct {
	db *gorm.DB
}

func NewProdukService(db *gorm.DB) *ProdukService {
	return &ProdukService{db: db}
}

func (s *ProdukService) GetAllProduk() ([]dto.ProdukResponse, error) {
	produkModel := &models.Produk{}
	produks, err := produkModel.GetAll(s.db)
	if err != nil {
		return nil, err
	}

	return dto.ProdukResponse{}.ToResponseList(produks), nil
}

func (s *ProdukService) GetProdukById(id string) (*dto.ProdukResponse, error) {
	produkModel := &models.Produk{}
	produk, err := produkModel.GetDetail(s.db, id)
	if err != nil {
		return nil, err
	}

	response := dto.ProdukResponse{}.ToResponse(*produk)
	return &response, nil
}
