<?php
/**
 * The template part for displaying results in archive/search pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package soup2nuts
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'excerpted-post' ); ?>>
  <header class="entry-header">
    <?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>

    <?php the_subhead( sprintf( '<h4 class="entry-subhead"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' ); ?>

    <div class="entry-meta">
      <?php soup2nuts_excerpt_meta(); ?>
    </div><!-- .entry-meta -->
  </header><!-- .entry-header -->

  <figure class="entry-hero">
    <a href="<?php the_permalink(); ?>" rel="bookmark">
      <?php the_hero_image( guess_hero_size( $home_section, $posts->current_post ) ); ?>
    </a>
  </figure><!-- .entry-hero -->

  <footer class="entry-footer">
    <?php soup2nuts_entry_footer(); ?>
  </footer>

</article><!-- #post-## -->
