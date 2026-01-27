<?php
/**
 * Retrieve a value from an array with a default fallback.
 *
 * This function checks if a specified key exists in the provided array
 * and whether its value is not empty. If both conditions are met, 
 * the value associated with the key is returned. Otherwise, a default 
 * value is returned.
 *
 *
 * @param   array       $array    The array from which to retrieve the value.
 * @param   string|int  $key      The key whose value should be retrieved.
 * @param   mixed       $default  The default value to return. Defaults to `false`.
 * @return  mixed  
 */
function get_array_value($array, $key, $default = false) {
  return isset($array[$key]) && !empty($array[$key])
    ? $array[$key]
    : $default;
}
