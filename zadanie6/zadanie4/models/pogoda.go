package models

import "gorm.io/gorm"

type Coord struct {
	gorm.Model
	Lon            float64 `json:"lon"`
	Lat            float64 `json:"lat"`
	WeatherModelID uint
}

type Weather struct {
	gorm.Model
	Main           string `json:"main"`
	Description    string `json:"description"`
	Icon           string `json:"icon"`
	WeatherModelID uint
}

type Main struct {
	gorm.Model
	Temp           float64 `json:"temp"`
	FeelsLike      float64 `json:"feels_like"`
	TempMin        float64 `json:"temp_min"`
	TempMax        float64 `json:"temp_max"`
	Pressure       int     `json:"pressure"`
	Humidity       int     `json:"humidity"`
	SeaLevel       int     `json:"sea_level"`
	GrndLevel      int     `json:"grnd_level"`
	WeatherModelID uint
}

type Wind struct {
	gorm.Model
	Speed          float64 `json:"speed"`
	Deg            int     `json:"deg"`
	Gust           float64 `json:"gust"`
	WeatherModelID uint
}

type Rain struct {
	gorm.Model
	OneH           float64 `json:"1h"`
	WeatherModelID uint
}

type Clouds struct {
	gorm.Model
	All            int `json:"all"`
	WeatherModelID uint
}

type Sys struct {
	gorm.Model
	Type           int    `json:"type"`
	Country        string `json:"country"`
	Sunrise        int    `json:"sunrise"`
	Sunset         int    `json:"sunset"`
	WeatherModelID uint
}

type WeatherModel struct {
	gorm.Model
	Coord      Coord `gorm:"foreignkey:WeatherModelID"`
	Weather    []Weather
	Base       string
	Main       Main
	Visibility int
	Wind       Wind
	Rain       Rain
	Clouds     Clouds
	DT         int
	Sys        Sys
	Timezone   int
	Name       string
	Cod        int
}
