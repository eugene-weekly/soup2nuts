<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package soup2nuts
 */

?>

  </div><!-- #content -->

  <footer id="colophon" class="site-footer" role="contentinfo">

    <?php if ( ! dynamic_sidebar( 'Footer' ) ) :

      $social_widget = array(
        'title'              => '',
        'facebook_username'  => 'eugeneweekly',
        'twitter_username'   => 'eugeneweekly',
        'instagram_username' => 'eugeneweekly',
        'youtube_username'   => 'eugeneweekly',
      );
      the_widget( 'wpcom_social_media_icons_widget', $social_widget );

      $footer_nav_widget = array(
        'nav_menu' => 'Footer Navigation',
      );
      the_widget( 'WP_Nav_Menu_Widget', $footer_nav_widget );

      $copyright_widget = array(
        'text' => '&copy; Eugene Weekly,',
      );
      the_widget( 'widget_copyright', $copyright_widget );

    endif; ?>

  </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
