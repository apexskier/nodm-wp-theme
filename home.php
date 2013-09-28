<?php get_header(); ?>

<div id="slideshow" class="carousel slide" data-interval="4000" data-pause="none">
    <ol class="carousel-indicators">
        <li data-target="#slideshow" data-slide-to="0" class="active"></li>
        <li data-target="#slideshow" data-slide-to="1"></li>
        <li data-target="#slideshow" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="active item">
            <img src="/wp-content/uploads/2013/06/DSC0236.jpg" alt="Ridge runners narrow depth of field" />
        </div>
        <div class="item">
            <img src="/wp-content/uploads/2013/06/DSC0039.jpg" alt="Kids finishing on the bridge" />
        </div>
        <div class="item">
            <img src="/wp-content/uploads/2013/06/Picture-146.jpg" alt="Runners rounding the bend" />
        </div>
    </div>
    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
        <span class="icon-prev"></span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
        <span class="icon-next"></span>
    </a>
</div>

<div class="container home">
	<?php 
        $eventsmenu = wp_nav_menu( array('theme_location' => 'events',
                                         'container'      => false,
                                         'menu_id'        => 'menu-events',
	                                     'menu_class'     => 'row',
	                                     'echo'           => '0',
                                         'items_wrap'     => '<div class="%2$s" id="%1$s">%3$s</div>',
                                         'depth'          => 0,) );
        $eventsmenu = str_replace('class="menu-item', 'class="menu-item col-lg-4 col-xs-6 ', $eventsmenu);
        $eventsmenu = str_replace('li', 'div', $eventsmenu);
        echo $eventsmenu;
    ?>
    <div class="row">
        <div class="col-sm-offset-2 col-sm-8">
            <div id="social-media" class="row">
                <div class="pinterest col-sm-4">
                    <a href="//pinterest.com/pin/create/button/?url=http%3A%2F%2Fnodm.com&media=http%3A%2F%2Fnodm.com%2Fsites%2Fall%2Fthemes%2Fnodmtheme%2Flogo.png&description=NODM%20Marathon!" data-pin-do="buttonPin" data-pin-config="beside"><img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" /></a>
                    <script type="text/javascript">
                    (function(d){
                      var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
                      p.type = 'text/javascript';
                      p.async = true;
                      p.src = '//assets.pinterest.com/js/pinit.js';
                      f.parentNode.insertBefore(p, f);
                    }(document));
                    </script>
                </div>
                <div class="facebook col-sm-4">
                    <iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2FNODMRace&amp;send=false&amp;layout=standard&amp;width=300&amp;show_faces=true&amp;font=arial&amp;colorscheme=light&amp;action=like&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:80px;" allowTransparency="true"></iframe>
                </div>
                <div class="twitter col-sm-4">
                    <a href="https://twitter.com/intent/tweet?button_hashtag=NODM" class="twitter-hashtag-button" data-size="large" data-lang="en">Tweet #NODM</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                </div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>
