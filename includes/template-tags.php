<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package soup2nuts
 */

if ( ! function_exists( 'archive_pagination' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @todo write this.
 */
function archive_pagination() {

  // Don't print empty markup if there's only one page.
  if ( $GLOBALS[ 'wp_query' ]->max_num_pages < 2 ) {
    return;
  }
  $current_page = (is_search() && !is_paged()) ? 1 : $GLOBALS[ 'wp_query' ]->query[ 'paged' ];
  ?>
  <nav class="navigation posts-navigation" role="navigation">
    <h2 class="screen-reader-text"><?php esc_html_e( __('Posts navigation', 'soup2nuts') ); ?></h2>
    <div class="nav-links">
      <div class="nav-previous"><?php previous_posts_link( '&larr; <span>Previous</span>', 'soup2nuts' ); ?></div>
      <div class="page-count">
        <span class="current-page"><?php echo $current_page; ?></span> of <?php echo $GLOBALS[ 'wp_query' ]->max_num_pages; ?>
      </div>
      <div class="nav-next"><?php next_posts_link( __('<span>Next</span> &rarr;', 'soup2nuts') ); ?></div>
    </div><!-- .nav-links -->
  </nav><!-- .navigation -->
  <?php
}
endif;

if ( ! function_exists( 'the_post_navigation' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function the_post_navigation() {
  // Don't print empty markup if there's nowhere to navigate.
  $previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
  $next     = get_adjacent_post( false, '', false );

  if ( ! $next && ! $previous ) {
    return;
  }
  ?>
  <nav class="navigation post-navigation" role="navigation">
    <h2 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'soup2nuts' ); ?></h2>
    <div class="nav-links">
      <?php
        previous_post_link( '<div class="nav-previous">%link</div>', '%title' );
        next_post_link( '<div class="nav-next">%link</div>', '%title' );
      ?>
    </div><!-- .nav-links -->
  </nav><!-- .navigation -->
  <?php
}
endif;


if ( ! function_exists( 'soup2nuts_excerpt_meta' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function soup2nuts_excerpt_meta() {
  $id = get_the_ID();

  if ( in_array( get_post_type( $id ), array( 'post', 'promotion' )) ) {
    /* translators: used between list items, there is a space after the comma */
    $categories = get_the_category( );

    if ( $categories ) {
      //pre_printr( $categories );
      echo '<span class="excerpt-meta-item meta-item post-categories">';

      foreach ( $categories as $i=>$category ) {
        if ( $i < 0 )
          echo ' / ';

        printf( '<a href="%1$s" class="post-category">%2$s</a>', esc_url( get_category_link( $category->term_id ) ), esc_html__( $category->name ) );

      }

      echo '</span> ';
      //printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'soup2nuts' ) . '</span>', $categories_list ); // WPCS: XSS OK.
    }


  } elseif ( tribe_is_event() ) {

    echo '<span class="excerpt-meta-item meta-item post-categories event-categories">';
    printf( '<a href="%1$s" class="post-category event-category">Calendar</a>', esc_url( tribe_get_events_link() ) );

    echo tribe_get_event_taxonomy( $id, array(
      'before'   => '',
      'sep'      => ' / ',
      'after'    => '',
    ) );

    echo '</span>';
  }

  if ( !tribe_is_event() ) {
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s ago</time>';

    $time_string = sprintf( $time_string,
      esc_attr( get_the_date( 'U' ) ),
      esc_html( human_time_diff( get_the_date( 'U' ) ) )
    );

    $time_string = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

    echo '<span class="excerpt-meta-item meta-item posted-on">' . $time_string . '</span>';
  }

}
endif;


if ( ! function_exists( 'soup2nuts_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function soup2nuts_posted_on() {
  $id = get_the_ID();

  if ( in_array( get_post_type( $id ), array( 'post', 'promotion' )) ) {
    /* translators: used between list items, there is a space after the comma */
    $categories = get_the_category( );

    if ( $categories ) {
      //pre_printr( $categories );
      echo '<span class="excerpt-meta-item meta-item post-categories">';

      foreach ( $categories as $i=>$category ) {
        if ( $i < 0 )
          echo ' / ';

        printf( '<a href="%1$s" class="post-category">%2$s</a>', esc_url( get_category_link( $category->term_id ) ), esc_html__( $category->name ) );

      }

      echo '</span> ';
      //printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'soup2nuts' ) . '</span>', $categories_list ); // WPCS: XSS OK.
    }


  } elseif ( tribe_is_event() ) {

    echo '<span class="excerpt-meta-item meta-item post-categories event-categories">';
    printf( '<a href="%1$s" class="post-category event-category">Calendar</a>', esc_url( tribe_get_events_link() ) );

    echo tribe_get_event_taxonomy( $id, array(
      'before'   => '',
      'sep'      => ' / ',
      'after'    => '',
    ) );

    echo '</span>';
  }

  $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

  $time_string = sprintf( $time_string,
    esc_attr( get_the_date( 'c' ) ),
    esc_html( get_the_date( 'm/d/Y') )
  );

  $posted_on = sprintf(
    esc_html_x( 'Posted on %s', 'post date', 'soup2nuts' ),
    '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
  );

  $byline = sprintf(
    esc_html_x( 'by %s', 'post author', 'soup2nuts' ),
    '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
  );

  echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

  if ( function_exists( 'sharing_display' ) ) { echo sharing_display(); }
}
endif;


if ( ! function_exists( 'soup2nuts_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function soup2nuts_entry_footer() {
  if ( ('tribe_events' == get_post_type()) ) {

    $sponsored = ( get_post_meta( get_the_ID(), 'sponsored', true ) ) ? 'Sponsored' : 'Featured';
    printf( '<span class="featured-event">%1$s Event</span>', $sponsored );
  }

  if ( is_singular() ) {
    $tags_list = get_the_tag_list( '', esc_html__( ' / ', 'soup2nuts' ) );
    if ( $tags_list ) {
      printf( '<span class="tags-links">Tags: ' . esc_html__( '%1$s', 'soup2nuts' ) . '</span>', $tags_list ); // WPCS: XSS OK.
    }
  }
}
endif;


if ( ! function_exists( 'the_subhead' ) ) :
/**
 * Display the subhead.
 *
 * @param string $before Optional. Content to prepend to the subhead.
 * @param string $after  Optional. Content to append to the subhead.
 * @param bool   $echo   Optional, default to true.Whether to display or return.
 * @return string|void String if $echo parameter is false.
 */
function the_subhead( $before = '', $after = '', $echo = true ) {
  $subhead = get_the_subhead();

  if ( strlen($subhead) == 0 )
    return;

  $subhead = $before . $subhead . $after;

  if ( $echo )
    echo $subhead;
  else
    return $subhead;
}
endif;


if ( ! function_exists( 'the_hero_image' ) ) :
/** @TODO: Update this
 * Shim for `the_archive_description()`.
 *
 * Display category, tag, or term description.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */
function the_hero_image( $size = 'hero', $position = 'hero' ) {
  global $post;

  $post_meta = get_post_meta( $post->ID );

  if ( !empty( $post_meta[ 'no-hero' ][0] ) && ($position == 'hero') )
    return;

  if ( (is_singular() && $position == 'hero')|| in_array( $position, array( 'features', 'video' ) ) ) {

    if ( has_post_format( 'gallery', $post->ID ) && $post_meta['hero-gallery'] ) {
      // Aesop Gallery
      $heroImg = do_shortcode( '[aesop_gallery id="' . $post_meta['hero-gallery'][0] . '"]' );

    } elseif ( has_post_format( 'video', $post->ID ) && $post_meta['hero-video'] ) {

      // Video
      $heroImg = apply_filters( 'the_content', $post_meta['hero-video'][0] );
    } else {
      // Boring old hero image
      $heroImg = get_the_hero_image( $size );
    }
  } else {
    // Boring old hero image
    $heroImg = get_the_hero_image( $size );
  }

  if ( strlen( $heroImg ) == 0 )
    return;

  echo $heroImg;

}
endif;


if ( ! function_exists( 'the_category_link' ) ) :
/** @TODO: Update this
 *
 * Display category, tag, or term description.
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */
function the_category_link( $category_name ) {

  if ( !isset( $category_name ) )
    return;

  echo esc_url( get_category_link( get_cat_ID( $category_name ) ) );

}
endif;


if ( ! function_exists( 'the_archive_link' ) ) :
/** @TODO: Update this
 *
 * Display category, tag, or term description.
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */
function the_archive_link( $section_name ) {
  if ( !isset( $section_name ) )
    return;

  $link = null;
  $categories = array( 'news', 'arts', 'culture' );
  $formats = array( 'gallery', 'video' );
  $post_types = array( 'events', 'promotions' );

  if ( in_array( $section_name, $categories ) ) :

    $link = get_category_link( get_cat_ID( $section_name ) );

  elseif ( in_array( $section_name, $formats ) ) :

    $link = get_post_format_link( section_normalizer( $section_name ) );

  elseif ( in_array( $section_name, $post_types ) ) :

    $link = get_post_type_archive_link( section_normalizer( $section_name ) );

  endif;

  echo $link;

}
endif;



if ( ! function_exists( 'related_posts' ) ) :
/** @TODO: Update this
 *
 * Display category, tag, or term description.
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */
function related_posts() {

  $related_posts = the_widget( 'related_posts', array('title' => 'Related Posts') );
  pre_printr( $related_posts );
  echo '<div class="related-posts">' . $related_posts . '</div>';

}
endif;


if ( ! function_exists( 'the_section_header' ) ) :
/** @TODO: Update this
 *
 * Section header.
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */
function the_section_header( $section ) {

  if ( !isset( $section ) )
    return;

  $section_header = get_the_section_header( $section );

  echo ucwords( $section_header );
}
endif;


if ( ! function_exists( 'icon_sprite' ) ) :
/** @TODO: Update this
 *
 * Display category, tag, or term description.
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */
function icon_sprite( $icon ) {

  if ( !isset( $icon ) )
    return;

  ob_start();
  echo get_the_icon( $icon );
  ob_end_flush();

}
endif;


if ( ! function_exists( 'the_social_header' ) ) :
/** @TODO: Update this
 *
 * Display category, tag, or term description.
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */
function the_social_header( ) {

  $social_widget_instance = get_option('widget_wpcom_social_media_icons_widget');
  $social_widget_instance = array_shift( $social_widget_instance );
  $social_widget_instance['youtube_username'] = '';

  return the_widget( 'wpcom_social_media_icons_widget', $social_widget_instance );

}
endif;



if ( ! function_exists( 'the_author_social' ) ) :
/** @TODO: Update this
 *
 * Display category, tag, or term description.
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */
function the_author_social( $service, $author ) {

  if ( !$service || !$author )
    return;

  $social_url = null;

  switch ($service) {
    case 'twitter':
      $social_url = 'https://twitter.com/' . $author;
      break;

    case 'facebook':
      $social_url = $author;
      break;

    case 'instagram':
    $social_url = 'https://instagram.com/' . $author;
      break;

    default:
      break;
  }

  if ( !empty( $social_url )) {
    echo( esc_url($social_url) );
  }

}
endif; //the_author_social
