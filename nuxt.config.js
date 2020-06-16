const laravelNuxt = require('laravel-nuxt');
require('dotenv').config();

module.exports = laravelNuxt
(
    {
        dev: process.env.NODE_ENV != 'production',
        head: {
            meta: [
                {
                    charset: 'utf-8'
                },
                {
                    name: 'viewport',
                    content: 'width=device-width, initial-scale=1'
                },
                {
                    name: 'theme-color',
                    content: '#c9dfff'
                },

                {
                    property: 'og:type',
                    content: 'article'
                },
                {
                    property: 'og:image',
                    content: '/storage/uploaded/images/prev.jpg'
                },
                {
                    property: 'og:image:width',
                    content: 612
                },
                {
                    property: 'og:image:height',
                    content: 286
                },

                {
                    name: 'twitter:card',
                    content: 'summary'
                },
                {
                    name: 'twitter:site',
                    content: '@StylephotosTO'
                },
                {
                    name: 'twitter:image',
                    content: '/storage/uploaded/images/prev.jpg'
                }
            ],
            link:
                [],
            script:
                []
        },
        plugins: [
            {
                src: '~plugins/phpdebugbar.js'
            },
            {
                src: '~plugins/axios.js'
            },
            {
                src: '~plugins/veeValidate.js'
            },
            {
                src: '~plugins/clickOutside.js'
            }
        ],
        css: [
            '~assets/scss/app.scss'
        ],
        build: {
            vendor: [
                'axios',
                'vee-validate'
            ]
        },
        buildModules: [
            '@nuxtjs/dotenv'
        ],
        loading:
            {
                color: 'blue',
                height: '5px'
            }
    }
);
