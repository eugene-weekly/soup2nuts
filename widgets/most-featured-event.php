<?php
/**
 * Most Featured Event Widget
 */

class MostFeaturedEvent extends WP_Widget {

  public function __construct() {
    $widget_ops = array( 'classname' => 'most_featured_event', 'description' => 'Show the Most Featured Event.' );
    parent::__construct( 'MostFeaturedEvent', __('MostFeaturedEvent', 'soup2nuts'), $widget_ops );
  }

  public function widget( $args, $instance ) {
    global $post;
    // output
    extract( $args );

    $count = ( !empty( $instance[ 'count' ] ) ) ? $instance[ 'count' ] : 1;
    $featured_event = featured_events( $count, array( $post->ID ), 'posts' );

    echo $before_widget;

    while ( $featured_event->have_posts() ) : $featured_event->the_post();

      $section = 'sidebar';
      include( locate_template( 'partials/content-excerpt.php', false ) );

    endwhile;
    wp_reset_postdata();

    echo $after_widget;

  }

  public function form( $instance ) {
    // admin form options

    $count = isset( $instance[ 'count' ] ) ? $instance[ 'count' ] : 1;

    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Number of Events:' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="number" value="<?php echo $count; ?>" />
    </p>
    <?php
  }

  public function update( $new_instance, $old_instance ) {
    // save options

    $instance = array();
    $instance[ 'count' ] = strip_tags( $new_instance[ 'count' ] );

    return $instance;
  }
}

add_action( 'widgets_init', function() {
 register_widget( 'MostFeaturedEvent' );
});
