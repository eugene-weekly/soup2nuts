/**
* Eugene Weekly 2017
* http://eugeneweekly.com
*
* Copyright (c) 2015 Nate Bedortha @ OK/No Way
*/

 ( function( window, undefined ) {
  'use strict';

  /**
   * MQ Class
   */
  if( Modernizr.mq( 'only all' ) ) {
    jQuery( 'html' ).addClass( 'mq' );
  } else {
    jQuery( 'html' ).addClass( 'no-mq' );
  }


  /**
   * FitVids
   */
   jQuery(".has-video-hero > .entry-hero").fitVids();


  /**
   * Lazy Loading
   */

  jQuery( '.delayed' ).each( function( ) {

    //console.log( $(this).data( 'delayed-background-image' ) );

    if ( jQuery( this ).is('iframe') ) {

      jQuery(this).attr( 'src', jQuery(this).data( 'src' ) );

    } else {

      jQuery(this).css( 'background-image', 'url(' + jQuery(this).data( 'delayed-background-image' ) + ')' );

    }

  });

  /**
   * Mobile Nav
   */

  function hideNav( e ) {
    e.preventDefault();
    jQuery( 'body' ).removeClass('show-nav');
  }

  jQuery( '.menu-toggle' ).on( 'click', function() {
    jQuery( 'body' ).removeClass('show-search').toggleClass('show-nav');
    //jQuery( '.show-nav #page' ).on( 'click', hideNav( e ) );
  });


  /**
   * Sub-Menu
   */
  jQuery( '.menu-item-more > a' ).on( 'click', function( e ) {
    e.preventDefault();
    jQuery( this ).parent( '.menu-item-more').toggleClass( 'show-sub-menu' );
  });


  /**
   * Search
   */
  jQuery( '.search-trigger' ).on( 'click', function() {
    jQuery( 'body' ).removeClass('show-nav').toggleClass('show-search');
  });


 } )( this );
