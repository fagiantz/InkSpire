package models

import (
	"fmt"
	"time"

	"golang.org/x/crypto/bcrypt"
	"gorm.io/gorm"
)

type Akun struct {
	ID        uint      `gorm:"primaryKey" json:"id"`
	Email     string    `gorm:"uniqueIndex;not null;type:varchar(255)" json:"email"`
	Password  string    `gorm:"not null;type:varchar(255)" json:"-"`
	Name      string    `gorm:"not null;type:varchar(255)" json:"name"`
	Role      string    `gorm:"default:user;type:enum('user','staff')" json:"role"`
	CreatedAt time.Time `json:"created_at"`
}

func (Akun) TableName() string {
	return "users"
}

// func (u *Akun) Register(db *gorm.DB) error {
// 	var exisitingAkun Akun
// 	if err := db.Where("email = ?", u.Email).First(&exisitingAkun).Error; err == nil {
// 		return fmt.Errorf("email already registered")
// 	}

// 	return db.Create(u).Error
// }

func (u *Akun) Login(db *gorm.DB, password string) (bool, error) {
	if err := db.Where("email = ?", u.Email).First(u).Error; err != nil {
		return false, fmt.Errorf("user not found")
	}

	if err := bcrypt.CompareHashAndPassword([]byte(u.Password), []byte(password)); err != nil {
		return false, fmt.Errorf("invalid password")
	}

	return true, nil
}

func (u *Akun) Logout(token string) error {
	return nil
}

func (u *Akun) HashPassword() error {
	hashedPassword, err := bcrypt.GenerateFromPassword([]byte(u.Password), bcrypt.DefaultCost)
	if err != nil {
		return err
	}
	u.Password = string(hashedPassword)
	return nil
}

func (u *Akun) IsAdmin() bool {
	return u.Role == "admin"
}
