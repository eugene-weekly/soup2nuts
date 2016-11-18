module.exports = function( grunt ) {
  
  'use strict';

  // Project configuration
  grunt.config.merge( {
    jshint: {
      browser: {
        all: [
          '<%= dirs.js %>/src/**/*.js',
          '<%= dirs.js %>/test/**/*.js'
        ],
        options: {
          jshintrc: '.jshintrc'
        }
      },
      grunt: {
        all: [
          'Gruntfile.js'
        ],
        options: {
          jshintrc: '.gruntjshintrc'
        }
      }
    },
    uglify: {
      dist: {
        files: {
          '<%= dirs.js %>/admin.js': [ '<%= dirs.js %>/src/admin/**/*.js' ],
          '<%= dirs.js %>/head.js': [ '<%= dirs.js %>/src/head/**/*.js' ],
          '<%= dirs.js %>/soup2nuts.js': [ '<%= dirs.js %>/src/soup2nuts/**/*.js' ]
        },
        options: {
          banner: '/*! <%= pkg.title %> - v<%= pkg.version %>\n' +
            ' * <%= pkg.homepage %>\n' +
            ' * Copyright (c) <%= grunt.template.today("yyyy") %>;' +
            ' */\n',
          sourceMap: true,
          sourceMapIncludeSources: true,
          sourceMapName: function( dest ) {
            return dest.replace( '/js/', '/maps/' ) + '.map';
          },
          mangle: {
            except: [ 'jQuery' ]
          }
        }
      }
    },
    modernizr: {
      dist: {
        'parseFiles': true,
        'customTests': [],
        'devFile': '<%= dirs.js %>/vendor/modernizr.js',
        'dest': '<%= dirs.js %>/src/head/_modernizr.custom.js',
        'tests': [
          'flexbox',
          'flexboxlegacy',
          'flexboxtweener'
        ],
        'excludeTests': [
          'hidden'
        ],
        'options': [
          'mq',
          'setClasses'
        ],
        'uglify': false,
        'files' : {
          'src': [
            '<%= dirs.js %>/src/**/*.js',
            '<%= dirs.sass %>/**/*.scss'
          ]
        }
      }
    },

    watch:  {
      scripts: {
        files: [ '<%= dirs.js %>/src/**/*.js', '<%= dirs.vendor %>/**/*.js' ],
        tasks: [ 'scripts' ]
      }
    }
  } );

  // Process Scripts.
  grunt.registerTask( 'scripts', [ 'modernizr', 'uglify' ] );
};
