<?php
/**
 * Generate a string of term property values separated by a specified separator.
 *
 * @param   array   $terms     An array of term objects (e.g., from `get_the_terms`).
 * @param   string  $separator Optional. The separator to use between term values. Default is ', '.
 * @param   string  $prop      Optional. The property of the term object to extract. Default is 'name'.
 * @return  string             A string of term property values separated by the specified separator, or an empty string if no valid terms.
 *
 * Usage:
 * $terms = get_the_terms($post_id, 'category');
 * echo get_terms_list($terms, ' | ', 'slug');
 */
function get_terms_list($terms, $separator = ', ', $prop = 'name') {
    // Check if the input is a valid array of objects
    if (!is_array($terms) || empty($terms)) {
        return '';
    }

    // Extract the specified property from each term
    $term_names = array_map(function($term) use ($prop) {
        // Check if $term is an object and has the specified property
        return is_object($term) && property_exists($term, $prop) ? $term->$prop : '';
    }, $terms);

    // Remove empty values and join the names with the specified separator
    return implode($separator, array_filter($term_names, fn($name) => !empty($name)));
}
