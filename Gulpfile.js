'use strict';

var gulp    = require( 'gulp' ),
	pkg     = require( './package.json' ),
	toolkit = require( 'gulp-wp-toolkit' ),
	zip     = require( 'gulp-zip' );

require( 'gulp-stats' )( gulp );

toolkit.extendConfig( {
	theme: {
		name: 'Utility Pro',
		homepage: pkg.homepage,
		description: pkg.description,
		author: pkg.author,
		version: pkg.version,
		license: pkg.license,
		textdomain: pkg.name,
		// domainpath: pkg.theme.domainpath, // Defaults to /languages.
		tags: pkg.theme.tags,
		template: 'genesis'
	},
	src: {
		zipuser: [
			'images/*',
			'js/*',
			'languages/*',
			'src/**/*',
			'vendor-includes/**/*',
			'front-page.php',
			'functions.php',
			'LICENSE.md',
			'page_landing.php',
			'readme.txt',
			'screenshot.png',
			'style*'
		],
		zipdev: [
			'develop/images/*',
			'develop/js/*',
			'develop/languages/*',
			'develop/scss/**/*',
			'images/*',
			'js/*',
			'languages/*',
			'src/**/*',
			'tests/**/*',
			'vendor-includes/**/*',
			'.bowerrc',
			'.gitignore',
			'bower.json',
			'CHANGELOG.md',
			'code-of-conduct.md',
			'composer.json',
			'composer.lock',
			'front-page.php',
			'functions.php',
			'Gulpfile.js',
			'LICENSE.md',
			'package.json',
			'page_landing.php',
			'phpcs.xml.dist',
			'phpunit.xml.dist',
			'README.md',
			'readme.txt',
			'screenshot.png',
			'style*'
		]
	},
	css: {
		outputStyle: 'expanded'
	}
} );

toolkit.extendTasks( gulp, { /* gulp task overrides */
	'zip': [[ 'zipuser', 'zipdev' ]],
	'zipuser': function() {
		return gulp.src( toolkit.config.src.zipuser, { base: './' } )
			.pipe( zip( pkg.name + '-' + pkg.version + '.zip' ) )
			.pipe( gulp.dest( 'dist' ) );
	},
	'zipdev': function() {
		return gulp.src( toolkit.config.src.zipdev, { base: './' } )
			.pipe( zip( pkg.name + '-developer-' + pkg.version + '.zip' ) )
			.pipe( gulp.dest( 'dist' ) );
	}
} );
