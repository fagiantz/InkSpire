package dto

import "github.com/fagiantz/InkSpire/backend/database/models"

type ProdukResponse struct {
	ID         uint    `json:"id"`
	IdProduk   string  `json:"id_produk"`
	NamaProduk string  `json:"nama_produk"`
	Harga      float64 `json:"harga"`
}

// ToResponse formats a single model into a API-safe response struct
func (ProdukResponse) ToResponse(produk models.Produk) ProdukResponse {
	return ProdukResponse{
		ID:         produk.ID,
		IdProduk:   produk.Id_produk,
		NamaProduk: produk.Nama_produk,
		Harga:      produk.Harga,
	}
}

// ToResponseList formats an array of models into API-safe response structs
func (ProdukResponse) ToResponseList(produks []models.Produk) []ProdukResponse {
	var responses []ProdukResponse
	for _, p := range produks {
		responses = append(responses, ProdukResponse{}.ToResponse(p))
	}
	// Return empty array instead of null if 0 items
	if responses == nil {
		return []ProdukResponse{}
	}
	return responses
}
