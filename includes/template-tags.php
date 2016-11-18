<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package soup2nuts
 */

if ( ! function_exists( 'the_posts_navigation' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function the_posts_navigation() {
  // Don't print empty markup if there's only one page.
  if ( $GLOBALS[ 'wp_query' ]->max_num_pages < 2 ) {
    return;
  }
  ?>
  <nav class="navigation posts-navigation" role="navigation">
    <h2 class="screen-reader-text"><?php esc_html_e( 'Posts navigation', 'soup2nuts' ); ?></h2>
    <div class="nav-links">

      <?php if ( get_next_posts_link() ) : ?>
      <div class="nav-previous"><?php next_posts_link( esc_html__( 'Older posts', 'soup2nuts' ) ); ?></div>
      <?php endif; ?>

      <?php if ( get_previous_posts_link() ) : ?>
      <div class="nav-next"><?php previous_posts_link( esc_html__( 'Newer posts', 'soup2nuts' ) ); ?></div>
      <?php endif; ?>

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

  if ( 'post' == get_post_type() ) {
    /* translators: used between list items, there is a space after the comma */
    $categories = get_the_category( );

    if ( $categories ) {

      echo '<span class="excerpt-meta-item meta-item post-categories">';

      foreach ( $categories as $i=>$category ) {
        if ( $i < 0 )
          echo ' / ';

        printf( '<a href="%2$s" class="post-category">%2$s</a>', esc_url( get_category_link( $category->term_id ) ), esc_html__( $category->name ) );


      }

      echo '</span> ';
      //printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'soup2nuts' ) . '</span>', $categories_list ); // WPCS: XSS OK.
    }

  }


  $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s ago</time>';

  $time_string = sprintf( $time_string,
    esc_attr( get_the_date( 'U' ) ),
    esc_html( human_time_diff( get_the_date( 'U' ) ) )
  );

  $time_string = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

  echo '<span class="excerpt-meta-item meta-item posted-on">' . $time_string . '</span>';

}
endif;


if ( ! function_exists( 'soup2nuts_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function soup2nuts_posted_on() {
  $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
  if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
    $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
  }

  $time_string = sprintf( $time_string,
    esc_attr( get_the_date( 'c' ) ),
    esc_html( get_the_date() ),
    esc_attr( get_the_modified_date( 'c' ) ),
    esc_html( get_the_modified_date() )
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

}
endif;


if ( ! function_exists( 'soup2nuts_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function soup2nuts_entry_footer() {
  // Hide category and tag text for pages.
  if ( 'post' == get_post_type() ) {
    /* translators: used between list items, there is a space after the comma */
    $categories_list = get_the_category_list( esc_html__( ', ', 'soup2nuts' ) );
    if ( $categories_list ) {
      printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'soup2nuts' ) . '</span>', $categories_list ); // WPCS: XSS OK.
    }

    /* translators: used between list items, there is a space after the comma */
    $tags_list = get_the_tag_list( '', esc_html__( ', ', 'soup2nuts' ) );
    if ( $tags_list ) {
      printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'soup2nuts' ) . '</span>', $tags_list ); // WPCS: XSS OK.
    }
  }

  if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
    echo '<span class="comments-link">';
    comments_popup_link( esc_html__( 'Leave a comment', 'soup2nuts' ), esc_html__( '1 Comment', 'soup2nuts' ), esc_html__( '% Comments', 'soup2nuts' ) );
    echo '</span>';
  }

  edit_post_link( esc_html__( 'Edit', 'soup2nuts' ), '<span class="edit-link">', '</span>' );
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
function the_hero_image( $size = 'hero' ) {

  $heroImg = get_the_hero_image( $size );

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
