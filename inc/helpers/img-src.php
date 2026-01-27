<?php
/**
 * Output the `src` attribute for an image in the 'assets/images' folder.
 *
 * @param   string  $image_name The name of the image file, including the extension.
 * @return  void
 *
 * Usage:
 * <img <?php img_src('image-name.png') ?> />
 */
function img_src(string $image_name): void {
  echo 'src="' . get_img_src($image_name) . '"';
}
