// Gulp Libraries
let gulp = require( 'gulp' );
let notify = require( 'gulp-notify' );
let prefixer = require( 'gulp-autoprefixer' );
let scss = require( 'gulp-sass' );
let concat = require( 'gulp-concat' );
let uglify = require( 'gulp-uglify' );
let plumber = require( 'gulp-plumber' );
let browsersync = require( 'browser-sync' ).create();


// Gulp Variables
let PROJECT_URL = 'http://dev.dorzki/';
let PROJECT_PORT = 8888;
let LISTEN_FILES = [ '**/*.php' ];

let SRC_SCSS = '__src/scss/**/*.scss';
let SRC_JS = [ '__src/js/vendor/*.js', '__src/js/*.js' ];

let DEST_CSS = 'assets/css';
let DEST_JS = 'assets/js';


// Gulp Tasks

/**
 * Compile SCSS files into one css file.
 */
gulp.task( 'build-scss', function () {

	return gulp
		.src( SRC_SCSS )
		.pipe( plumber() )
		.pipe( prefixer() )
		.pipe( scss( {
			outputStyle : 'compressed'
		} ) )
		.pipe( concat( 'styles.min.css' ) )
		.pipe( gulp.dest( DEST_CSS ) )
		.pipe( browsersync.stream() )
		.pipe( notify( '### Finished Building SCSS ###' ) );

} );

/**
 * Concat & compress JavaScript files into one js file.
 */
gulp.task( 'build-js', function () {

	return gulp
		.src( SRC_JS )
		.pipe( plumber() )
		.pipe( uglify() )
		.pipe( concat( 'scripts.min.js' ) )
		.pipe( gulp.dest( DEST_JS ) )
		.pipe( browsersync.stream() )
		.pipe( notify( '### Finished Building JS ###' ) );

} );

/**
 * Listen to file changes and reload the page.
 */
gulp.task( 'browser-sync', function () {

	browsersync.init( {
		proxy : PROJECT_URL,
		port : PROJECT_PORT,
		injectChanges : true
	} );

	gulp.watch( LISTEN_FILES ).on( 'change', browsersync.reload );
	gulp.watch( SRC_SCSS, [ 'build-scss' ] );
	gulp.watch( SRC_JS, [ 'build-js' ] );

} );