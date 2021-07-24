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

    static public function get_weather($sinoptik_daily_html){
         $weather['temperature'] = SinoptikDaily::get_temperature($sinoptik_daily_html);
         $weather['humidity'] = SinoptikDaily::get_humidity($sinoptik_daily_html);
         $weather['wind'] = SinoptikDaily::get_wind($sinoptik_daily_html);

         return $weather;
    }

}



