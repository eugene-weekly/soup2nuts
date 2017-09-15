<?php
/**
 * Related Posts Widget
 */

class RelatedPosts extends WP_Widget {

  public function __construct() {
    $widget_ops = array( 'classname' => 'related_posts', 'description' => 'Show Related Posts.' );
    parent::__construct( 'RelatedPosts', __('RelatedPosts', 'soup2nuts'), $widget_ops );
  }

  public function widget( $args, $instance ) {

    // output
    extract( $args );

    $title = ( !empty( $instance[ 'title' ] ) ) ? $instance[ 'title' ] : null;

    if ( is_page() && $title == 'Related Posts' ) {
      $title = 'Recent Posts';
    }

    $related_posts = get_related_posts();

    echo $before_widget; ?>
    <?php if ( !empty( $title ) ) : ?>
      <h5 class="widget-title"><?php echo $title; ?></h5>
    <?php endif; ?>

    <?php while ( $related_posts->have_posts() ) : $related_posts->the_post();

      $section = 'sidebar';

      if ( $related_posts->current_post == 1 ) {
        include( locate_template( 'partials/content-excerpt.php', false ) );
      } else {
        include( locate_template( 'partials/content-excerpt-list.php', false ) );
      }

    endwhile;
    wp_reset_postdata();

    echo $after_widget;

  }

  public function form( $instance ) {
    // admin form options

    $text = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : 'Related Posts';

    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $text; ?>" />
    </p>
    <?php
  }

  public function update( $new_instance, $old_instance ) {
    // save options

    $instance = array();
    $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );

    return $instance;
  }
}

add_action( 'widgets_init', function() {
 register_widget( 'RelatedPosts' );
});
