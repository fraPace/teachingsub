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

mix.js('resources/assets/js/app.js', 'public/js');
mix.sass('resources/assets/sass/app.scss', 'public/css/');

// Let's compile all CSSs into one file
mix.styles([
        'public/css/app.css',
        'resources/assets/plugins/DataTables-1.10.16/css/dataTables.bootstrap4.min.css',
        'resources/assets/plugins/Buttons-1.5.1/css/buttons.bootstrap4.min.css',
        'resources/assets/plugins/Responsive-2.2.1/css/responsive.bootstrap4.min.css',
        'resources/assets/plugins/Select-1.2.5/css/select.bootstrap4.min.css'
    ], 'public/css/app.css');
// Let's compile all JSs into one file
mix.scripts([
        'public/js/app.js',
        'resources/assets/plugins/DataTables-1.10.16/js/jquery.dataTables.min.js',
        'resources/assets/plugins/DataTables-1.10.16/js/dataTables.bootstrap4.min.js',
        'resources/assets/plugins/Buttons-1.5.1/js/dataTables.buttons.min.js',
        'resources/assets/plugins/Buttons-1.5.1/js/buttons.bootstrap4.min.js',
        'resources/assets/plugins/Responsive-2.2.1/js/dataTables.responsive.min.js',
        'resources/assets/plugins/Responsive-2.2.1/js/responsive.bootstrap4.min.js',
        'resources/assets/plugins/Select-1.2.5/js/dataTables.select.min.js'
    ], 'public/js/app.js');
