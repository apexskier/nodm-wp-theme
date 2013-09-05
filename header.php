<!DOCTYPE html>
<!--[if lt IE 7]>      <html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html <?php language_attributes(); ?> class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php wp_title( '|', true, 'right' ); ?></title>

    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

    <?php wp_head(); ?><?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
    <!--[if lt IE 9]>
    <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
    <![endif]-->
</head>
<body <?php body_class(); ?>>
    <!--[if lt IE 7]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->
<div class="color-stripe">
	<div class="color red"></div>
	<div class="color blue"></div>
	<div class="color green"></div>
	<div class="color orange"></div>
</div>
<div class="header-bg">
    <div class="container header">

        <a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'nodm2013' ); ?>"><?php _e( 'Skip to content', 'nodm2013' ); ?></a>

        <div class="logo-action row">
            <h1 class="site-title col-sm-6 visuallyhidden"><a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><span class="visible-lg">North Olympic <br />Discovery Marathon</span><span class="hidden-lg">NODM</span></a></h1>

            <div class="action-links col-sm-6">
                <div class="pull-right">
                    <?php wp_nav_menu( array( 'theme_location' => 'action-links', 'menu_class' => 'action-links', 'container' => false ) ); ?>
                </div>
            </div>
        </div>
        
        <div class="row">
                <nav id="main-nav" role="navigation">
                		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu nav', 'container' => false ) ); ?>
        		</nav>
        </div>		
    </div>
</div>
