module.exports = function( grunt ) {

  'use strict';

  // Project configuration
  grunt.config.merge( {
    watch:  {
      options: {
        atBegin: false,
        spawn: false
      }
    },
    browserSync: {
      dev: {
        bsFiles: {
          src: [
            '<%= dirs.css %>/*.css',
            '<%= dirs.js %>/*.js',
            '*.php',
            'includes/*.php',
            'partials/*.php',
            'post-types/*.php',
            'taxonomies/*.php',
            'widgets/*.php'
          ]
        },
        options: {
          watchTask: true,
          ghostMode: false,
          open: false,
          notify: false,
          reloadDebounce: 10000,
          reloadThrottle: 10
        }
      }
    }
  } );

  // Watch.
  grunt.registerTask( 'live', [ 'browserSync', 'watch' ] );

};
