<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Config;
use Walker_Nav_Menu;

/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  if (Config\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

/**
 * Custom primary menu walker
 */
class custom_nav_walker extends Walker_Nav_Menu {
    public function walk_know_parent( $elements, $max_depth, $top_field_number, $current_depth ) {
        $args = array_slice(func_get_args(), 2);
        $output = '';

        //invalid parameter or nothing to walk
        if ( $max_depth < -1 || empty( $elements ) ) {
            return $output;
        }

        $parent_field = $this->db_fields['parent'];

        // flat display
        if ( -1 == $max_depth ) {
            $empty_array = array();
            foreach ( $elements as $e )
                $this->display_element( $e, $empty_array, 1, $current_depth + 1, $args, $output );
            return $output;
        }

        /*
         * Need to display in hierarchical order.
         * Separate elements into two buckets: top level and children elements.
         * Children_elements is two dimensional array, eg.
         * Children_elements[10][] contains all sub-elements whose parent is 10.
         */
        $top_level_elements = array();
        $children_elements  = array();
        foreach ( $elements as $e) {
            if ( $top_field_number == $e->$parent_field )
                $top_level_elements[] = $e;
            else
                $children_elements[ $e->$parent_field ][] = $e;
        }

        /*
         * When none of the elements is top level.
         * Assume the first one must be root of the sub elements.
         */
        if ( empty($top_level_elements) ) {

            $first = array_slice( $elements, 0, 1 );
            $root = $first[0];

            $top_level_elements = array();
            $children_elements  = array();
            foreach ( $elements as $e) {
                if ( $root->$parent_field == $e->$parent_field )
                    $top_level_elements[] = $e;
                else
                    $children_elements[ $e->$parent_field ][] = $e;
            }
        }

        foreach ( $top_level_elements as $e )
            $this->display_element( $e, $children_elements, 1, $current_depth_+ 1, $args, $output );

        $child_output = "";
        foreach ( $children_elements as $parent_id => $child_group ) {
            $newlevel = true;
            //start the child delimiter
            $cb_args = array_merge(array(&$child_output, $depth), $args);
            call_user_func_array(array($this, 'start_lvl'), $cb_args);

            $child_output .= $this->walk_know_parent( $child_group, $max_depth, $parent_id, $current_depth + 1 );

            $cb_args = array_merge( array(&$child_output, $depth), $args);
            call_user_func_array(array($this, 'end_lvl'), $cb_args);
        }

        /*
         * If we are displaying all levels, and remaining children_elements is not empty,
         * then we got orphans, which should be displayed regardless.
         */
        if ( ( $max_depth == 0 ) && count( $children_elements ) > 0 ) {
            $empty_array = array();
            foreach ( $children_elements as $orphans )
                foreach( $orphans as $op )
                    $this->display_element( $op, $empty_array, 1, $current_depth + 1, $args, $output );
        }
        /*
        print("<pre style='text-align: left'>");
        echo($output);
        print("</pre>");
        die();
         */

        return $child_output;
    }

    /**
     * Display array of elements hierarchically.
     *
     * Does not assume any existing order of elements.
     *
     * $max_depth = -1 means flatly display every element.
     * $max_depth = 0 means display all levels.
     * $max_depth > 0 specifies the number of display levels.
     *
     * @since 2.1.0
     *
     * @param array $elements  An array of elements.
     * @param int   $max_depth The maximum hierarchical depth.
     * @return string The hierarchical item output.
     */
    public function walk( $elements, $max_depth ) {
        return $this->walk_know_parent( $elements, $max_depth, 0, 0 );
    }
}
