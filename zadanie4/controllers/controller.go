package controllers

import (
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
			return c.JSON(http.StatusInternalServerError, map[string]string{"error": "Failed to fetch weather data"})
		}
		return c.JSON(http.StatusOK, weather)
	}
}
