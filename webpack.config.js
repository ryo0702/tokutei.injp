const path                          = require('path');
const MiniCssExtractPlugin          = require('mini-css-extract-plugin');
const CopyPlugin                    = require('copy-webpack-plugin');
const CssMinimizerPlugin            = require('css-minimizer-webpack-plugin');
const LodashModuleReplacementPlugin = require('lodash-webpack-plugin');

const devMode = false;

module.exports = {
    mode : devMode ? 'development' : 'production',
    entry: {
        'main'     : './src/js/main.js',
        'style'    : './src/scss/style.scss',
        'admin-css': './src/scss/admin.scss',
        'admin'    : './src/js/admin.js'
    },

    output: {
        filename     : 'js/[name].min.js',
        chunkFilename: 'libs/[name].[chunkhash].min.js',
        path         : path.resolve(__dirname, 'dist'),
        library      : 'mylib',
        libraryTarget: 'var', // var | umd
        clean        : true,
    },

    module: {
        rules: [
            {
                test: /\.css$/i,
                use : ['style-loader', 'css-loader'],
            },
            {
                test: /\.(sa|sc)ss$/,
                use : [
                    {loader: MiniCssExtractPlugin.loader},
                    {loader: 'css-loader', options: {importLoaders: 2}},
                    {loader: 'postcss-loader'},
                    {loader: 'sass-loader'},
                ]
            },
            {
                test     : /\.(png|jpg|jpeg|gif|svg)$/i,
                type     : 'asset/resource',
                generator: {
                    filename: 'images/[name][ext][query]'
                }
            },
            {
                test     : /\.(woff|woff2|eot|ttf|otf)$/i,
                type     : 'asset/resource',
                generator: {
                    filename: 'fonts/[name][ext][query]'
                }
            },
            {
                test: /\.(txt|tmpl)$/i,
                use : 'raw-loader',
            },
        ],
    },

    cache: {
        type          : 'memory',
        maxGenerations: Infinity,
    },

    optimization: {
        sideEffects : true,
        runtimeChunk: 'single', // single | false
        minimizer   : [
            // For webpack@5 you can use the `...` syntax to extend existing minimizers
            '...',
            new CssMinimizerPlugin({
                minimizerOptions: {
                    preset: [
                        "advanced",
                        {
                            discardComments: {removeAll: true},
                        },
                    ],
                },
            }),
        ],
    },

    externals: {
        jquery: 'jQuery',
    },

    plugins: [
        new MiniCssExtractPlugin({
            filename: devMode ? './css/[name].css' : './css/[name].min.css'
        }),
        new LodashModuleReplacementPlugin({
            collections: true,
            paths      : true,
            caching    : true,
            flattening : true,
        }),
        new CopyPlugin({
            patterns: [
                {from: "./src/images", to: "images"},
            ],
        }),
    ]
};