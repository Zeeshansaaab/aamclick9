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
mix.js('resources/js/app.js', 'public/js')


mix.scripts([
    'resources/theme/js/bundle.js',
    'resources/theme/js/scripts.js',
    'resources/theme/js/sweetalert.js'
    // 'resources/theme/js/chart-crypto.js',
], 'public/js/theme.js');
    
mix.styles([
    'resources/theme/css/dashlite.css',
    'resources/css/app.css',
], 'public/css/app.css')

if (mix.inProduction()) {
    mix.version();
}
