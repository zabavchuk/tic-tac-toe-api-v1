<?php

/**
 * Push value to start of array
 * @param string $cache_name
 * @param array $value
 * @param int $expiration_time
 */
function cache_unshift(string $cache_name, array $value, int $expiration_time)
{
    if (cache($cache_name) === null) {
        $values[] = $value;
        cache()->save($cache_name, $values, $expiration_time);
    } else {
        $values = cache($cache_name);
        array_unshift($values, $value);
        cache()->save($cache_name, $values, $expiration_time);
    }
}

/**
 * @param string $cache_name
 * @param array $array
 * @param $delete
 * @param $array_key
 * @return bool|mixed
 */
function delete_cache_array_value(string $cache_name, array $array, $delete, $array_key)
{
    $ids = array_column($array, $array_key);
    $index = array_search($delete, $ids);

    if (!is_numeric($index)) {
        $response = false;
    } else {
        $response = $array[$index];
    }

    return $response;
}