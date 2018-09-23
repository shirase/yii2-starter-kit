const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const VueLoaderPlugin = require('vue-loader/lib/plugin');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const mergeRules = require('postcss-merge-rules');

const commonConfig = {
    mode: 'production', // production or development
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: [/node_modules/],
                use: [
                    {
                        loader: 'babel-loader',
                        options: { presets: ['env'] }
                    },
                ]
            },
            {
                test: /\.vue$/,
                loader: 'vue-loader',
            },
            {
                test: /\.scss$/,
                oneOf: [
                    {
                        resourceQuery: /vue/,
                        use: [
                            'vue-style-loader',
                            {
                                loader: 'css-loader',
                                options: {
                                    //sourceMap: true,
                                    minimize: true || {/* CSSNano Options */}
                                }
                            },
                            {
                                loader: 'postcss-loader',
                                options: {
                                    plugins: [
                                        autoprefixer({
                                            browsers: 'last 2 versions, > 5%'
                                        }),
                                        cssnano,
                                    ],
                                    //sourceMap: true
                                }
                            },
                            'sass-loader',
                        ],
                    },
                    {
                        use: [
                            MiniCssExtractPlugin.loader,
                            {
                                loader: 'css-loader',
                                options: {
                                    //sourceMap: true,
                                    minimize: true || {/* CSSNano Options */}
                                }
                            },
                            {
                                loader: 'postcss-loader',
                                options: {
                                    plugins: [
                                        autoprefixer({
                                            browsers: 'last 2 versions, > 5%'
                                        }),
                                        cssnano,
                                    ],
                                    //sourceMap: true
                                }
                            },
                            {
                                loader: 'sass-loader',
                                options: {
                                    //sourceMap: true
                                },
                            },
                        ]
                    }
                ],
            },
            {
                test: /\.css$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    {
                        loader: 'css-loader',
                        options: {
                            //sourceMap: true,
                            minimize: true || {/* CSSNano Options */}
                        }
                    },
                    {
                        loader: 'postcss-loader',
                        options: {
                            plugins: [
                                cssnano,
                                autoprefixer({
                                    browsers: 'last 2 versions, > 5%'
                                }),
                            ],
                            //sourceMap: true
                        }
                    },
                ],
            },
        ]
    },
    //devtool: "source-map"
};

module.exports = [
    {
        ...commonConfig,
        entry: {
            'bundle/vue-bundle': path.resolve(__dirname, './backend/js/vue-bundle.js'),
        },
        output: {
            filename: '[name].js',
            path: path.resolve(__dirname, './backend/web'),
        },
        externals: {
            jquery: 'jQuery',
        },
        module: {
            rules: [
                ...commonConfig.module.rules,
                {
                    test: /\.(woff(2)?|ttf|eot)(\?v=\d+\.\d+\.\d+)?$/,
                    use: [{
                        loader: 'file-loader',
                        options: {
                            name: '[path][name].[ext]',
                            context: 'backend/web',
                            publicPath: '../',
                        }
                    }]
                },
                {
                    test: /\.(gif|png|jp(e*)g|svg)$/,
                    use: [{
                        loader: 'url-loader',
                        options: {
                            limit: 8000, // Convert images < 8kb to base64 strings
                            name: '[path][name].[ext]',
                            context: 'backend/web',
                            publicPath: '../',
                        }
                    }]
                },
            ],
        },
        plugins: [
            new MiniCssExtractPlugin({
                filename: "css/style.css",
            }),
            new VueLoaderPlugin(),
        ],
    },
    {
        ...commonConfig,
        entry: {
            'bundle/app': path.resolve(__dirname, './frontend/js/app.js'),
            //'bundle/vue-bundle': path.resolve(__dirname, './frontend/js/vue-bundle.js'),
        },
        output: {
            filename: '[name].js',
            path: path.resolve(__dirname, './frontend/web'),
        },
        externals: {
            jquery: 'jQuery',
        },
        module: {
            rules: [
                ...commonConfig.module.rules,
                {
                    test: /\.(woff(2)?|ttf|eot)(\?v=\d+\.\d+\.\d+)?$/,
                    use: [{
                        loader: 'file-loader',
                        options: {
                            name: '[path][name].[ext]',
                            context: 'frontend/web',
                            publicPath: '../',
                        }
                    }]
                },
                {
                    test: /\.(gif|png|jp(e*)g|svg)$/,
                    use: [{
                        loader: 'url-loader',
                        options: {
                            limit: 8000, // Convert images < 8kb to base64 strings
                            name: '[path][name].[ext]',
                            context: 'frontend/web',
                            publicPath: '../',
                        }
                    }]
                },
            ],
        },
        plugins: [
            new MiniCssExtractPlugin({
                filename: "css/style.css",
            }),
            new VueLoaderPlugin(),
        ],
    },
    {
        ...commonConfig,
        entry: {
            'bundle/style': path.resolve(__dirname, './frontend/web/css/style.scss'),
        },
        output: {
            filename: '[name].js',
            path: path.resolve(__dirname, './frontend/web'),
        },
        externals: {
            jquery: 'jQuery',
        },
        module: {
            rules: [
                ...commonConfig.module.rules,
                {
                    test: /\.(woff(2)?|ttf|eot)(\?v=\d+\.\d+\.\d+)?$/,
                    use: [{
                        loader: 'file-loader',
                        options: {
                            name: '[path][name].[ext]',
                            context: 'frontend/web',
                            publicPath: '../',
                        }
                    }]
                },
                {
                    test: /\.(gif|png|jp(e*)g|svg)$/,
                    use: [{
                        loader: 'url-loader',
                        options: {
                            limit: 8000, // Convert images < 8kb to base64 strings
                            name: '[path][name].[ext]',
                            context: 'frontend/web',
                            publicPath: '../',
                        }
                    }]
                },
            ],
        },
        plugins: [
            new MiniCssExtractPlugin({
                filename: "css/style.css",
            }),
            new VueLoaderPlugin(),
        ],
    },
    {
        ...commonConfig,
        entry: {
            'bundle/style': path.resolve(__dirname, './backend/web/css/style.scss'),
        },
        output: {
            filename: '[name].js',
            path: path.resolve(__dirname, './backend/web'),
        },
        module: {
            rules: [
                ...commonConfig.module.rules,
                {
                    test: /\.(woff(2)?|ttf|eot)(\?v=\d+\.\d+\.\d+)?$/,
                    use: [{
                        loader: 'file-loader',
                        options: {
                            name: '[path][name].[ext]',
                            context: 'frontend/web',
                            publicPath: '../',
                        }
                    }]
                },
                {
                    test: /\.(gif|png|jp(e*)g|svg)$/,
                    use: [{
                        loader: 'url-loader',
                        options: {
                            limit: 8000, // Convert images < 8kb to base64 strings
                            name: '[path][name].[ext]',
                            context: 'backend/web',
                            publicPath: '../',
                        }
                    }]
                },
            ],
        },
        plugins: [
            new MiniCssExtractPlugin({
                filename: "css/style.css",
            }),
            new VueLoaderPlugin(),
        ],
    },
]