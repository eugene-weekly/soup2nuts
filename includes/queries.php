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


    if ( $section == 'features' )
      $home_posts_args['posts_per_page'] = 2;

    return new WP_Query( $home_posts_args );

  }

endif; //home_posts


if ( ! function_exists( 'one_featured_post' ) ) :
 /**
  * Return X posts.
  *
  * @uses WP_Query
  *
  * @since 0.1.0
  */

  function one_featured_post( $excludedPosts = array() ) {
    global $post;

    $newsPostArgs = array(
      'posts_per_page' => 1,
      'post__not_in' => array_merge( $excludedPosts, array( $post->ID) ),
      'tax_query' => array(
        array(
          'taxonomy' => 'category',
          'field' => 'term_id',
          'terms' => '14' // News
        )
      )
    );


    $newsPost = new WP_Query( $newsPostArgs );

    if ( $newsPost->have_posts() ) {

      return $newsPost->posts[0]->ID;

    }
  }

endif; //one_featured_post
