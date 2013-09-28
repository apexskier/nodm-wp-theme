<?php
/**
 * Twenty Twelve functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

/**
 * Sets up theme defaults and registers the various WordPress features that
 * Twenty Twelve supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add a Visual Editor stylesheet.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links,
 *     custom background, and post formats.
 * @uses register_nav_menu() To add support for navigation menus.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Twelve 1.0
 */
function nodm2013_setup() {
    /*
     * Makes Twenty Twelve available for translation.
     *
     * Translations can be added to the /languages/ directory.
     * If you're building a theme based on Twenty Twelve, use a find and replace
     * to change 'nodm2013' to the name of your theme in all the template files.
     */
    load_theme_textdomain( 'nodm2013', get_template_directory() . '/languages' );

    // Adds RSS feed links to <head> for posts and comments.
    add_theme_support( 'automatic-feed-links' );

    // This theme uses wp_nav_menu() in one location.
    register_nav_menu( 'primary', __( 'Primary Menu', 'nodm2013' ) );
    register_nav_menu( 'action-links', __( 'Action Links Menu', 'nodm2013' ) );
    register_nav_menu( 'events', __( 'Events Menu', 'nodm2013' ) );

    // This theme uses a custom image size for featured images, displayed on "standard" posts.
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop
}
add_action( 'after_setup_theme', 'nodm2013_setup' );

/**
 * Enqueues scripts and styles for front-end.
 *
 * @since Twenty Twelve 1.0
 */
function nodm2013_scripts_styles() {
    global $wp_styles;

    /* load styles */
    wp_enqueue_style( 'nodm2013-bootstrap',
                      get_template_directory_uri() . '/css/bootstrap.min.css',
                      false, '2.9.1', 'all' );
    wp_enqueue_style( 'nodm2013-style', get_stylesheet_uri() );

    /* load scripts */
    wp_enqueue_script( 'nodm2013-jquery',
                       'http://code.jquery.com/jquery-1.9.1.min.js',
                       array(), '1.9.1', true );
    wp_enqueue_script( 'nodm2013-bootstrap',
                       get_template_directory_uri() . '/js/bootstrap.min.js',
                       array(), '2.9.1', true );
    wp_enqueue_script( 'nodm2013-script',
                       get_template_directory_uri() . '/js/script.js',
                       array(), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'nodm2013_scripts_styles' );

/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since Twenty Twelve 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function nodm2013_wp_title( $title, $sep ) {
    global $paged, $page;

    if ( is_feed() )
        return $title;

    // Add the site name.
    $title .= get_bloginfo( 'name' );

    // Add the site description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
        $title = "$title $sep $site_description";

    // Add a page number if necessary.
    if ( $paged >= 2 || $page >= 2 )
        $title = "$title $sep " . sprintf( __( 'Page %s', 'nodm2013' ), max( $paged, $page ) );

    return $title;
}
add_filter( 'wp_title', 'nodm2013_wp_title', 10, 2 );

/**
 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
 *
 * @since Twenty Twelve 1.0
 */
function nodm2013_page_menu_args( $args ) {
    if ( ! isset( $args['show_home'] ) )
        $args['show_home'] = true;
    return $args;
}
add_filter( 'wp_page_menu_args', 'nodm2013_page_menu_args' );

/**
 * Registers our main widget area and the front page widget areas.
 *
 * @since Twenty Twelve 1.0
 */
function nodm2013_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Main Sidebar', 'nodm2013' ),
        'id' => 'sidebar-1',
        'description' => __( 'Appears on posts and pages except the home page.', 'nodm2013' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s hidden-phone">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
}
add_action( 'widgets_init', 'nodm2013_widgets_init' );

if ( ! function_exists( 'nodm2013_content_nav' ) ) :

/**
 * Displays navigation to next/previous pages when applicable.
 *
 * @since Twenty Twelve 1.0
 */
function nodm2013_content_nav( $html_id ) {
    global $wp_query;

    $html_id = esc_attr( $html_id );

    if ( $wp_query->max_num_pages > 1 ) : ?>
        <nav id="<?php echo $html_id; ?>" class="navigation" role="navigation">
            <h3 class="assistive-text"><?php _e( 'Post navigation', 'nodm2013' ); ?></h3>
            <div class="nav-previous alignleft"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'nodm2013' ) ); ?></div>
            <div class="nav-next alignright"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'nodm2013' ) ); ?></div>
        </nav><!-- #<?php echo $html_id; ?> .navigation -->
    <?php endif;
}
endif;

if ( ! function_exists( 'nodm2013_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own nodm2013_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Twelve 1.0
 */
function nodm2013_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' :
        // Display trackbacks differently than normal comments.
    ?>
    <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
        <p><?php _e( 'Pingback:', 'nodm2013' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'nodm2013' ), '<span class="edit-link">', '</span>' ); ?></p>
    <?php
            break;
        default :
        // Proceed with normal comments.
        global $post;
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <article id="comment-<?php comment_ID(); ?>" class="comment">
            <header class="comment-meta comment-author vcard">
                <?php
                    echo get_avatar( $comment, 44 );
                    printf( '<cite class="fn">%1$s %2$s</cite>',
                        get_comment_author_link(),
                        // If current post author is also comment author, make it known visually.
                        ( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'nodm2013' ) . '</span>' : ''
                    );
                    printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
                        esc_url( get_comment_link( $comment->comment_ID ) ),
                        get_comment_time( 'c' ),
                        /* translators: 1: date, 2: time */
                        sprintf( __( '%1$s at %2$s', 'nodm2013' ), get_comment_date(), get_comment_time() )
                    );
                ?>
            </header><!-- .comment-meta -->

            <?php if ( '0' == $comment->comment_approved ) : ?>
                <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'nodm2013' ); ?></p>
            <?php endif; ?>

            <section class="comment-content comment">
                <?php comment_text(); ?>
                <?php edit_comment_link( __( 'Edit', 'nodm2013' ), '<p class="edit-link">', '</p>' ); ?>
            </section><!-- .comment-content -->

            <div class="reply">
                <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'nodm2013' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
            </div><!-- .reply -->
        </article><!-- #comment-## -->
    <?php
        break;
    endswitch; // end comment_type check
}
endif;

if ( ! function_exists( 'nodm2013_entry_meta' ) ) :
/**
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own nodm2013_entry_meta() to override in a child theme.
 *
 * @since Twenty Twelve 1.0
 */
function nodm2013_entry_meta() {
    // Translators: used between list items, there is a space after the comma.
    $categories_list = get_the_category_list( __( ', ', 'nodm2013' ) );

    // Translators: used between list items, there is a space after the comma.
    $tag_list = get_the_tag_list( '', __( ', ', 'nodm2013' ) );

    $date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
        esc_url( get_permalink() ),
        esc_attr( get_the_time() ),
        esc_attr( get_the_date( 'c' ) ),
        esc_html( get_the_date() )
    );

    $author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
        esc_attr( sprintf( __( 'View all posts by %s', 'nodm2013' ), get_the_author() ) ),
        get_the_author()
    );

    // Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
    if ( $tag_list ) {
        $utility_text = __( 'This entry was posted in %1$s and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.', 'nodm2013' );
    } elseif ( $categories_list ) {
        $utility_text = __( 'This entry was posted in %1$s on %3$s<span class="by-author"> by %4$s</span>.', 'nodm2013' );
    } else {
        $utility_text = __( 'This entry was posted on %3$s<span class="by-author"> by %4$s</span>.', 'nodm2013' );
    }

    printf(
        $utility_text,
        $categories_list,
        $tag_list,
        $date,
        $author
    );
}
endif;

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @since Twenty Twelve 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function nodm2013_customize_register( $wp_customize ) {
    $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
}
add_action( 'customize_register', 'nodm2013_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since Twenty Twelve 1.0
 */
function nodm2013_customize_preview_js() {
    wp_enqueue_script( 'nodm2013-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20120827', true );
}
add_action( 'customize_preview_init', 'nodm2013_customize_preview_js' );

/**
 * Add sponsor content type
 */
function sponsor_register() {
    $labels = array(
        'name' => _x('Sponsors', 'post type general name'),
        'singular_name' => _x('Sponsor', 'post type singular name'),
        'add_new' => _x('Add New', 'sponsor'),
        'add_new_item' => __('Add New Sponsor'),
        'edit_item' => __('Edit Sponsor'),
        'new_item' => __('New Sponsor'),
        'view_item' => __('View Sponsor'),
        'search_items' => __('Search Sponsors'),
        'not_found' =>  __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => ''
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        // 'menu_icon' => get_stylesheet_directory_uri() . '/article16.png',
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title','thumbnail')
      );

    register_post_type( 'sponsor' , $args );
}
add_action( 'init', 'sponsor_register' );

function admin_init(){
    add_meta_box("sponsor_meta", "Sponsor Details", "sponsor_meta", "sponsor", "normal", "low");
}
add_action("admin_init", "admin_init");

function sponsor_meta(){
    global $post;
    $custom = get_post_custom($post->ID);
    $sponsor_url = $custom["sponsor_url"][0];
    $sponsor_level = $custom["sponsor_level"][0];
    ?>
    <p>
        <label for="sponsor_url">Website URL</label><br />
        <input type="text" name="sponsor_url" value="<?php echo $sponsor_url; ?>" placeholder="http://example.com" />
    </p>
    <p>
        <label for="sponsor_level">Level</label><br />
        <input type="number" name="sponsor_level" value="<?php echo $sponsor_level; ?>" min="1" max="5" step="1" />
    </p>
    <?php
}

function save_details(){
    global $post;
    update_post_meta($post->ID, "sponsor_url", $_POST["sponsor_url"]);
    update_post_meta($post->ID, "sponsor_level", $_POST["sponsor_level"]);
}
add_action('save_post', 'save_details');

function sponsor_edit_columns($columns){
    $columns = array(
        "cb" => "<input type='checkbox' />",
        "title" => "Name",
        "url" => "Website URL",
        "level" => "Level",
    );

    return $columns;
}
function sponsor_custom_columns($column){
    global $post;

    switch ($column) {
        case "url":
            $custom = get_post_custom();
            echo $custom["sponsor_url"][0];
            break;
        case "level":
            $custom = get_post_custom();
            echo $custom["sponsor_level"][0];
            break;
    }
}
add_action("manage_posts_custom_column",  "sponsor_custom_columns");
add_filter("manage_edit-sponsor_columns", "sponsor_edit_columns");

/**
 * Widget for sidebar sponsors
 */
class Random_Sponsors extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'random_sponsors', // Base ID
            'Random Sponsors', // Name
            array(
                'description' => __( 'A widget that displays a random list of sponsors weighted by their level.', 'text_domain' ),
            ) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );

        echo $before_widget;
        if ( ! empty( $title ) )
            echo $before_title . $title . $after_title;

        add_image_size($name = 'sponsor', $width = 156);

        global $post;
        for ($i = 5; $i >= 1; $i--) {
            $args = array( 'post_type' => 'sponsor', 'posts_per_page' => $instance['level' . $i], 'orderby' => 'rand', 'meta_key' => 'sponsor_level', 'meta_value' => $i );
            $loop = new WP_Query( $args );
            while ( $loop->have_posts() ) : $loop->the_post();
            ?>
                <div class="individual-sponsor">
                    <a target="_blank" href="<?php $key = "sponsor_url"; echo get_post_meta($post->ID, $key, true); ?>"><?php
                    $attr = array(
                        'alt'   => $title . ' logo',
                        'title' => $title,
                    );
                    the_post_thumbnail('sponsor');
                    ?></a>
                </div><!-- #post -->
            <?php
            endwhile;
        }


        echo $after_widget;
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['level1'] = strip_tags( $new_instance['level1'] );
        $instance['level2'] = strip_tags( $new_instance['level2'] );
        $instance['level3'] = strip_tags( $new_instance['level3'] );
        $instance['level4'] = strip_tags( $new_instance['level4'] );
        $instance['level5'] = strip_tags( $new_instance['level5'] );

        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'New title', 'text_domain' );
        }
        if ( isset( $instance[ 'level1' ] ) ) {
            $level1 = $instance[ 'level1' ];
        }
        else {
            $level1 = __( '0', 'text_domain' );
        }
        if ( isset( $instance[ 'level2' ] ) ) {
            $level2 = $instance[ 'level2' ];
        }
        else {
            $level2 = __( '0', 'text_domain' );
        }
        if ( isset( $instance[ 'level3' ] ) ) {
            $level3 = $instance[ 'level3' ];
        }
        else {
            $level3 = __( '0', 'text_domain' );
        }
        if ( isset( $instance[ 'level4' ] ) ) {
            $level4 = $instance[ 'level4' ];
        }
        else {
            $level4 = __( '0', 'text_domain' );
        }
        if ( isset( $instance[ 'level5' ] ) ) {
            $level5 = $instance[ 'level5' ];
        }
        else {
            $level5 = __( '0', 'text_domain' );
        }

        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label><br />
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'level1' ); ?>"><?php _e( '# level 1:' ); ?></label>
            <input class="" id="<?php echo $this->get_field_id( 'level1' ); ?>" name="<?php echo $this->get_field_name( 'level1' ); ?>" type="number" min="0" max="9" step="1" value="<?php echo esc_attr( $level1 ); ?>" /><br />
            <label for="<?php echo $this->get_field_id( 'level2' ); ?>"><?php _e( '# level 2:' ); ?></label>
            <input class="" id="<?php echo $this->get_field_id( 'level2' ); ?>" name="<?php echo $this->get_field_name( 'level2' ); ?>" type="number" min="0" max="9" step="1" value="<?php echo esc_attr( $level2 ); ?>" /><br />
            <label for="<?php echo $this->get_field_id( 'level3' ); ?>"><?php _e( '# level 3:' ); ?></label>
            <input class="" id="<?php echo $this->get_field_id( 'level3' ); ?>" name="<?php echo $this->get_field_name( 'level3' ); ?>" type="number" min="0" max="9" step="1" value="<?php echo esc_attr( $level3 ); ?>" /><br />
            <label for="<?php echo $this->get_field_id( 'level4' ); ?>"><?php _e( '# level 4:' ); ?></label>
            <input class="" id="<?php echo $this->get_field_id( 'level4' ); ?>" name="<?php echo $this->get_field_name( 'level4' ); ?>" type="number" min="0" max="9" step="1" value="<?php echo esc_attr( $level4 ); ?>" /><br />
            <label for="<?php echo $this->get_field_id( 'level5' ); ?>"><?php _e( '# level 5:' ); ?></label>
            <input class="" id="<?php echo $this->get_field_id( 'level5' ); ?>" name="<?php echo $this->get_field_name( 'level5' ); ?>" type="number" min="0" max="9" step="1" value="<?php echo esc_attr( $level5 ); ?>" />
        </p>
        <?php
    }

} // class Random_Sponsors

// register Random_Sponsors widget
add_action( 'widgets_init', create_function( '', 'register_widget( "random_sponsors" );' ) );
