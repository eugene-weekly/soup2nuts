<?php
/**
 * soup2nuts Fields
 *
 * @package soup2nuts
 */

function meta_fields() {


   $social_links = new Fieldmanager_Group( array(
     'label' => 'Social Links',
     'sortable' => true,
     'children' => array(
       'twitter' => new Fieldmanager_Textfield( 'Twitter', array(
         'description' => 'Enter a Twitter username (no @).',
       ) ),
       'facebook' => new Fieldmanager_Textfield( 'Facebook', array(
         'description' => 'Enter a Facebook URL (not just a User Name)',
       ) ),
       'instagram' => new Fieldmanager_Textfield( 'Instagram', array(
         'description' => 'Enter an Instagram username (no @).',
       ) ),
     )
   ) );


  $alt_title = new Fieldmanager_Textfield( 'Alternate Title', array(
    'description' => 'Used in place of post title in thumbnails, lists, search results.',
  ) );

  $sub_head = new Fieldmanager_Textfield( 'Subhead', array(
    'description' => 'Subheading, visible in thumbnails, lists, and posts.'
  ) );

  $issue_url = new Fieldmanager_Textfield( 'Link to issue', array(
    'description' => 'Enter the issue&rsquo;s url.',
    'input_type' => 'url',
  ) );

  $featured = new Fieldmanager_Checkbox( array(
    'name' => 'featured',
    'label' => 'Feature this post on the home page.',
    'description' => 'Allows this post to be shown in the Featured position on the home page.',
  ) );

  $full_screen = new Fieldmanager_Checkbox( array(
    'name' => 'full-screen',
    'label' => 'Use &ldquo;Full Screen&rdquo; Post Format.',
    'description' => 'Widescreen Hero, content in a center column.',
  ) );

  $no_hero = new Fieldmanager_Checkbox( array(
    'name' => 'no-hero',
    'label' => '&ldquo;No Hero&rdquo; Post Format.',
    'description' => 'Don&rsquo;t show the Featured Image above the headline, show it in the post content.',
  ) );

  $featured_event = new Fieldmanager_Textfield( array(
    'name' => 'featured-event-quotient',
    'label' => 'Feature this event on the home page.',
    'description' => 'Allows this post to be shown in Featured Events on the home page. A higher number moves the event higher up the page.',
    'input_type' => 'number',
    'default_value' => 0,
    'attributes' => array(
      'min' => '0',
      'max' => '100'
    )
  ) );

  $sponsored_event = new Fieldmanager_Checkbox( array(
    'name' => 'sponsored',
    'label' => 'Mark this event as sponsored.',

  ) );

  $expiration_date = new Fieldmanager_Datepicker( array(
   'name' => 'expiration-date',
   'label' => 'Expires On',
   'description' => 'Set a date to expire this promotion.'
 ) );


   $related_posts = new Fieldmanager_Group( array(
     'label' => 'Related Post',
     'limit' => 3,
     'label_macro' => array( 'Post: %s', 'name'),
     'add_more_label' => 'Add another post',
     'sortable' => true,
     'children' => array(
       'related_post' => new Fieldmanager_Autocomplete( array(
         'name' => 'related_post',
         'label' => 'Related Post:',
         'description' => 'Type to find a Related Post.',
         'datasource' => new Fieldmanager_Datasource_Post( array(
           'query_args' => array(
             'post_type' => 'post'
           )
         ) ),
       ) ),
     )
   ) );

  $hero_gallery = new Fieldmanager_Autocomplete( array(
   'name' => 'hero-gallery',
   'label' => 'Hero Gallery:',
   'description' => 'Type to find a Gallery.',
   'datasource' => new Fieldmanager_Datasource_Post( array(
     'query_args' => array(
       'post_type' => 'ai_gallery'
     ),
     'use_ajax' => true
   ) ),
  ) );

  $hero_video = new Fieldmanager_Textfield( array(
    'name' => 'hero-video',
    'label' => 'Hero Video',
    'description' => 'Show a video above the post.',
    'input_type' => 'url',
    'attributes' => array(
      'placeholder' => 'https://www.youtube.com/watch?v=4OZjma8iLtE',
      'class' => 'widefat'
    )
  ) );


  $user_details = new Fieldmanager_Group( array(
    'name' => 'user_details',
    'tabbed' => true,
    'serialize_data' => false,
    'add_to_prefix' => false,
    'children' => array(
      'tab-1' => new Fieldmanager_Group( array(
        'label' => 'Social Links',
        'serialize_data' => false,
        'add_to_prefix' => false,
        'children' => array(
          'social-links' => $social_links,
        )
      ) ),
    ),
  ) );
  $user_details->add_user_form( 'Author Details', 'user' );

  $post_details = new Fieldmanager_Group( array(
    'name' => 'post_details',
    'tabbed' => true,
    'serialize_data' => false,
    'add_to_prefix' => false,
    'children' => array(
      'tab-1' => new Fieldmanager_Group( array(
        'label' => 'Post Details',
        'serialize_data' => false,
        'add_to_prefix' => false,
        'children' => array(
          'alt-title' => $alt_title,
          'sub-head' => $sub_head,
          'featured' => $featured,
          'full-screen' => $full_screen,
          'no-hero' => $no_hero,
        )
      ) ),
      'tab-2' => new Fieldmanager_Group( array(
        'label' => 'Related Posts',
        'serialize_data' => false,
        'add_to_prefix' => false,
        'children' => array(
          'related' => $related_posts,
        )
      ) ),
      'tab-3' => new Fieldmanager_Group( array(
        'label' => 'Gallery',
        'serialize_data' => false,
        'add_to_prefix' => false,
        'children' => array(
          'hero-gallery' => $hero_gallery,
        )
      ) ),
      'tab-4' => new Fieldmanager_Group( array(
        'label' => 'Video',
        'serialize_data' => false,
        'add_to_prefix' => false,
        'children' => array(
          'hero-video' => $hero_video,
        )
      ) ),
    ),
  ) );
  $post_details->add_meta_box( 'Post Details', 'post' );
  $post_details->add_meta_box( 'Post Details', 'style-guide' );


  $promotion_details = new Fieldmanager_Group( array(
    'name' => 'promotion_details',
    'tabbed' => true,
    'serialize_data' => false,
    'add_to_prefix' => false,
    'children' => array(
      'tab-1' => new Fieldmanager_Group( array(
        'label' => 'Post Details',
        'serialize_data' => false,
        'add_to_prefix' => false,
        'children' => array(
          'alt-title' => $alt_title,
          'sub-head' => $sub_head,
          'expiration-date' => $expiration_date,
          'featured' => $featured,
          'full-screen' => $full_screen,
          'no-hero' => $no_hero,
        )
      ) ),
      'tab-2' => new Fieldmanager_Group( array(
        'label' => 'Gallery',
        'serialize_data' => false,
        'add_to_prefix' => false,
        'children' => array(
          'hero-gallery' => $hero_gallery,
        )
      ) ),
      'tab-3' => new Fieldmanager_Group( array(
        'label' => 'Video',
        'serialize_data' => false,
        'add_to_prefix' => false,
        'children' => array(
          'hero-video' => $hero_video,
        )
      ) ),
    ),
  ) );
  $promotion_details->add_meta_box( 'Promotion Details', 'promotion' );


  $issue_details = new Fieldmanager_Group( array(
    'name' => 'issue_details',
    'serialize_data' => false,
    'add_to_prefix' => false,
    'children' => array(
      'issue-url' => $issue_url,
    ),
  ) );
  $issue_details->add_meta_box( 'Issue Details', 'issue' );


  $event_details = new Fieldmanager_Group( array(
    'name' => 'event_details',
    'serialize_data' => false,
    'add_to_prefix' => false,
    'children' => array(
      'featured-event-quotient' => $featured_event,
      'sponsored' => $sponsored_event,
    ),
  ) );
  $event_details->add_meta_box( 'Event Details', 'tribe_events' );
}

add_action( 'fm_user', 'meta_fields' );
add_action( 'fm_post_post', 'meta_fields' );
add_action( 'fm_post_promotion', 'meta_fields' );
add_action( 'fm_post_issue', 'meta_fields' );
add_action( 'fm_post_style-guide', 'meta_fields' );
add_action( 'fm_post_tribe_events', 'meta_fields' );
