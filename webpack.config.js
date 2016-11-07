var path = require('path');
var webpack = require('webpack');
var webpackMerge = require('webpack-merge');
var CommonsChunkPlugin = require("webpack/lib/optimize/CommonsChunkPlugin");

var prodConfig = require('./webpack.prod.config');
var devConfig = require('./webpack.dev.config');

var pathInfo = {
    permission: path.resolve(__dirname, '/resources/assets/core/permission'),
    menu: path.resolve(__dirname, '/resources/assets/core/menu'),
    lang: path.resolve(__dirname, '/resources/assets/core/lang')
};

console.log('path', path);

var common = {
    //devtool: 'cheap-module-source-map',
    entry: {
        'vendor': ['react', 'react-dom', 'jquery'],
        'assets/core/permission/permission': [
            pathInfo.permission + '/Permission.jsx',
            pathInfo.permission + '/PermissionExclude.jsx',
            pathInfo.permission + '/PermissionInclude.jsx',
            pathInfo.permission + '/PermissionRadioComp.jsx',
            pathInfo.permission + '/PermissionRenderer.jsx',
            pathInfo.permission + '/PermissionTag.jsx',
            pathInfo.permission + '/PermissionTagSuggestion.jsx',
            pathInfo.permission + '/SettingsPermission.jsx'
        ],
        'assets/core/menu/menu': [
            pathInfo.menu + '/MenuRenderer.js',
            pathInfo.menu + '/MenuEntity.js',
            pathInfo.menu + '/MenuItem.js',
            pathInfo.menu + '/TreeNode.js',
            pathInfo.menu + '/MenuSearchBar.js',
            pathInfo.menu + '/UITree.js',
            pathInfo.menu + '/MenuSearchBar.js',
            pathInfo.menu + '/MenuSearchSuggestion.js',
            pathInfo.menu + '/MenuTree.js'
        ],
        'assets/core/lang/langEditorBox': path.lang + '/LangEditorBox.js'
    },
    output: {
        path: path.resolve(__dirname, './'),
        filename: '[name].bundle.js'
    },
    plugins: [
        new webpack.optimize.UglifyJsPlugin({minimize: true, compress: {warnings: false}}),   //uglify, minify
        new webpack.HotModuleReplacementPlugin(),
        new webpack.NoErrorsPlugin(),
        new webpack.DefinePlugin({
            "process.env": {
                NODE_ENV: JSON.stringify("production")  //production -> 파일 용량 작아짐. warning 제거
            }
        }),
        new CommonsChunkPlugin({
            name: "vendor",
            filename: "assets/vendor/vendor.js",
            minChunks: Infinity,
        })
    ],
    module: {
        loaders: [
            {
                test: /(\.js|\.jsx)$/,
                loader: 'babel-loader',
                exclude: /node_modules/,
                query: {
                    presets: ['es2015', 'react'],
                    cacheDirectory: true
                }
            }
        ]
    },
    resolve: {
        extensions: ['', '.js', '.jsx'],
        alias: {}
    }
};


var config;

if(target === 'build') {
    config = webpackMerge(common, prodConfig)
} else {
    config = webpackMerge(common, devConfig)
}

module.exports = config;