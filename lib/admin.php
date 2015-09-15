<?php

namespace Roots\Sage\Admin;

use WP_Customize_Image_Control;

function setup_customization( $wp_customize ) {
    $wp_customize->add_setting('event_details', array());
    $wp_customize->add_control('event_details', array(
        'label'     => __('Details', 'Sage'),
        'section'   => 'title_tagline',
        'settings'  => 'event_details',
        'type'      => 'textfield'
    ));

    $wp_customize->add_setting('event_date', array());
    $wp_customize->add_control('event_date', array(
        'label'     => __('Date', 'Sage'),
        'section'   => 'title_tagline',
        'settings'  => 'event_date',
        'type'      => 'textfield'
    ));

    $wp_customize->add_setting('event_start_hour', array());
    $wp_customize->add_control('event_start_hour', array(
        'label'     => __('Event Start Hour', 'Sage'),
        'section'   => 'title_tagline',
        'settings'  => 'event_start_hour',
        'type'      => 'textfield'
    ));

    $wp_customize->add_section('home_page' , array(
        'title' => __('Home Page', 'Sage'),
    ));
    $wp_customize->add_setting('lead_text', array());
    $wp_customize->add_control('lead_text', array(
        'label'     => __('Lead Text', 'Sage'),
        'section'   => 'home_page',
        'settings'  => 'lead_text',
        'type'      => 'textarea'
    ));

    $wp_customize->add_setting('lead_photo');
    $wp_customize->add_control(new WP_Customize_Image_Control(
        $wp_customize,
        'lead_photo',
        array(
            'label' => 'Image Upload',
            'section' => 'home_page',
            'settings' => 'lead_photo'
        )
    ));

    $wp_customize->add_setting('second_image');
    $wp_customize->add_control(new WP_Customize_Image_Control(
        $wp_customize,
        'second_image',
        array(
            'label' => 'Second Home Page Image (none to disable)',
            'section' => 'home_page',
            'settings' => 'second_image'
        )
    ));
}
add_action('customize_register', __NAMESPACE__ . '\\setup_customization');
