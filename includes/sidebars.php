<?php
/**
 *  Register Sidebars.
 *
 * @package WordPress
 * @subpackage soup2nuts Music News
 */


/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function soup2nuts_widgets_init() {
  register_sidebar( array(
    'name'          => esc_html__( 'Post Sidebar', 'soup2nuts' ),
    'id'            => 'post-sidebar',
    'description'   => '',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h1 class="widget-title">',
    'after_title'   => '</h1>',
  ) );

  register_sidebar( array(
    'name'          => esc_html__( 'Archive Sidebar', 'soup2nuts' ),
    'id'            => 'archive-sidebar',
    'description'   => '',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h1 class="widget-title">',
    'after_title'   => '</h1>',
  ) );

  register_sidebar( array(
    'name'          => esc_html__( 'Footer', 'soup2nuts' ),
    'id'            => 'footer',
    'description'   => '',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h6 class="widget-title">',
    'after_title'   => '</h6>',
  ) );
}
add_action( 'widgets_init', 'soup2nuts_widgets_init' );
