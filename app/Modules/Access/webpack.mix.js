const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../../public').mergeManifest();

//mix.js(__dirname + '/Resources/js/app.js', 'js/access.js')
    //.sass( __dirname + '/Resources/sass/app.scss', 'css/access.css');

if (mix.inProduction()) {
    mix.version();
}