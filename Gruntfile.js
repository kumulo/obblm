module.exports = function(grunt) { 
  // Importation des différents modules grunt
  require('load-grunt-tasks')(grunt);

  // Configuration des plugins
  grunt.initConfig({
    uglify: {
      options: {
        mangle: false,
        sourceMap: true
      },
      libs: {
        files: {
          'web/built/libs.min.js': [
            'app/Resources/lib/jquery/dist/jquery.js',
            'app/Resources/lib/nanobar/nanobar.js',
            'app/Resources/lib/amcharts/dist/amcharts/amcharts.js',
            'app/Resources/lib/amcharts/dist/amcharts/serial.js',
            'app/Resources/lib/amcharts/dist/amcharts/lang/fr.js',
            'app/Resources/lib/amcharts/dist/amcharts/lang/en.js',
            'app/Resources/lib/semantic/dist/semantic.js'
          ]
        },
        sourceMapName: 'web/built/libs.map'
      },
      dist: {
        files: {
          'web/built/app.min.js': [
             "src/BbLeagueBundle/Resources/public/js/front.js"
          ]
        },
        sourceMapName: 'web/built/app.map'
      }
    }, //end uglify
    less: {
        dist: {
            options: {
                compress: true,
                yuicompress: true,
                paths: [".tmp/css"],
                optimization: 2
            },
            files: {
                ".tmp/css/app.css": [
                    "src/BbLeagueBundle/Resources/less/layout.less"
                ],
                ".tmp/css/print.css": [
                    "src/BbLeagueBundle/Resources/less/print.less"
                ]
            }
        }
    }, //end less
    cssmin: {
      combinelibs: {
        options:{
          report: 'gzip',
          keepSpecialComments: 0
        },
        files: {
          'web/built/libs.min.css': [
            '.tmp/libs/1.fonts.css',
            '.tmp/libs/semantic.css',
            '.tmp/libs/reset5.css'
          ]
        }
      },
      combine: {
        options:{
          report: 'gzip',
          keepSpecialComments: 0
        },
        files: {
          'web/built/app.min.css': [
            '.tmp/css/layout.css'
          ],
          'web/built/print.min.css': [
            '.tmp/css/print.css'
          ]
        }
      }
    }, //end cssmin
    watch: {
      css: {
        files: ['src/BbLeagueBundle/Resources/less/**/*.less'],
        tasks: ['less'],
        options: {
          nospawn: true
        }
      }
    }, //end watch
    copy: {
        fonts: {
            expand: true,
            filter: 'isFile',
            src: '.tmp/libs/*.css',
            dest: '.tmp/libs/',
            options: {
                process: function (content, srcpath) {
                    return content.replace(/web\//g, "/");
                },
            },
            flatten: true,
        },
        fontIcons: {
            expand: true,
            filter: 'isFile',
            src: 'app/Resources/lib/semantic/dist/themes/default/assets/fonts/*',
            dest: 'web/built/fonts/',
            flatten: true,
        },
        cssLibs: {
            expand: true,
            filter: 'isFile',
            src: [
                'app/Resources/lib/semantic/dist/semantic.css',
                'src/BbLeagueBundle/Resources/public/css/vendor/reset5.css'
            ],
            dest: '.tmp/libs/', //themes/default/assets/fonts/
            flatten: true,
            options: {
                process: function (content, srcpath) {
                    return content.replace(/themes\/default\/assets\//g, "/built/");
                },
            }
        },
    },
    googlefonts : {
        build: {
            options: {
                formats: {
                    eot: true,
                    ttf: true,
                    woff: true,
                    woff2: true,
                    svg: true
                },
                fontPath: 'web/built/fonts/',
                cssFile: '.tmp/libs/1.fonts.css',
                fonts: [
                    {
                        family: 'Lato',
                        styles: [
                            100,300,400,700,900,'100italic','300italic','400italic','700italic','900italic'
                        ]
                    },
                    {
                        family: 'Dosis',
                        styles: [
                            200,300,400,500,600,700,800
                        ]
                    }
                ]
            }
        }
    } //end googlefont
  });

  // Déclaration des différentes tâches
  grunt.registerTask('default', ['css', 'javascript']);
  grunt.registerTask('fonts', ['googlefonts', 'copy:fontIcons', 'copy:fonts']);
  grunt.registerTask('javascript', ['uglify:libs', 'uglify:dist']);
  grunt.registerTask('css', ['fonts', 'copy:cssLibs', 'less', 'cssmin']);
};
