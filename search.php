<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>
    
<div class="navbar" id="title">
    <div class="container">
        <h2 class="navbar-brand col-sm-7 col-lg-8" id="title-h2">
    		<?php if ( have_posts() ) : ?>
                <?php printf( __( 'Search Results for: %s', 'nodm2013' ), '<span>' . get_search_query() . '</span>' ); ?>
            <?php else : ?>
                <?php _e( 'Nothing Found', 'nodm2013' ); ?>
    		<?php endif; ?>
        </h2>
        <?php get_search_form(); ?>
    </div>
</div>
<div class="container">
    <div class="row">
    	<div id="primary" class="col-sm-9 col-lg-10">
    		<div id="content" role="main">
            	<?php if ( have_posts() ) : ?>

                    <?php /* Start the Loop */ ?>
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php get_template_part( 'content', get_post_format() ); ?>
                    <?php endwhile; ?>

                    <?php nodm2013_content_nav( 'nav-below' ); ?>

                <?php else : ?>
                <article>
                    <h3>Sorry,</h3>
                    <p><?php _e( 'Nothing matched your search terms. Please try again with something else.', 'nodm2013' ); ?></p>
                </article>

                <?php endif; ?>
    		</div><!-- #content -->
    	</div><!-- #primary -->
        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>
