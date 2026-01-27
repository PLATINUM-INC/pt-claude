<?php
/**
 * Outputs HTML attributes for a link (`href` and `target`).
 *
 * This function accepts an array (typically from an ACF link field) containing 
 * a URL and an optional target, and outputs sanitized HTML attributes.
 *
 * @param array $link An associative array with the following keys:
 *                    - 'url' (string): The URL for the link.
 *                    - 'target' (string|optional): The target attribute for the link (e.g., '_blank' or '_self').
 *                      Defaults to '_self' if not provided.
 * 
 * @return void Outputs the `href` and `target` attributes for an anchor (`<a>`) tag.
 */
function acf_link_attrs(array $link) {
  $target = $link['target'] ? $link['target'] : '_self';
  $url = $link['url'];

  // Output the href and target attributes.
  echo 'href="' . esc_url($url) . '" target="' . esc_attr($target) . '"';
}
