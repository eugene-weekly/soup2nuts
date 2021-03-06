<?php
/**
 * Template part for displaying full-screen posts.
 *
 * @package soup2nuts
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <figure class="entry-hero">
    <?php the_hero_image( 'wide-hero' ); ?>
  </figure><!-- .entry-hero -->

  <header class="entry-header">
    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
    <?php the_subhead( '<h4 class="entry-subhead">','</h4>' ); ?>

    <div class="entry-meta">
      <?php soup2nuts_posted_on(); ?>
    </div><!-- .entry-meta -->
  </header><!-- .entry-header -->

  <div class="entry-content">
    <?php the_content(); ?>
  </div><!-- .entry-content -->
  <!-- ad sidebar will go here -->

  <footer class="entry-footer">
    <?php soup2nuts_entry_footer(); ?>
  </footer><!-- .entry-footer -->

</article><!-- #post-## -->
