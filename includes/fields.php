<?php
/**
 * soup2nuts Fields
 *
 * @package soup2nuts
 */

 add_action( 'fm_post_post', function() {
   $fm = new Fieldmanager_Group( array(
     'name' => 'post_details',
     'children' => array(
       'subhead' => new Fieldmanager_Textfield( 'Subhead' ),
     ),
   ) );
   $fm->add_meta_box( 'Post Details', 'post' );
 } );
