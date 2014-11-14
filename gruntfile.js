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
				type: 'wp-theme'
				}
			}
		},
		/**
		 * CSSJanus
		 */
		cssjanus: {
			theme: {
				options: {
					swapLtrRtlInUrl: false
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
		 * Tenon
		 */
		tenon: {
		  options: {
		    key: 'e0703a2b0c2a030806c03fc88efe437e',
		    url: 'http://utility.dev',
		    filter: [31, 54],
		    level: 'AAA'
		  },
		  all: {
		    options: {
		      saveOutputIn: 'allHtml.json',
		      snippet: true,
		      asyncLim: 2
		    },
		    src: [
		      'http://utility.dev'
		    ]
		  },
		  index: {
		    src: [
		      'index.html'
		    ]
		  }
		},
		/**
		 * Watch
		 */
		watch: {
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
		'tenon',
		'cssjanus',
		'watch'
	]);
};
