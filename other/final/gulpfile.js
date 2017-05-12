'use strict';

var gulp = require('gulp');
var sass = require('gulp-sass');
var imagemin = require('gulp-imagemin');
var concat = require('gulp-concat');
var cleanCSS = require('gulp-clean-css');
var uglify = require('gulp-uglify');
var spritesmith = require('gulp.spritesmith');

gulp.task('sass', function () {
    return gulp.src('src/css/main*.scss')
        .pipe(sass())
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(gulp.dest('dist/css'))
});


gulp.task('img', function () {
    return gulp.src('src/img/*')
        .pipe(imagemin())
        .pipe(gulp.dest('dist/img'));
});

gulp.task('concat', function () {
    return gulp.src([
        'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js',
        'src/js/masonry.pkgd.js',
        'src/js/slider.js',
        'src/js/masonry.js',
        'src/js/loader.js',
    ])
        .pipe(concat('main.js'))
        .pipe(uglify())
        .pipe(gulp.dest('dist/js'));
});

gulp.task('sprite', function generateSpritesheets() {
    var spriteData = gulp.src('src/img/partner-icons/*.png')
        .pipe(spritesmith({
            retinaSrcFilter: 'src/img/partner-icons/*retina.png',
            imgName: 'spritesheet.png',
            retinaImgName: 'spritesheet-2x.png',
            cssName: 'sprites.scss'
        }));
    spriteData.img.pipe(gulp.dest('src/img'));
    spriteData.css.pipe(gulp.dest('src/css'));
});


gulp.task('watch', function () {
    gulp.watch("src/css/**/*.scss", ['sass']);
    gulp.watch("src/img/**/*", ['img']);
    gulp.watch("src/js/*", ['js']);
});

gulp.task("default", ['img', 'sass', 'concat', 'sprite', 'watch']);
