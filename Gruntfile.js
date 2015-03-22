module.exports = function(grunt) {

// Load multiple grunt tasks using globbing patterns
require('load-grunt-tasks')(grunt);

// Project configuration.
grunt.initConfig({
  pkg: grunt.file.readJSON('package.json'),

    makepot: {
      target: {
        options: {
          domainPath: 'wordpress-plugin-boilerplate/languages/',    // Where to save the POT file.
          exclude: ['build/.*'],
          mainFile: 'wordpress-plugin-boilerplate/wordpress-plugin-boilerplate.php',    // Main project file.
          potComments: 'WordPress Plugin Boilerplate Copyright (c) {{year}}',      // The copyright at the beginning of the POT file.
          potFilename: 'wordpress-plugin-boilerplate.pot',    // Name of the POT file.
          type: 'wp-plugin',    // Type of project.
          updateTimestamp: true,    // Whether the POT-Creation-Date should be updated without other changes.
          processPot: function( pot, options ) {
            pot.headers['report-msgid-bugs-to'] = 'https://github.com/BoilWP/WordPress-Plugin-Boilerplate/issues\n';
            pot.headers['plural-forms'] = 'nplurals=2; plural=n != 1;\n';
            pot.headers['last-translator'] = 'WordPress Plugin Boilerplate <mailme@sebastiendumont.com>\n';
            pot.headers['language-team'] = 'WP-Translations <wpt@wp-translations.org>\n';
            pot.headers['x-poedit-basepath'] = '..\n';
            pot.headers['x-poedit-language'] = 'English\n';
            pot.headers['x-poedit-country'] = 'UNITED STATES\n';
            pot.headers['x-poedit-sourcecharset'] = 'utf-8\n';
            pot.headers['x-poedit-searchpath-0'] = '.\n';
            pot.headers['x-poedit-keywordslist'] = '__;_e;__ngettext:1,2;_n:1,2;__ngettext_noop:1,2;_n_noop:1,2;_c;_nc:4c,1,2;_x:1,2c;_ex:1,2c;_nx:4c,1,2;_nx_noop:4c,1,2;\n';
            pot.headers['x-textdomain-support'] = 'yes\n';
            return pot;
          }
        }
      }
    },

    exec: {
      npmUpdate: {
        command: 'npm update'
      },
      txpull: { // Pull Transifex translation - grunt exec:txpull
        cmd: 'tx pull -a --minimum-perc=60' // Change the percentage with --minimum-perc=yourvalue
      },
      txpush_s: { // Push pot to Transifex - grunt exec:txpush_s
        cmd: 'tx push -s'
      },
    },

         dirs: {
    lang: 'wordpress-plugin-boilerplate/languages',
    },

    potomo: {
      dist: {
        options: {
         poDel: false // Set to true if you want to erase the .po
        },
        files: [{
         expand: true,
         cwd: '<%= dirs.lang %>',
          src: ['*.po'],
          dest: '<%= dirs.lang %>',
         ext: '.mo',
          nonull: true
      }]
    }
  },

    // Clean up build directory
    clean: {
      main: ['build/<%= pkg.name %>']
    },

    // Copy the theme into the build directory
    copy: {
      main: {
        src:  [
          '**',
          '!node_modules/**',
          '!build/**',
          '!.git/**',
          '!Gruntfile.js',
          '!package.json',
          '!.gitignore',
          '!.gitmodules',
          '!.gitattributes',
          '!.editorconfig',
          '!.tx/**',
          '!**/Gruntfile.js',
          '!**/package.json',
          '!**/README.md',
          '!**/CHANGELOG.md',
          '!**/CONTRIBUTING.md',
          '!**/travis.yml',
          '!**/composer.json',
          '!**/*~'
        ],
        dest: 'build/<%= pkg.name %>/'
      }
    },

    //Compress build directory into <name>.zip and <name>-<version>.zip
    compress: {
      main: {
        options: {
          mode: 'zip',
          archive: './build/<%= pkg.name %>.zip'
        },
        expand: true,
        cwd: 'build/<%= pkg.name %>/',
        src: ['**/*'],
        dest: '<%= pkg.name %>/'
      }
    },

});

// Default task. - grunt makepot
grunt.registerTask( 'default', 'makepot' );

// Makepot and push it on Transifex task(s).
grunt.registerTask( 'makandpush', [ 'makepot', 'exec:txpush_s' ] );

// Pull from Transifex and create .mo task(s).
grunt.registerTask( 'tx', [ 'exec:txpull', 'potomo' ] );

// Build task(s).
grunt.registerTask( 'build', [ 'clean', 'copy', 'compress' ] );

};
