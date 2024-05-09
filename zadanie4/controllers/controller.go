package controllers

import (
	"net/http"
	"zadanie4/models"

	"github.com/labstack/echo/v4"
	"gorm.io/gorm"
)

func GetWeather(db *gorm.DB) echo.HandlerFunc {
	return func(c echo.Context) error {
		var weather []models.Weather
		if err := db.Find(&weather).Error; err != nil {
			return c.JSON(http.StatusInternalServerError, map[string]string{"error": "Failed to fetch weather data"})
		}
		return c.JSON(http.StatusOK, weather)
	}
}
