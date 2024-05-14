package main

import (
	"zadanie4/controllers"
	"zadanie4/models"

	"gorm.io/driver/sqlite"
	"gorm.io/gorm"

	"github.com/joho/godotenv"
	"github.com/labstack/echo/v4"
)

func main() {

	err := godotenv.Load(".env")
	if err != nil {
		panic("Failed to load .env file")
	}

	db, err := gorm.Open(sqlite.Open("baza.db"), &gorm.Config{})
	if err != nil {
		panic("Nie udało się połączyć z bazą danych")
	}

	db.AutoMigrate(&models.Coord{}, &models.Weather{}, &models.Main{}, &models.Wind{}, &models.Rain{}, &models.Clouds{}, &models.Sys{}, &models.WeatherModel{})

	e := echo.New()

	e.Use(func(next echo.HandlerFunc) echo.HandlerFunc {
		return func(c echo.Context) error {
			c.Set("db", db)
			return next(c)
		}
	})

	e.GET("/pogoda", controllers.GetWeather(db))

	e.Logger.Fatal(e.Start(":3000"))
}
