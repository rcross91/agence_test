const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.sass('resources/sass/app.scss', 'public/css')
    .sourceMaps();

mix.scripts([
    'public/assets/node_modules/jquery/jquery-3.2.1.min.js',
    'public/assets/node_modules/popper/popper.min.js',
    'public/assets/node_modules/bootstrap/dist/js/bootstrap.min.js',
    'public/assets/node_modules/axios/dist/axios.min.js',
],'public/js/app.js');
