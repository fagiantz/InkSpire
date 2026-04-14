package models

import (
	"time"

	"gorm.io/gorm"
)

type OrderItem struct {
	IdOrderItem uint    `gorm:"primaryKey" json:"id_order_item"`
	IdPesanan   uint    `gorm:"not null" json:"id_pesanan"`
	IdProduk    string  `gorm:"not null" json:"id_produk"`
	Kuantitas   int     `gorm:"not null" json:"kuantitas"`
	HargaOrder  float64 `gorm:"not null" json:"harga_order"`

	CreatedAt time.Time `json:"created_at"`
	UpdatedAt time.Time `json:"updated_at"`
}

func (oi *OrderItem) TableName() string {
	return "order_items"
}

func (oi *OrderItem) Create(db *gorm.DB) error {
	return db.Create(oi).Error
}
