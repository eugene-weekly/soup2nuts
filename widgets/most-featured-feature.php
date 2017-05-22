<?php
/**
 * Most Featured Feature Widget
 */

class MostFeaturedFeature extends WP_Widget {

  public function __construct() {
    $widget_ops = array( 'classname' => 'most_featured_feature', 'description' => 'Show the Most Featured Feature.' );
    parent::__construct( 'MostFeaturedFeature', __('MostFeaturedFeature', 'soup2nuts'), $widget_ops );
  }

  public function widget( $args, $instance ) {
    global $post;
    // output
    extract( $args );

    $count = ( !empty( $instance[ 'count' ] ) ) ? $instance[ 'count' ] : 1;
    $featured_feature = featured_post( $count, array(), array( $post->ID), 'posts' );

    echo $before_widget;

    while ( $featured_feature->have_posts() ) : $featured_feature->the_post();

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
      <label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Number of Features:' ); ?></label>
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
 register_widget( 'MostFeaturedFeature' );
});
