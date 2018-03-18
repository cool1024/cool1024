var webpack = require('webpack');

module.exports = {
    entry: {
        home: './src/home.ts'
    },
    devtool: 'inline-source-map',
    output: {
        path: __dirname + '/src/build',
        filename: '[name].js'
    },
    module: {
        rules: [
            // { test: /\.css$/, loader: "style-loader!css-loader" },
            {
                test: /\.tsx?$/,
                use: 'ts-loader',
                exclude: /node_modules/
            }
        ]
    },
    externals: {
        jquery: 'jQuery'
    },
    resolve: {
        modules: ['node_modules'],
        extensions: [".tsx", ".ts", ".js"]
    }
};