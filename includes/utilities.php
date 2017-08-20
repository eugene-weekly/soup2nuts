<?php
/**
 *  Utility functions.
 *
 * @package WordPress
 * @subpackage Eugene Weekly 2017
 */



if ( ! function_exists( 'get_the_subhead' ) ) :
/**
* Retrieve the subhead.
*
* @param int|WP_Post $post Optional. Post ID or WP_Post object. Default is global $post.
* @return string
*/
function get_the_subhead( $post = 0 ) {

  $post = get_post( $post );

  $id = isset( $post->ID ) ? $post->ID : 0;
  //$post_meta = get_post_meta( $id, 'post_details', true );
  $post_meta = ( metadata_exists( 'post', $id, 'post_details' ) ) ? get_post_meta( $id, 'post_details', false ) : get_post_meta( $id, '', false );

  //pre_printr($post_meta);

  if ( in_array( get_post_type( $id ), array( 'post', 'promotion' )) ) {

    $subhead = '';

    $subhead = isset( $post_meta['subhead'] ) ? $post_meta['subhead'] : $subhead;
    $subhead = isset( $post_meta['sub-head'] ) ? $post_meta['sub-head'] : $subhead;

    $subhead = ( gettype( $subhead ) == 'array' ) ? implode( $subhead ) : $subhead;

  } elseif ( 'tribe_events' == get_post_type( $id ) ) {

    $eventInfo = array(
      'venue' => tribe_get_venue( $id ),
      'time' => tribe_get_start_time( $id ),
    );

    if ( !empty( tribe_get_event_website_url( $id ) ) )
      $eventInfo['tickets'] = '<a href="' . tribe_get_event_website_url( $id ) . '" class="ticket-link">Tickets&rarr;</a>';

    $eventInfo = array_filter( $eventInfo );

    $subhead = implode( ' &bull; ', $eventInfo );

  }


  /**
  * Filter the post subhead.
  *
  * @since 0.71
  *
  * @param string $subhead The post subhead.
  * @param int    $id    The post ID.
  */
  return apply_filters( 'the_subhead', $subhead, $id );

}
endif;


if ( ! function_exists( 'get_the_icon' ) ) :
/**
* Retrieve the icon.
*
* @param string $icon icon slug
* @return string
*/
function get_the_icon( $icon ) {

  $use_href = get_stylesheet_directory_uri() . '/assets/svg/sprite.symbol.svg#' . $icon;

  return '<svg class="icon ' . $icon . '"><use xlink:href="' . $use_href . '" /></svg>';

}
endif;


if ( ! function_exists( 'get_the_section_header' ) ) :
/**
* Get the section header.
*
* @param string $section section
* @return string
*/
function get_the_section_header( $section ) {

  $section_header = $section;

  if ( is_archive() && $section == 'features' ) {
    $section_header = get_the_archive_title();
  }

  return $section_header;

}
endif;


function guess_hero_size( $origin, $position = 0 ) {

  $deduced_size = null;

  switch ($origin) {
    case 'features':
    case 'video':

      $deduced_size = ( $position == 0 ) ? 'large' : 'medium';
      break;

    case 'more_features':

      $deduced_size = 'medium';
      break;

    case 'news':
    case 'arts':
    case 'culture':
    case 'gallery':
    case 'latest':
    case 'popular':

      $deduced_size = ( $position == 0 ) ? 'medium' : 'thumbnail';
      break;

    case 'sidebar':
    case 'more_features':
    case 'events':

      $deduced_size = 'medium';
      break;

    default:
      $deduced_size = 'thumbnail';
      break;
  }

  return $deduced_size;
}


if ( ! function_exists( 'get_the_hero_image' ) ) :
/** @TODO: Update this
 *
 * Retrieve the hero image.
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */
function get_the_hero_image( $size, $hero_origin = false ) {

  if ( empty( $size ) )
    return;

  if ( !$hero_origin )
    $hero_origin = get_hero_origin();

  $heroImgID = get_post_thumbnail_id( $hero_origin );
  //$heroImgID = $heroImgObject['ID'];
  $heroImgSrc = wp_get_attachment_image( $heroImgID, $size, false, array( 'class' => 'aesop-lazy-img_not-yet' ) );
  $heroImgMeta = wp_get_attachment_metadata( $heroImgID );
  $heroImg = wp_image_add_srcset_and_sizes( $heroImgSrc, $heroImgMeta, $heroImgID );

  $figcaption = get_the_photo_caption( $hero_origin, $heroImgID );

  if ( $figcaption ) {

    if ( tribe_is_event( $hero_origin ) ) {
      $figcaption = '<figcaption class="event-caption">' . $figcaption . '</figcaption>';
    } else {
      $figcaption = '<figcaption class="hero-caption">' . $figcaption . '</figcaption>';
    }

  }

  return $heroImg . $figcaption;
  //return $heroImg;

}
endif;


if ( ! function_exists( 'noscript_image' ) ) :
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
function noscript_image( $size = 'hero' ) {

  $heroImg = get_the_hero_image( $size );

  if ( strlen( $heroImg ) == 0 )
    return;

  echo '<noscript>' .  $heroImg . '</noscript>';

}
endif;




if ( ! function_exists( 'get_the_responsive_bg_img_styles' ) ) :
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
function get_the_responsive_bg_img_styles( $size, $selector, $field, $post = '' ) {

  if ( empty( $size ) || empty( $selector ) )
    return;

  if ( empty( $post ) )
    global $post;

  if ( empty( $post ) )
    return;

  $heroImgObject = get_field( $field, $post );

  $heroImgSrc = wp_get_attachment_image( $heroImgObject['ID'], $size );
  $heroImgMeta = wp_get_attachment_metadata( $heroImgObject['ID'] );
  //$imgSizes = wp_calculate_image_sizes( $size, $heroImgSrc, $heroImgMeta, $heroImgObject['ID'] );

  $imgSizes = array(
    absint( $heroImgObject['sizes'][$size . '-width'] ),
    absint( $heroImgObject['sizes'][$size . '-height'] ),
  );

  $imgSrcSet = calculate_responsive_bg_img_styles( $imgSizes, $heroImgSrc, $heroImgMeta, $heroImgObject['ID'], $selector );

  return $imgSrcSet;

}
endif;


if ( ! function_exists( 'the_responsive_bg_img_styles' ) ) :
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
function the_responsive_bg_img_styles( $size, $selector, $field = 'hero_image', $post = '' ) {

  if ( empty( $size ) || empty( $selector ) )
    return;

  if ( empty( $post ) )
    global $post;

  if ( empty( $post ) )
    return;

  $styles = get_the_responsive_bg_img_styles( $size, $selector, $field, $post );

  if ( strlen( $styles ) == 0 )
    return;

  echo $styles;

}
endif;


/** @TODO: Update this
 * Bastardized hack of wp_calculate_image_srcset
 *
 * Display category, tag, or term description.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */

function calculate_responsive_bg_img_styles( $size_array, $image_src, $image_meta, $attachment_id = 0, $selector ) {

    if ( empty( $image_meta['sizes'] ) ) {
      return false;
    }

    $image_sizes = $image_meta['sizes'];

    // Get the width and height of the image.
    $image_width = (int) $size_array[0];
    $image_height = (int) $size_array[1];

    // Bail early if error/no width.
    if ( $image_width < 1 ) {
      return false;
    }

    $image_basename = wp_basename( $image_meta['file'] );
    $image_baseurl = wp_get_upload_dir();
    $upload_dir = wp_upload_dir();

    /*
     * WordPress flattens animated GIFs into one frame when generating intermediate sizes.
     * To avoid hiding animation in user content, if src is a full size GIF, a srcset attribute is not generated.
     * If src is an intermediate size GIF, the full size is excluded from srcset to keep a flattened GIF from becoming animated.
     */
    if ( ! isset( $image_sizes['thumbnail']['mime-type'] ) || 'image/gif' !== $image_sizes['thumbnail']['mime-type'] ) {
      $image_sizes['full'] = array(
        'width'  => $image_meta['width'],
        'height' => $image_meta['height'],
        'file'   => $image_basename,
      );
    } elseif ( strpos( $image_src, $image_meta['file'] ) ) {
      return false;
    }

    // Uploads are (or have been) in year/month sub-directories.
    if ( $image_basename !== $image_meta['file'] ) {
      $dirname = dirname( $image_meta['file'] );

      if ( $dirname !== '.' ) {
        $image_baseurl = trailingslashit( $image_baseurl ) . $dirname;
      }
    }

    $image_baseurl = trailingslashit( $image_baseurl );

    // Calculate the image aspect ratio.
    $image_ratio = $image_height / $image_width;

    /*
     * Images that have been edited in WordPress after being uploaded will
     * contain a unique hash. Look for that hash and use it later to filter
     * out images that are leftovers from previous versions.
     */
    $image_edited = preg_match( '/-e[0-9]{13}/', wp_basename( $image_src ), $image_edit_hash );

    /**
     * Filter the maximum image width to be included in a 'srcset' attribute.
     *
     * @since 4.4.0
     *
     * @param int   $max_width  The maximum image width to be included in the 'srcset'. Default '1600'.
     * @param array $size_array Array of width and height values in pixels (in that order).
     */
    $max_srcset_image_width = apply_filters( 'max_srcset_image_width', 1600, $size_array );

    // Array to hold URL candidates.
    $sources = array();

    // holder for largest img value
    $biggestImg = 0;

    /*
     * Loop through available images. Only use images that are resized
     * versions of the same edit.
     */
    foreach ( $image_sizes as $image ) {

      // Filter out images that are from previous edits.
      if ( $image_edited && ! strpos( $image['file'], $image_edit_hash[0] ) ) {
        continue;
      }

      // Filter out images that are wider than '$max_srcset_image_width'.
      if ( $max_srcset_image_width && $image['width'] > $max_srcset_image_width ) {
        continue;
      }

      // Calculate the new image ratio.
      if ( $image['width'] ) {
        $image_ratio_compare = $image['height'] / $image['width'];
      } else {
        $image_ratio_compare = 0;
      }

      // If the new ratio differs by less than 0.002, use it.
      if ( abs( $image_ratio - $image_ratio_compare ) < 0.1 ) {
        // Add the URL, descriptor, and value to the sources array to be returned.
        $sources[ $image['width'] ] = array(
          'url'        => $image_baseurl . $image['file'],
          'descriptor' => 'max-width',
          'value'      => $image['width'],
        );

        // Replace the biggestImg value if this one is bigger
        if ( $image['width'] > $biggestImg )
          $biggestImg = $image['width'];
      }
    }

    // Adjust last value & descriptor
    $lastSource = array_pop( $sources );

    $lastSource['descriptor'] = 'min-width';
    $lastSource['original-value'] = $lastSource['value'];

    if ( count( $sources ) > 1 ) {
      $secondLastSource = array_pop( $sources );

      $lastSource['value'] = $secondLastSource['value'];
      $sources[ $secondLastSource['value'] ] = $secondLastSource;

    } else {

      $lastSource['value'] = 767;

    }

    $sources[ $lastSource['original-value'] ] = $lastSource;

    /**
     * Filter an image's 'srcset' sources.
     *
     * @since 4.4.0
     *
     * @param array  $sources {
     *     One or more arrays of source data to include in the 'srcset'.
     *
     *     @type array $width {
     *         @type string $url        The URL of an image source.
     *         @type string $descriptor The descriptor type used in the image candidate string,
     *                                  either 'w' or 'x'.
     *         @type int    $value      The source width if paired with a 'w' descriptor, or a
     *                                  pixel density value if paired with an 'x' descriptor.
     *     }
     * }
     * @param array  $size_array    Array of width and height values in pixels (in that order).
     * @param string $image_src     The 'src' of the image.
     * @param array  $image_meta    The image meta data as returned by 'wp_get_attachment_metadata()'.
     * @param int    $attachment_id Image attachment ID or 0.
     */
    $sources = apply_filters( 'calculate_responsive_bg_img_styles', $sources, $size_array, $image_src, $image_meta, $attachment_id );

    // Only return a 'srcset' value if there is more than one source.
    if ( count( $sources ) < 2 ) {
      //return false;
    }

    ksort( $sources );

    $styles = '<style>';

    foreach ( $sources as $i=>$source ) {

      $styles .= '@media screen and (' . $source['descriptor'] . ':' . $source['value'] . 'px ) { ';
      $styles .= $selector . '{ background-image: url(' . $upload_dir['baseurl'] . $source['url'] . '); }';
      $styles .= ' }' . "\n";
    }

    $styles .= '</style>';

    return $styles;
}


function get_the_photo_caption( $post_id, $img_id ) {
  //@TODO: write this.

  $caption = false;


  if ( $img_id && !is_home() && !is_front_page() && !is_archive() ) {
    $img_content = get_post( $img_id );

    $caption = ( isset( $img_content->post_excerpt ) ) ? $img_content->post_excerpt : $caption;
    $description = ( isset( $img_content->post_content ) && ( $caption !== $img_content->post_content )) ? '<span class="photo-credit">' . $img_content->post_content . '</span>' : false;

    $caption = $caption . $description;
  }

  if ( tribe_is_event( $post_id ) ) {
    //$event_month = space_string( tribe_get_start_date( $id, false, 'M' ) );
    //$event_day = space_string( tribe_get_start_date( $id, false, 'd' ) );
    $event_month = tribe_get_start_date( $post_id, false, 'M' );
    $event_day = tribe_get_start_date( $post_id, false, 'd' );

    $caption = sprintf('<span class="event-month">%1$s</span><span class="event-date">%2$s</span>', $event_month, $event_day );

  }

  return $caption;
}


function get_hero_origin() {
  //@TODO: write this.

  global $post;

  $heroOwner = false;

  if ( !empty( $post ) ) {
    $heroOwner = $post->ID;
  }


  return $heroOwner;
}

function get_hero_title() {
  //@TODO: write this.

  global $post;

  $heroTitle = false;

  if ( !in_the_loop() ) {

    if ( is_category() ) {

      $heroTitle = single_cat_title( '', false );

    } elseif ( is_tag() ) {

      $tag = get_queried_object();
      $heroTitle = $tag->name;
    }

  } else {

    $heroTitle = get_the_title( $post->ID );

  }

  return $heroTitle;
}



if ( ! function_exists( 'get_all_the_terms' ) ):

  /**
   * Get a list of all terms across all taxonomies
   *
   * @param $post (object or ID)
   *
   * @return array of terms
   *
   * @since 0.1.0
   */
  function get_all_the_terms( $post = 0 ) {

    $post = get_post( $post );

    if ( !$post )
      return false;

    $taxonomies = get_object_taxonomies( $post->post_type, 'objects' );

    $output = array();

    foreach ( $taxonomies as $taxonomy_slug => $taxonomy ) :

      $terms = get_the_terms( $post->ID, $taxonomy_slug );

      if ( !empty( $terms ) ) :

        foreach ( $terms as $term ) :

          $output[] = $term->name;

        endforeach;

      endif;

    endforeach;

    return $output;
  }

endif; // get_all_the_terms

if ( ! function_exists( 'get_page_id_by_slug' ) ) :

  /**
   * Quick way to get a page ID from a slug
   *
   * @param $slug
   *
   * @return int
   *
   * @since 0.1.0
   */

  function get_page_id_by_slug( $slug ) {
    $page = get_page_by_path( $slug );

    $id = ( !empty($page ) ) ? $page->ID : null;

    return $id;
  }

endif; // get_page_id_by_slug


if ( ! function_exists( 'get_the_slug' ) ) :

  /**
   * Quick way to get a slug from a post object
   *
   * @param $post
   *
   * @return string
   *
   * @since 0.1.0
   */

  function get_the_slug( $post ) {

    if ( $post == null )
      global $post;

    $slug = basename( get_permalink( $post ) );

    do_action('before_slug', $slug);

    $slug = apply_filters('slug_filter', $slug);

    do_action('after_slug', $slug);

    return $slug;
  }

endif; // get_the_slug


if ( ! function_exists( 'is_post_format_archive' ) ) :


/** Is the query for a post format archive page?
 *
 * If the $format parameter is specified, this function will check
 * if the query is for one of the formats specified.
 *
 * @since 3.9.0
 *
 * @param mixed $format Optional. Format slug or array of format slugs, without the post-format prefix.
 * @return bool
 */
function is_post_format_archive( $format = '' ) {

  global $wp_query;

  if ( ! isset( $wp_query ) ) {
    return false;
  }

  if ( ! empty( $format ) ) {
    $format = (array) $format;

    foreach ( $format as &$value ) {
      $value = 'post-format-' . $value;
    }
  }

  return $wp_query->is_tax( 'post_format', $format );
}

endif; // is_post_format_archive


if ( ! function_exists( 'section_normalizer' ) ) :

  /**
   * Get the "proper" name for an item referred to by a "section"
   *
   * @param $section
   *
   * @return string
   *
   * @since 0.1.0
   */

  function section_normalizer( $section) {

    $section_item_names = array(
      'events' => 'tribe_events',
      'gallery' => 'gallery',
      'video' => 'video',
      'promotions' => 'promotion',
    );

    return ( $section_item_names[ $section ] ) ? $section_item_names[ $section ] : $section;
  }

endif; // get_the_slug

/**
 * Insert a space between every character
 *
 * @param $string
 *
 * @return string
 *
 * @since 0.1.0
 */

function space_string( $str ) {
  return implode( ' ', str_split( $str, 1 ) );
}


function pre_printr( $output ) {

   if ( empty( $output ) )
    return;

  echo '<pre>';
  print_r( $output );
  echo '</pre>';
}
