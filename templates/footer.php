<footer class="content-info" role="contentinfo">
  <div class="container">
    <?php dynamic_sidebar('sidebar-footer'); ?>
    <div class="clearfix">
      <hr>
      <span class="pull-right">Site by <a href="http://camlittle.com" target="_blank">Cameron Little</a></span>
      <span class="pull-left">&copy; 2013<?php $currentYear = date("Y"); echo ($currentYear == '2013' ? '' : '&ndash;'.$currentYear); ?> Port Angeles Marathon Association</span>
    </div>
  </div>
</footer>
