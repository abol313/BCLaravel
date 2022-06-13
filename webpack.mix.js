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

// mix.options(
//     {
//         autoprefixer:false
//     }
// )
mix.js('resources/js/app.js', 'public/js')
    .styles('resources/css/*','public/css/app.css')
    .postCss('resources/css/main.css','public/css',[
    //   require('autoprefixer'),
    //   require('postcss-sorting'),
    //   require('postcss-custom-properties')
    ])
    .copy('resources/images/*','public/images')

mix.version()


mix.browserSync('localhost:8000');