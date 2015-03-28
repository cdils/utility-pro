/**
 * Grunt Module
 */
module.exports = function(grunt) {
	/**
	 * Load Grunt plugins
	 */
	require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);
	/**
	 * Configuration
	 */
	grunt.initConfig({
		/**
		 * Get package meta data
		 */
		pkg: grunt.file.readJSON('package.json'),
		/**
		* Bower Copy
		*/
		bowercopy: {
			options: {
				srcPrefix: 'bower_components',
				clean: true
			},
			scss: {
				options: {
					destPrefix: 'assets/scss/vendor'
				},
				files: {
					'bourbon': 'bourbon'
				}
			}
		},
		/**
		 * Sass
		 */
		sass: {
			dist: {
				options: {
					style: 'expanded',
					lineNumbers: false,
					debugInfo: false,
					compass: false
				},
				files: {
					'style.css' : 'assets/scss/style.scss'
				}
			}
		},
		/**
		 * Makepot
		 * https://github.com/blazersix/grunt-wp-i18n/
		 */
		makepot: {
			theme: {
				options: {
					domainPath: '/languages',
					type: 'wp-theme',
		            exclude: [
		                'dist/.*'
		            ]
				}
			}
		},
		/**
		 * Addtextdomain
		 * https://github.com/blazersix/grunt-wp-i18n/
		 */
		addtextdomain: {
			options: {
				textdomain: 'utility-pro'
			},
			update_all_domains: {
				options: {
					updateDomains: true
				}
			}
		},
		/**
		 * Po to Mo
		 * https://github.com/axisthemes/grunt-potomo
		 */
		potomo: {
			dist: {
				files: [
					{
						expand: true,
						cwd: 'languages',
						src: ['*.po'],
						dest: 'languages',
						ext: '.mo',
						nonull: true
					}
				]
			}
		},
		/**
		 * CSSJanus
		 */
		cssjanus: {
			theme: {
				options: {
					swapLtrRtlInUrl: true
				},
				files: [
					{
						src: 'style.css',
						dest: 'style-rtl.css'
					}
				]
			}
		},
		/**
		 * Watch
		 */
		watch: {
			sass: {
				files: [
					'assets/scss/*.scss',
					'assets/scss/**/*.scss',
					'assets/scss/**/**/*.scss'
				],
				tasks: [
					'sass'
				]
			},
			cssjanus: {
				files: [
					'style.css'
				],
				tasks: [
					'cssjanus'
				]
			}
		},
		// https://github.com/gruntjs/grunt-contrib-compress
		compress: {
			standard: {
				options: {
					archive: 'dist/<%= pkg.name %>-<%= pkg.version %>.zip'
				},
				files: [
					{
						expand: true,
						cwd: '',
						src: [ // Take this...
							'**',
							'!gruntfile.js',
							'!package.json',
							'!node_modules/**',
							'!.sass-cache/**',
							'!dist/**',
							'!*.sublime*',
							'!.DS_Store'
						],
						dest: '<%= pkg.name %>' // ...put it into this, then zip that up as ^^^
					}
				]
			},
			dev: {
				options: {
					archive: 'dist/<%= pkg.name %>-developer-<%= pkg.version %>.zip'
				},
				files: [
					{
						expand: true,
						src: [
							'**',
							'!node_modules/**',
							'!.sass-cache/**',
							'!dist/**',
							'!*.sublime*',
							'!.DS_Store'
						], // Take this...
						dest: '<%= pkg.name %>' // ...put it into this, then zip that up as ^^^
					}
				]
			}
		}
	});

	/**
	 * Default task
	 * Run `grunt` on the command line
	 */
	grunt.registerTask('default', [
		'bowercopy',
		'cssjanus',
		'sass',
		'watch'
	]);
};
