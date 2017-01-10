<?php
/**
 * soup2nuts Body and Post Class filters
 *
 * @package soup2nuts
 */


if ( ! function_exists( 'soup2nuts_pre_get_posts' ) ) :
 /**
  * Filter Queries.
  *
  * @param $query
  *
  * @return $query
  *
  * @since 0.1.0
  */

 function soup2nuts_pre_get_posts( $query ) {

  if ( is_admin() )
    return $query;


  if ( !$query->is_main_query() )
    return $query;


  $existingMetaQuery = $query->meta_query;

  // Filter Expired Promotions
  if ( get_query_var( 'post_type' ) == 'promotion' ) {

    $existingMetaQuery[ 'relation' ] = 'AND';
    $expiredMetaQuery = array(
      'key' => 'expiration-date',
      'value' => date( time() ),
      'type' => 'DATE',
      'compare' => 'EXISTS'
    );
  }


  if ( $query->is_home() || $query->is_front_page() ) {


    $thumbnailMetaQuery = array(
      'key' => '_thumbnail_id',
      'compare' => 'EXISTS'
    );

    $existingMetaQuery[] = $thumbnailMetaQuery;

    //pre_printr( $query );

  }

  $query->set( 'meta_query', $existingMetaQuery );

   return $query;
 }
endif; // soup2nuts_pre_get_posts

add_filter( 'pre_get_posts', 'soup2nuts_pre_get_posts' );


if ( ! function_exists( 'soup2nuts_title_filter' ) ) :
  /**
   * Filter the title, optionally to replace with Alternate Title.
   *
   * @param $title
   * @param $id
   *
   * @return $title
   *
   * @since 0.1.0
   */

  function soup2nuts_title_filter( $title, $id = null ) {

    if ( is_single( $id ) || is_admin() )
      return $title;

    $alt_title = get_post_meta( $id, 'alt-title', true );

    if ( !empty( $alt_title) )
      return $alt_title;

    return $title;

  }
endif; // soup2nuts_title_filter

add_filter( 'the_title', 'soup2nuts_title_filter', 10, 2 );


if ( ! function_exists( 'soup2nuts_body_class' ) ) :
  /**
   * Some extra classes for the body.
   *
   * @param $classes
   *
   * @return $classes
   *
   * @since 0.1.0
   */

  function soup2nuts_body_class( $classes ) {
    global $post;

    $postType = ( get_query_var( 'post_type' ) ) ? get_query_var( 'post_type' ) : 1;

    if ( is_page() )
      $classes[] = $post->post_type . '-' . $post->post_name;

    if ( is_page() && $post->post_parent > 0 )
      $classes[] = 'parent-page-' . basename( get_permalink( $post->post_parent ) );

    if ( is_home() || is_search() )
      $classes[] = 'archive';

    return $classes;
  }
endif; // soup2nuts_body_class

add_filter( 'body_class', 'soup2nuts_body_class' );


if ( ! function_exists( 'soup2nuts_post_class' ) ) :
  /**
   * Some extra classes for posts.
   *
   * @param $classes
   *
   * @return $classes
   *
   * @since 0.1.0
   */

  function soup2nuts_post_class( $classes ) {
    global $post;
    $fields = ( function_exists( 'get_fields' ) ) ? get_fields( $post->ID ) : null;

    $classes[] = ( !empty( $fields[ 'gallery' ] ) || has_post_thumbnail( $post->ID ) ) ? 'has-post-img' : 'no-post-img';

    return $classes;
  }
endif; // soup2nuts_post_class

add_filter( 'post_class', 'soup2nuts_post_class' );


if ( ! function_exists( 'soup2nuts_wp_nav_menu_args' ) ) :

  /**
   * Better defaults for wp_nav_menu
   *
   * @param $args (array)
   *
   * @return $args (array)
   *
   * @since 0.1.0
   */

  function soup2nuts_wp_nav_menu_args( $args = '' ) {

    // Always nav, never div
    $args['container'] = 'nav';
    $args['container_class'] = 'navigation-menu';

    if ( isset($args['menu']->name) && 'Social' == $args['menu']->name ) :

      // Except for the social menu, because it's not navigation
      $args['container'] = 'div';

    endif;

    return $args;
  }

endif; // excerpt_length

add_filter( 'wp_nav_menu_args', 'soup2nuts_wp_nav_menu_args' );


if ( ! function_exists( 'soup2nuts_nav_menu_item_title' ) ) :

  /**
   * Filter Nav Menu Item Title
   *
   * @param $title (string)
   * @param $item (array)
   * @param $args (array)
   * @param $depth (int)
   *
   * @return $title (string)
   *
   * @since 0.1.0
   */

  function soup2nuts_nav_menu_item_title( $title, $item, $args, $depth ) {

    $title = '<span class="menu-item-title">' . $title . '</span>';

    //  Add the Calendar icon
    if ( in_array( $item->post_title, array( 'Calendar', 'events', 'calendar', 'tribe_events' )) ) {
      $title .= get_the_icon( 'icon-calendar' );
    }

    // Add the Contact icon, but only for the Contact menu
    if ( $args->theme_location == 'contact' ) {
      $title .= get_the_icon( 'icon-contact' );
    }

    return $title;
  }

endif; // excerpt_length

add_filter( 'nav_menu_item_title', 'soup2nuts_nav_menu_item_title', 10, 4 );


if ( ! function_exists( 'soup2nuts_nav_menu_item_class' ) ) :

  /**
   * Filter Nav Menu Classes
   *
   * @param $classes (array)
   * @param $item (array)
   *
   * @return $classes (array)
   *
   * @since 0.1.0
   */

  function soup2nuts_nav_menu_item_class( $classes, $item ) {

    $classes[] = 'menu-item-' . preg_replace('#[ -]+#', '-', strtolower( $item->title ));

    if ( in_array( $item->post_title, array( 'Events', 'Calendar', 'Contact Us' )) ) {
      $classes[] = 'menu-item-has-icon';
    }

    return $classes;
  }

endif; // excerpt_length

add_filter( 'nav_menu_css_class', 'soup2nuts_nav_menu_item_class', 10, 2 );
