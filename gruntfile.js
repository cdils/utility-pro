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
		* https://www.npmjs.com/package/grunt-bowercopy
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
					'bourbon': 'bourbon/app/assets/stylesheets',
					'neat': 'neat/app/assets/stylesheets'
				}
			}
		},

		/**
		 * Sass
		 * https://github.com/gruntjs/grunt-contrib-sass/
		 */
		sass: {
			dist: {
				options: {
					style: 'expanded',
					lineNumbers: false,
					debugInfo: false,
					compass: false,
					'sourcemap=none': true
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
		 *  Grunt Clean (run with care)
		 *  https://github.com/gruntjs/grunt-contrib-clean
		 */
		 clean: {
		   style: {
		     src: [
		     	"style-rtl.css",
		      	"style.css"
		      ]
		   },
		   bower: {
		     src: [
		     	"bower_components/",
		     	"assets/scss/vendor"
		      ]
		   },
		   i18n: {
		     src: [
		     	"languages/utility-pro.pot",
		     	"languages/*.mo"
		      ]
		   },
		   distribution: {
		     src: [
		     	"dist/"
		      ]
		   }
		 },

		/**
		 * CSSJanus
		 * https://github.com/cssjanus/grunt-cssjanus
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
		 * https://github.com/gruntjs/grunt-contrib-watch
		 */
		watch: {
			sass: {
				files: [
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

		/**
		 * Compile Sass to CSS
		 * https://github.com/gruntjs/grunt-contrib-sass
		 */
		compress: {
			standard: {
				options: {
					archive: 'dist/<%= pkg.name %>-<%= pkg.version %>.zip'
				},
				files: [
					{
						expand: true,
						cwd: '',
						src: [
							'**',
							'!bower.json',
							'!package.json',
							'!gruntfile.js',
							'!CHANGELOG.md',
							'!README.md',
							'!node_modules/**',
							'!.sass-cache/**',
							'!dist/**',
							'!assets/**',
							'!*.sublime*',
							'!.DS_Store'
						], // Take this...
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
							'!assets/scss/vendor/**',
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
