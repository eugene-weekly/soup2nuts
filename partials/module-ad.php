<?php
/**
 * The template for displaying the Ad module.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package soup2nuts
 */

$section = '';
$tag_code = '300x250_featured';
if ( isset( $home_section ) ) {

  $section = $home_section;

} elseif ( isset( $tax_section ) ) {

  $section = $tax_section;
}

$position = isset( $posts->current_post ) ? $posts->current_post : 1;

$position = ( $position < 1 ) ? 1 : $position;

if ( !empty( $section ) ) {

}

if ( !$tag_code )
  return;

?><div class="ad">
  <?php do_action( 'acm_tag', $tag_code ); ?>
</div>
