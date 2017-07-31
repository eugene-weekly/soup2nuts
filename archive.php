<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package soup2nuts
 */

get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

    <?php if ( have_posts() ) : ?>
      <header class="section-header page-header archive-header">
        <h5 class="section-title page-title"><?php the_archive_title(); ?></h5>
      </header><!-- .page-header -->

      <?php /* Start the Loop */ ?>
      <?php while ( have_posts() ) : the_post(); ?>

        <?php

          /*
           * Include the Post-Format-specific template for the content.
           * If you want to override this in a child theme, then include a file
           * called content-___.php (where ___ is the Post Format name) and that will be used instead.
           */
           //get_template_part( 'partials/content', get_post_format() );
           if ( is_paged() ||
            has_post_format( array('video', 'gallery') ) ||
            is_post_type_archive('promotion') ||
            is_search() ||
            is_tag() ) {
             get_template_part( 'partials/content', 'excerpt-list' );
           } else {
             get_template_part( 'partials/content', 'excerpt' );
           }
        ?>

      <?php endwhile; ?>

      <?php the_posts_navigation(); ?>

    <?php else : ?>

      <?php get_template_part( 'partials/content', 'none' ); ?>

    <?php endif; ?>

    </main><!-- #main -->
  </div><!-- #primary -->

<?php get_sidebar( 'archive-sidebar' ); ?>
<?php get_footer(); ?>
