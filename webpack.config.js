const path = require('path');

module.exports = {
    entry: './resources/assets/js/index.js',
    output: {
        path: path.resolve(__dirname, 'dist'),
        filename: 'public/dist/js/bundle.js'
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
