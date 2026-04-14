package models

import (
	"time"

	"github.com/fagiantz/InkSpire/backend/utils"

	"gorm.io/gorm"
)

type Order struct {
	IdPesanan    uint      `gorm:"primaryKey" json:"id_pesanan"`
	TotalHarga   float64   `gorm:"not null" json:"total_harga"`
	Status       string    `gorm:"not null" json:"status"`
	EmailPembeli string    `gorm:"not null" json:"email_pembeli"`
	NoPesanan    string    `gorm:"not null" json:"no_pesanan"`
	OrderDate    time.Time `gorm:"not null" json:"order_date"`

	OrderItems []OrderItem `gorm:"foreignKey:IdPesanan;references:IdPesanan" json:"order_items"`

	CreatedAt time.Time `json:"created_at"`
	UpdatedAt time.Time `json:"updated_at"`
}

func (o *Order) TableName() string {
	return "orders"
}

func (o *Order) BeforeCreate(tx *gorm.DB) (err error) {
	o.NoPesanan = utils.GenerateOrderID()
	return
}

func (o *Order) Create(db *gorm.DB) error {
	return db.Create(o).Error
}
