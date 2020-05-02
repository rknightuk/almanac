const path = require('path');

module.exports = {
    entry: './resources/assets/js/index.js',
    output: {
        path: path.resolve(__dirname, 'public/dist/js'),
        filename: 'bundle.js'
    },
    devServer: {
        port: 9000,
    },
    module: {
        rules: [
            {
                test: /\.(js|jsx)$/,
                exclude: /(node_modules)/,
                loader: "babel-loader",
                options: { presets: ["@babel/env"] }
            }
        ]
    },
};
