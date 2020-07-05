const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../../public').mergeManifest();

//mix.js(__dirname + '/Resources/js/app.js', 'js/section.js')
    //.sass( __dirname + '/Resources/sass/app.scss', 'css/section.css');

if (mix.inProduction()) {
    mix.version();
}
