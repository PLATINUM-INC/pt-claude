<?php
/**
 * Generates a shortened excerpt of a post with a specified word limit.
 *
 * This function retrieves the excerpt of a post by limiting the number of words 
 * to a specified `$limit`. It optionally takes a `$post_id` to retrieve the 
 * excerpt for a specific post, defaulting to the current post if no ID is provided.
 *
 * @param   int     $limit    The maximum number of words for the excerpt.
 * @param   int     $post_id  Optional. The ID of the post to get the excerpt from. Defaults to `-1`, which uses the current post in the loop.
 * @return  string  Shortened excerpt with a maximum of `$limit` words, appended with '...' if truncated. Shortcodes are stripped out.
 */
function excerpt($limit, $post_id = -1)
{
  // Retrieve the excerpt for the specified post or the current post.
  if ($post_id === -1) {
    $excerpt = explode(' ', get_the_excerpt(), $limit);
  } else {
    $excerpt = explode(' ', get_the_excerpt($post_id), $limit);
  }

  // If the excerpt reaches the limit, remove the last word and add ellipses.
  if (count($excerpt) >= $limit) {
    array_pop($excerpt);
    $excerpt = implode(' ', $excerpt) . '...';
  } else {
    // Otherwise, join the words as is.
    $excerpt = implode(' ', $excerpt);
  }

  // Remove any shortcodes or unwanted characters.
  $excerpt = preg_replace('`[[^]]*]`', '', $excerpt);

  return $excerpt;
}
