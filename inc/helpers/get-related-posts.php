<?php
/**
 * Retrieve related posts based on shared tags or categories.
 *
 * @param   int   $post_id  The ID of the post for which to find related posts.
 * @param   int   $limit    The number of related posts to retrieve. Default is 3.
 * @return  array           An array of related posts, or an empty array if none found.
 *
 * Usage:
 * $related_posts = get_related_posts($post_id, 5);
 * foreach ($related_posts as $post) {
 *     // Access post details using $post->ID, $post->post_title, etc.
 * }
 */
function get_related_posts($post_id, $limit = 3) {
  $current_post = get_post($post_id);

  if (!$current_post) {
    return [];
  }

  $post_type = get_post_type($post_id);
  $tags = wp_get_post_tags($post_id, ['fields' => 'ids']);
  $categories = wp_get_post_categories($post_id, ['fields' => 'ids']);

  $args = [
    'post_type'      => $post_type, // Restrict to the same post type
    'post_status'    => 'publish',
    'posts_per_page' => $limit,
    'post__not_in'   => [$post_id], // Exclude the current post
    'tax_query'      => [
      'relation' => 'OR',
      [
        'taxonomy' => 'category',
        'terms'    => $categories,
        'field'    => 'term_id',
      ],
      [
        'taxonomy' => 'post_tag',
        'terms'    => $tags,
        'field'    => 'term_id',
      ],
    ],
  ];

  return get_posts($args);
}
