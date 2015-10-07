module.exports = function(grunt) { 
  // Importation des différents modules grunt
  require('load-grunt-tasks')(grunt);

  // Configuration des plugins
  grunt.initConfig({
    uglify: {
      options: {
        mangle: false,
        sourceMap: true,
        sourceMapName: 'web/built/app.map'
      },
      dist: {
        files: {
          'web/built/app.min.js': [
            'app/Resources/lib/jquery/jquery.js',
            'app/Resources/lib/nanobar/nanobar.js',
            'app/Resources/lib/bootstrap-sass-official/asset/javascripts/bootstrap.js',
            '.tmp/js/**/*.js'
          ]
        }
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
                    "bower_components/bootsrap/dist/css/bootstrap.css",
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
    } //end watch
  });

  // Déclaration des différentes tâches
  grunt.registerTask('default', ['css', 'javascript']);
  grunt.registerTask('javascript', ['uglify']);
  grunt.registerTask('css', ['less','cssmin']);
};