package models

import "gorm.io/gorm"

type Weather struct {
	gorm.Model
	Miasto      string  `json:"miasto"`
	Temperatura float64 `json:"temperatura"`
	Typ         string  `json:"typ"`
}
