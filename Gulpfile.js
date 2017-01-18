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
		template: 'genesis',
    },
	src: {
		zipuser: [
			'images/*',
			'includes/**/*',
			'includes-vendors/**/*',
			'js/*',
			'languages/*',
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
			'includes/**/*',
			'includes-vendors/**/*',
			'js/*',
			'languages/*',
			'.bowerrc',
			'bower.json',
			'CHANGELOG.md',
			'composer.json',
			'composer.lock',
			'front-page.php',
			'functions.php',
			'Gulpfile.js',
			'LICENSE.md',
			'package.json',
			'page_landing.php',
			'readme.txt',
			'README.md',
			'screenshot.png',
			'style*'
		]
	},
	css: {
		outputStyle: 'expanded'
	}
} );

toolkit.extendTasks( gulp, { /* gulp task overrides */
	'pre-commit': '',
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
