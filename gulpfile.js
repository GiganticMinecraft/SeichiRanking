const elixir = require('laravel-elixir');

elixir(mix => {
    mix.browserify('resources/assets/jsx/ranking.jsx', 'public/js/jsx', 'resources/assets');
});
