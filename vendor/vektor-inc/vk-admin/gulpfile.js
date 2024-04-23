const gulp = require('gulp');
const plumber = require('gulp-plumber');
const sass = require('gulp-sass')(require('sass'));
const cmq = require('gulp-merge-media-queries');
const autoprefixer = require('gulp-autoprefixer');
const cleanCss = require('gulp-clean-css');

gulp.task('sass', function(done) {
    gulp.src('src/assets/_scss/*.scss')
        .pipe(plumber())
        .pipe(sass())
        .pipe(cmq({
            log: true
        }))
        .pipe(autoprefixer())
        .pipe(cleanCss())
        .pipe(gulp.dest('./src/assets/css/'));
    done();
  });
