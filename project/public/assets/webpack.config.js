const path = require('path')
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
let conf = {
    entry: {
        app: './src/index.js'
    },
    output: {
        path: path.resolve(__dirname, './dist'),
        filename: './js/main.js',
        publicPath: 'dist/js/'
    },
    module: {
        rules: [{
                test: /\.css$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    "css-loader"
                ]
            },
            {
                test: /\.scss$/,
                use: [
                    "style-loader",
                    MiniCssExtractPlugin.loader,
                    {
                        loader: "css-loader",
                        options: {
                            sourceMap: true 
                        }
                    },
                    {
                        loader: "sass-loader",
                        options: {
                            sourceMap: true 
                        }
                    }
                ]
            }]
    },
    devServer: {
        overlay: true
    },
    plugins: [
        new MiniCssExtractPlugin({
                filename: "/style/style.css"
        })
    ]
}

module.exports = conf;