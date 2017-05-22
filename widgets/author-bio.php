<?php
/**
 * Author Bio Widget
 */

class AuthorBio extends WP_Widget {

  public function __construct() {
    $widget_ops = array( 'classname' => 'author_bio', 'description' => 'Show Author Bio.' );
    parent::__construct( 'AuthorBio', __('AuthorBio', 'soup2nuts'), $widget_ops );
  }

  public function widget( $args, $instance ) {

    if ( !is_author() )
      return;

    $author = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));

    if ( empty( $author ) )
      return;

    // output
    extract( $args );

    $title = ( !empty( $instance[ 'title' ] ) ) ? $instance[ 'title' ] : null;

    $author_photo = get_avatar( $author->ID, 300 );
    $author_name = get_the_author_meta( 'display_name', $author->ID );
    $author_bio = get_the_author_meta( 'description', $author->ID );
    $author_social = get_user_meta( $author->ID, 'social-links', false);

    echo $before_widget; ?>
    <?php if ( !empty( $title ) ) : ?>
      <h5 class="widget-title"><?php echo $title; ?></h5>
    <?php endif; ?>

    <?php if ( !empty( $author_photo ) )
      echo $author_photo; ?>

    <?php if ( !empty( $author_name ) ) : ?>
      <h3><?php echo $author_name; ?></h3>
    <?php endif; ?>

    <?php if ( !empty( $author_bio ) ) : ?>
      <p><?php echo $author_bio; ?></p>
    <?php endif; ?>

    <?php if ( !empty( $author_social ) ) : ?>
      <ul class="author-social">
        <?php foreach ($author_social[0] as $service=>$social) :
          if (empty( $social ) ) continue; ?>
        <li>
          <a href="<?php the_author_social( $service, $social ); ?>" class="genericon genericon-<?php echo $service; ?> social-icon-<?php echo $service; ?>"><span class="visuallyhidden">Follow <?php echo $author_name; ?> on <?php echo ucfirst( $service ); ?>.</span></a>
        </li>
      <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <?php echo $after_widget;

  }

  public function form( $instance ) {
    // admin form options

    $text = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : 'Author Bio';

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
 register_widget( 'AuthorBio' );
});
