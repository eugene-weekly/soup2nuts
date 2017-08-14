<?php
/**
 * Template part for displaying single posts.
 *
 * @package soup2nuts
 */

$format = get_post_format();

if ( in_array( $format, array('video','gallery') ) )
  do_action( 'acm_tag', '728x90-before-' . $format  ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <figure class="entry-hero">
    <?php the_hero_image( 'hero' ); ?>
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

  <footer class="entry-footer">
    <?php soup2nuts_entry_footer(); ?>
  </footer><!-- .entry-footer -->


  <?php if ( !in_array( $format, array('video','gallery') ) )
    do_action( 'acm_tag', '300x600-post-sidebar-atf' ); ?>

</article><!-- #post-## -->
