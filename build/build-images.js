module.exports = function( grunt ) {

  'use strict';

  // Project configuration
  grunt.config.merge( {
    svg_sprite: {
      options: {},
      icons: {
        expand    : true,
        cwd       : '<%= dirs.assets %>',
        src       : ['svg/src/**/*.svg'],
        dest      : 'svg',
        options   : {
            'dest': '<%= dirs.svg %>',
            'log': 'debug',
            'shape' : {
              'id' : {
                'separator' : '-',
                'generator' : function( name, file ) { return file.stem;},
                'pseudo' : '~',
                'whitespace' : '_',
              },
              'transform': ['svgo']
            },
            'variables' : {
              'png' : function() {
                return function(sprite, render) {
                  return render(sprite).split('.svg').join('.png');
                };
              }
            },
            'mode': {
              'symbol': {
                  'dest': '.',
                  'prefix': '%s',
                  'dimensions': true,
                  'bust': false,
                  'sprite': 'sprite.symbol.svg'
              },
              'view': {
                  'dest': '.',
                  'mixin': 'icon',
                  'prefix': '%s',
                  'dimensions': true,
                  'bust': false,
                  'sprite': 'sprite.view.svg',
                  'render': {
                      'scss': {
                          'template': '<%= dirs.tmpl %>/sprite.view.scss',
                          'dest': '../css/src/base/sprite.view.scss'
                      }
                  }
              }
          }
        }

      }
    },
    svg2png: {
      dist: {
          files: [{
            cwd: '<%= dirs.assets %>',
            src: ['svg/*.svg'],
            dest: 'img'
          }]
      }
    },
    imageoptim: {
      dist: {
        options: {
          jpegMini: false,
          imageAlpha: true,
          quitAfter: true
        },
        src: ['<%= dirs.assets %>/img']
      }
    },
    watch:  {
      images: {
        files: [ '<%= dirs.svg %>/src/**/*.svg' ],
        tasks: [ 'images' ]
      }
    }
  } );

  // Process Scripts.
  grunt.registerTask( 'images', [ 'svg_sprite' ] );
};
