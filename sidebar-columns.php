<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package soup2nuts
 */

?>

<div id="secondary" class="widget-area" role="complementary">
  <div class="widget">
    <?php dynamic_sidebar( 'post-sidebar-1' ); ?>
  </div>
  <div class="widget">
    <?php dynamic_sidebar( 'post-sidebar-2' ); ?>
  </div>
  <div class="widget">
    <?php dynamic_sidebar( 'post-sidebar-3' ); ?>
  </div>
</div><!-- #secondary -->
