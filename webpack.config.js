const path = require('path');
const cssnext = require('postcss-cssnext');
const inputRange = require('postcss-input-range');

module.exports = {
    entry: [
        './resources/assets/js/index.js',
        './resources/assets/sass/site/site.scss'
    ],
    output: {
        path: path.resolve(__dirname, 'public/dist'),
        filename: 'bundle.js'
    },
    devServer: {
        port: 9000,
    },
    module: {
        rules: [
            {
                test: /\.scss$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: '[name].css',
                        }
                    },
                    {
                        loader: 'extract-loader'
                    },
                    {
                        loader: 'css-loader?-url'
                    },
                    {
                        loader: 'postcss-loader',
                        options: {
                            plugins: [
                                cssnext({
                                    browsers: ['last 3 versions', 'ie 11'],
                                }),
                                inputRange(),
                            ],
                        },
                    },
                    {
                        loader: 'sass-loader'
                    }
                ]
            },
            {
                test: /\.(js|jsx)$/,
                exclude: /(node_modules)/,
                loader: "babel-loader",
                options: { presets: ["@babel/env"] }
            },
            {
                test: /\.css$/,
                include: [
                    path.join(__dirname, 'resources/assets/js'),
                ],
                use: [
                    { loader: 'style-loader' },
                    {
                        loader: 'css-loader',
                        options: {
                            modules: true,
                            importLoaders: 1,
                            localIdentName: '[name]__[local]__[hash:base64:5]',
                        },
                    },
                    {
                        loader: 'postcss-loader',
                        options: {
                            plugins: [
                                cssnext({
                                    browsers: ['last 3 versions', 'ie 11'],
                                }),
                                inputRange(),
                            ],
                        },
                    },
                ],
            }
        ]
    },
};
