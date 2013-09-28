<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>
    
<div class="navbar navbar-default" id="title">
    <div class="container">
        <h2 class="navbar-brand col-sm-7 col-lg-8" id="title-h2"><?php _e( 'Whoops!', 'nodm2013' ); ?></h2>
        <?php get_search_form(); ?>
    </div>
</div>
<div class="container">
    <div class="row">
    	<div id="primary" class="col-sm-9 col-lg-10">
    		<div id="content" role="main">
            	<h3><?php _e('This is somewhat embarrassing, isn&rsquo;t it?', 'nodm2013'); ?></h3>
                <p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'nodm2013' ); ?></p>
    		</div><!-- #content -->
    	</div><!-- #primary -->
        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>
