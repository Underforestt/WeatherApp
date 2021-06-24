<?php

include("simple_html_dom.php");

function get_temperature($url, $min_separator, $max_separator)
{
    $html = file_get_html($url);


    $min_tmp = $html->find($min_separator);
    $max_tmp = $html->find($max_separator);
    for ($i = 0;$i < 7;$i++)
    {
        $min_tmp_n[$i] = preg_replace('/\D/', '', $min_tmp[$i]);
        $max_tmp_n[$i] = preg_replace('/\D/', '', $max_tmp[$i]);
    }
    $temperature[0] = $min_tmp_n;
    $temperature[1] = $max_tmp_n;

    print_r($temperature);
    return $temperature;

}

