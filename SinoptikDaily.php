<?php

include_once("simple_html_dom.php");

class SinoptikDaily
{

     static private function get_temperature($sinoptik_html){
        $arr = [];
        for ($i = 1; $i<=8; $i++){
            $arr[$i - 1] = $sinoptik_html->find('.temperature .p'.$i, 0);
            $arr[$i - 1] = preg_replace('/\D/','' , $arr[$i - 1]);
            $arr[$i - 1] = substr($arr[$i - 1], 1);
        }

        $temperature = [];
        for ($i = 0; $i < 8; $i+=2){
            $temperature[] = ($arr[$i] + $arr[$i + 1]) / 2;
        }

        return($temperature);
    }

     static private function get_humidity($sinoptik_html){
        $arr = [];
        for ($i = 1; $i<=8; $i++){
            $arr[$i - 1] = $sinoptik_html->find('tr[!class] .p'.$i, 0);
            $arr[$i - 1] = $arr[$i - 1]->text();
        }

        $humidity = [];
        for ($i = 0; $i < 8; $i+=2){
            $humidity[] = ($arr[$i] + $arr[$i + 1]) / 2;
        }

        return $humidity;
    }

    static private function get_wind($sinoptik_html){
        $arr = [];
        foreach ($sinoptik_html->find('.wind') as $item){
            $arr[] = $item->text();
        }

        $wind = [];
        for ($i = 0; $i < 8; $i+=2){
            $wind[] = ($arr[$i] + $arr[$i + 1]) / 2;
        }

        return $wind;
    }

    static public function get_weather($sinoptik_daily_url){
         $html = file_get_html($sinoptik_daily_url);
         $weather['temperature'] = SinoptikDaily::get_temperature($html);
         $weather['humidity'] = SinoptikDaily::get_humidity($html);
         $weather['wind'] = SinoptikDaily::get_wind($html);

         print_r($weather);
    }

}

SinoptikDaily::get_weather("https://sinoptik.ua/%D0%BF%D0%BE%D0%B3%D0%BE%D0%B4%D0%B0-%D1%85%D0%BC%D0%B5%D0%BB%D1%8C%D0%BD%D0%B8%D1%86%D0%BA%D0%B8%D0%B9/2021-07-07");

