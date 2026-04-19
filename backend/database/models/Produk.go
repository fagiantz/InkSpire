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

func (*Produk) GetDetail(db *gorm.DB, id string) (*Produk, error) {
	var produk Produk
	if err := db.Where("id_produk = ?", id).First(&produk).Error; err != nil {
		return nil, err
	}
	return &produk, nil
}

func (*Produk) Update(db *gorm.DB, id string, nama string, harga float64) error {
	return db.Model(&Produk{}).Where("id_produk = ?", id).Updates(map[string]interface{}{
		"nama_produk": nama,
		"harga":       harga,
	}).Error
}

func (*Produk) Delete(db *gorm.DB, id string) error {
	return db.Where("id_produk = ?", id).Delete(&Produk{}).Error
}
