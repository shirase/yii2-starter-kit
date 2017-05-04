var gulp = require('gulp'),
    postcss = require('gulp-postcss'),
    autoprefixer = require('autoprefixer'),
    csscomb = require('gulp-csscomb'),
    less = require('gulp-less'),
    sourcemaps = require('gulp-sourcemaps'),
    plumber = require('gulp-plumber'),
    rename = require('gulp-rename');

var argv = require('yargs').argv;

gulp.task('default', ['watch']);

gulp.task('less-pre', function() {
    gulp.src('frontend/web/css/*.less', {base: './'})
        .pipe(csscomb())
        .pipe(gulp.dest('./'));

    gulp.src('backend/web/css/*.less', {base: './'})
        .pipe(csscomb())
        .pipe(gulp.dest('./'));
});

function lessCompile(src) {
    var processors = [
        autoprefixer({browsers: 'last 2 versions, > 5%'})
    ];

    return gulp.src(src, {base: './'})
        .pipe(plumber({
            errorHandler: function (err) {
                console.log(err);
                this.emit('end');
            }
        }))
        .pipe(sourcemaps.init())
        .pipe(less())
        .pipe(postcss(processors))
        .pipe(rename({
            extname: '.css'
        }))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./'));
}

gulp.task('less', function() {
    if (!argv.in) {
        console.log('In argument is required');
        return;
    }

    return lessCompile(argv.in);
});

gulp.task('less-frontend', function() {
    return lessCompile(['frontend/web/css/*.less', '!frontend/web/css/_*.less']);
});

gulp.task('less-backend', function() {
    return lessCompile(['backend/web/css/*.less', '!backend/web/css/_*.less']);
});

gulp.task('watch', ['less-frontend', 'less-backend'], function() {
    gulp.watch('frontend/web/css/*.less', ['less-frontend']);
    gulp.watch('backend/web/css/*.less', ['less-backend']);
});