<?php
/**
 * Get the contents of an SVG file as a string.
 *
 * @param   string  $name The name of the SVG file in 'assets/icons'.
 * @return  string  The SVG content if the file exists, or an empty string.
 *
 * Usage:
 * <div class="icon">
 *   <?php echo get_inline_svg('name.svg') ?>
 * </div>
 */
function get_inline_svg(string $name): string {
  if ($name) {
    $file_path = get_template_directory() . '/assets/icons/' . $name;

    if (file_exists($file_path)) {
      return file_get_contents($file_path);
    }
  }

  return '';
}
