<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>
<div class="navbar" id="title">
    <div class="container">
        <h2 class="navbar-brand col-sm-7 col-lg-8" id="title-h2">
        <?php if ( current_user_can( 'edit_posts' ) ): ?>
            <?php _e( 'No posts to display', 'nodm2013' ); ?>
		<?php else: ?>
            <?php _e( 'Nothing Found', 'nodm2013' ); ?>
		<?php endif; ?>
        <?php get_search_form(); ?>
    </div>
</div>
<div class="container">
    <div class="row">
    	<div id="primary" class="col-sm-9 col-lg-10">
    		<div id="content" role="main">
        		<?php if ( have_posts() ) : ?>
        			<?php while ( have_posts() ) : the_post(); ?>
        				<?php get_template_part( 'content', get_post_format() ); ?>
        			<?php endwhile; ?>
        			<?php nodm2013_content_nav( 'nav-below' ); ?>
        		<?php else : ?>
        			<article id="post-0" class="post no-results not-found">
        			<?php if ( current_user_can( 'edit_posts' ) ): ?>
        				<div class="entry-content">
        					<p><?php printf( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'nodm2013' ), admin_url( 'post-new.php' ) ); ?></p>
        				</div><!-- .entry-content -->
        			<?php else: ?>
        				<div class="entry-content">
        					<p><?php _e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'nodm2013' ); ?></p>
        					<?php get_search_form(); ?>
        				</div><!-- .entry-content -->
        			<?php endif; ?>
        			</article><!-- #post-0 -->
        		<?php endif; // end have_posts() check ?>    
    		</div><!-- #content -->
    	</div><!-- #primary -->
        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>