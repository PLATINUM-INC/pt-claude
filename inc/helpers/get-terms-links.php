<?php
/**
 * Generate a list of links for the given terms.
 *
 * @param   array   $terms        An array of term objects (e.g., from `get_the_terms`).
 * @param   string  $link_classes Optional. A string of CSS classes to add to each link. Default is an empty string.
 * @return  string                A comma-separated string of HTML anchor tags, or an empty string if no valid terms.
 *
 * Usage:
 * $terms = get_the_terms($post_id, 'category');
 * echo get_terms_links($terms, 'custom-class');
 */
function get_terms_links($terms, $link_classes = '') {
    // Check if the input is a valid array
    if (!is_array($terms) || empty($terms)) {
        return '';
    }

    // Generate links for each term
    $term_links = array_map(function($term) use ($link_classes) {
        $term_link = get_term_link($term);

        // Check if the link generation succeeded
        if (is_wp_error($term_link)) {
            return '';
        }

        // Build the anchor tag
        return "<a href='" . esc_url($term_link) . "' class='" . esc_attr($link_classes) . "'>" . esc_html($term->name) . "</a>";
    }, $terms);

    // Remove empty values and join the links with a comma
    return implode(', ', array_filter($term_links));
}
