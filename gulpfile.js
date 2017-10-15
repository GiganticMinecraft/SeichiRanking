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

gulp.task('browserify', () => {
    browserify('./resources/assets/jsx/ranking.jsx', { debug : false })
        .transform(babelify).bundle()
        .on('error', console.log)
        .pipe(source("ranking.js"))
        .pipe(gulp.dest('./public/js/jsx'));

    browserify('./resources/assets/js/player-search.js', { debug : false })
        .transform(babelify).bundle()
        .on('error', console.log)
        .pipe(source("player-search.js"))
        .pipe(gulp.dest('./public/js'));
});

gulp.task("default", ['browserify']);
