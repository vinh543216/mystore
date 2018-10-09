let mix = require('laravel-mix');

mix.sass('scss/style.scss', 'css/')
  .copyDirectory('bootstrap/assets/javascripts/bootstrap', 'js/')
  .copyDirectory('resources/js/', 'js/')
  .sourceMaps();
mix.options({
  processCssUrls: false
});

