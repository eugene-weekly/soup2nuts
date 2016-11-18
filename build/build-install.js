module.exports = function( grunt ) {

  'use strict';

  // Bower configuration
  grunt.config.merge( {
    bower: {
      install: {
        options: {
          cleanup: true,
          copy: true,
          install: true,
          layout: 'byType',
          targetDir: '<%= dirs.vendor %>'
        }
      }
    },
    copy: {
      modernizr: {
        expand: true,
        flatten: true,
        filter: 'isFile',
        src: '<%= dirs.vendor %>/modernizr/modernizr/modernizr.js',
        dest: '<%= dirs.js %>/vendor/'
      },
      head: {
        expand: true,
        flatten: true,
        filter: 'isFile',
        src: '<%= dirs.vendor %>/head/**/*.js',
        dest: '<%= dirs.js %>/src/head/'
      },
      js: {
        expand: true,
        flatten: true,
        filter: 'isFile',
        src: '<%= dirs.vendor %>/js/**/*.js',
        dest: '<%= dirs.js %>/src/soup2nuts/'
      },
      scss: {
        expand: true,
        flatten: false,
        cwd: '<%= dirs.vendor %>/scss',
        src: '**',
        dest: '<%= dirs.sass %>/vendor'
      }
    },
    clean: {
      vendor: [ '<%= dirs.vendor %>' ]
    }



  } );

  // Install Dependencies.
  grunt.registerTask( 'install', [ 'bower', 'copy' ] );
};
