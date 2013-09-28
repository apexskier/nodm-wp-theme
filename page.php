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
<div class="navbar navbar-default" id="title">
    <div class="container">
        <h2 class="navbar-brand col-sm-7 col-lg-8" id="title-h2"><?php the_title(); ?></h2>
        <?php get_search_form(); ?>
    </div>
</div>
<div class="container">
    <div class="row">
    
    <?php
// test if has children
$leftnav = false;
$parentnav = false;
$my_wp_query = new WP_Query();
$all_wp_pages = $my_wp_query->query(array('post_type' => 'page'));
$children = get_page_children($post->ID, $all_wp_pages);
if (sizeof($children) > 0) {
    $leftnav = true;
    $parent = $post->ID;
} else if ($post->post_parent > 0) {
    $children = get_page_children(get_page($post->post_parent)->ID, $all_wp_pages);
    if (sizeof($children) > 1) {
        $leftnav = true;
        $parent = get_page($post->post_parent)->ID;
    }
}
?>
<?php if ($leftnav): ?>
        <div id="left-nav" class="span2">
            <ul class="nav nav-stacked">
<?php
$page_args = array(
    'depth' => 1,
    'child_of' => $parent,
    'title_li' => null,
    'sort_column' => 'menu_order',
    'exclude' => $post->ID,
    'post_status' => 'publish'
);
wp_list_pages($page_args); ?>
            </ul>
        </div>
<?php endif; ?>
        <div id="primary" class="site-content span<?php if ($leftnav) { echo '8'; } else { echo '9'; } ?>">
    
    
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