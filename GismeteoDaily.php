<?php

include_once("simple_html_dom.php");


class GismeteoDaily
{
    static private function get_temperature($gismeteo_html){
        $arr = $gismeteo_html->find('.chart__temperature .unit_temperature_c');

       for($i = 0; $i<count($arr); $i++){
           $arr[$i] = preg_replace('/\D/','' , $arr[$i]);
       }

       $temperature = [];
        for ($i = 0; $i < 8; $i+=2){
            $temperature[] = ($arr[$i] + $arr[$i + 1]) / 2;
        }

        return $temperature;
    }

    static private function get_humidity($gismeteo_html){
        $arr = [];
        foreach ($gismeteo_html->find('.w-humidity') as $item){
            $arr[] = $item->text();
        }

        $humidity = [];
        for ($i = 0; $i < 8; $i+=2){
            $humidity[] = ($arr[$i] + $arr[$i + 1]) / 2;
        }

        return $humidity;
    }

    static private function get_wind($gismeteo_html){
        $arr = [];
        foreach ($gismeteo_html->find('div.widget__row.widget__row_table.widget__row_wind div.w_wind div.w_wind__warning .unit_wind_m_s') as $item){
            $arr[] = $item->text();
        }

        $wind = [];
        for ($i = 0; $i < 8; $i+=2){
            $wind[] = ($arr[$i] + $arr[$i + 1]) / 2;
        }

        return $wind;
    }

    static public function get_weather($gismeteo_daily_html){
        $weather['temperature'] = GismeteoDaily::get_temperature($gismeteo_daily_html);
        $weather['humidity'] = GismeteoDaily::get_humidity($gismeteo_daily_html);
        $weather['wind'] = GismeteoDaily::get_wind($gismeteo_daily_html);

        return $weather;
    }
}

$html = file_get_html('https://www.gismeteo.ua/ua/weather-khmelnytskyi-4952/');
GismeteoDaily::get_weather($html);