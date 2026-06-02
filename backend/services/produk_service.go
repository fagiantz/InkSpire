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

func (s *ProdukService) GetProdukById(id uint) (*dto.ProdukResponse, error) {
	produkModel := &models.Produk{}
	produk, err := produkModel.GetDetail(s.db, id)
	if err != nil {
		return nil, err
	}

	response := dto.ProdukResponse{}.ToResponse(*produk)
	return &response, nil
}

func (s *ProdukService) CreateProduk(req dto.CreateProdukRequest) (*dto.ProdukResponse, error) {
	produk := models.Produk{
		Nama_produk: req.NamaProduk,
		Harga:       req.Harga,
	}

	if err := produk.Create(s.db); err != nil {
		return nil, err
	}

	response := dto.ProdukResponse{}.ToResponse(produk)
	return &response, nil
}

func (s *ProdukService) UpdateProduk(id uint, req dto.UpdateProdukRequest) (*dto.ProdukResponse, error) {
	produkModel := &models.Produk{}

	existing, err := produkModel.GetDetail(s.db, id)
	if err != nil {
		return nil, err
	}

	namaToUpdate := existing.Nama_produk
	if req.NamaProduk != "" {
		namaToUpdate = req.NamaProduk
	}

	if err := produkModel.Update(s.db, id, namaToUpdate, req.Harga); err != nil {
		return nil, err
	}

	return s.GetProdukById(id)
}

func (s *ProdukService) DeleteProduk(id uint) error {
	produkModel := &models.Produk{}
	return produkModel.Delete(s.db, id)
}
