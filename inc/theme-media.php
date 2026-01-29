<?php

// Resize and compress uploaded image and replace original file
add_filter('wp_generate_attachment_metadata', function ($metadata, $attachment_id) {

    $file_path = get_attached_file($attachment_id);
    $editor = wp_get_image_editor($file_path);

    if (is_wp_error($editor)) {
        return $metadata;
    }

    // Set JPEG/WebP quality
    $editor->set_quality(60);

    // Resize and crop to final size
    $editor->resize(310, 620, true);

    // Save optimized file as a new main image
    $saved = $editor->save();

    if (! is_wp_error($saved)) {

        // Remove original uploaded file
        @unlink($file_path);

        // Update path of the main attachment file
        update_attached_file($attachment_id, $saved['path']);

        // Update metadata for the new image
        $metadata['file'] = str_replace(wp_upload_dir()['basedir'].'/', '', $saved['path']);
        $metadata['width'] = $saved['width'];
        $metadata['height'] = $saved['height'];
        $metadata['filesize'] = filesize($saved['path']);
        $metadata['sizes'] = []; // Remove auto-generated extra sizes
    }

    return $metadata;

}, 20, 2);

// Rename files if the original name starts with numbers (AdBlock-safe)
add_filter('sanitize_file_name', function ($filename) {
    if (preg_match('/^\d+/', pathinfo($filename, PATHINFO_FILENAME))) {
        $filename = 'model-'.$filename;
    }

    return $filename;
}, 10, 1);

// Disable all default WordPress image sizes
add_filter('intermediate_image_sizes', '__return_empty_array');
