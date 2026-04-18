package models

import (
	"github.com/fagiantz/InkSpire/backend/utils"
	"gorm.io/gorm"
)

type Produk struct {
	ID          uint    `gorm:"primaryKey" json:"id"`
	Id_produk   string  `gorm:"uniqueIndex;not null;type:varchar(100)" json:"id_produk"`
	Nama_produk string  `gorm:"not null;type:varchar(255)" json:"nama_produk"`
	Harga       float64 `gorm:"not null" json:"harga"`
}

func (Produk) TableName() string {
	return "produk"
}

func (p *Produk) BeforeCreate(tx *gorm.DB) (err error) {
	p.Id_produk = utils.GenerateProdukID()
	return
}

func (p *Produk) Create(db *gorm.DB) error {
	return db.Create(p).Error
}

func (*Produk) GetAll(db *gorm.DB) ([]Produk, error) {
	var produks []Produk
	if err := db.Find(&produks).Error; err != nil {
		return nil, err
	}
	return produks, nil
}
