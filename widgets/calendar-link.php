<?php
/**
 * Calendar Link Widget
 */

class CalendarLink extends WP_Widget {

  public function __construct() {
    $widget_ops = array( 'classname' => 'calendar_link', 'description' => 'Show link to Calendar page with icon.' );
    parent::__construct( 'CalendarLink', __('CalendarLink', 'soup2nuts'), $widget_ops );
  }

  public function widget( $args, $instance ) {

    // output
    extract( $args );

    $text = ( !empty( $instance[ 'text' ] ) ) ? $instance[ 'text' ] : null;

    echo $before_widget; ?>
    <?php if ( !empty( $text ) ) : ?>
      <p class="copyright"><?php echo $text; ?>&nbsp;<?php echo date('Y'); ?></p>

    <?php endif; ?>

    <?php echo $after_widget;

  }

  public function form( $instance ) {
    // admin form options

    $text = isset( $instance[ 'text' ] ) ? $instance[ 'text' ] : '&copy; Eugene Weekly,';

    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Text:' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>" type="text" value="<?php echo $text; ?>" />
    </p>
    <?php
  }

  public function update( $new_instance, $old_instance ) {
    // save options

    $instance = array();
    $instance[ 'text' ] = strip_tags( $new_instance[ 'text' ] );

    return $instance;
  }
}

add_action( 'widgets_init', function() {
 register_widget( 'CalendarLink' );
});
