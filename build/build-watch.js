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
        },
        options: {
          files: [
            '<%= dirs.css %>/*.css',
            '<%= dirs.js %>/*.js',
            '*.php',
            'includes/*.php',
            'partials/*.php',
            'post-types/*.php',
            'taxonomies/*.php',
            'widgets/*.php'
          ],
          watchTask: true,
          ghostMode: false,
          open: false,
          notify: false,
          reloadDebounce: 1000,
          reloadThrottle: 2
        }
      }
    }
  } );

  // Watch.
  grunt.registerTask( 'live', [ 'browserSync:dev', 'watch' ] );

};
