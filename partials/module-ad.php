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

if ( !empty( $section ) ) {
  switch ($section) {
    case 'single':
      $tag_code = '300x600';
      break;

    case 'promotions':
    case 'features':
    default:
      $tag_code = '300x250';
      break;
  }
}


?><div class="ad">
  <?php do_action( 'acm_tag', $tag_code ); ?>
</div>
