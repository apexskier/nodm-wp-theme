<!-- display-case is above this ^^^ -->

<div class="row">
    <div class="col-md-6">
        <h3>Countdown</h3>
        <span class="countdown">
        </span>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var dateMatch = /(\w+) (\d+)\w+, (\d+)/.exec('<?php echo get_theme_mod('event_date'); ?>');
            if (dateMatch) {
                var month = (function() {
                    switch (dateMatch[1].toLowerCase()) {
                        case 'june': return 6; // common case
                        case 'january': return 1;
                        case 'february': return 2;
                        case 'march': return 3;
                        case 'april': return 4;
                        case 'may': return 5;
                        case 'july': return 7;
                        case 'august': return 8;
                        case 'september': return 9;
                        case 'october': return 10;
                        case 'november': return 11;
                        case 'december': return 12;
                    };
                })();
                var day = dateMatch[2];
                var year = dateMatch[3];
            }
            var eventDate = new Date(year, month, day);

            window.setInterval(function() {
                var now = new Date();
            }, 1000);
            console.log(eventDate);
        });
        </script>
        <h3>Follow Us!</h3>
        <div id="social-media">
            <div class="floating clearfix">
                <div class="pinterest">
                    <a href="//www.pinterest.com/pin/create/button/" data-pin-do="buttonBookmark" data-pin-color="white" data-pin-height="28"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_white_28.png" /></a>
                    <script type="text/javascript" async defer src="//assets.pinterest.com/js/pinit.js"></script>
                </div>
                <div class="twitter">
                    <a href="https://twitter.com/nodm2613" class="twitter-follow-button" data-show-count="false" data-size="large">Follow @nodm2613</a>
                    <script>!function(d,s,i){var j,f=d.getElementsByTagName(s)[0];if(!d.getElementById(i)){j=d.createElement(s);j.i=i;j.src='//platform.twitter.com/widgets.js';j.async=true;j.defer=true;f.parentNode.insertBefore(j,f);}}(document,'script','twitter-wjs');</script>
                </div>
            </div>
            <div class="facebook">
                <iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2FNODMRace&amp;send=false&amp;layout=standard&amp;width=300&amp;show_faces=true&amp;font=arial&amp;colorscheme=light&amp;action=like&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:80px;" allowTransparency="true"></iframe>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <?php while (have_posts()) : the_post(); ?>
          <?php get_template_part('templates/content', 'page'); ?>
        <?php endwhile; ?>
    </div>
</div>

<h3>Sponsors</h3>
<div class="row sponsors">
    <div class="col-md-6 col-md-push-6">
        <div class="row">
            <div class="col-sm-4">
                <div class="sponsor-img"><img src="http://placehold.it/165x125" style="max-width: 100%;"></div>
            </div>
            <br class="visible-xs-inline">
            <div class="col-sm-8">
                <div class="sponsor-img"><img src="http://placehold.it/360x125" style="max-width: 100%;"></div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-8">
                <div class="sponsor-img"><img src="http://placehold.it/360x218" style="max-width: 100%;"></div>
            </div>
            <br class="visible-xs-inline">
            <div class="col-sm-4">
                <div class="sponsor-img"><img src="http://placehold.it/165x218" style="max-width: 100%;"></div>
            </div>
        </div>
        <br>
    </div>
    <div class="col-md-6 col-md-pull-6">
        <div class="row">
            <div class="col-sm-4">
                <div class="sponsor-img"><img src="http://placehold.it/165x125" style="max-width: 100%;"></div>
                <br>
                <div class="sponsor-img"><img src="http://placehold.it/165x218" style="max-width: 100%;"></div>
            </div>
            <br class="visible-xs-inline">
            <div class="col-sm-8">
                <div class="sponsor-img"><img src="http://placehold.it/360x218" style="max-width: 100%;"></div>
                <br>
                <div class="sponsor-img"><img src="http://placehold.it/360x125" style="max-width: 100%;"></div>
            </div>
        </div>
        <br>
    </div>
</div>

