'use strict';

module.exports = function(grunt) {
  grunt.initConfig({

    // Get the package vars
    pkg: grunt.file.readJSON( 'package.json' ),

    makepot: {
      target: {
          options: {
              cwd: '',                          // Directory of files to internationalize.
              domainPath: '/languages',                   // Where to save the POT file.
              exclude: ['node_modules/.*'],
              mainFile: 'parlamentar.php',        // Main project file.
              //potComments: '',                  // The copyright at the beginning of the POT file.
              potFilename: 'parlamentar.pot',                  // Name of the POT file.
              potHeaders: {
                  poedit: true,                 // Includes common Poedit headers.
                  'x-poedit-keywordslist': true // Include a list of all possible gettext functions.
              },                                // Headers to add to the generated POT file.
              type: 'wp-plugin',                // Type of project (wp-plugin or wp-theme).
              updateTimestamp: true,             // Whether the POT-Creation-Date should be updated without other changes.
              updatePoFiles: false              // Whether to update PO files in the same directory as the POT file.
          }
      }
    },

    po2mo: {
      files: {
        src: 'languages/*.po',
        expand: true,
      },
    },
  });

  // Load npm tasks
  grunt.loadNpmTasks('grunt-wp-i18n');
  grunt.loadNpmTasks('grunt-po2mo');

  // Register tasks

}