var path = require('path');

module.exports = function (grunt) {
  grunt.initConfig({
    sass: {
      // this is the "dev" Sass config used with "grunt watch" command
      dev: {
        options: {
          style: 'nested',
          // tell Sass to look in the Bootstrap stylesheets directory when compiling
          loadPath: 'node_modules/bootstrap-sass/assets/stylesheets'
        },
        files: {
          // the first path is the output and the second is the input
          'css/style.css': 'scss/style.scss'
        }
      },
      // this is the "production" Sass config used with the "grunt buildcss" command
      dist: {
        options: {
          style: 'compressed',
          loadPath: 'node_modules/bootstrap-sass/assets/stylesheets'
        },
        files: {
          'css/style.css': 'scss/style.scss'
        }
      }
    },
    // configure the "grunt watch" task
    watch: {
      sass: {
        files: 'scss/*.scss',
        tasks: ['sass:dev']
      }
    }
  });
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.registerTask('buildcss', ['sass:dist']);
};
