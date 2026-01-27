<?php
/**
 * Log and display a PHP value in a readable format for debugging.
 *
 * Outputs the given value in a preformatted style and stops execution.
 *
 * @param   mixed   $value The value to display and debug.
 * @return  void
 *
 * Usage:
 * pretty_log($some_variable);
 */
function pretty_log($value): void {
  echo "<pre>";
  print_r($value);
  wp_die(); // Ends execution, useful for debugging in WordPress.
}
