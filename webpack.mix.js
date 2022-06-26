const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css');

mix.copy('resources/images/todo_icon.png','public/images')
mix.copy('resources/fonts/digi_sarve_naz/*','public/fonts/digi_sarve_naz')

mix.styles([
    'resources/css/app.css',
    'resources/css/main.css',
    'resources/css/todo_item.css',
    'resources/css/todo_make.css'
],'public/css/todo_app.css')
mix.styles('resources/css/lang_fa.css','public/css/lang_fa.css')

mix.version()