var gulp = require('gulp'),
    postcss = require('gulp-postcss'),
    base64 = require('gulp-base64'),
    autoprefixer = require('autoprefixer'),
    csscomb = require('gulp-csscomb'),
    cssnano = require('gulp-cssnano'),
    mergeRules = require('postcss-merge-rules'),
    sass = require('gulp-sass'),
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

gulp.task('build', ['sass-frontend', 'sass-backend']);

gulp.task('sass-pre', function() {
    gulp.src('frontend/web/css/*.sass', {base: './'})
        .pipe(csscomb())
        .pipe(gulp.dest('./'));

    gulp.src('backend/web/css/*.sass', {base: './'})
        .pipe(csscomb())
        .pipe(gulp.dest('./'));
});

function sassCompile(src, base) {
    if (typeof src == 'string') {
        src = path.relative(process.cwd(), src);

        if (!base && src.indexOf('*')==-1) {
            base = path.dirname(src);
        }
    }

    if (!base) {
        base = '.';
    }

    var processors = [
        autoprefixer({browsers: 'last 2 versions, > 5%'}),
        mergeRules()
    ];

    return gulp.src(src, {base: base})
        .pipe(plumber({
            errorHandler: function (err) {
                console.log(err);
                this.emit('end');
            }
        }))
        .pipe(sourcemaps.init())
        .pipe(sass())
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
        .pipe(gulp.dest(base));
}

gulp.task('sass', function() {
    if (!argv.in) {
        console.log('In argument is required');
        return;
    }

    return sassCompile(argv.in);
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

gulp.task('sass-frontend', function() {
    return sassCompile(['frontend/web/css/*.sass', '!**/_*.sass'], 'frontend/web/css');
});

gulp.task('sass-backend', function() {
    return sassCompile(['backend/web/css/*.sass', '!**/_*.sass'], 'backend/web/css');
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
            external: [
                'jquery'
            ],
            globals: {
                'jquery': 'jQuery'
            },
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

gulp.task('watch', ['sass-frontend', 'sass-backend', 'js-frontend'], function() {
    gulp.watch('frontend/web/css/*.sass', ['sass-frontend']);
    gulp.watch('backend/web/css/*.sass', ['sass-backend']);
    gulp.watch('frontend/js/**/*.js', ['js-frontend']);
});