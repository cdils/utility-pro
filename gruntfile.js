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
		addtextdomain: {
			options: {
				textdomain: 'utility-pro'
			},
			add_domain: {
				src: ['tmp/text-domains/add-domain.php']
			},
			update_domains: {
				options: {
				updateDomains: ['oldtextdomain', 'vendortextdomain']
			},
				src: ['tmp/text-domains/update-domains.php']
			},
			update_all_domains: {
				options: {
					updateDomains: true
				},
				src: ['tmp/text-domains/update-all-domains.php']
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
			files: ['style.css'],
			tasks: [
				'cssjanus'
			]
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
		'cssjanus',
		'watch',
	]);
};
