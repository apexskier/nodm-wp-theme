<!-- display-case is above this ^^^ -->

    <div class="col-sm-6">
        <h3>Countdown</h3>
        <p class="countdown">
            <span class="day"></span> <span class="day-text"></span>
            <span class="hour"></span> <span class="hour-text"></span>
            <span class="minute"></span> <span class="minute-text"></span>
            <span class="second"></span> <span class="second-text"></span>
        </p>

        <script>
(function () {
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
            var eventDate = new Date(year, month, day, <?php echo get_theme_mod('event_start_hour'); ?>);

            var containerEl = document.getElementsByClassName('countdown')[0];
            var dayEl = containerEl.getElementsByClassName('day')[0];
            var hourEl = containerEl.getElementsByClassName('hour')[0];
            var minuteEl = containerEl.getElementsByClassName('minute')[0];
            var secondEl = containerEl.getElementsByClassName('second')[0];
            var dayTextEl = containerEl.getElementsByClassName('day-text')[0];
            var hourTextEl = containerEl.getElementsByClassName('hour-text')[0];
            var minuteTextEl = containerEl.getElementsByClassName('minute-text')[0];
            var secondTextEl = containerEl.getElementsByClassName('second-text')[0];

            function tick() {
                dayEl.classList.remove('animate');
                hourEl.classList.remove('animate');
                minuteEl.classList.remove('animate');
                secondEl.classList.remove('animate');
                var now = new Date();
                var dateDiff = (eventDate - now);
                var dayDiff = dateDiff / (1000 * 60 * 60 * 24);
                var dayInt = parseInt(dayDiff);
                var hourDiff = (dayDiff - dayInt) * 24;
                var hourInt = parseInt(hourDiff);
                var minuteDiff = (hourDiff - hourInt) * 60;
                var minuteInt = parseInt(minuteDiff);
                var secondDiff = (minuteDiff - minuteInt) * 60;
                var secondInt = parseInt(secondDiff);
                if (dayEl.textContent != dayInt) {
                    window.setTimeout(function () {
                        dayEl.classList.add('animate');
                    });
                }
                dayEl.textContent = dayInt;
                dayTextEl.textContent = 'day' + (dayInt == 1 ? '' : 's');
                if (hourEl.textContent != hourInt) {
                    window.setTimeout(function () {
                        hourEl.classList.add('animate');
                    });
                }
                hourEl.textContent = hourInt;
                hourTextEl.textContent = 'hour' + (hourInt == 1 ? '' : 's');
                if (minuteEl.textContent != minuteInt) {
                    window.setTimeout(function () {
                        minuteEl.classList.add('animate');
                    });
                }
                minuteEl.textContent = minuteInt;
                minuteTextEl.textContent = 'minute' + (minuteInt == 1 ? '' : 's');
                if (secondEl.textContent != secondInt) {
                    window.setTimeout(function () {
                        secondEl.classList.add('animate');
                    });
                }
                secondEl.textContent = secondInt;
                secondTextEl.textContent = 'second' + (secondInt == 1 ? '' : 's');
            }
            tick();
            window.setInterval(tick, 1000);
        });
})();
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
    <div class="col-sm-6">
        <?php while (have_posts()) : the_post(); ?>
          <?php get_template_part('templates/content', 'page'); ?>
        <?php endwhile; ?>
    </div>
