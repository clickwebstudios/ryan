const mix = require('laravel-mix');
const path = require('path');

mix.options({
    processCssUrls: false
});

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

mix.webpackConfig({
  resolve: {
    alias: {
      rootpath: path.resolve(__dirname, ''),
      assets: path.resolve(__dirname, 'assets'),
      vueadmin: path.resolve(__dirname, 'assets/admin/js/vue'),
      vuec: path.resolve(__dirname, 'assets/site/js/vue'),
    },
    extensions: ['.js']
  },
  module: {
    rules: [

    ]
  }
});


mix
  .js('assets/admin/js/app.js', 'dist/admin')
  .sass('assets/admin/sass/app.scss', 'dist/admin')
  .js('assets/site/js/app.js', 'dist/site')
  .sass('assets/site/sass/app.scss', 'dist/site')
  .vue();