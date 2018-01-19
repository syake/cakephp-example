var gulp = require('gulp');
var browserSync = require('browser-sync').create();

// CSS
const sass = require('gulp-sass');
const sourcemaps = require('gulp-sourcemaps');
const cleanCSS = require('gulp-clean-css');

var src = 'src';
var dst = '../htdocs';

gulp.task('sass', function () {
  gulp.src(src+'/sass/**/*.scss')
    .pipe(sourcemaps.init())
    .pipe(sass())
    .pipe(cleanCSS())
    .pipe(sourcemaps.write())
    .pipe(gulp.dest(dst+'/css'))
})
gulp.task('serve', function() {
  browserSync.init({
    proxy: 'cakephp:8888'
  });
});

gulp.task('default',['sass','serve']);
