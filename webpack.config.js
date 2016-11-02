var path = require('path');
var webpack = require('webpack');

//todo menu

module.exports = {
    //devtool: 'cheap-module-source-map',
    entry: {
        'assets/core/permission/permission': [
            __dirname + '/resources/assets/core/permission/Permission.jsx',
            __dirname + '/resources/assets/core/permission/PermissionExclude.jsx',
            __dirname + '/resources/assets/core/permission/PermissionInclude.jsx',
            __dirname + '/resources/assets/core/permission/PermissionRadioComp.jsx',
            __dirname + '/resources/assets/core/permission/PermissionRenderer.jsx',
            __dirname + '/resources/assets/core/permission/PermissionTag.jsx',
            __dirname + '/resources/assets/core/permission/PermissionTagSuggestion.jsx',
            __dirname + '/resources/assets/core/permission/SettingsPermission.jsx'
        ],
        'assets/core/lang/LangEditorBox': __dirname + '/resources/assets/core/lang/LangEditorBox.js'
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
                NODE_ENV: JSON.stringify("production")
            }
        })
    ],
    module: {
        loaders: [
            {
                test: /(\.js|\.jsx)$/,
                loader: 'babel-loader',
                exclude: /node_modules/,
                query: {
                    presets: ['es2015', 'react']
                }
            }
        ]
    },
    resolve: {
        extensions: ['', '.js', '.jsx']
    }
};
