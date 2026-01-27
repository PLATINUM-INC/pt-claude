<?php
/**
 * Outputs responsive image attributes including `src`, `srcset`, and `alt`.
 *
 * This function handles images referenced either by ID or by an array 
 * (e.g., as returned by ACF image fields). For image IDs, it uses `acf_image_src`
 * to generate `src` and `srcset` attributes and retrieves the `alt` text based on
 * the image title. For image arrays, it retrieves the URL and `alt` text directly.
 *
 * @param int|array $image The image to display, which can be either an image ID (integer) 
 *                          or an array with `url` and `alt` keys.
 */
function acf_image_attrs($image) {
  if(is_int($image)){
    echo acf_image_src($image) . ' alt="' . esc_attr(get_the_title($image)) . '"';
  } else {
    $url = $image['url'];
    $alt = $image['alt'] ? $image['alt'] : $image['title'];
    echo 'src="' . esc_url($url) . '" alt="' . esc_attr($alt) . '"';
  }
}
