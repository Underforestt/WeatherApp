<?php

function get_average_temperature($arr1, $arr2, $arr3)
{
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
