<?php
/**
 * Generates responsive image markup for a given image ID.
 *
 * This function retrieves the URL and srcset for an image attachment, 
 * allowing responsive display based on the specified width and size.
 *
 * @param   int         $image_id     The attachment ID of the image.
 * @param   string      $max_width    Optional. The maximum width for the image display in CSS units. Default is "100%".
 * @param   string      $image_size   Optional. The image size to retrieve. Default is "full".
 * @return  string|null               HTML markup for responsive image attributes, or null if no image ID is provided.
 */
function acf_image_src($image_id, $max_width = "100%", $image_size = "full"){

  // Check that an image ID is provided.
  if($image_id != '') {

    // Retrieve the URL for the specified image size.
    $image_src = wp_get_attachment_image_url( $image_id, $image_size );

    // Retrieve the srcset for responsive image sizes.
    $image_srcset = wp_get_attachment_image_srcset( $image_id, $image_size );

    // Generate and return the HTML for responsive image attributes.
    return 'src="'.$image_src.'" srcset="'.$image_srcset.'" sizes="(max-width: '.$max_width.') 100vw, '.$max_width.'"';
  }

  // Return null if no image ID is provided.
  return null;
}
