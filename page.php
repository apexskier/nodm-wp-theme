<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
<div class="navbar" id="title">
    <div class="container">
        <h2 class="navbar-brand col-sm-7 col-lg-8" id="title-h2"><?php the_title(); ?></h2>
        <?php get_search_form(); ?>
    </div>
</div>
<div class="container">
    <div class="row">
    	<div id="primary" class="col-sm-9 col-lg-10">
    		<div id="content" role="main">
            	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> aria-labeledby="#title-h2">
        			<?php while ( have_posts() ) : the_post(); ?>
        			    <?php the_content(); ?>
    			    <?php endwhile; ?>
            	</article><!-- #post -->
    		</div><!-- #content -->
    	</div><!-- #primary -->
        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>