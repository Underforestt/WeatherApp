<?php

require_once 'vendor/autoload.php';
include("WeatherParser.php");
include("config.php");


$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

$Weather_khm = new WeatherParser($sinoptik_url, $gismeteo_url, $meteo_url);

$avg_temperature = $Weather_khm->get_average_temperature();
$days_info = $Weather_khm->get_days_info();
$images = $Weather_khm->get_weather_img();

$template = $twig->load('main.twig');
echo $template->render(['avgTmp' => $avg_temperature, 'days_info' => $days_info, 'imgs' => $images]);
