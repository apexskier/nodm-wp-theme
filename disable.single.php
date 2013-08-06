<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>
<div class="contents">
<div class="container">
    <div class="row-fluid">
    	<div id="primary" class="site-content span9">
    		<div id="content" role="main">

    			<?php while ( have_posts() ) : the_post(); ?>
    
    				<?php get_template_part( 'content', get_post_format() ); ?>
    
    				<nav class="nav-single">
    					<h3 class="assistive-text"><?php _e( 'Post navigation', 'nodm2013' ); ?></h3>
    					<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'nodm2013' ) . '</span> %title' ); ?></span>
    					<span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'nodm2013' ) . '</span>' ); ?></span>
    				</nav><!-- .nav-single -->
    
    				<?php comments_template( '', true ); ?>
    
    			<?php endwhile; // end of the loop. ?>
    
    		</div><!-- #content -->
    	</div><!-- #primary -->
    	<?php get_sidebar(); ?>
    </div>
    
<?php get_footer(); ?>