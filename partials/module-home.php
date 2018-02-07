<?php
/**
 * The template for displaying the Home Posts module.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package soup2nuts
 */

$excludedPosts = array();

foreach( array( 'features', 'news', 'arts', 'culture', 'events', 'gallery', 'video', 'promotions' ) as $home_section ) :

  $posts = home_posts( $home_section, $excludedPosts );
  $sectionName = ( $home_section == 'promotions' ) ? 'Sponsored Content' : $home_section;

  //pre_printr( $posts );

  if ( $posts->have_posts() ) :

    $excludedPosts = array_merge( $excludedPosts, wp_list_pluck( $posts->posts, 'ID' ) );

    if (( $home_section == 'events' )) {

      // ad block above Events
      do_action( 'acm_tag', '900x250-home-before-events' );
    }

    // video column wrapper
    if (( $home_section == 'video' )) { ?>
      <div class="video-column-wrapper">
    <?php } ?>
    <section class="<?php echo $home_section; ?>-posts home-posts">

      <?php if ( !in_array( $home_section, array( 'features', 'events' ) ) ) : ?>

      <header class="section-header news-header">
        <h5 class="section-title"><?php echo ucwords( $sectionName ); ?></h5>
      </header>

      <?php endif;

      while ( $posts->have_posts() ) : $posts->the_post();

        if (( $home_section == 'features' ) && ( $posts->current_post == 1 )) : ?>

          <div class="right-column">
            <?php include( locate_template( 'partials/content-excerpt.php', false ) );
            // ad block above the fold
            do_action( 'acm_tag', '300x250-home-atf' );  ?>
          </div> <!-- right-column -->

        <?php else :

          include( locate_template( 'partials/content-excerpt.php', false ) );

        endif;

      endwhile; ?>

      <?php if ( !in_array( $home_section, array( 'features', 'events' ) ) ) : ?>

      <footer class="section-footer news-footer">
        <a href="<?php the_archive_link( $home_section ); ?>" class="archive-link" rel="archive">Explore <span class="category-name"><?php echo ucwords( $sectionName ); ?></span><span class="svg_icon-explore"><?php icon_sprite( 'icon-explore' ); ?></span></a>
      </footer>

      <?php endif; ?>

    </section><!-- <?php echo $home_section; ?> posts -->
  <?php endif;

  if (( $home_section == 'video' )) {
    // ad block after video
    do_action( 'acm_tag', '728x90-home-after-video' );  ?>
    </div>
  <?php }

  if (( $home_section == 'events' )) {
    // ad block after events
    do_action( 'acm_tag', '900x250-home-after-events' );
  }

  if (( $home_section == 'promotions' )) { ?>
    <div class="promotions-ad-column">
      <?php the_widget( 'CurrentIssue' ); ?><!-- CurrentIssue -->
      
      <?php do_action( 'acm_tag', '300x250-promotions-btf' );  ?>
    </div>
  <?php }


endforeach;
