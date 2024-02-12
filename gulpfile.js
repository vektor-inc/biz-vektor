const gulp = require('gulp');
const cssmin = require('gulp-cssmin');
const rename = require('gulp-rename');
const concat = require('gulp-concat');
const jsmin = require('gulp-jsmin');
const plumber = require('gulp-plumber');
const sass = require('gulp-sass')(require('sass'));
const cmq = require('gulp-merge-media-queries');
const autoprefixer = require('gulp-autoprefixer');
const cleanCss = require('gulp-clean-css');

const sassTask = () => {
	return gulp.src('./_scss/**/*.scss')
    .pipe(plumber({
      errorHandler: function(err) {
        console.log(err);
        this.emit('end');
      }
    }))
    .pipe(sass().on('error', sass.logError))
    .pipe(postcss([ autoprefixer() ]))
    // .pipe(cmq({ log: true })) // 必要に応じて
    // .pipe(cleanCss()) // 必要に応じて
    .pipe(gulp.dest('./css'));
};

const cssConcatMin = () => {
  return gulp.src(['css/bizvektor_common.css', 'js/res-vektor/res-vektor.css', 'js/FlexSlider/flexslider.css'])
    .pipe(concat('bizvektor_common.css'))
    .pipe(cssmin())
    .pipe(rename({ suffix: '_min' }))
    .pipe(gulp.dest('./css/'));
};

const scripts = () => {
  return gulp.src(['js/FlexSlider/jquery.flexslider.js', 'js/master.js', 'js/res-vektor/res-vektor.js', 'js/jquery.cookie.js', 'js/jquery.flatheights.js'])
    .pipe(concat('biz-vektor.js'))
    .pipe(gulp.dest('./js/'));
};

const jsMin = () => {
  return gulp.src('./js/biz-vektor.js')
    .pipe(plumber())
    .pipe(jsmin())
    .pipe(rename({ suffix: '-min' }))
    .pipe(gulp.dest('./js'));
};

const watch = () => {
  gulp.watch('_scss/**/*.scss', sassTask);
  gulp.watch('css/*.css', cssConcatMin);
  gulp.watch('js/**/*.js', gulp.series(scripts, jsMin));
};

exports.default = gulp.series(scripts, jsMin, cssConcatMin, gulp.parallel(watch));
exports.compile = gulp.series(scripts, jsMin, cssConcatMin);

const dist = () => {
  return gulp.src([
      './**/*.js',
      './**/*.jpeg',
      './**/*.jpg',
      './**/*.png',
      './**/*.gif',
      './**/*.php',
      './**/*.txt',
      './**/*.css',
      './**/*.scss',
      './**/*.bat',
      './**/*.rb',
      './**/*.eot',
      './**/*.svg',
      './**/*.ttf',
      './**/*.woff',
      './**/*.md',
      './**/*.woff2',
      './**/*.otf',
      './**/*.less',
      './languages/**',
      './libraries/**',
      "!./tests/**",
      "!./dist/**",
      "!./node_modules/**/*.*"
    ], { base: './' })
    .pipe(gulp.dest('dist/biz-vektor'));
};

exports.dist = dist;