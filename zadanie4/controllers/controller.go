package controllers

import (
	"log"
	"net/http"
	"zadanie4/proxy"

	"github.com/labstack/echo/v4"
	"gorm.io/gorm"
)

func GetWeather(db *gorm.DB) echo.HandlerFunc {
	return func(c echo.Context) error {
		service := &proxy.WeatherProxyImpl{}
		weather, err := service.TakeWeather()
		if err != nil {
			log.Println("Error fetching weather data:", err)
			return c.JSON(http.StatusInternalServerError, map[string]string{"error": "Failed to fetch weather data"})
		}

		// Save weather data to the database
		if err := db.Create(&weather).Error; err != nil {
			log.Println("Error saving weather data to database:", err)
			return c.JSON(http.StatusInternalServerError, map[string]string{"error": "Failed to save weather data"})
		}

		return c.JSON(http.StatusOK, weather)
	}
}
