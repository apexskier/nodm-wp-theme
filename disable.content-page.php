<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

<div class="page-title">
<div class="container">
    <div class="row-fluid">
		<h2 class="entry-title span7"><?php the_title(); ?></h2>

		<div class="span5 search-form-div">
    		<?php get_search_form(); ?>
		</div>
    </div>
</div>
</div>
<div class="contents">
<div class="container">
    <div class="row-fluid">
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
            <div id="content" role="main">
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <?php if (has_post_thumbnail()): ?>
                        <div class="featured-image pull-right">
                            <?php echo get_the_post_thumbnail(); ?>
                        </div>
                    <?php endif; ?>
            		<div class="entry-content">
            			<?php the_content(); ?>
            			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'nodm2013' ), 'after' => '</div>' ) ); ?>
            		</div><!-- .entry-content -->
            	</article><!-- #post -->
    		</div><!-- #content -->
    	</div><!-- #primary -->
    	<?php get_sidebar(); ?>
    </div>
