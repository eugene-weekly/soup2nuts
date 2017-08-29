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
      'relation' => 'OR',
      array(
        'key' => 'expiration-date',
        'value' => 0,
        'compare' => '='
      ),
      array(
        'key' => 'expiration-date',
        'value' => date( time() ),
        'type' => 'DATE',
        'compare' => '>'
      )
    );

    $existingMetaQuery[] = $expiredMetaQuery;
  }


  if ( $query->is_home() || $query->is_front_page() ) {

    $existingMetaQuery[ 'relation' ] = 'AND';
    $thumbnailMetaQuery = array(
      'key' => '_thumbnail_id',
      'compare' => 'EXISTS'
    );

    $expiredMetaQuery = array(
      'key' => 'expiration-date',
      'value' => date( time() ),
      'type' => 'DATE',
      'compare' => 'EXISTS'
    );

    //$existingMetaQuery[] = $thumbnailMetaQuery;
    //$existingMetaQuery[] = $expiredMetaQuery;

  }

  $query->set( 'meta_query', $existingMetaQuery );

  return $query;
}
endif; // soup2nuts_pre_get_posts

add_filter( 'pre_get_posts', 'soup2nuts_pre_get_posts' );


if ( ! function_exists( 'soup2nuts_template_include' ) ) :
  /**
   * Template Filters.
   *
   * @param $template
   *
   * @return $template
   *
   * @since 0.1.0
   */

  function soup2nuts_template_include( $template ) {

    if ( is_category() ) {

      if ( is_paged() ) {

        $archive = locate_template( array( 'archive.php' ) );

        $template = ( empty( $archive ) ) ? $template : $archive;

      } else {

        $taxonomy = locate_template( array( 'taxonomy.php' ) );

        $template = ( empty( $taxonomy ) ) ? $template : $taxonomy;
      }
    } elseif ( is_post_format_archive( array( 'gallery', 'video' ) ) ) {
      $archive = locate_template( array( 'archive.php' ) );

      $template = ( empty( $archive ) ) ? $template : $archive;

    } elseif ( is_singular( 'post' ) ) {
      if ( get_post_meta( get_the_ID(), 'full-screen', true ) ) {
        $full_screen = locate_template( array( 'single-fullscreen.php' ) );

        $template = ( empty( $full_screen ) ) ? $template : $full_screen;
      }
    }

    return $template;

  }
endif; // soup2nuts_template_include

add_filter( 'template_include', 'soup2nuts_template_include' );




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

    $post_meta = get_post_meta( $post->ID );

    $classes[] = ( has_post_thumbnail( $post->ID ) ) ? 'has-post-img' : 'no-post-img';

    if ( !empty( $post_meta[ 'no-hero' ][0] ))
      $classes[] = 'no-post-hero';

    if ( get_post_meta( get_the_ID(), 'full-screen', true ) )
      $classes[] = 'full-screen';

    return $classes;
  }
endif; // soup2nuts_post_class

add_filter( 'post_class', 'soup2nuts_post_class' );


if ( ! function_exists( 'soup2nuts_the_content' ) ) :
  /**
   * The content.
   *
   * @param $length
   *
   * @return int
   *
   * @since 0.1.0
   */

  function soup2nuts_the_content( $content ) {
    global $post;

    $post_meta = get_post_meta( $post->ID );


    if ( is_singular('post') && $post_meta[ 'no-hero' ][0] )
      $content = sprintf(
        '<figure class="entry-hero in-content-hero alignleft">%s</figure>%s',
        get_the_hero_image( 'in-content' ),
        $content
      );

    return $content;
  }
endif; // soup2nuts_the_content

add_filter( 'the_content', 'soup2nuts_the_content' );


if ( ! function_exists( 'soup2nuts_excerpt_length' ) ) :
  /**
   * Excerpt Length.
   *
   * @param $length
   *
   * @return int
   *
   * @since 0.1.0
   */

  function soup2nuts_excerpt_length( $length ) {
    return 25;
  }
endif; // soup2nuts_excerpt_length

add_filter( 'excerpt_length', 'soup2nuts_excerpt_length' );


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
    $container_classes = array('navigation-menu');

    if ( isset($args['menu']->name) && 'Social' == $args['menu']->name ) :

      // Except for the social menu, because it's not navigation
      $args['container'] = 'div';

    endif;

    if ( isset( $args['menu_id'] ) )
      $container_classes[] = $args['menu_id'] . '-container';

    $args['container_class'] = implode( ' ', $container_classes );

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

    //  Add the More icon
    if ( $item->post_title == 'MORE') {
      $title .= get_the_icon( 'icon-next' );

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

    if ( in_array( $item->post_title, array( 'Events', 'Calendar', 'Contact Us', 'MORE' )) ) {
      $classes[] = 'menu-item-has-icon';
    }

    return $classes;
  }

endif; // excerpt_length

add_filter( 'nav_menu_css_class', 'soup2nuts_nav_menu_item_class', 10, 2 );

/**
 * Returns a "Continue Reading" link for excerpts
 */
function soup2nuts_continue_reading_link() {
  return ' <a href="'. esc_url( get_permalink() ) . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'soup2nuts') . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and soup2nuts_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 */
function soup2nuts_auto_excerpt_more( $more ) {
  return ' &hellip;' . soup2nuts_continue_reading_link();
}
add_filter( 'excerpt_more', 'soup2nuts_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 */
function soup2nuts_custom_excerpt_more( $output ) {
  if ( has_excerpt() && ! is_attachment() ) {
  $output .= soup2nuts_continue_reading_link();
  }
  return $output;
}
add_filter( 'get_the_excerpt', 'soup2nuts_custom_excerpt_more' );

add_action( 'admin_head', 'showhiddencustomfields' );

function showhiddencustomfields() {
  echo "<style type='text/css'>#postcustom .hidden { display: table-row; }</style>
";
}



if ( ! function_exists( 'soup2nuts_archive_title' ) ) :

  /**
   * Filter archive_title
   *
   * @param $title (string)
   *
   * @return $title (string)
   *
   * @since 0.1.0
   */

  function soup2nuts_archive_title( $title ) {

    if ( is_category() ) {
      if ( is_paged() ) {
        $title = single_cat_title( '', false ) . ' Archive';
      } else {
        $title = single_cat_title( '', false );
      }
    }

    if ( is_tag() ) {
      if ( is_paged() ) {
        $title = single_tag_title( '', false ) . ' Archive';
      } else {
        $title = single_tag_title( '', false );
      }
    }

    if ( is_search() ) {
      $title = 'Search Results: ' . esc_html( get_search_query( false ) );
    }

    return $title;
  }

endif; // excerpt_length

add_filter( 'get_the_archive_title', 'soup2nuts_archive_title', 10, 2 );

if ( ! function_exists( 'soup2nuts_sharing_filter' ) ) :

  /**
   * Filter sharing
   *
   * @param $title (string)
   *
   * @return $title (string)
   *
   * @since 0.1.0
   */

  function soup2nuts_sharing_filter( $title ) {

    if ( is_singular() && function_exists( 'sharing_display' ) ) {
        remove_filter( 'the_content', 'sharing_display', 19 );
        remove_filter( 'the_excerpt', 'sharing_display', 19 );
    }
  }

endif; // excerpt_length

add_filter( 'loop_start', 'soup2nuts_sharing_filter' );


if ( ! function_exists( 'soup2nuts_community_required_fields' ) ) :

  /**
   * Community Events Required Fields
   *
   * @param $fields (array)
   *
   * @return $fields (array)
   *
   * @since 0.1.0
   */

  function soup2nuts_community_required_fields( $fields ) {

    if ( ! is_array( $fields ) ) {
        return $fields;
    }

    $fields = array_merge(array_diff($fields, array('EventImage','organizer','EventURL')));

    $fields[] = 'venue';
    $fields[] = 'tax_input';
    $fields[] = 'post_content';
    $fields[] = 'event-time';
    $fields[] = 'EventStartDate';
    $fields[] = 'EventStartHour';
    $fields[] = 'EventStartMinute';
    $fields[] = 'EventStartMeridian';

    return $fields;
  }

endif;

add_filter( 'tribe_events_community_required_fields', 'soup2nuts_community_required_fields', 10, 1 );



if ( ! function_exists( 'soup2nuts_ad_tag_ids' ) ) :

  /**
   * Ad Tag IDs
   *
   * @param $fields (array)
   *
   * @return $fields (array)
   *
   * @since 0.1.0
   */

  function soup2nuts_ad_tag_ids( $ad_tag_ids ) {

    $ad_tag_ids = array(
      array(
        'tag' => '300x250-home-atf',
        'url_vars' => array(
          'tag' => '300x250-home-atf',
        	'sz' => '300x250',
        	'width' => '300',
        	'height' => '250',
        ),
        'enable_ui_mapping' => 1
      ), array(
        'tag' => '900x250-home-before-events',
        'url_vars' => array(
          'tag' => '900x250-home-before-events',
        	'sz' => '900x250',
        	'width' => '900',
        	'height' => '250',
      	),
        'enable_ui_mapping' => 1
      ), array(
        'tag' => '900x250-home-after-events',
        'url_vars' => array(
          'tag' => '900x250-home-after-events',
          'sz' => '900x250',
          'width' => '900',
          'height' => '250',
      	),
        'enable_ui_mapping' => 1
      ), array(
        'tag' => '728x90-home-after-video',
        'url_vars' => array(
          'tag' => '728x90-home-after-video',
        	'sz' => '728x90',
        	'width' => '728',
        	'height' => '90',
      	),
        'enable_ui_mapping' => 1
      ), array(
        'tag' => '728x90-before-gallery',
        'url_vars' => array(
          'tag' => '728x90-before-gallery',
          'sz' => '728x90',
        	'width' => '728',
        	'height' => '90',
      	),
        'enable_ui_mapping' => 1
      ), array(
        'tag' => '728x90-before-video',
        'url_vars' => array(
          'tag' => '728x90-before-video',
          'sz' => '728x90',
        	'width' => '728',
        	'height' => '90',
      	),
        'enable_ui_mapping' => 1
      ), array(
        'tag' => '728x90-before-calendar',
        'url_vars' => array(
          'tag' => '728x90-before-calendar',
          'sz' => '728x90',
        	'width' => '728',
        	'height' => '90',
      	),
        'enable_ui_mapping' => 1
      ), array(
        'tag' => '300x250-promotions-btf',
        'url_vars' => array(
          'tag' => '300x250-promotions-btf',
        	'sz' => '300x250',
        	'width' => '300',
        	'height' => '250',
      	),
        'enable_ui_mapping' => 1
      ), array(
        'tag' => '300x250-arts-atf',
        'url_vars' => array(
          'tag' => '300x250-arts-atf',
        	'sz' => '300x250',
        	'width' => '300',
        	'height' => '250',
      	),
        'enable_ui_mapping' => 1
      ), array(
        'tag' => '300x250-arts-btf',
        'url_vars' => array(
          'tag' => '300x250-arts-btf',
        	'sz' => '300x250',
        	'width' => '300',
        	'height' => '250',
      	),
        'enable_ui_mapping' => 1
      ), array(
        'tag' => '300x250-news-atf',
        'url_vars' => array(
          'tag' => '300x250-news-atf',
        	'sz' => '300x250',
        	'width' => '300',
        	'height' => '250',
      	),
        'enable_ui_mapping' => 1
      ), array(
        'tag' => '300x250-news-btf',
        'url_vars' => array(
          'tag' => '300x250-news-btf',
        	'sz' => '300x250',
        	'width' => '300',
        	'height' => '250',
      	),
        'enable_ui_mapping' => 1
      ), array(
        'tag' => '300x250-culture-atf',
        'url_vars' => array(
          'tag' => '300x250-culture-atf',
        	'sz' => '300x250',
        	'width' => '300',
        	'height' => '250',
      	),
        'enable_ui_mapping' => 1
      ), array(
        'tag' => '300x250-culture-btf',
        'url_vars' => array(
          'tag' => '300x250-culture-btf',
        	'sz' => '300x250',
        	'width' => '300',
        	'height' => '250',
      	),
        'enable_ui_mapping' => 1
      ), array(
        'tag' => '300x600-post-sidebar-atf',
        'url_vars' => array(
          'tag' => '300x600-post-sidebar-atf',
        	'sz' => '300x600',
        	'width' => '300',
        	'height' => '600',
      	),
        'enable_ui_mapping' => 1
      ), array(
        'tag' => '300x600-post-footer-btf',
        'url_vars' => array(
          'tag' => '300x600-post-footer-btf',
        	'sz' => '300x600',
        	'width' => '300',
        	'height' => '600',
      	),
        'enable_ui_mapping' => 1
      )
    );
    return $ad_tag_ids;
  }

endif;

add_filter( 'acm_ad_tag_ids', 'soup2nuts_ad_tag_ids' );


if ( ! function_exists( 'soup2nuts_acm_output_html' ) ) :

  /**
   * Filter ACM Output HTML
   *
   * @param $output_html (str)
   *
   * @return $tag_id (str)
   *
   * @since 0.1.0
   */

  function soup2nuts_acm_output_html( $output_html, $tag_id ) {
    return '<div class="ad">' . $output_html . '</div>' . "\n";
  }

endif;

add_filter( 'acm_output_html_after_tokens_processed','soup2nuts_acm_output_html', 5, 2 );


if ( ! function_exists( 'soup2nuts_oembed_dataparse' ) ) :

  /**
   * Filter oembed Output HTML
   *
   * @param $output_html (str)
   *
   * @return $tag_id (str)
   *
   * @since 0.1.0
   */

  function soup2nuts_oembed_dataparse( $return, $data, $url ) {
    if ($data->provider_name == 'YouTube') {
        $data->html = str_replace('feature=oembed', 'feature=oembed&#038;rel=0&#038;showinfo=0', $data->html);
        return $data->html;
    } else return $return;
  }

endif;

add_filter( 'oembed_dataparse','soup2nuts_oembed_dataparse', 10, 3 );
