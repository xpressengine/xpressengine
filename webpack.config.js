var path = require('path');
var webpack = require('webpack');
var webpackMerge = require('webpack-merge');
var CommonsChunkPlugin = require("webpack/lib/optimize/CommonsChunkPlugin");

var prodConfig = require('./webpack.prod.config');
var devConfig = require('./webpack.dev.config');

var path = {
    permission: path.resolve(__dirname, '/resources/assets/core/permission'),
    menu: path.resolve(__dirname, '/resources/assets/core/menu'),
    lang: path.resolve(__dirname, '/resources/assets/core/lang')
};

var common = {
    //devtool: 'cheap-module-source-map',
    entry: {
        'vendor': ['react', 'react-dom', 'jquery'],
        'assets/core/permission/permission': [
            path.permission + '/Permission.jsx',
            path.permission + '/PermissionExclude.jsx',
            path.permission + '/PermissionInclude.jsx',
            path.permission + '/PermissionRadioComp.jsx',
            path.permission + '/PermissionRenderer.jsx',
            path.permission + '/PermissionTag.jsx',
            path.permission + '/PermissionTagSuggestion.jsx',
            path.permission + '/SettingsPermission.jsx'
        ],
        'assets/core/menu/menu': [
            path.menu + '/MenuRenderer.js',
            path.menu + '/MenuEntity.js',
            path.menu + '/MenuItem.js',
            path.menu + '/TreeNode.js',
            path.menu + '/MenuSearchBar.js',
            path.menu + '/UITree.js',
            path.menu + '/MenuSearchBar.js',
            path.menu + '/MenuSearchSuggestion.js',
            path.menu + '/MenuTree.js'
        ],
        'assets/core/lang/langEditorBox': path.lang + '/LangEditorBox.js'
    },
    output: {
        path: path.join(__dirname, './'),
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