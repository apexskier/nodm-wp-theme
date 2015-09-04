<?php

/**
 * Widget for sidebar sponsors
 */
class NODM_Social_Media extends WP_Widget {
    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'nodm_social_media', // Base ID
            'Social Media', // Name
            array(
                'description' => __( 'Hardcoded mini social media buttons.', 'text_domain' ),
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
            ?>
<div class="side-social-media clearfix">
    <div class="facebook">
        <div id="fb-root"></div>
        <script>(function(d,s,i){var j,f=d.getElementsByTagName(s)[0];if(d.getElementById(i))return;j=d.createElement(s);j.i=i;j.src="//connect.facebook.net/en_US/all.js#xfbml=1";j.async=true;j.defer=true;f.parentNode.insertBefore(j,f);}(document,'script','facebook-jssdk'));</script>
        <div class="fb-like" data-href="https://www.facebook.com/NODMRace" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-font="arial"></div>
    </div>
    <div class="twitter">
        <a href="https://twitter.com/nodm2613" class="twitter-follow-button" data-show-count="false">Follow @nodm2613</a>
        <script>!function(d,s,i){var j,f=d.getElementsByTagName(s)[0];if(!d.getElementById(i)){j=d.createElement(s);j.i=i;j.src='//platform.twitter.com/widgets.js';j.async=true;j.defer=true;f.parentNode.insertBefore(j,f);}}(document,'script','twitter-wjs');</script>
    </div>
    <div class="pinterest">
        <a href="//www.pinterest.com/pin/create/button/" data-pin-do="buttonBookmark" data-pin-color="white"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_white_20.png" /></a> <!-- Please call pinit.js only once per page -->
        <script type="text/javascript" async defer src="//assets.pinterest.com/js/pinit.js"></script>
    </div>
</div>
        <?php
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
        $instance['facebook_handle'] = strip_tags( $new_instance['facebook_handle'] );
        $instance['twitter_handle'] = strip_tags( $new_instance['twitter_handle'] );
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
        if ( isset( $instance[ 'facebook_handle' ] ) ) {
            $facebook_handle = $instance[ 'facebook_handle' ];
        }
        else {
            $facebook_handle = __( 'NODMRace', 'text_domain' );
        }
        if ( isset( $instance[ 'twitter_handle' ] ) ) {
            $twitter_handle = $instance[ 'twitter_handle' ];
        }
        else {
            $twitter_handle = __( 'nodm2613', 'text_domain' );
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label><br />
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'facebook_handle' ); ?>"><?php _e( 'Facebook handle:' ); ?></label>
            <input class="" id="<?php echo $this->get_field_id( 'facebook_handle' ); ?>" name="<?php echo $this->get_field_name( 'facebook_handle' ); ?>" type="text" value="<?php echo esc_attr( $facebook_handle ); ?>" /><br />
            <label for="<?php echo $this->get_field_id( 'twitter_handle' ); ?>"><?php _e( 'Twitter handle:' ); ?></label>
            <input class="" id="<?php echo $this->get_field_id( 'twitter_handle' ); ?>" name="<?php echo $this->get_field_name( 'twitter_handle' ); ?>" type="text" value="<?php echo esc_attr( $twitter_handle ); ?>" /><br />
        </p>
        <?php
    }
}

add_action( 'widgets_init', create_function( '', 'register_widget( "nodm_social_media" );' ) );

