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
   .sass('resources/assets/sass/app.scss', 'public/css')
   // jQuery
   .js('resources/assets/js/jquery.js', 'public/js')
   // Nice Scroll
   .copy('resources/assets/js/nicescroll.js', 'public/js')
   // Axios
   .js('resources/assets/js/axios.js', 'public/js')
   // Popper
   .js('resources/assets/js/popper.js', 'public/js')
   // Bootstrap
   .js('node_modules/bootstrap/dist/js/bootstrap.min.js', 'public/js')
   .copy('node_modules/bootstrap/dist/css/bootstrap.min.css', 'public/css')
   // My Styles
   .sass('resources/assets/sass/global.scss', 'public/css')
   .sass('resources/assets/sass/auth.scss', 'public/css')
   .sass('resources/assets/sass/tasks.scss', 'public/css');
