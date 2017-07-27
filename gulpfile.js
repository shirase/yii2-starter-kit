var gulp = require('gulp'),
    postcss = require('gulp-postcss'),
    base64 = require('gulp-base64'),
    autoprefixer = require('autoprefixer'),
    csscomb = require('gulp-csscomb'),
    cssnano = require('gulp-cssnano'),
    mergeRules = require('postcss-merge-rules'),
    less = require('gulp-less'),
    sourcemaps = require('gulp-sourcemaps'),
    plumber = require('gulp-plumber'),
    rename = require('gulp-rename'),
    rollup = require('gulp-rollup'),
    rollupBabel = require('rollup-plugin-babel'),
    resolve = require('rollup-plugin-node-resolve'),
    commonjs = require('rollup-plugin-commonjs'),
    uglify = require('gulp-uglify');

var path = require('path');

var argv = require('yargs').argv;

gulp.task('default', ['watch']);

gulp.task('build', ['less-frontend', 'less-backend']);

gulp.task('less-pre', function() {
    gulp.src('frontend/web/css/*.less', {base: './'})
        .pipe(csscomb())
        .pipe(gulp.dest('./'));

    gulp.src('backend/web/css/*.less', {base: './'})
        .pipe(csscomb())
        .pipe(gulp.dest('./'));
});

function lessCompile(src) {
    if (typeof src == 'string') {
        src = path.relative(process.cwd(), src);
    }

    var processors = [
        autoprefixer({browsers: 'last 2 versions, > 5%'}),
        mergeRules()
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
        .pipe(base64({
            extensions: ['svg', 'png'],
            maxImageSize: 8*1024
        }))
        .pipe(postcss(processors))
        .pipe(cssnano({zindex: false}))
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

function cssCompile(src, dest) {
    if (typeof src == 'string') {
        src = path.relative(process.cwd(), src);
    }

    if (typeof dest == 'string') {
        dest = path.relative(process.cwd(), dest);
    }

    var processors = [
        autoprefixer({browsers: 'last 2 versions, > 5%'}),
        mergeRules()
    ];

    return gulp.src(src, {base: './'})
        .pipe(plumber({
            errorHandler: function (err) {
                console.log(err);
                this.emit('end');
            }
        }))
        .pipe(base64({
            extensions: ['svg', 'png'],
            maxImageSize: 8*1024
        }))
        .pipe(postcss(processors))
        .pipe(cssnano({zindex: false}))
        .pipe(rename(dest))
        .pipe(gulp.dest('./'));
}

gulp.task('css', function() {
    if (!argv.in) {
        console.log('In argument is required');
        return;
    }

    if (!argv.out) {
        console.log('Out argument is required');
        return;
    }

    return cssCompile(argv.in, argv.out);
});

gulp.task('less-frontend', function() {
    return lessCompile(['frontend/web/css/*.less', '!frontend/web/css/_*.less']);
});

gulp.task('less-backend', function() {
    return lessCompile(['backend/web/css/*.less', '!backend/web/css/_*.less']);
});

gulp.task('js-frontend', function() {
    return gulp.src('frontend/js/**/*.js')
        .pipe(plumber({
            errorHandler: function (err) {
                console.log(err);
                this.emit('end');
            }
        }))
        .pipe(rollup({
            entry: 'frontend/js/app.js',
            allowRealFiles: true,
            format: 'iife',
            plugins: [
                resolve({
                    jsnext: true,
                    browser: true,
                    customResolveOptions: {
                        moduleDirectory: ['node_modules', 'vendor/npm-asset', 'vendor/bower-asset']
                    }
                }),
                commonjs(),
                rollupBabel({
                    babelrc: false,
                    presets: [
                        ['babel-preset-es2015-rollup']
                    ],
                    exclude: ['node_modules', 'vendor/npm-asset', 'vendor/bower-asset']
                })
            ]
        }))
        .pipe(rename('bundle.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('frontend/web/js'));
});

gulp.task('watch', ['less-frontend', 'less-backend', 'js-frontend'], function() {
    gulp.watch('frontend/web/css/*.less', ['less-frontend']);
    gulp.watch('backend/web/css/*.less', ['less-backend']);
    gulp.watch('frontend/js/**/*.js', ['js-frontend']);
});