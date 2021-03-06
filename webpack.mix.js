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
    .extract([
        'lodash',
        'popper.js',
        'jquery',
        'feather-icons',
        'bootstrap',
        'typeface-nunito',
    ])
    .scripts([
        'node_modules/datatables.net/js/jquery.dataTables.js',
        'node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js',
        'node_modules/datatables.net-responsive/js/dataTables.responsive.js',
        'node_modules/datatables.net-responsive-bs4/js/responsive.bootstrap4.js'
    ], 'public/js/datatable.js')
    .styles(['node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css'], 'public/css/datatable.css')
    .sass('resources/sass/app.scss', 'public/css')
    .version();