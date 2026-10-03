const fs = require('fs');
const gulp = require('gulp');
const cssmin = require('gulp-cssmin');
const rename = require('gulp-rename');
const concat = require('gulp-concat');
const jsmin = require('gulp-jsmin');
const plumber = require('gulp-plumber');
const sass = require('gulp-sass')(require('sass'));
const cmq = require('gulp-merge-media-queries');
const autoprefixer = require('autoprefixer');
const cleanCss = require('gulp-clean-css');
const postcss = require('gulp-postcss');

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

// dev 込みの vendor（composer install）のまま dist すると、Composer の読み込み設定が
// 配布物に存在しないパッケージを参照してしまうため、dev でない vendor のときだけ進める。
const distCheck = (done) => {
  let raw;
  try {
    raw = fs.readFileSync('./vendor/composer/installed.json', 'utf8');
  } catch (e) {
    if (e.code === 'ENOENT') {
      return done();
    }
    return done(new Error('vendor/composer/installed.json を読み込めません: ' + e.message));
  }
  let installed;
  try {
    installed = JSON.parse(raw);
  } catch (e) {
    return done(new Error('vendor/composer/installed.json を JSON として読み込めません: ' + e.message));
  }
  if (!installed || typeof installed !== 'object' || Array.isArray(installed) || typeof installed.dev !== 'boolean') {
    return done(new Error('vendor/composer/installed.json の形式が想定外です（dev キーを判定できません）。'));
  }
  if (installed.dev === true) {
    return done(new Error('開発用パッケージが入った vendor では dist できません。npm run dist を使ってください。'));
  }
  done();
};

const distClean = (done) => {
  fs.rmSync('dist/biz-vektor', { recursive: true, force: true });
  done();
};

const distCopy = () => {
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
      "!./node_modules/**/*.*",
      // 配布物に不要な開発用ファイル
      "!./**/*.bat",
      "!./**/*.rb",
      "!./gulpfile.js",
      "!./_scss/**",
      "!./how-to-use-and-customize.md",
      "!./module_panList_old.php",
      "!./vendor/**/gulpfile.js",
      "!./vendor/**/config.php"
    ], { base: './' })
    .pipe(gulp.dest('dist/biz-vektor'));
};

exports.dist = gulp.series(distCheck, distClean, distCopy);
