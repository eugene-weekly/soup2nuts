<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package soup2nuts
 */

get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

      <section class="error-404 not-found">
        <header class="page-header">
          <h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'soup2nuts' ); ?></h1>
        </header><!-- .page-header -->

        <div class="page-content">
          <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'soup2nuts' ); ?></p>

          <?php $category_list_args = array(
            'exclude' => array( 1, 79, 102 ),
            'hide_title_if_empty' => true,
            'title_li' => '',
          );

          //wp_list_categories( $category_list_args ); ?>

          <?php //get_search_form(); ?>

        </div><!-- .page-content -->
      </section><!-- .error-404 -->

    </main><!-- #main -->
  </div><!-- #primary -->

<?php get_footer(); ?>
