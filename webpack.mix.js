let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');
mix.styles(['resources/assets/css/ie10-viewport-bug-workaround.css','resources/assets/css/dashboard.css','resources/assets/css/other.css','public/css/app.css'],'public/css/app.css');
mix.styles(['public/js/app.js','resources/assets/js/holder.min.js','resources/assets/js/raw-files.min.js','resources/assets/js/ie10-viewport-bug-workaround.js','resources/assets/js/ie-emulation-modes-warning.js'],'public/js/app.js');