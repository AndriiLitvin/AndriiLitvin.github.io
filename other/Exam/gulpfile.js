var gulp = require('gulp');
var concat = require('gulp-concat');
var sass = require('gulp-sass');
var watch = require('gulp-watch');
var imagemin = require('gulp-imagemin');
var uglify = require('gulp-uglify');
var babel = require('gulp-babel');
var uglifycss = require('gulp-uglifycss');

gulp.task('scripts', function() {
  return gulp.src(['app/scripts/*.js', '!app/scripts/ignore'])
    .pipe(concat('script.main.js'))
    .pipe(babel({
      presets: ['es2015']
      }))
    .pipe(uglify())
    .pipe(gulp.dest('dist/scripts/')),
    gulp.src('app/scripts/ignore/*.js')
      .pipe(gulp.dest('dist/scripts/ignore/')),
    /*          IE       */
    gulp.src('app/scripts/IE/*.js')
      .pipe(gulp.dest('dist/scripts/IE'))
});

gulp.task('scss', function() {
  return gulp.src('app/styles/main.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(uglifycss({
      "maxLineLen": 80,
      "uglyComments": true
    }))
    .pipe(gulp.dest('dist/styles/')),
      /*          IE       */
   gulp.src('app/styles/IE/*.scss')
     .pipe(concat('stylesIE.scss'))
     .pipe(sass().on('error', sass.logError))
     .pipe(uglifycss({
       "maxLineLen": 80,
       "uglyComments": true
     }))
     .pipe(gulp.dest('dist/styles/IE/')),
     gulp.src('app/styles/IE/PIE/**')
       .pipe(gulp.dest('dist/styles/IE/PIE/'));
});

gulp.task('img', function() {
   return gulp.src('app/images/**')
      .pipe(imagemin())
      .pipe(gulp.dest('dist/images'));
});

gulp.task('fonts', function() {
   return gulp.src('app/fonts/*')
      .pipe(gulp.dest('dist/fonts/'));
});

gulp.task('watch', function() {
   gulp.watch('app/scripts/**/*.{js,jsx}', ['scripts']);
   gulp.watch('app/styles/**/*.scss', ['scss']);
});

gulp.task('default', ['scss', 'scripts', 'fonts']);
