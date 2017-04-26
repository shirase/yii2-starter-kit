var gulp = require('gulp'),
    postcss = require('gulp-postcss'),
    autoprefixer = require('autoprefixer'),
    csscomb = require('gulp-csscomb'),
    less = require('gulp-less'),
    sourcemaps = require('gulp-sourcemaps'),
    plumber = require('gulp-plumber'),
    rename = require('gulp-rename');

var argv = require('yargs').argv;

gulp.task('less-pre', function() {
    gulp.src('frontend/web/css/*.less', {base: './'})
        .pipe(csscomb())
        .pipe(gulp.dest('./'));

    gulp.src('backend/web/css/*.less', {base: './'})
        .pipe(csscomb())
        .pipe(gulp.dest('./'));
});

gulp.task('less', function() {
    if (!argv.in) {
        console.log('In argument is required');
        return;
    }

    var processors = [
        autoprefixer({browsers: 'last 2 versions, > 5%'})
    ];

    return gulp.src(argv.in, {base: './'})
        .pipe(plumber())
        .pipe(sourcemaps.init())
        .pipe(less())
        .pipe(postcss(processors))
        .pipe(rename({
            extname: '.css'
        }))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./'));
});