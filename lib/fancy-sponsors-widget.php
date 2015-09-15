<?php

function generate_post_select($posts, $select_id, $select_name, $selected) {
    echo '<select class="widefat" name="' . $select_name . '" id="' . $select_id . '">';
    echo '<option value=""', $selected == '-1' ? ' selected="selected"' : '', '>None</option>';
    echo '<option value="-2"', $selected == '-2' ? ' selected="selected"' : '', '>Random</option>';
    foreach ($posts as $post) {
        echo '<option value="', $post->ID, '"', $selected == $post->ID ? ' selected="selected"' : '', '>', $post->post_title, '</option>';
    }
    echo '</select>';
}

/**
 * Widget for sidebar sponsors
 */
class Fancy_Sponsors_Block extends WP_Widget {
    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'fancy_sponsors_block', // Base ID
            'Fancy Sponsors Block', // Name
            array(
                'description' => __( 'A widget that displays a random list of sponsors weighted by their level.', 'text_domain' ),
            ) // Args
        );
    }

    public function echo_image($id, $size, &$cache) {
        if ($id != ''):
            if ($id == '-2') {
                $tries = 0;

                while ($tries == 0 || (in_array($id, $cache) && $tries < 8)) {
                    $rand_sponsor = get_posts(array(
                        'post_type' => 'sponsor',
                        'numberposts' => 1,
                        'orderby' => 'rand'
                    ));
                    if ($rand_sponsor) $id = $rand_sponsor[0]->ID;
                    else return;
                    $tries++;
                }
                if ($tries == 8) {
                    $rand_sponsor = get_posts(array(
                        'post_type' => 'sponsor',
                        'numberposts' => 1,
                        'orderby' => 'rand'
                    ));
                    $id = $rand_sponsor[0]->ID;
                }
                $title = $rand_sponsor[0]->post_title;
            } else {
                $title = get_post($id)->post_title;
            }
            if (!in_array($id, $cache)) $cache[] = $id;
            $image = wp_get_attachment_image_src(get_post_thumbnail_id($id), $size);
        ?>
            <div class="sponsor-img">
                <a href="<?php $key = "sponsor_url"; echo get_post_meta($id, $key, true); ?>" target="_blank">
                    <img title="<?php echo $title; ?>" src="<?php echo $image[0] ?>" style="max-width: 100%;">
                </a>
            </div>
        <?php endif;
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
        $usedSponsors = array();
        ?>
<div class="row sponsors">
    <div class="col-md-6 col-md-push-6">
        <div class="row">
            <div class="col-sm-4">
                <?php $this->echo_image($instance['sponsor1'], 'bootstrap_165x125', $usedSponsors); ?>
            </div>
            <br class="visible-xs-inline">
            <div class="col-sm-8">
                <?php $this->echo_image($instance['sponsor2'], 'bootstrap_360x125', $usedSponsors); ?>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-8">
                <?php $this->echo_image($instance['sponsor3'], 'bootstrap_360x218', $usedSponsors); ?>
            </div>
            <br class="visible-xs-inline">
            <div class="col-sm-4">
                <?php $this->echo_image($instance['sponsor4'], 'bootstrap_165x218', $usedSponsors); ?>
            </div>
        </div>
        <br>
    </div>
    <div class="col-md-6 col-md-pull-6">
        <div class="row">
            <div class="col-sm-4">
                <?php $this->echo_image($instance['sponsor5'], 'bootstrap_165x125', $usedSponsors); ?>
                <br>
                <?php $this->echo_image($instance['sponsor6'], 'bootstrap_165x218', $usedSponsors); ?>
            </div>
            <br class="visible-xs-inline">
            <div class="col-sm-8">
                <?php $this->echo_image($instance['sponsor7'], 'bootstrap_360x218', $usedSponsors); ?>
                <br>
                <?php $this->echo_image($instance['sponsor8'], 'bootstrap_360x125', $usedSponsors); ?>
            </div>
        </div>
        <br>
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
        $instance['sponsor1'] = strip_tags( $new_instance['sponsor1'] );
        $instance['sponsor2'] = strip_tags( $new_instance['sponsor2'] );
        $instance['sponsor3'] = strip_tags( $new_instance['sponsor3'] );
        $instance['sponsor4'] = strip_tags( $new_instance['sponsor4'] );
        $instance['sponsor5'] = strip_tags( $new_instance['sponsor5'] );
        $instance['sponsor6'] = strip_tags( $new_instance['sponsor6'] );
        $instance['sponsor7'] = strip_tags( $new_instance['sponsor7'] );
        $instance['sponsor8'] = strip_tags( $new_instance['sponsor8'] );
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
        } else {
            $title = __( 'New title', 'text_domain' );
        }
        if ( isset( $instance[ 'sponsor1' ] ) ) { $sponsor1 = $instance[ 'sponsor1' ]; }
        else { $sponsor1 = __( '-2', 'text_domain' ); }
        if ( isset( $instance[ 'sponsor2' ] ) ) { $sponsor2 = $instance[ 'sponsor2' ]; }
        else { $sponsor2 = __( '-2', 'text_domain' ); }
        if ( isset( $instance[ 'sponsor3' ] ) ) { $sponsor3 = $instance[ 'sponsor3' ]; }
        else { $sponsor3 = __( '-2', 'text_domain' ); }
        if ( isset( $instance[ 'sponsor4' ] ) ) { $sponsor4 = $instance[ 'sponsor4' ]; }
        else { $sponsor4 = __( '-2', 'text_domain' ); }
        if ( isset( $instance[ 'sponsor5' ] ) ) { $sponsor5 = $instance[ 'sponsor5' ]; }
        else { $sponsor5 = __( '-2', 'text_domain' ); }
        if ( isset( $instance[ 'sponsor6' ] ) ) { $sponsor6 = $instance[ 'sponsor6' ]; }
        else { $sponsor6 = __( '-2', 'text_domain' ); }
        if ( isset( $instance[ 'sponsor7' ] ) ) { $sponsor7 = $instance[ 'sponsor7' ]; }
        else { $sponsor7 = __( '-2', 'text_domain' ); }
        if ( isset( $instance[ 'sponsor8' ] ) ) { $sponsor8 = $instance[ 'sponsor8' ]; }
        else { $sponsor8 = __( '-2', 'text_domain' ); }

        $post_type_object = get_post_type_object('sponsor');
        $label = $post_type_object->label;
        $posts = get_posts(array(
            'post_type'=> 'sponsor',
            'post_status'=> 'publish',
            'suppress_filters' => false,
            'posts_per_page' => -1
        ));
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label><br />
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'sponsor1' ); ?>">Sponsor 1</label><br />
            <?php generate_post_select($posts, $this->get_field_id( 'sponsor1' ), $this->get_field_name( 'sponsor1' ), esc_attr( $sponsor1 ))?>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'sponsor2' ); ?>">Sponsor 2</label><br />
            <?php generate_post_select($posts, $this->get_field_id( 'sponsor2' ), $this->get_field_name( 'sponsor2' ), esc_attr( $sponsor2 ))?>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'sponsor3' ); ?>">Sponsor 3</label><br />
            <?php generate_post_select($posts, $this->get_field_id( 'sponsor3' ), $this->get_field_name( 'sponsor3' ), esc_attr( $sponsor3 ))?>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'sponsor4' ); ?>">Sponsor 4</label><br />
            <?php generate_post_select($posts, $this->get_field_id( 'sponsor4' ), $this->get_field_name( 'sponsor4' ), esc_attr( $sponsor4 ))?>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'sponsor5' ); ?>">Sponsor 5</label><br />
            <?php generate_post_select($posts, $this->get_field_id( 'sponsor5' ), $this->get_field_name( 'sponsor5' ), esc_attr( $sponsor5 ))?>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'sponsor6' ); ?>">Sponsor 6</label><br />
            <?php generate_post_select($posts, $this->get_field_id( 'sponsor6' ), $this->get_field_name( 'sponsor6' ), esc_attr( $sponsor6 ))?>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'sponsor7' ); ?>">Sponsor 7</label><br />
            <?php generate_post_select($posts, $this->get_field_id( 'sponsor7' ), $this->get_field_name( 'sponsor7' ), esc_attr( $sponsor7 ))?>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'sponsor8' ); ?>">Sponsor 8</label><br />
            <?php generate_post_select($posts, $this->get_field_id( 'sponsor8' ), $this->get_field_name( 'sponsor8' ), esc_attr( $sponsor8 ))?>
        </p>
        <?php
    }
} // class Fancy_Sponsors_Block

// register Fancy_Sponsors_Block widget
add_action( 'widgets_init', create_function( '', 'register_widget( "fancy_sponsors_block" );' ) );

