<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package soup2nuts
 */

$sidebarType = ( is_archive() ) ? 'archive' : 'post';
$sidebarType = ( is_author() ) ? 'author' : $sidebarType;

if ( ! is_active_sidebar( $sidebarType . '-sidebar' ) ) {
  return;
}
?>

<div id="secondary" class="widget-area" role="complementary">
  <?php dynamic_sidebar( $sidebarType . '-sidebar' ); ?>
</div><!-- #secondary -->
