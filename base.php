<?php

use Roots\Sage\Config;
use Roots\Sage\Wrapper;

?>

<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
  <?php get_template_part('templates/head'); ?>
  <body <?php body_class(); ?>>
    <!--[if lt IE 9]>
      <div class="alert alert-warning">
        <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
      </div>
    <![endif]-->
<?php
do_action('get_header');
get_template_part('templates/header');
?>
    <?php if (is_page('Home')) : ?>
    <div class="display-case-bg">
        <div class="container display-case">
            <div class="row">
                <div class="col-sm-5 col-sm-push-7">
                    <div class="text-center right">
                        <?php dynamic_sidebar('display-case'); ?>
                    </div>
                </div>
<?php
$lead_text = get_theme_mod('lead_text');
if ($lead_text != ''):
?>
                <div class="col-sm-7 left-container">
                    <div class="left">
                        <?php echo $lead_text; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="wrap container" role="document">
      <div class="content row">
        <main class="main<?php if (Config\display_sidebar()) echo " col-sm-9 col-lg-8"; ?>" role="main">
          <?php include Wrapper\template_path(); ?>
        </main><!-- /.main -->
        <?php if (Config\display_sidebar()) : ?>
          <aside class="sidebar col-sm-3 col-lg-3 col-lg-push-1" role="complementary">
            <?php include Wrapper\sidebar_path(); ?>
          </aside><!-- /.sidebar -->
        <?php endif; ?>
      </div><!-- /.content -->
    </div><!-- /.wrap -->
    <?php if (is_page('Home')) : ?>
    <div class="second-image-bg">
        <div class="container second-image">
            <div class="row">
            </div>
        </div>
    </div>
    <div class="container">
        <?php dynamic_sidebar('home-content'); ?>
    </div>
    <?php endif; ?>
<?php
do_action('get_footer');
get_template_part('templates/footer');
wp_footer();
?>
  </body>
</html>
