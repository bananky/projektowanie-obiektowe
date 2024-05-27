package proxy

import (
	"encoding/json"
	"fmt"
	"log"
	"net/http"
	"os"
	"zadanie4/models"
)

const (
	BaseURL         = "https://api.openweathermap.org"
	WeatherEndpoint = "/data/2.5/weather"
	APIParameter    = "&appid="
)

type WeatherProxy interface {
	TakeWeather(lat, lon float64) (models.WeatherModel, error)
}

type WeatherProxyImpl struct{}

func (s *WeatherProxyImpl) TakeWeather(lat, lon float64) (models.WeatherModel, error) {
	OpenWeatherApi := os.Getenv("OPEN_WEATHER_API")
	if OpenWeatherApi == "" {
		return models.WeatherModel{}, fmt.Errorf("API key is not set or empty")
	}

	url := fmt.Sprintf("%s%s?lat=%f&lon=%f%s%s", BaseURL, WeatherEndpoint, lat, lon, APIParameter, OpenWeatherApi)
	log.Println("Fetching weather data from:", url)

	resp, err := http.Get(url)
	if err != nil {
		return models.WeatherModel{}, fmt.Errorf("error fetching weather data: %v", err)
	}
	defer resp.Body.Close()

	if resp.StatusCode != http.StatusOK {
		return models.WeatherModel{}, fmt.Errorf("unexpected status code: %d", resp.StatusCode)
	}

	var weather models.WeatherModel
	if err := json.NewDecoder(resp.Body).Decode(&weather); err != nil {
		return models.WeatherModel{}, err
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

	return weather, nil
}
