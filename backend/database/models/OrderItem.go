package models

import (
	"gorm.io/gorm"
)

type OrderItem struct {
	IdOrderItem uint    `gorm:"primaryKey" json:"id_order_item"`
	OrderID     uint    `gorm:"column:id_pesanan;not null;index" json:"id_pesanan"`
	ProdukID    uint    `gorm:"column:id_produk;not null;index" json:"id_produk"`
	Kuantitas   int     `gorm:"not null" json:"kuantitas"`
	HargaOrder  float64 `gorm:"not null" json:"harga_order"`
	Produk      *Produk `gorm:"foreignKey:ProdukID;references:Id_produk" json:"produk,omitempty"`
}

func (oi *OrderItem) TableName() string {
	return "order_items"
}

func (oi *OrderItem) Create(db *gorm.DB) error {
	return db.Create(oi).Error
}
