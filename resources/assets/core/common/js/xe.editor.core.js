(function(exports) {
    'use strict';

    //define시 필수 구현되어야 하는 object
    var editorSet = {},
        editorOptionSet = {};

    var instanceObj = function(editorName, sel, editorOptions, authOptions, partsOptions) {

        // this.editorOptions = editorOptions;
        // this.authOptions = authOptions;
        // this.partsOptions = partsOptions;

        var _options = {
            editorOptions: editorOptions,
            authOptions: authOptions,
            partsOptions: partsOptions
        };

        this.editorName = editorName;
        this.selector = sel;
        this.props = {};
        this.getOptions = function() {
            return _options;
        };

    };

    instanceObj.prototype = {
        getInstance: function() {
            return editorSet[this.editorName].editorList[this.selector];
        },
        getContents: function() {
            return editorSet[this.editorName].interfaces.getContents.call(this.getInstance());
        },
        setContents: function(text) {
            editorSet[this.editorName].interfaces.setContents.call(this.getInstance(), text);
        },
        addContents: function(text) {
            editorSet[this.editorName].interfaces.addContents.call(this.getInstance(), text);
        },
        addProps: function(obj) {
            for(var o in obj) {
                this.getInstance().props[o] = obj[o];
            }
        },
        addTools: function(tools) {
            editorSet[this.editorName].interfaces.addTools.call(this.getInstance(), tools);
        }
    };

    var Editor = function(editorSettings, interfaces) {
        this.name = editorSettings.name;
        this.configs = editorSettings.configs;
        this.editorList = [];

        if(editorSettings.hasOwnProperty('plugins')
            && editorSettings.plugins instanceof Array
            && editorSettings.plugins.length > 0
            && editorSettings.hasOwnProperty('addPlugins')) {
            editorSettings.addPlugins(editorSettings.plugins);
        }

        for(var o in interfaces) {
            this.interfaces[o] = interfaces[o];
        }
    };

    Editor.prototype = {
        configs: {},
        interfaces: {},
        create: function(sel, editorOptions, authOptions, partsOptions) {
            var editorOptions = editorOptions || {},
                authOptions = authOptions || {},
                partsOptions = partsOptions || {};

            var editorOptions = $.extend(this.configs || {}, editorOptions);

            if(!sel) {
                console.error('[XEeditor fn:create] invalid editor id. (id=' + sel + ')');
            }

            this.editorList[sel] = new instanceObj(this.name, sel, editorOptions, authOptions, partsOptions);
            this.interfaces.initialize.call(this.editorList[sel], sel, editorOptions, authOptions, partsOptions);

            if(this.interfaces.hasOwnProperty('tools') && this.interfaces.tools.length > 0) {
                this.interfaces.addTools.call(this.editorList[sel], this.interfaces.tools);
            }

            return this.editorList[sel];
        }
    };

    var Tools = function(obj) {
        this.id = obj.id;
        this.events = obj.events;
    };

    var XEeditor = (function() {
        return {
            define: function(obj) {
                var editorSettings = obj.editorSettings,
                    interfaces = obj.interfaces;

                if(Validation.isValidEditorOptions(editorSettings, interfaces)) {
                    editorOptionSet[editorSettings.name] = editorSettings;
                    editorSet[editorSettings.name] = new Editor(editorSettings, interfaces);
                }
            },
            getEditor: function(name) {
                return editorSet[name];
            },
            tools: {
                define: function(obj) {
                    if(Validation.isValidToolsObject(obj)) {
                        // {
                        //     id : 'editorparts/emoticon@emoticon',
                        //         events: {
                        //     'icon.click': function() {
                        //
                        //     },
                        //     'element.dblclick': function(e, editor, target) {
                        //
                        //     }
                        // }


                    }
                },
                get: function(id) {

                }
            }
        }
    })();

    var Validation = (function() {
        var requireOptions = {
            editorSettings: [
                'name'
            ],
            interfaces: [
                'initialize',
                'getContents', 'setContents', 'addContents'
            ],
            tools: {
                interface: [
                    'id', 'events'
                ],
                events: [
                    'icon.click', 'element.dbclick'
                ]
            }
        };

        return {
            isValidEditorOptions: function(editorSettings, interfaces) {
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
                }

                if(editorSettings.hasOwnProperty('plugins')
                    && editorSettings.plugins instanceof Array
                    && editorSettings.plugins.length > 0
                    && !editorSettings.hasOwnProperty('addPlugins')) {
                    console.error('구현 필요 [fn:addPlugins]');
                }

                if(!!editorSet.hasOwnProperty(editorSettings.name)) {
                    console.error('등록된 에디터 있음 [' + editorSettings.name + ']');
                    valid = false;
                }

                return (!valid)? false : true;
            },
            isValidToolsObject: function(obj) {
                var valid = true;

                for(var i = 0, max = requireOptions.tools.length; i < max; i += 1) {
                    if(!obj.hasOwnProperty(requireOptions.tools[i])) {
                        console.error('구현 필요 [XEeditor.tools.define => fn:' + requireOptions.tools[i] + ']');
                        valid = false;
                    }

                    valid = false;
                }

                if(obj.hasOwnProperty('events')) {
                    for(var i = 0, max = obj.events.length; i < max; i += 1) {
                        if(!obj.events.hasOwnProperty(obj.events[i])) {
                           console.error('구현 필요[XEeditor.tools.define => event' + obj.events[i] + ']');
                        }

                        valid = false;
                    }
                }

                return valid;
            }
        }
    })();



    exports.XEeditor = XEeditor;
})(window);

/*
XEedior.tools.define({
    id : 'editorparts/emoticon@emoticon',
    events: {
        'icon.click': function() {

        },
        'element.dblclick': function(e, editor, target) {

        }
    }
});
*/

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