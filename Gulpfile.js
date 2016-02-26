var gulp = require('gulp');
var jshint = require('gulp-jshint');

gulp.task('lint', function () {
	return gulp.src('./resources/assets/**/*.js')
		.pipe(jshint())
		.pipe(jshint.reporter('default'));
});
