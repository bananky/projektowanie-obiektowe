package main

import (
	"zadanie4/controllers"

	"github.com/labstack/echo/v4"
)

func main() {
	e := echo.New()
	e.GET("/pogoda", controllers.ReadWeather)
	e.POST("/pogoda", controllers.ReadWeather)
	e.Logger.Fatal(e.Start(":3000"))
}
