<?php
/**
 * The template for displaying taxonomy archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package soup2nuts
 */

get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

      <?php $excludedPosts = array();

      $obj = get_queried_object();

      foreach( array( 'features', 'latest', 'more_features', 'popular', 'promotions' ) as $tax_section ) :

        $posts = tax_posts( $tax_section, $obj, $excludedPosts );

        //pre_printr( $posts );

        if ( $posts->have_posts() ) :

          $excludedPosts = array_merge( $excludedPosts, wp_list_pluck( $posts->posts, 'ID' ) ); ?>

          <section class="<?php echo $tax_section; ?>-posts taxonomy-posts">

            <?php if ( !in_array( $tax_section, array( 'features', 'more_features' ) ) ) : ?>

            <header class="section-header news-header">
              <h5 class="section-title"><?php echo ucwords( $tax_section ); ?></h5>
            </header>

            <?php endif;

            while ( $posts->have_posts() ) : $posts->the_post();

              //get_template_part( 'partials/content', 'excerpt' );
              include( locate_template( 'partials/content-excerpt.php', false ) );

              if (( $tax_section == 'features' ) && ( $posts->current_post == 1 ))
                get_template_part( 'partials/module', 'ad' );

            endwhile; ?>

            <?php if ( !in_array( $tax_section, array( 'features', 'more_features' ) ) ) : ?>

            <footer class="section-footer news-footer">
              <a href="<?php the_category_link( $tax_section ); ?>" class="archive-link" rel="archive">Explore <span class="category-name"><?php echo ucwords( $tax_section ); ?></span><span class="svg_icon-explore"><?php icon_sprite( 'icon-explore' ); ?></span></a>
            </footer>

            <?php endif; ?>

          </section><!-- featured posts -->
        <?php endif;

        if (( $tax_section == 'promotions' ))
          get_template_part( 'partials/module', 'ad' );


      endforeach; ?>

    </main><!-- #main -->
  </div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
