<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<a href="<?php $key = "sponsor_url"; echo get_post_meta($post->ID, $key, true); ?>"><?php
		$attr = array(
			'alt'	=> $title . ' logo',
			'title'	=> $title,
		);
		the_post_thumbnail($attr);
		?></a>
	</article><!-- #post -->
