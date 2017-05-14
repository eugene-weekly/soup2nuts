<?php
/**
 * The template for displaying the Home Posts module.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package soup2nuts
 */

$excludedPosts = array();

foreach( array( 'features', 'news', 'arts', 'culture', 'events', 'galleries', 'video', 'promotions' ) as $home_section ) :

  $posts = home_posts( $home_section, $excludedPosts );

  //pre_printr( $posts );

  if ( $posts->have_posts() ) :

    $excludedPosts = array_merge( $excludedPosts, wp_list_pluck( $posts->posts, 'ID' ) ); ?>

    <section class="<?php echo $home_section; ?>-posts home-posts">

      <?php if ( !in_array( $home_section, array( 'features', 'events' ) ) ) : ?>

      <header class="section-header news-header">
        <h5 class="section-title"><?php echo ucwords( $home_section ); ?></h5>
      </header>

      <?php endif;

      while ( $posts->have_posts() ) : $posts->the_post();

        if (( $home_section == 'features' ) && ( $posts->current_post == 1 )) : ?>

          <div class="right-column">
            <?php include( locate_template( 'partials/content-excerpt.php', false ) );
            include( locate_template( 'partials/module-ad.php', false ) ); ?>
          </div> <!-- right-column -->

        <?php else :

          include( locate_template( 'partials/content-excerpt.php', false ) );

        endif;

      endwhile; ?>

      <?php if ( !in_array( $home_section, array( 'features', 'events' ) ) ) : ?>

      <footer class="section-footer news-footer">
        <a href="<?php the_category_link( $home_section ); ?>" class="archive-link" rel="archive">Explore <span class="category-name"><?php echo ucwords( $home_section ); ?></span><span class="svg_icon-explore"><?php icon_sprite( 'icon-explore' ); ?></span></a>
      </footer>

      <?php endif; ?>

    </section><!-- <?php echo $home_section; ?> posts -->
  <?php endif;

  if (( $home_section == 'events' )) {
    include( locate_template( 'partials/module-ad.php', false ) );
  }

  if (( $home_section == 'promotions' )) { ?>
    <div class="promotions-ad-column">
      <?php include( locate_template( 'partials/module-ad.php', false ) ); ?>
    </div>
  <?php }


endforeach;
