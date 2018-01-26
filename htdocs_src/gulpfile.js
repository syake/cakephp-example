const gulp = require('gulp');
const browserSync = require('browser-sync').create();

// CSS
const sass = require('gulp-sass');
const sourcemaps = require('gulp-sourcemaps');
const cleanCSS = require('gulp-clean-css');

const src = 'src';
const php = '../cakephp/src';
const dst = '../htdocs';

gulp.task('sass', function () {
  gulp.src(src+'/sass/**/*.scss')
    .pipe(sourcemaps.init())
    .pipe(sass())
    .pipe(cleanCSS())
    .pipe(sourcemaps.write())
    .pipe(gulp.dest(dst+'/css'))
})
gulp.task('watch', function () {
  gulp.watch([src+'/sass/**/*.scss'], ['sass'])
})
gulp.task('serve', function() {
  browserSync.init({
    proxy: 'cakephp:8888/users'
  });
  gulp.watch(php+'/**/*.+(ctp|php)').on('change', browserSync.reload);
  gulp.watch(dst+'/**/*.+(css|js|jpg|png|gif)').on('change', browserSync.reload);
});

gulp.task('default',['sass','watch','serve']);
