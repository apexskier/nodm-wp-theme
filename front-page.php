<!-- display-case is above this ^^^ -->

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

<h3>Countdown</h3>

<h3>Content</h3>

<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/content', 'page'); ?>
<?php endwhile; ?>
