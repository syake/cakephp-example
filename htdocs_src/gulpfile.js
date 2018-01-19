var gulp = require('gulp');
var browserSync = require('browser-sync').create();

gulp.task('serve', function() {
  browserSync.init({
    proxy: 'cakephp:8888'
  });
});

gulp.task('default',['serve']);
