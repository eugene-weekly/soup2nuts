<?php
/**
 * The template for displaying the home page.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package soup2nuts
 */

get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

      <?php get_template_part( 'partials/module', 'home' ); ?>

    </main><!-- #main -->
  </div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
