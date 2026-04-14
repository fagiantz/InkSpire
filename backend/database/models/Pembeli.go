package models

type Pembeli struct {
	Akun
	RiwayatPesanan []Order `gorm:"foreignKey:EmailPembeli;references:Email" json:"riwayat_pesanan"`
}
