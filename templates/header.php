<header>
    <div class="container" role="banner">
        <div class="row">
            <div class="col-md-4">
                <h1 class="text-hide">
                    <a class="brand" href="<?= esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
                </h1>
                <a class="brand" href="<?= esc_url(home_url('/')); ?>">
                    <img alt="<?php bloginfo('name'); ?>" src="http://placehold.it/300x150">
                </a>
            </div>
            <div class="col-md-8 text-right">
                <br>
                <h3>June 5th, 2016</h3>
                <button class="btn btn-lg btn-primary">Register</button>
            </div>
        </div>
    </div>
</header>
<nav role="navigation" class="closed">
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

        <div alt="Toggle Menu" id="mobile-nav-toggle" class="visible-xs-inline-block" tabindex="1">
          <span></span>
          <span></span>
          <span></span>
          <span class="text-hide">Toggle Menu</span>
        </div>
    </div>
</nav>
