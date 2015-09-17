<?php
/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$sage_includes = [
  'lib/utils.php',                  // Utility functions
  'lib/init.php',                   // Initial theme setup and constants
  'lib/images.php',                 //
  'lib/wrapper.php',                // Theme wrapper class
  'lib/conditional-tag-check.php',  // ConditionalTagCheck class
  'lib/config.php',                 // Configuration
  'lib/assets.php',                 // Scripts and stylesheets
  'lib/titles.php',                 // Page titles
  'lib/extras.php',                 // Custom functions
  'lib/admin.php',                  // Admin page
  'lib/sponsor-type.php',           // Custom sponsor type
  'lib/course-type.php',            // Custom course type
  'lib/course-icons-type.php',       // Custom course type
  'lib/random-sponsors-widget.php', // Random sponsors widget
  'lib/fancy-sponsors-widget.php',  // Home page fancy sponsors widget
  'lib/social-media-widget.php',    // Custom social media widget
  'lib/anchor-links.php',           // Add anchor ids to content
  'lib/anchor-links-widget.php',    // Setup anchor links widget.
];

foreach ($sage_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);
