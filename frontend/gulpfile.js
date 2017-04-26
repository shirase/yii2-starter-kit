var gulp = require('gulp'),
    postcss = require('gulp-postcss'),
    autoprefixer = require('autoprefixer'),
    csscomb = require('gulp-csscomb');

gulp.task('default', ['less-pre']);

gulp.task('less-pre', function() {
    var processors = [
        autoprefixer({browsers: 'last 2 versions, > 5%'})
    ];

    return gulp.src('web/css/*.less', {base: './'})
        .pipe(postcss(processors))
        .pipe(csscomb())
        .pipe(gulp.dest('./'));
});

gulp.task('watch', ['less-pre'], function() {
    gulp.watch('web/css/*.less', ['less-pre']);
});