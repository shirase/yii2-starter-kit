var gulp = require('gulp'),
    postcss = require('gulp-postcss'),
    autoprefixer = require('autoprefixer'),
    csscomb = require('gulp-csscomb');

gulp.task('default', ['watch']);

gulp.task('css', function() {
    var processors = [
        autoprefixer({browsers: 'last 2 versions, > 5%'})
    ];

    return gulp.src('web/css/*.less', {base: './'})
        .pipe(postcss(processors))
        .pipe(csscomb())
        .pipe(gulp.dest('./'));
});

gulp.task('watch', ['css'], function() {
    gulp.watch('web/css/*.less', ['css']);
});