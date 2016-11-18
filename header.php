<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package soup2nuts
 */

?><!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 9]><html class="no-js lt-ie10" <?php language_attributes(); ?>><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta http-equiv="X-UA-Compatible" content="IE=10;IE=9;IE=8;IE=7;IE=EDGE,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
  <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
  <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
  <link rel="manifest" href="/manifest.json">
  <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#ec1c24">
  <meta name="apple-mobile-web-app-title" content="Eugene Weekly">
  <meta name="application-name" content="Eugene Weekly">
  <meta name="theme-color" content="#ffffff">

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
  <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'soup2nuts' ); ?></a>

  <header id="masthead" class="site-header" role="banner">
    <div class="container">
      <div class="site-branding">
        <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><span class="visuallyhidden"><?php bloginfo( 'name' ); ?></span><?php icon_sprite( 'logo-ew-type' ); ?></a></h1>
        <p class="site-description"><?php bloginfo( 'description' ); ?></p>
      </div><!-- .site-branding -->

      <nav id="site-navigation" class="main-navigation" role="navigation">
        <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
          <?php icon_sprite( 'icon-hamburger' ); ?>
          <?php icon_sprite( 'icon-close' ); ?>
        </button>
        <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
      </nav><!-- #site-navigation -->

      <?php $social_widget_instance = get_option('widget_wpcom_social_media_icons_widget');
      $social_widget_instance = array_shift( $social_widget_instance );

      the_widget( 'wpcom_social_media_icons_widget', $social_widget_instance ); ?>

      <?php the_widget( 'WP_Widget_Search' ); ?><!-- .widget-search -->

    </div>
  </header><!-- #masthead -->

  <div id="content" class="site-content">
