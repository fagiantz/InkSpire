package dto

type OrderItemRequest struct {
	IdProduk  uint `json:"id_produk" binding:"required"`
	Kuantitas int  `json:"kuantitas" binding:"required,gt=0"`
}

type CreateOrderRequest struct {
	Items []OrderItemRequest `json:"items" binding:"required,min=1,dive"`
}

type UpdateStatusRequest struct {
	Status string `json:"status" binding:"required,oneof=done unpaid process"`
}
