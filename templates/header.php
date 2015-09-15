<header>
    <div class="header-parallax">
        <div class="mountains-container">
            <div class="mountains bg"></div>
            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/mountains.svg" class="mountains" alt="">
        </div>
        <div class="foothills-container">
            <div class="foothills bg"></div>
            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/foothills-left.svg" class="foothills left" alt="">
            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/foothills-right.svg" class="foothills right" alt="">
        </div>
        <div class="trees-container">
            <div class="trees bg"></div>
            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/trees-left.svg" class="trees left" alt="">
            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/trees-right.svg" class="trees right" alt="">
        </div>
    </div>
    <div class="container" role="banner">
        <div class="row">
            <div class="col-lg-6 col-md-7 col-sm-6">
                <h1 class="text-hide">
                    <a class="brand" href="<?= esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
                </h1>
                <a class="brand" href="<?= esc_url(home_url('/')); ?>">
                    <img alt="<?php bloginfo('name'); ?>" src="<?php echo get_template_directory_uri(); ?>/dist/images/nodm-logo.svg">
                </a>
            </div>
            <div class="col-lg-6 col-md-5 col-sm-6 header-right">
                <h3><?php echo get_theme_mod('event_date'); ?></h3>
                <p><small><?php echo get_theme_mod('event_details'); ?></small></p>
                <button class="btn btn-lg btn-primary">Register</button>
                <?php dynamic_sidebar('header-right'); ?>
            </div>
        </div>
    </div>
</header>
<nav role="navigation" class="closed <?php if ($post->post_parent || count(get_pages('child_of='.$post->ID)) > 0) { echo " has-parent"; }?>">
    <div class="container">
    <?php if (has_nav_menu('primary_navigation')) :
        wp_nav_menu([
          'theme_location'  => 'primary_navigation',
          'container'       => '',
          'container_class' => '',
          'container_id'    => '',
          'menu_class'      => 'menu',
          'menu_id'         => '',
          'echo'            => true,
          'fallback_cb'     => 'wp_page_menu',
          'before'          => '',
          'after'           => '',
          'link_before'     => '',
          'link_after'      => '',
          'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
          'depth'           => 0,
          'walker'          => ''
        ]);
    endif; ?>

        <div alt="Toggle Menu" id="mobile-nav-toggle" class="visible-xs-block" tabindex="1">
          <span></span>
          <span></span>
          <span></span>
          <span class="text-hide">Toggle Menu</span>
        </div>
    </div>
</nav>
