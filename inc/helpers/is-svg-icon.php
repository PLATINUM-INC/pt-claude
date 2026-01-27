<?php
/**
 * Check if a given URL points to an SVG icon.
 *
 * @param   string  $url  The URL of the file to check.
 * @return  bool          True if the file is an SVG, false otherwise.
 *
 * Usage:
 * if (is_svg_icon('https://example.com/icon.svg')) {
 *     // Do something if the file is an SVG.
 * }
 */
function is_svg_icon($url) {
  return wp_check_filetype($url)['ext'] === 'svg';
}
