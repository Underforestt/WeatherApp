<?php

require_once 'vendor/autoload.php';
include("get_temperature.php");

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

get_temperature("https://sinoptik.ua/%D0%BF%D0%BE%D0%B3%D0%BE%D0%B4%D0%B0-%D1%85%D0%BC%D0%B5%D0%BB%D1%8C%D0%BD%D0%B8%D1%86%D0%BA%D0%B8%D0%B9"
, '.min', '.max');
echo "<br>";
get_temperature("https://www.gismeteo.ua/ua/weather-khmelnytskyi-4952/10-days/", '.mint .unit_temperature_c', '.maxt .unit_temperature_c');
echo "<br>";
get_temperature("https://meteo.ua/49/hmelnitskiy", '.wwt_min', '.wwt_max');

//$template = $twig->load('main.twig');
//echo $template->render(['daysWeek' => $daysWeek]);