<?php

/**
 * Widget for sidebar sponsors
 */
class Anchor_Links extends WP_Widget {
    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'anchor_links', // Base ID
            'Anchor Links', // Name
            array(
                'description' => __( 'Display a list of anchor links contained within the pages content.', 'text_domain' ),
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
        $topText = $instance['toptext'];
        echo $before_widget;
        if ( ! empty( $title ) )
            echo $before_title . $title . $after_title;

        $content = get_the_content();
        $content = apply_filters('the_content', $content);
        $content = str_replace(']]>', ']]&gt;', $content);

        if ($content != '') {
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML('<?xml encoding="utf-8" ?>' . $content);
            libxml_use_internal_errors(false);
            $elements = $dom->getElementsByTagName('h3');
            $len = $elements->length;
            if ($len > 0) {
                echo '<ul>';
                foreach($elements as $element) {
                    $id = $element->getAttribute('id');
                    $name = $element->textContent;
                    echo '<li><a href="#' . $id . '">' . $name . '</a></li>';
                }
                echo '</ul>';
            }
        }

        echo '<a href="#menu-menu-1" class="top-link affix-top">' . $topText . '</a>';
        echo '<div class="top-spacing">';

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
        $instance['toptext'] = strip_tags( $new_instance['toptext'] );
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
        if (isset($instance['title'])) $title = $instance['title'];
        else $title = __('New title', 'text_domain');
        if (isset($instance['toptext'])) $topText = $instance['toptext'];
        else $topText = __('Back to Top', 'text_domain');
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label><br>
            <input class="widefat"
                   id="<?php echo $this->get_field_id( 'title' ); ?>"
                   name="<?php echo $this->get_field_name( 'title' ); ?>"
                   type="text"
                   value="<?php echo esc_attr( $title ); ?>" />
            <label for="<?php echo $this->get_field_id( 'toptext' ); ?>"><?php _e( 'Back to top link text:' ); ?></label><br>
            <input class="widefat"
                   id="<?php echo $this->get_field_id( 'toptext' ); ?>"
                   name="<?php echo $this->get_field_name( 'toptext' ); ?>"
                   type="text"
                   value="<?php echo esc_attr( $topText ); ?>" />
        </p>
        <?php
    }
} // class Anchor_Links

// register Anchor_Links widget
add_action( 'widgets_init', create_function( '', 'register_widget( "anchor_links" );' ) );

