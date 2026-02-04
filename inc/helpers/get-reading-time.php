<?php
/**
 * Calculate reading time for a post.
 *
 * @param int $post_id Post ID. Defaults to current post.
 * @param int $words_per_minute Reading speed. Default 200.
 * @return int Reading time in minutes (minimum 1).
 */
function get_reading_time($post_id = null, $words_per_minute = 200) {
	if (!$post_id) {
		$post_id = get_the_ID();
	}

	$content = get_post_field('post_content', $post_id);
	$content = wp_strip_all_tags($content);
	$word_count = str_word_count($content);

	$reading_time = ceil($word_count / $words_per_minute);

	return max(1, $reading_time);
}
