<?php
/**
 * soup2nuts Fields
 *
 * @package soup2nuts
 */

function meta_fields() {

  $alt_title = new Fieldmanager_Textfield( 'Alternate Title', array(
    'description' => 'Used in place of post title in thumbnails, lists, search results.',
  ) );

  $sub_head = new Fieldmanager_Textfield( 'Subhead', array(
    'description' => 'Subheading, visible in thumbnails, lists, and posts.'
  ) );

  $featured = new Fieldmanager_Checkbox( array(
    'name' => 'featured',
    'label' => 'Feature this post on the home page.',
    'description' => 'Allows this post to be shown in the Featured position on the home page.',

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
    ),
  ) );
  $post_details->add_meta_box( 'Post Details', 'post' );


  $promotion_details = new Fieldmanager_Group( array(
    'name' => 'promotion_details',
    'serialize_data' => false,
    'add_to_prefix' => false,
    'children' => array(
      'alt-title' => $alt_title,
      'sub-head' => $sub_head,
      'expiration-date' => $expiration_date,
    ),
  ) );
  $promotion_details->add_meta_box( 'Promotion Details', 'promotion' );


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

add_action( 'fm_post_post', 'meta_fields' );
add_action( 'fm_post_promotion', 'meta_fields' );
add_action( 'fm_post_tribe_events', 'meta_fields' );
