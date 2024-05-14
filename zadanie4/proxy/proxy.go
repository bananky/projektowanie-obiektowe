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
	LongLat         = "?lat=44.34&lon=10.99"
	APIParameter    = "&appid="
)

type WeatherProxy interface {
	TakeWeather() (models.WeatherModel, error)
}

type WeatherProxyImpl struct{}

func (s *WeatherProxyImpl) TakeWeather() (models.WeatherModel, error) {
	OpenWeatherApi := os.Getenv("OPEN_WEATHER_API")
	if OpenWeatherApi == "" {
		return models.WeatherModel{}, fmt.Errorf("API key is not set or empty")
	}

	url := BaseURL + WeatherEndpoint + LongLat + APIParameter + OpenWeatherApi
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

	return weather, nil
}
