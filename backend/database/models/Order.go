package models

import (
	"time"

	"github.com/fagiantz/InkSpire/backend/utils"

	"gorm.io/gorm"
)

type Order struct {
	IdPesanan    uint      `gorm:"primaryKey" json:"id_pesanan"`
	TotalHarga   float64   `gorm:"not null" json:"total_harga"`
	Status       string    `gorm:"not null;type:enum('done','unpaid','process');default:'unpaid'" json:"status"`
	EmailPembeli string    `gorm:"not null;type:varchar(255)" json:"email_pembeli"`
	NoPesanan    string    `gorm:"not null;type:varchar(255)" json:"no_pesanan"`
	OrderDate    time.Time `gorm:"not null" json:"order_date"`
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

func (o *Order) UpdateStatus(db *gorm.DB, orderID uint, status string) error {
	return db.Model(&Order{}).Where("id_pesanan = ?", orderID).Update("status", status).Error
}
