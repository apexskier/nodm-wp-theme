<?php

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
            $args = array(
                'post_type' => 'sponsor',
                'posts_per_page' => $instance['level' . $i],
                'orderby' => 'rand',
                'meta_key' => 'sponsor_level',
                'meta_value' => $i
            );
            $loop = new WP_Query( $args );
            while ( $loop->have_posts() ) : $loop->the_post();
            ?>
                <div class="individual-sponsor">
                    <a target="_blank" href="<?php $key = "sponsor_url"; echo get_post_meta($post->ID, $key, true); ?>"><?php
                    $attr = array(
                        'alt'    => $title . ' logo',
                        'title'  => $title,
                        'target' => '_blank'
                    );
                    the_post_thumbnail('sponsor', $attr);
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

