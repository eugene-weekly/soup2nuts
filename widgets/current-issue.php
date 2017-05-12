<?php
/**
 * Current Issue Widget
 */

class CurrentIssue extends WP_Widget {

  public function __construct() {
    $widget_ops = array( 'classname' => 'current_issue', 'description' => 'Show Current Issue.' );
    parent::__construct( 'CurrentIssue', __('CurrentIssue', 'soup2nuts'), $widget_ops );
  }

  public function widget( $args, $instance ) {

    // output
    extract( $args );

    $title = ( !empty( $instance[ 'title' ] ) ) ? $instance[ 'title' ] : null;

    if ( is_page() && $title == 'Current Issue' ) {
      $title = 'Recent Posts';
    }

    $current_issue = get_current_issue();

    echo $before_widget; ?>
    <?php if ( !empty( $title ) ) : ?>
      <h5 class="widget-title"><?php echo $title; ?></h5>
    <?php endif; ?>

    <?php while ( $current_issue->have_posts() ) : $current_issue->the_post();

      $section = 'sidebar';
      include( locate_template( 'partials/content-excerpt.php', false ) );

    endwhile;
    wp_reset_postdata();

    echo $after_widget;

  }

  public function form( $instance ) {
    // admin form options

    $text = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : 'Current Issue';

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
 register_widget( 'CurrentIssue' );
});
