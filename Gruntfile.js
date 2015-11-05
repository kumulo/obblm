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
            'app/Resources/lib/amcharts/dist/amcharts/lang/en.js'
          ]
        },
        sourceMapName: 'web/built/libs.map'
      },
      dist: {
        files: {
          'web/built/app.min.js': [
             "src/BbLigueBundle/Resources/public/js/front.js"
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
                    "src/BbLigueBundle/Resources/public/css/vendor/reset5.css",
                    "src/BbLigueBundle/Resources/less/**/*.less"
                ]
            }
        }
    }, //end less
    cssmin: {
      combine: {
        options:{
          report: 'gzip',
          keepSpecialComments: 0
        },
        files: {
          'web/built/app.min.css': [
            '.tmp/css/**/*.css'
          ]
        }
      }
    }, //end cssmin
    watch: {
      css: {
        files: ['src/BbLigueBundle/Resources/less/**/*.less'],
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
            src: '.tmp/fonts/*.css',
            dest: '.tmp/css/',
            options: {
                process: function (content, srcpath) {
                    return content.replace(/web\//g, "/");
                },
            },
            flatten: true,
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
                cssFile: '.tmp/fonts/1.fonts.css',
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
  grunt.registerTask('fonts', ['googlefonts', 'copy:fonts']);
  grunt.registerTask('javascript', ['uglify:libs', 'uglify:dist']);
  grunt.registerTask('css', ['fonts', 'less','cssmin']);
};
