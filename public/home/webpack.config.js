var webpack = require('webpack')
const ExtractTextPlugin = require("extract-text-webpack-plugin")
const UglifyJsPlugin = require('uglifyjs-webpack-plugin')
const CopyWebpackPlugin = require('copy-webpack-plugin')

const extractSass = new ExtractTextPlugin({
    filename: "[name].css",
    disable: process.env.NODE_ENV === "development"
})

module.exports = {
    entry: {
        index: __dirname + '/src/index.ts',
        zone: __dirname + '/src/pages/zone/zone.ts',
        type: __dirname + '/src/pages/type/type.ts',
        docs: __dirname + '/src/pages/docs/docs.ts',
        value: __dirname + '/src/pages/value/value.ts',
    },
    output: {
        path: __dirname + '/build',
        filename: '[name].js'
    },
    module: {
        rules: [
            {
                test: /\.(png|jpg|gif)$/,
                use: [
                    {
                        loader: 'url-loader',
                        options: {
                            limit: 8192
                        }
                    }
                ]
            },
            {
                test: /\.scss$/,
                use: extractSass.extract({
                    use: [
                        {
                            loader: "css-loader"
                        },
                        {
                            loader: "sass-loader",
                        }
                    ],
                    fallback: "style-loader"
                })
            },
            {
                test: /\.text$/,
                use: 'raw-loader'
            },
            { test: /\.ts$/, use: 'ts-loader', exclude: /node_modules/ },
        ]
    },
    plugins: [
        extractSass,
        new UglifyJsPlugin(),
        new CopyWebpackPlugin([{ from: 'src/pages/*/*.html', to: '[name].html', flatten: true }])
    ],
    externals: {
        jquery: 'jQuery'
    },
    resolve: {
        modules: ['node_modules'],
        extensions: [".tsx", ".ts", ".js"]
    }
}