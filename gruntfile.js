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
		                'includes/.*'
		            ]
				}
			}
		},
		/**
		 * colorguard
		 */
		colorguard: {
		    options: {},
		    files: {
		    	src: ['style.css'],
		    },
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
		 * Exec
		 */
		exec: {
		      get_grunt_sitemap: {
		        command: 'curl --silent --output sitemap.json http://utility.dev/?show_sitemap'
		      }
		},
		/**
		 * Uncss
		 */
		uncss: {
		      dist: {
		        options: {
		          ignore       : [class$='utility-pro-'],
		          stylesheets  : ['style.css'],
		          ignoreSheets : [/fonts.googleapis/],
		          urls         : [], //Overwritten in load_sitemap_and_uncss task
		        },
		        files: {
		          'style.clean.css': ['**/*.php']
		        }
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
		'watch',
	]);

	grunt.registerTask('load_sitemap_json',
		function() {
			var sitemap_urls = grunt.file.readJSON('./sitemap.json');
			grunt.config.set('uncss.dist.options.urls', sitemap_urls);
		}
	);

	grunt.registerTask('deploy', [
		'exec:get_grunt_sitemap',
		'load_sitemap_json','uncss:dist'
	]);
};
