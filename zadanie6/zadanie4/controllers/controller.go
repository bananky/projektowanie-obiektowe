package controllers

import (
	"log"
	"net/http"
	"zadanie4/models"
	"zadanie4/proxy"

	"github.com/labstack/echo/v4"
	"gorm.io/gorm"
)

func GetWeather(db *gorm.DB) echo.HandlerFunc {
	return func(c echo.Context) error {
		locations := []struct {
			Lat float64
			Lon float64
		}{
			{Lat: 44.34, Lon: 10.99},
			{Lat: 52.23, Lon: 21.01}, // Warszawa
			{Lat: 50.06, Lon: 19.94}, // Kraków
			{Lat: 51.10, Lon: 17.03}, // Wrocław
			{Lat: 54.35, Lon: 18.65}, // Gdańsk
			{Lat: 53.13, Lon: 23.15}, // Białystok
			{Lat: 50.87, Lon: 20.63}, // Kielce
			{Lat: 53.01, Lon: 18.60}, // Toruń
			{Lat: 51.76, Lon: 19.46}, // Łódź
			{Lat: 50.30, Lon: 18.68}, // Opole
		}

		var weathers []models.WeatherModel
		service := &proxy.WeatherProxyImpl{}

		for _, loc := range locations {
			weather, err := service.TakeWeather(loc.Lat, loc.Lon)
			if err != nil {
				log.Println("Error fetching weather data:", err)
				return c.JSON(http.StatusInternalServerError, map[string]string{"error": "Failed to fetch weather data"})
			}

			weather.Model.ID = 0
			weather.Coord.Model.ID = 0
			weather.Main.Model.ID = 0
			weather.Wind.Model.ID = 0
			weather.Rain.Model.ID = 0
			weather.Clouds.Model.ID = 0
			weather.Sys.Model.ID = 0
			for i := range weather.Weather {
				weather.Weather[i].Model.ID = 0
			}

			if err := db.Create(&weather).Error; err != nil {
				log.Println("Error saving weather data to database:", err)
				return c.JSON(http.StatusInternalServerError, map[string]string{"error": "Failed to save weather data"})
			}

			weathers = append(weathers, weather)
		}

		return c.JSON(http.StatusOK, weathers)
	}
}
