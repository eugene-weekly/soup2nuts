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
}

$position = isset( $posts->current_post ) ? $posts->current_post : 1;

$position = ( $position < 1 ) ? 1 : $position;

if ( !empty( $section ) ) {
  switch ($section) {
    case 'promotions':
      $tag_code = '300x250';
      break;

    case 'features':
    default:
      $tag_code = '300x250';
      break;
  }
}

if ( !$tag_code )
  $tag_code = '300x250';

?><div class="ad">
  <?php do_action( 'acm_tag', $tag_code ); ?>
</div>
