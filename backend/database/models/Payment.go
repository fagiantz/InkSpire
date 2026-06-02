package models

import (
	"time"

	"gorm.io/gorm"
)

type Payment struct {
	IdPembayaran uint      `gorm:"primaryKey;autoIncrement" json:"id_pembayaran"`
	IdPesanan    uint      `gorm:"not null" json:"id_pesanan"`
	ImagePath    string    `gorm:"not null;type:varchar(255)" json:"image_path"`
	CreatedAt    time.Time `gorm:"autoCreateTime" json:"created_at"`
}

func (p *Payment) TableName() string {
	return "payments"
}

func (p *Payment) Create(db *gorm.DB) error {
	return db.Create(p).Error
}
