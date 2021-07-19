<?php

include_once("simple_html_dom.php");

class WeatherParser
{
    private $sinoptic_url;
    private $gismeteo_url;
    private $meteo_url;

    public function __construct($sinoptic_url, $gismeteo_url, $meteo_url)
    {
        $this->sinoptic_url = $sinoptic_url;
        $this->gismeteo_url = $gismeteo_url;
        $this->meteo_url = $meteo_url;
    }

    private function get_temperature($url, $min_separator, $max_separator): array
    {
        $html = file_get_html($url);

        $min_tmp = $html->find($min_separator);
        $max_tmp = $html->find($max_separator);
        for ($i = 0;$i < 7;$i++)
        {
            $min_tmp_n[$i] = preg_replace('/\D/', '', $min_tmp[$i]);
            $max_tmp_n[$i] = preg_replace('/\D/', '', $max_tmp[$i]);
        }
        $temperature['min'] = $min_tmp_n;
        $temperature['max'] = $max_tmp_n;

        return $temperature;

    }

    public function get_average_temperature(): array
    {
        $arr1 = $this->get_temperature($this->sinoptic_url, '.min', '.max');
        $arr2 = $this->get_temperature($this->gismeteo_url, '.mint .unit_temperature_c', '.maxt .unit_temperature_c');
        $arr3 = $this->get_temperature($this->meteo_url, '.wwt_min', '.wwt_max');

        $avg_temperature = [];
        for ($i = 0; $i<count($arr1['min']); $i++)
        {
            $min_tmp = ($arr1['min'][$i] + $arr2['min'][$i] + $arr3['min'][$i]) / 3;
            $max_tmp = ($arr1['max'][$i] + $arr2['max'][$i] + $arr3['max'][$i]) / 3;

            $avg_temperature['min'][$i] = round($min_tmp, 1);
            $avg_temperature['max'][$i] = round($max_tmp, 1);
        }

        return $avg_temperature;
    }

    private function get_text($selector, $url): array
    {
        $html = file_get_html($url);

        $arr = [];
        foreach ($html->find($selector) as $item)
        {
            $arr[] = $item->text();
        }

        return $arr;
    }

    public function get_days_info(): array
    {

        $info = [];
        $info['day'] = $this->get_text('.day-link', $this->sinoptic_url);
        $info['date'] = $this->get_text('.date', $this->sinoptic_url);
        $info['month'] = $this->get_text('.month', $this->sinoptic_url);

        return $info;
    }

    public function get_weather_img(): array
    {
        $html = file_get_html($this->sinoptic_url);

        $images = [];
        foreach ($html->find('.main .weatherIco img.weatherImg') as $img)
        {
            $images[] = 'https:'.$img->src;
        }


        return $images;
    }


}