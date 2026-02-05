<?php

/**
 * Custom Walker for Desktop Header Menu
 * Matches the existing auto-menu markup
 */
class PT_Desktop_Menu_Walker extends Walker_Nav_Menu
{
    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        $output .= '<div class="dropdown-menu"><ul>';
    }

    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        $output .= '</ul></div>';
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $has_children = in_array('menu-item-has-children', $item->classes);
        $title = apply_filters('the_title', $item->title, $item->ID);

        // Limit words for top-level items
        if ($depth === 0) {
            $title = pt_menu_limit_words($title, 3);
        }

        if ($depth === 0) {
            // Top level item
            $classes = ['menu-item'];
            if ($has_children) {
                $classes[] = 'dropdown';
            }

            $output .= '<li class="' . esc_attr(implode(' ', $classes)) . '">';

            if ($has_children) {
                // Button for dropdown
                $output .= '<button class="dropdown-toggle dropdown-toggle--js" type="button">';
                $output .= '<span>' . esc_html($title) . '</span>';
                $output .= '</button>';
            } else {
                // Simple link
                $output .= '<a class="dropdown-toggle" href="' . esc_url($item->url) . '">';
                $output .= '<span>' . esc_html($title) . '</span>';
                $output .= '</a>';
            }
        } else {
            // Child item - simple link
            $output .= '<li>';
            $output .= '<a href="' . esc_url($item->url) . '">';
            $output .= esc_html($title);
            $output .= '</a>';
        }
    }

    public function end_el(&$output, $item, $depth = 0, $args = null)
    {
        $output .= '</li>';
    }
}

/**
 * Custom Walker for Mobile Header Menu
 * Matches the existing mobile auto-menu markup
 */
class PT_Mobile_Menu_Walker extends Walker_Nav_Menu
{
    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        $output .= '<ul class="m-sub">';
    }

    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        $output .= '</ul>';
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $has_children = in_array('menu-item-has-children', $item->classes);
        $title = apply_filters('the_title', $item->title, $item->ID);

        if ($depth === 0) {
            // Top level item
            $output .= '<li class="m-item">';

            if ($has_children) {
                // Button for submenu
                $output .= '<button class="m-toggle" type="button">';
                $output .= esc_html($title);
                $output .= '</button>';
            } else {
                // Simple link
                $output .= '<a class="m-toggle" href="' . esc_url($item->url) . '">';
                $output .= esc_html($title);
                $output .= '</a>';
            }
        } else {
            // Child item - simple link
            $output .= '<li>';
            $output .= '<a href="' . esc_url($item->url) . '">';
            $output .= esc_html($title);
            $output .= '</a>';
        }
    }

    public function end_el(&$output, $item, $depth = 0, $args = null)
    {
        $output .= '</li>';
    }
}

/**
 * Helper function to limit words in menu titles
 */
function pt_menu_limit_words($text, $limit = 3)
{
    $text = trim(wp_strip_all_tags((string) $text));
    if ($text === '') {
        return '';
    }

    $words = preg_split('/\s+/u', $text, -1, PREG_SPLIT_NO_EMPTY);
    if (! $words) {
        return '';
    }

    $words = array_slice($words, 0, $limit);

    // if last word consists of 1-2 letters — hide it
    while (count($words) > 1) {
        $last = end($words);
        if (mb_strlen($last) <= 2) {
            array_pop($words);
        } else {
            break;
        }
    }

    return implode(' ', $words);
}
