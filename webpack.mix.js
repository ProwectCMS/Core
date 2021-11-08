const mix = require('laravel-mix');
const webpack = require('webpack');
const path = require('path');

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

mix.options({
    terser: {
        terserOptions: {
            compress: {
                drop_console: true,
            },
        },
    },
})
    .setPublicPath('public')
    .js('resources/assets/js/admin.js', 'public/js')
    .js('resources/assets/js/strikingdash.js', 'public/js')
    .vue()
    .sass('resources/assets/sass/strikingdash/bootstrap/bootstrap.scss', 'public/css')
    .sass('resources/assets/sass/admin.scss', 'public/css')
    .version()
    // .copy('resources/img', 'public/img')
    .webpackConfig({
        resolve: {
            symlinks: false,
            alias: {
                '@': path.resolve(__dirname, 'resources/assets/js/'),
            },
        },
        plugins: [
            // new webpack.IgnorePlugin({
            //     resourceRegExp: /^\.\/locale$/,
            //     contextRegExp: /moment$/,
            // }),
        ],
    });