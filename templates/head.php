<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php
    wp_head();
    $secondImage = get_theme_mod('second_image');
  ?>
  <style>
      .display-case-bg {background-image: url("<?php echo get_theme_mod('lead_photo'); ?>");}
      <?php if ($secondImage): ?>
      .second-image-bg {background-image: url("<?php echo $secondImage; ?>");}
      <?php else: ?>
      .second-image-bg {display: none;}
      <?php endif; ?>
  </style>
</head>
