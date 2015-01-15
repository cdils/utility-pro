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
		 * makepot
		 */
		makepot: {
			theme: {
				options: {
					domainPath: '/languages',
					type: 'wp-theme',
		            exclude: [
		                'includes/vendors/.*'
		            ]
				}
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
