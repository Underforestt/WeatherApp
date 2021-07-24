<?php

require_once "simple_html_dom.php";


class MeteoDaily
{
    static private function get_temperature($meteo_html){
        $arr = $meteo_html->find('.wnow_tmpr');

        $temperature = [];
        for($i = 0; $i < 4; $i++){
            $temperature[$i] = preg_replace('/\D/','' , $arr[$i]);
        }

        return $temperature;
    }

    static private function get_humidity($meteo_html){
        $arr = $meteo_html->find(".wnow_info.no_bg", 1)->find("td div");

        $humidity = [];
        for ($i = 0; $i < 4; $i++){
            $humidity[$i] = preg_replace('/\D/','' , $arr[$i]);
        }

        return $humidity;
    }

    static private function get_wind($meteo_html){
        $arr = $meteo_html->find(".wnow_info", 4)->find("td div");

        $wind = [];
        for ($i = 0; $i < 4; $i++){
            $wind[$i] = preg_replace("#[а-я<>a-z-/]#iu",'' , $arr[$i]);
        }

        return $wind;
    }

    static public function get_weather($gismeteo_daily_html){
        $weather['temperature'] = MeteoDaily::get_temperature($gismeteo_daily_html);
        $weather['humidity'] = MeteoDaily::get_humidity($gismeteo_daily_html);
        $weather['wind'] = MeteoDaily::get_wind($gismeteo_daily_html);

        return $weather;
    }
}

$html = file_get_html("https://meteo.ua/49/hmelnitskiy/today");
MeteoDaily::get_weather($html);