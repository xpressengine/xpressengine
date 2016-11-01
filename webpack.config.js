var path = require('path');
var webpack = require('webpack');

module.exports = {
    devtool: 'cheap-module-eval-source-map',
    entry: [
        __dirname + '/resources/assets/core/permission/Permission',
        __dirname + '/resources/assets/core/permission/PermissionExclude',
        __dirname + '/resources/assets/core/permission/PermissionInclude',
        __dirname + '/resources/assets/core/permission/PermissionRadioComp',
        __dirname + '/resources/assets/core/permission/PermissionRenderer',
        __dirname + '/resources/assets/core/permission/PermissionTag',
        __dirname + '/resources/assets/core/permission/PermissionTagSuggestion',
        __dirname + '/resources/assets/core/permission/SettingsPermission'
    ],
    output: {
        path: path.join(__dirname, 'assets', 'dist'),
        filename: 'bundle.js',
        publicPath: '/static/'
    },
    plugins: [
        new webpack.HotModuleReplacementPlugin(),
        new webpack.NoErrorsPlugin()
    ],
    module: {
        loaders: [
            // {
            //     test: /\.jsx?/,
            //     exclude: /(node_modules|bower_components)/,
            //     loaders: ['babel-loader'],
            //     include: path.join(__dirname, 'src')
            // },
            {
                test: /\/resoureces\/assets\/core\/permission\/.jsx?$/,
                loader: 'babel-loader',
                exclude: /node_modules/,
                query: {
                    presets: ['es2015', 'react']
                }
            },
            {
                test: /\.css$/,
                exclude: /(node_modules|bower_components)/,
                loaders: ['style-loader', 'css-loader', 'postcss-loader']
            }
        ]
    },
    resolve: {
        extensions: ['', '.js', '.jsx']
    }
};
