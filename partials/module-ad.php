<?php
/**
 * The template for displaying the Ad module.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package soup2nuts
 */

$section = '';
if ( isset( $home_section ) ) {

  $section = $home_section;

} elseif ( isset( $tax_section ) ) {

  $section = $tax_section;
} elseif ( is_singular() ) {

  $section = 'single';
}

$position = isset( $posts->current_post ) ? $posts->current_post : 1;

$position = ( $position < 1 ) ? 1 : $position;

$tag_code = null;

if ( !empty( $section ) ) {
  switch ($section) {
    case 'single':
      $tag_code = ( $position == 0 ) ? '300x600-post-sidebar-atf' : '300x600-post-footer-atf';
      break;

    case 'events':
      $tag_code = ( $position == 0 ) ? '900x250-home-before-events' : '900x250-home-after-events';
      break;

    case 'promotions':
      $tag_code = '300x250-promotions-btf';
      break;

    case 'features':
      $tag_code = '300x250';
      break;

    default:
      $tag_code = '300x250';
      break;
  }
}


?><div class="ad">
  <?php do_action( 'acm_tag', $tag_code ); ?>
</div>
