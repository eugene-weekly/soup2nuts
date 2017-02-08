<?php
/**
 * The template for displaying all single posts.
 *
 * @package soup2nuts
 */

get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

    <?php if ( have_posts() ) : ?>

      <?php while ( have_posts() ) : the_post(); ?>

        <?php get_template_part( 'partials/content', 'single' ); ?>

        <?php the_post_navigation(); ?>

      <?php endwhile; // End of the loop. ?>

    <?php else : ?>

        <?php get_template_part( 'partials/content', 'none' ); ?>

    <?php endif; ?>

    </main><!-- #main -->
  </div><!-- #primary -->

<?php get_footer(); ?>
