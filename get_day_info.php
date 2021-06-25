<?php

include_once("simple_html_dom.php");


function get_text($selector, $url)
{
    $html = file_get_html($url);

    $arr = [];
    foreach ($html->find($selector) as $item)
    {
        $arr[] = $item->text();
    }

    return $arr;
}

function get_days_info($url)
{

    $info = [];
    $info['day'] = get_text('.day-link', $url);
    $info['date'] = get_text('.date', $url);
    $info['month'] = get_text('.month', $url);

    //print_r($info);
    return $info;
}

//get_days_info("https://sinoptik.ua/%D0%BF%D0%BE%D0%B3%D0%BE%D0%B4%D0%B0-%D1%85%D0%BC%D0%B5%D0%BB%D1%8C%D0%BD%D0%B8%D1%86%D0%BA%D0%B8%D0%B9");

