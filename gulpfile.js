/*
const elixir = require('laravel-elixir');

elixir(mix => {
    mix.browserify('resources/assets/jsx/ranking.jsx', 'public/js/jsx', 'resources/assets');
});
*/

const gulp = require('gulp');
const browserify = require('browserify');
const babelify = require('babelify');
const source = require('vinyl-source-stream');
const buffer = require('vinyl-buffer');
const uglify = require('gulp-uglify');

gulp.task('browserify', function(done)  {
    browserify('./resources/assets/jsx/ranking.jsx', { debug : false })
        .transform(babelify).bundle()
        .on('error', console.log)
        .pipe(source("ranking.js"))
        .pipe(buffer())
        .pipe(uglify())
        .pipe(gulp.dest('./public/js/jsx'));

    browserify('./resources/assets/js/player-search.js', { debug : false })
        .transform(babelify).bundle()
        .on('error', console.log)
        .pipe(source("player-search.js"))
        .pipe(buffer())
        .pipe(uglify())
        .pipe(gulp.dest('./public/js'));
    done();
});

gulp.task('default', gulp.task('browserify'));
