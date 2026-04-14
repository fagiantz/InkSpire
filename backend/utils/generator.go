package utils

import (
	"crypto/rand"
	"encoding/hex"
	"time"
)

func GenerateProdukID() string {
	bytes := make([]byte, 6)
	if _, err := rand.Read(bytes); err != nil {
		return "PRD-UNKNOWN"
	}
	return "PRD-" + hex.EncodeToString(bytes)
}

func GenerateOrderID() string {
	return time.Now().Format("20060102-150405")
}
