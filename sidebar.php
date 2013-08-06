<?php
/**
 * The sidebar containing the main widget area.
 *
 * If no active widgets in sidebar, let's hide it completely.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
        <div id="secondary" class="col-sm-3 col-lg-2" role="complementary">
            <div class="side-social-media clearfix">
                <div class="facebook ">
                    <div id="fb-root"></div>
                    <script>(function(d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) return;
                        js = d.createElement(s); js.id = id;
                        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));</script>
                        <div class="fb-like" data-href="https://www.facebook.com/NODMRace" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-font="arial"></div>
                </div>
                <div class="twitter ">
                    <a href="https://twitter.com/intent/tweet?button_hashtag=NODM" class="twitter-hashtag-button" data-lang="en">Tweet #NODM</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                </div>
                <div class="pinterest ">
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
            </div>
            <?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div><!-- #secondary -->
	<?php endif; ?>
