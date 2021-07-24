<?php

require_once "simple_html_dom.php";
require_once "SinoptikDaily.php";
require_once "GismeteoDaily.php";
require_once "MeteoDaily.php";

class DailyWeather
{
    public static function get_daily_weather(){

        date_default_timezone_set('Ukraine/Kyiv');
        $date = date('Y-m-d', time());
        $sinoptik = file_get_html("https://sinoptik.ua/%D0%BF%D0%BE%D0%B3%D0%BE%D0%B4%D0%B0-%D1%85%D0%BC%D0%B5%D0%BB%D1%8C%D0%BD%D0%B8%D1%86%D0%BA%D0%B8%D0%B9/$date");
        $gismeteo = file_get_html('https://www.gismeteo.ua/ua/weather-khmelnytskyi-4952/');
        $meteo = file_get_html("https://meteo.ua/49/hmelnitskiy/today");
        $sinoptik_info = SinoptikDaily::get_weather($sinoptik);
        $gismeteo_info = GismeteoDaily::get_weather($gismeteo);
        $meteo_info = MeteoDaily::get_weather($meteo);

        $average = [];
        for($i = 0; $i < 4; $i++){
            $average['temperature'][$i] = round(($sinoptik_info['temperature'][$i] + $gismeteo_info['temperature'][$i] + $meteo_info['temperature'][$i]) / 3, 1);
            $average['humidity'][$i] = round(($sinoptik_info['humidity'][$i] + $gismeteo_info['humidity'][$i] + $meteo_info['humidity'][$i]) / 3, 1);
            $average['wind'][$i] = round(($sinoptik_info['wind'][$i] + $gismeteo_info['wind'][$i] + $meteo_info['wind'][$i]) / 3, 1);
        }

        return $average;
    }

}

