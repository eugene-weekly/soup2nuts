<?php
/**
 * The template file for displaying a search form.
 *
 * @package soup2nuts
 */ ?>

<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
  <label for="s" class="search-trigger">
    <?php icon_sprite( 'icon-search' ); ?>
    <?php icon_sprite( 'icon-close' ); ?>
    <span class="screen-reader-text"><?php echo _x( 'Search', 'label' ) ?></span>
  </label>
  <div class="search-wrapper">
    <label class="search-label">
      <span class="screen-reader-text"><?php echo _x( 'Search', 'label' ) ?></span>
      <input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search', 'placeholder' ) ?>" data-mobile-placeholder="<?php echo esc_attr_x( 'Search&hellip;', 'placeholder' ) ?>" data-tablet-placeholder="<?php echo esc_attr_x( 'What are you looking for?', 'placeholder' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
    </label>
    <span class="submit-wrapper">
      <button type="submit" class="search-submit" aria-role="button">
        <span class="screen-reader-text"><?php echo esc_attr_x( 'Search', 'submit button' ) ?></span>
        <?php icon_sprite( 'icon-search' ); ?>
      </button>
    </span>
  </div>
</form>
