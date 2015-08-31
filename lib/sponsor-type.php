<?php
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
add_action('init', __NAMESPACE__ . '\\sponsor_register');

function admin_init() {
    add_meta_box("sponsor_meta", "Sponsor Details", "sponsor_meta", "sponsor", "normal", "low");
}
add_action("admin_init", "admin_init");

function sponsor_meta() {
    global $post;
    $custom = get_post_custom($post->ID);
    $sponsor_url = $custom["sponsor_url"][0];
    $sponsor_level = $custom["sponsor_level"][0];
    ?>
    <p>
        <label for="sponsor_url">Website URL</label><br />
        <input type="text" name="sponsor_url" value="<?php echo $sponsor_url; ?>" placeholder="https://example.com" />
    </p>
    <p>
        <label for="sponsor_level">Level</label><br />
        <input type="number" name="sponsor_level" value="<?php echo $sponsor_level; ?>" min="1" max="5" step="1" />
    </p>
    <?php
}

function save_details() {
    global $post;
    update_post_meta($post->ID, "sponsor_url", $_POST["sponsor_url"]);
    update_post_meta($post->ID, "sponsor_level", $_POST["sponsor_level"]);
}
add_action('save_post', 'save_details');

function sponsor_edit_columns($columns) {
    $columns = array(
        "cb" => "<input type='checkbox' />",
        "title" => "Name",
        "url" => "Website URL",
        "level" => "Level",
    );

    return $columns;
}
function sponsor_custom_columns($column) {
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
add_action('widgets_init', create_function('', 'register_widget("random_sponsors");'));
