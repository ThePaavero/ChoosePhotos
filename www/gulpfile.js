var gulp = require('gulp');

var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var sass = require('gulp-sass');
var cssmin = require('gulp-cssmin');

var paths = {
    scripts : ['assets/js/**/*.js'],
    scss : 'assets/scss/**/*.scss'
};

gulp.task('scripts', function () {
    return gulp.src(paths.scripts)
        .pipe(uglify())
        .pipe(concat('all.min.js'))
        .pipe(gulp.dest('public/assets/js'));
});

gulp.task('styles', function () {
    return gulp.src('assets/scss/main.scss')
        .pipe(sass())
        .pipe(cssmin())
        .pipe(concat('all.min.css'))
        .pipe(gulp.dest('public/assets/css'));
});

gulp.task('watch', function () {
    gulp.watch(paths.scripts, ['scripts']);
    gulp.watch(paths.scss, ['styles']);
});

gulp.task('default', ['scripts', 'styles', 'watch']);
