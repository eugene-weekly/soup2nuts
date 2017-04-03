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

     $termExclusionQuery = array(
       'taxonomy' => 'category',
       'field'    => 'slug',
       'terms'    => array( 'slant', 'letters', 'pollution-update', 'biz-beat', 'spray-schedule', 'happening-people', 'savage-love' ),
       'operator' => 'NOT IN',
     );

     $home_posts_args = array(
       'posts_per_page' => 3,
       'post__not_in' => $excludedPosts,
       'meta_query' => array(
         // $thumbnailMetaQuery // NOTE: Uncomment this to require thumbnails
       ),
       'tax_query' => array(
         $termExclusionQuery
       ),
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
       $home_posts_args['posts_per_page'] = 4;
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

     $tax_query[] = array(
       'taxonomy' => $tax->taxonomy,
       'field'    => 'slug',
       'terms'    => array( $tax->slug ),
     );

     if ( $tax->slug == 'news' ) {
       $tax_query[] = array(
         'taxonomy' => $tax->taxonomy,
         'field'    => 'slug',
         'terms'    => array( 'letters' ),
         'operator' => 'NOT IN',
       );
     }


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

    $upcomingEventsMetaQuery = array(
      'key' => '_EventEndDate',
      'value' => date( 'Y-m-d' ),
      'compare' => '>=',
      'type' => 'DATE,'
    );

    $baseEventArgs = array(
      'suppress_filters' => true,
      'posts_per_page' => $count,
      'post__not_in' => $excludedPosts,
      'post_type' => 'tribe_events',
    );

    $featuredEventsArgs = array_merge(
      $baseEventArgs,
      array(
        'order' => 'DESC',
        'orderby' => 'meta_value_num',
        'meta_key' => 'featured-event-quotient',
        'meta_query' => array(
          'relation' => 'AND',
          $upcomingEventsMetaQuery,
          array(
            'key' => 'featured-event-quotient',
            'value' => 1,
            'compare' => '>=',
            'type' => 'NUMERIC'
          ),
        )
      )
    );
    //pre_printr( $featuredEventsArgs );

    $featuredEvents = new WP_Query( $featuredEventsArgs );

    //pre_printr( $featuredEvents );

    // No events marked as featured, get most recent instead.
    if ( empty( $featuredEvents ) ) {

      $featuredEventsArgs = array_merge(
        $featuredEventsArgs,
        array(
          'meta_query' => array(
            $upcomingEventsMetaQuery
          )
        )
      );


      $featuredEvents = new WP_Query( $featuredEventsArgs );
    }

    if ( $return == 'ids' ) {

      // Return array of ids
      return wp_list_pluck( $featuredEvents->posts, 'ID' );

    } elseif ( $return == 'posts' ) {

      // Return posts
      return $featuredEvents;

    } else {

      // Return empty array
      return array( 0 );

    }



  }

endif; //featured_events


if ( ! function_exists( 'related_posts' ) ) :
 /**
  * Return Related Posts.
  *
  * @uses WP_Query
  *
  * @since 0.1.0
  */

  function related_posts( $count = 3, $related_to = null ) {

    global $post;

    $related_to = ( isset( $related_to ) ) ? $related_to : $post;

    pre_printr( $related_post_ids );

    $related_post_ids = get_post_meta( $related_to->ID, 'related', true );
    $related_post_ids = ( empty( $related_post_ids ) ) ? array() : wp_list_pluck( $related_post_ids, 'related_post' );

    // check if we have enough related posts
    $backfill_needed = $count - count( $related_post_ids );

    if ( $backfill_needed > 0 ) {

      $backfill_query_args = array(
        'post_type' => 'post',
        'posts_per_page' => $backfill_needed,
        'post__not_in' => array_merge( array( $related_to->ID ), $related_post_ids ),
        'tax_query' => array(
          'relation' => 'OR',
        ),
      );

      foreach ( array( 'category', 'post_tag' ) as $tax ) :
        $terms = get_the_terms( $related_to, $tax );

        $term_tax_query = array();

        if ( !empty( $terms )  && !is_wp_error( $terms ) ) {
          $term_tax_query['taxonomy'] = $tax;
          $term_tax_query['terms'] = wp_list_pluck( $terms, 'term_id' );
        }

        if ( !empty( $term_tax_query ) ) {
          $backfill_query_args['tax_query'][] = $term_tax_query;
        }

      endforeach;

      $backfill_posts = new WP_Query( $backfill_query_args );

      if ( $backfill_posts->have_posts() )
        $backfill_posts = wp_list_pluck( $backfill_posts->posts, 'ID' );
    }

    if ( isset($backfill_posts) )
      $related_post_ids = array_merge( $related_post_ids, $backfill_posts );

    $related_posts_args = array(
      'post_type' => 'post',
      'posts_per_page' => $count,
      'post__not_in' => $related_to->ID,
      'post__in' => $related_post_ids,
      'orderby' => 'post__in',
    );

    return new WP_Query( $related_posts_args );
  }

endif; //related_posts
