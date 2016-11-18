<?php
/**
 * The template for displaying attachments (actually just redirecting them to the post_parent).
 *
 * @package soup2nuts
 */

wp_redirect( get_permalink( $post->post_parent ) ); ?>
