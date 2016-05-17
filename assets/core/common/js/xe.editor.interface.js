(function(exports) {
    'use strict';

    //define시 필수 구현되어야 하는 object
    var requireOptions = {
            editorSettings: [
                'name'
            ],
            interfaces: [
                'initialize',
                'getContents', 'setContents', 'addContents'
            ]
        },
        editorSet = {},
        editorOptionSet = {};

    var instanceObj = function(editorName, sel, options) {
        this.editorName = editorName;
        this.selector = sel;
        this.options = options;
        this.props = {};

    };

    instanceObj.prototype = {
        getInstance: function() {
            return editorSet[this.editorName].editorList[this.selector];
        },
        getContents: function() {
            return editorSet[this.editorName].getContents.call(this.getInstance());
        },
        setContents: function(text) {
            editorSet[this.editorName].setContents.call(this.getInstance(), text);
        },
        addContents: function(text) {
            editorSet[this.editorName].addContents.call(this.getInstance(), text);
        },
        addProps: function(obj) {
            for(var o in obj) {
                this.getInstance().props[o] = obj[o];
            }
        }
    };

    var Editor = function(editorSettings, interfaces) {
        this.name = editorSettings.name;
        this.defaultOptions = editorSettings.defaultOptions;
        this.editorList = [];

        if(editorSettings.hasOwnProperty('plugins')
            && editorSettings.plugins instanceof Array
            && editorSettings.plugins.length > 0
            && editorSettings.hasOwnProperty('addPlugins')) {
            editorSettings.addPlugins(editorSettings.plugins);
        }

        if(editorSettings.hasOwnProperty('components')
            && editorSettings.components instanceof Array
            && editorSettings.components.length > 0
            && editorSettings.hasOwnProperty('addComponents')) {
            editorSettings.addComponents(editorSettings.components);
        }

        for(var o in interfaces) {
            this[o] = interfaces[o];
        }
    };

    Editor.prototype = {
        defaultOptions: {},
        create: function(sel, options) {
            var options = $.extend(this.defaultOptions, options);

            this.editorList[sel] = new instanceObj(this.name, sel, options);
            this.initialize.call(this.editorList[sel], sel, options);

            if(this.hasOwnProperty('components') && this.components.length > 0) {
                this.addComponents.call(this.editorList[sel], this.components);
            }

            return this.editorList[sel];
        },
        getContents: function() {
            console.error('Editor.getContents');
        },
        setContents: function(text) {
            console.error('Editor.setContents');
        },
        addContents: function(text) {
            console.error('Editor.addContents');
        },
        addComponents: function(components) {

        }
    };

    var XEeditor = {
        define: function(obj) {
            var editorSettings = obj.editorSettings,
                interfaces = obj.interfaces;

            if(this.isValidOptions(editorSettings, interfaces)) {
                editorOptionSet[editorSettings.name] = editorSettings;
                editorSet[editorSettings.name] = new Editor(editorSettings, interfaces);
            }
        },
        isValidOptions: function(editorSettings, interfaces) {
            var valid = true;
            for(var eSettings in requireOptions.editorSettings) {
                if(!editorSettings.hasOwnProperty(requireOptions.editorSettings[eSettings])) {
                    console.error('구현 필요 [editorSettings.' + requireOptions.editorSettings[eSettings] + ']');
                    valid = false;
                }
            }

            for(var eInterface in requireOptions.interfaces) {
                if(!interfaces.hasOwnProperty(requireOptions.interfaces[eInterface])) {
                    console.error('구현 필요 [' + requireOptions.interfaces[eInterface] + ']');
                    valid = false;
                }

                if(editorSettings.hasOwnProperty('components')
                    && editorSettings.components instanceof Array
                    && editorSettings.components.length > 0
                    && !editorSettings.hasOwnProperty('addComponents')) {
                    console.error('구현 필요 [fn:addComponents]');
                }

                if(editorSettings.hasOwnProperty('plugins')
                    && editorSettings.plugins instanceof Array
                    && editorSettings.plugins.length > 0
                    && !editorSettings.hasOwnProperty('addPlugins')) {
                    console.error('구현 필요 [fn:addPlugins]');
                }
            }

            if(!!editorSet.hasOwnProperty(editorSettings.name)) {
                console.error('등록된 에디터 있음 [' + editorSettings.name + ']');
                valid = false;
            }

            return (!valid)? false : true;
        },
        getEditor: function(name) {
            return editorSet[name];
        }
    };

    exports.XEeditor = XEeditor;
})(window);

// //tinyMCE
// XEeditor.define({
//     name: 'editor.tinyMCE',
//     initialize: function (selector, options) {
//         tinymce.init({
//             selector: selector,
//             setup: function (editor) {
//                 editor.on('keyup', function (e) {
//
//                 });
//             }
//         });
//
//         this.addProps({
//             selector: selector
//             , options: options
//             , id: selector.replace('#', '')
//         });
//     },
//     getContents: function () {
//         return tinymce.get(this.props.id).getContent();
//     },
//     setContents: function (text) {
//         tinymce.get(this.props.id).setContent(text);
//     },
//     addContents: function (text) {
//         tinymce.get(this.props.id).execCommand('mceInsertContent', false, text);
//     }
// });
//
//
// $(function () {
//     var ckEditor = XEeditor.getEditor('editor.ckeditor');
//     var tinyEditor = XEeditor.getEditor('editor.tinyMCE');
//
//     console.log(xe3CkEditorConfig.configs);
//
//     window.editor11 = ckEditor.create('editor1', xe3CkEditorConfig.configs);
//
// });