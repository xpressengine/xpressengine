var path = require('path');
var webpack = require('webpack');

module.exports = {
    devtool: 'cheap-module-eval-source-map',
    entry: {
        'permission': [
            __dirname + '/resources/assets/core/permission/Permission',
            __dirname + '/resources/assets/core/permission/PermissionExclude',
            __dirname + '/resources/assets/core/permission/PermissionInclude',
            __dirname + '/resources/assets/core/permission/PermissionRadioComp',
            __dirname + '/resources/assets/core/permission/PermissionRenderer',
            __dirname + '/resources/assets/core/permission/PermissionTag',
            __dirname + '/resources/assets/core/permission/PermissionTagSuggestion',
            __dirname + '/resources/assets/core/permission/SettingsPermission'
        ]
    },
    output: {
        path: path.join(__dirname, 'assets/core/permission'),
        filename: '[name].js'
    },
    plugins: [

    ],
    module: {
        loaders: [
            {
                test: /\/resoureces\/assets\/core\/.jsx?$/,
                loader: 'babel-loader',
                exclude: /node_modules/,
                query: {
                    presets: ['es2015', 'react']
                }
            },
            {
                test: /\.css$/,
                exclude: /node_modules/,
                loaders: ['style-loader', 'css-loader', 'postcss-loader']
            }
        ]
    },
    resolve: {
        extensions: ['', '.js', '.jsx']
    }
};
