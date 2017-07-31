<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package soup2nuts
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <header class="entry-header">
    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
  </header><!-- .entry-header -->

  <div class="entry-content">
    <?php the_content(); ?>
  </div><!-- .entry-content -->

  <?php do_action( 'acm_tag', '300x600-post-sidebar-atf' ); ?>

  <footer class="entry-footer">
    <?php soup2nuts_entry_footer(); ?>
  </footer><!-- .entry-footer -->
</article><!-- #post-## -->

<?php //get_sidebar(); ?>
