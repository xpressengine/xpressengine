var webpack = require('webpack')
var path = require('path')

var dir_build = path.resolve(__dirname, 'dist')

module.exports = {
    devServer: {
        contentBase: dir_build
    },
    devtool: 'cheap-module-source-map'
    //devtool: 'eval'
}