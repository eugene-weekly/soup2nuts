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

     $thumbnailMetaQuery = array(
       'key' => '_thumbnail_id',
       'compare' => 'EXISTS'
     );

     $home_posts_args = array(
       'posts_per_page' => 3,
       'post__not_in' => $excludedPosts,
       'meta_query' => array(
         // $thumbnailMetaQuery // NOTE: Uncomment this to require thumbnails
       )
     );

     if ( $section == 'features' ) {

       $featured_post_id = featured_post( 1, $home_posts_args, $excludedPosts, 'id' );
       $featured_event_id = featured_events( 1, $excludedPosts, 'ids' );

       $home_posts_args['posts_per_page'] = 2;
       $home_posts_args['post__in'] = array_merge( $featured_post_id, $featured_event_id );
       $home_posts_args['orderby'] = 'post__in';
       $home_posts_args['suppress_filters'] = true;
       $home_posts_args['post_type'] = array( 'post', 'tribe_events' );
     }

     // Require thumbnails in certain sections
     if ( in_array( $section, array( 'arts', 'culture' ) ) ) {
       $home_posts_args[ 'meta_query' ][] = $thumbnailMetaQuery; // NOTE: Uncomment this to require thumbnails
     }

     // Restrict posts to the appropriate categories
     if ( in_array( $section, array( 'news', 'arts', 'culture' ) ) ) {

       $home_posts_args[ 'tax_query' ][] = array(
         'taxonomy' => 'category',
         'field'    => 'slug',
         'terms'    => $section,
       );
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

 if ( ! function_exists( 'tax_posts' ) ) :
   /**
    * Return X posts.
    *
    * @uses WP_Query
    *
    * @since 0.1.0
    */

   function tax_posts( $section = 'features', $tax, $excludedPosts = array() ) {

     if ( !isset( $tax ) )
      return false;

     $thumbnailMetaQuery = array(
       'key' => '_thumbnail_id',
       'compare' => 'EXISTS'
     );

     $tax_query = array(
       'taxonomy' => $tax->taxonomy,
       'field'    => 'slug',
       'terms'    => array( $tax->slug ),
     );

     $tax_posts_args = array(
       'posts_per_page' => 6,
       'post__not_in' => $excludedPosts,
       'tax_query' => array(
         $tax_query
       ),
       'meta_query' => array(
         // $thumbnailMetaQuery // NOTE: Uncomment this to require thumbnails
       )
     );

     if ( in_array( $section, array( 'features', 'more_features' ) ) ) {

       $featured_post_count = ( $section == 'features' ) ? 1 : 2;
       $event_post_count = 1;

       $featured_posts = featured_post( $featured_post_count, $tax_posts_args, $excludedPosts, 'id' );
       $featured_events = featured_events( $event_post_count, $excludedPosts, 'ids' );

       $featured_post_args = array();


       if ( $section == 'features') {
         $post__in = array_merge( $featured_posts, $featured_events );
       } else {
         $post__in = array( $featured_posts[0], $featured_events[0], $featured_posts[1] );
       }

       $featured_post_args['posts_per_page'] = $featured_post_count + $event_post_count;
       $featured_post_args['post__not_in'] = $excludedPosts;
       $featured_post_args['post__in'] = $post__in;
       $featured_post_args['orderby'] = 'post__in';
       $featured_post_args['suppress_filters'] = true;
       $featured_post_args['post_type'] = array( 'post', 'tribe_events' );

       $tax_posts_args = $featured_post_args;

     }

     if ( $section == 'promotions' ) {
       $promotions_args = array();

       $promotions_args['post_type'] = 'promotion';
       $promotions_args['posts_per_page'] = 4;
       $promotions_args['post__in'] = $excludedPosts;

       $tax_posts_args = $promotions_args;
     }

     return new WP_Query( $tax_posts_args );

   }

 endif; //tax_posts


if ( ! function_exists( 'featured_post' ) ) :
 /**
  * Return 1 post, most featured.
  *
  * @uses WP_Query
  *
  * @since 0.1.0
  */

  function featured_post( $count = 1, $extantPostArgs = array(), $excludedPosts = array(), $return = 'posts' ) {

    $featuredPostArgs = array(
      'posts_per_page' => $count,
      'post_type' => 'post',
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
    if ( (!$featured_post->have_posts()) || ($featured_post->found_posts < $count) ) {

      $backupPostArgs = array(
        'posts_per_page' => $count,
        'post__not_in' => $excludedPosts,
      );

      $featured_post = new WP_Query( $backupPostArgs );

      //pre_printr( $featured_post );
      //pre_printr( $count );
    }


    //pre_printr( $featured_post );


    if ( $featured_post->have_posts() ) {

      if ( $return == 'id' ) {


        // Return array of ids
        return wp_list_pluck( $featured_post->posts, 'ID' );

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

endif; //featured_post


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

    $baseEventArgs = array(
      'posts_per_page' => $count,
      'post__not_in' => $excludedPosts,
      'eventDisplay' => 'custom',
    );

    $featuredEventsArgs = array_merge(
      $baseEventArgs,
      array(
        'order' => 'DESC',
        'orderby' => 'meta_value_num',
        'meta_key' => 'featured-event-quotient',
        'meta_query' => array(
          array(
            'key' => 'featured-event-quotient',
            'value' => 1,
            'compare' => '>=',
            'type' => 'NUMERIC'
          )
        )
      )
    );

    $featuredEvents = tribe_get_events( $featuredEventsArgs );

    // No events marked as featured, get most recent instead.
    if ( empty( $featuredEvents ) ) {

      $featuredEventsArgs = $baseEventArgs;

      $featuredEvents = tribe_get_events( $featuredEventsArgs );
    }

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
