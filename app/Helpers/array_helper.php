<?php

/**
 * Search value through a multi dimensional array
 * @param array $array
 * @param $needle
 * @param $array_key
 * @return array|mixed
 */
function search_value_array(array $array, $needle, $array_key)
{
    $result = [];
    $index = search_index_array($array, $needle, $array_key);

    if (isset($array[$index]) && !empty($array[$index])) {
        $result = $array[$index];
    }

    return $result;
}

/**
 * Search index through a multi dimensional array
 *
 * @param array $array
 * @param $needle
 * @param $array_key
 * @return false|int|null|string
 */
function search_index_array(array $array, $needle, $array_key)
{
    foreach ($array as $index => $value){
        if (isset($value[$array_key]) && $value[$array_key] === $needle){
            return $index;
        }
    }

    return null;
}