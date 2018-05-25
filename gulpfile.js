var gulp = require('gulp');
var sass = require('gulp-sass');

gulp.task('sass', function(){
	return gulp.src('application/sass/*.scss')
		.pipe(sass())
		.pipe(gulp.dest('public/css'))
	});

gulp.task('watch', ['sass'], function(){
	gulp.watch('application/sass/*.scss', ['sass'])
	})