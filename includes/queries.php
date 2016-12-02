<?php
/**
 * soup2nuts Special Queries
 *
 * @package soup2nuts
 */

if ( ! function_exists( 'home_posts' ) ) :
  /**
   * Return X posts.
   *
   * @uses WP_Query
   *
   * @since 0.1.0
   */

  function home_posts( $section = 'features', $excludedPosts = array() ) {

    $home_posts_args = array(
      'posts_per_page' => 3,
      'post__not_in' => $excludedPosts,
      'meta_query' => array(
        array(
          'key' => '_thumbnail_id',
          'compare' => 'EXISTS'
        )
      )
    );


    if ( $section == 'features' ) {

      $featured_post_id = one_featured_post( $home_posts_args, $excludedPosts, 'id' );
      $featured_event_id = featured_events( 1, $excludedPosts, 'ids' );

      $home_posts_args['posts_per_page'] = 2;
      $home_posts_args['post__in'] = array_merge( $featured_post_id, $featured_event_id );
      $home_posts_args['orderby'] = 'post__in';
      $home_posts_args['post_type'] = array( 'post', 'tribe_events' );

    }

    if ( $section == 'events' ) {

      return featured_events( 3, $excludedPosts, 'posts' );

    }

    if ( $section == 'promotions' ) {
      $home_posts_args['post_type'] = 'promotion';
      $home_posts_args['posts_per_page'] = 4;
    }

    return new WP_Query( $home_posts_args );

  }

endif; //home_posts


if ( ! function_exists( 'one_featured_post' ) ) :
 /**
  * Return 1 post, most featured.
  *
  * @uses WP_Query
  *
  * @since 0.1.0
  */

  function one_featured_post( $extantPostArgs = array(), $excludedPosts = array(), $return = 'posts' ) {

    $featuredPostArgs = array(
      'posts_per_page' => 1,
      'post__not_in' => $excludedPosts,
    );

    $featuredPostArgs = array_merge( $extantPostArgs, $featuredPostArgs );

    $featuredPostArgs['meta_query'][] = array(
      'key' => 'featured',
      'value' => 1,
      'compare' => '='
    );

    $featuredPostArgs['meta_query'][ 'relation' ] = 'AND';

    $featured_post = new WP_Query( $featuredPostArgs );

    if ( !$featured_post->have_posts() ) {

      $backupPostArgs = array(
        'posts_per_page' => 1,
        'post__not_in' => $excludedPosts,
        'meta_query' => array(
          array(
            'key' => '_thumbnail_id',
            'compare' => 'EXISTS'
          )
        )
      );

      $featured_post = new WP_Query( $backupPostArgs );
    }


    if ( $featured_post->have_posts() ) {


      if ( $return == 'id' ) {

        // Return array of ids
        return array( $featured_post->posts[0]->ID );

      } elseif ( $return == 'posts' ) {

        // Return posts
        return $featured_post;

      } else {

        // Return empty array
        return array( 0 );

      }

    } else {

      return array( 0 );
    }

  }

endif; //one_featured_post


if ( ! function_exists( 'featured_events' ) ) :
 /**
  * Return featured events.
  *
  * @uses WP_Query
  *
  * @since 0.1.0
  */

  function featured_events( $count = 3, $excludedPosts = array(), $return = 'posts' ) {

    if ( ! function_exists( 'tribe_get_events' ) )
      return array( 0 );

    $featuredEventsArgs = array(
      'posts_per_page' => $count,
      'post__not_in' => $excludedPosts,
      'eventDisplay' => 'list',
      'order' => 'DESC',
      'orderby' => 'meta_value_num',
      'meta_key' => 'featured-event-quotient',
      'meta_query' => array(
        array(
          'key' => '_thumbnail_id',
          'compare' => 'EXISTS'
        ),
        array(
          'key' => 'featured-event-quotient',
          'value' => 1,
          'compare' => '>=',
          'type' => 'NUMERIC'
        )
      )
    );

    $featuredEvents = tribe_get_events( $featuredEventsArgs );

    if ( $return == 'ids' ) {

      // Return array of ids
      return wp_list_pluck( $featuredEvents, 'ID' );

    } elseif ( $return == 'posts' ) {

      $featuredEventQueryArgs = array(
        'post__in' => wp_list_pluck( $featuredEvents, 'ID' ),
        'orderby' => 'post__in',
        'post_type' => array( 'posts', 'tribe_events' ),
      );

      // Return posts
      return new WP_Query( $featuredEventQueryArgs );

    } else {

      // Return empty array
      return array( 0 );

    }



  }

endif; //featured_events
