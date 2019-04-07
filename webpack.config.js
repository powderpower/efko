var path = require('path'),
ExtractTextPlugin = require('extract-text-webpack-plugin');

module.exports = 
{
    entry: {
        app: './resources/assets/js/app.js',
    },
    output: {
        path: path.resolve(__dirname, 'public/js'),
        filename: '[name].js'
    },
    module: {
      rules: [
        {
          test: /\.scss$/,
          use: ExtractTextPlugin.extract({
            fallback: 'style-loader',
            use: ['css-loader', 'sass-loader']
          })
        }
      ]
    },
    plugins: [ new ExtractTextPlugin('../css/[name].css') ]
};