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

 setPublicPath('/var/www/etl-cdiac')
 */

webpackConfig()

mix.options({
    url : 'http://cdiac.manizales.unal.edu.co/etl-cdiac/'
});


mix.js('resources/js/app.js', 'public/js');

mix.setPublicPath('/var/www/etl-cdiac');

mix.js('resources/js/app.js', 'js');

//mix.sass('resources/css/app.scss','css');





