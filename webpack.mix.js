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

mix
.js('resources/js/httpWeb', 'public/js')
.js('resources/js/register', 'public/js')
.js('resources/js/swal', 'public/js')
.js('resources/js/tinyMCE', 'public/js')
.postCss('resources/css/app.css', 'public/css', [
        require("tailwindcss"),
    ]);


    if(mix.inProduction())
    {
        mix.version();
    }