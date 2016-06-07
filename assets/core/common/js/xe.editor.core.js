(function(exports) {
    'use strict';

    //define시 필수 구현되어야 하는 object
    var editorSet = {},
        editorOptionSet = {};

    var instanceObj = function(editorName, sel, editorOptions, toolInfoList) {
        var _options = {
            editorOptions: editorOptions,
            toolInfoList: toolInfoList
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
        addTools: function(toolInstanceList) {
            editorSet[this.editorName].interfaces.addTools.call(this.getInstance(), this.getOptions().toolInfoList, toolInstanceList);
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
        create: function(sel, editorOptions, customOptions, toolInfoList) {
            var editorOptions = editorOptions || {},
                toolInfoList = toolInfoList || [];

            var editorOptions = $.extend(this.configs || {}, editorOptions);

            if(Validation.isValidBeforeCreateInstance(sel, toolInfoList, this)) {
                this.editorList[sel] = new instanceObj(this.name, sel, editorOptions, toolInfoList);
                this.interfaces.initialize.call(this.editorList[sel], sel, editorOptions, customOptions);

                if(!!toolInfoList && toolInfoList.length > 0) {
                    var tools = {};
                    var toolInfoListFilter = [];

                    for(var i = 0, max = toolInfoList.length; i < max; i += 1) {
                        if(XEeditor.tools.get(toolInfoList[i].id)) {
                            //tools.push(XEeditor.tools.get(toolInfoList[i].id));
                            tools[toolInfoList[i].id] = XEeditor.tools.get(toolInfoList[i].id);
                            toolInfoListFilter.push(toolInfoList[i]);

                        }else {
                            console.error('define된 tool이 존재하지 않음. [' + toolInfoList[i].id + ']');
                        }
                    }

                    this.interfaces.addTools.call(this.editorList[sel], tools, toolInfoListFilter);
                }

                return this.editorList[sel];
            }
        }
    };

    var Tools = function(obj) {
        for(var o in obj) {
            this[o] = obj[o];
        }
    };

    var toolsSet = {};

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
                        toolsSet[obj.id] = new Tools(obj);
                    }
                },
                get: function(id) {
                    return toolsSet[id];
                }
            },
            attachDomId: function(content, id) {
                return $(content).attr('xe-tool-id', id).clone().wrap('<div/>').parent().html();
            },
            getDomSelector: function(id) {
                return '[xe-tool-id="' + id + '"]';
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
                property: [
                    'id', 'events'
                ],
                events: [
                    'iconClick', 'elementDoubleClick'
                ]
            }
        };

        return {
            isValidBeforeCreateInstance: function(sel, toolIdList, editorParent) {
                if(!sel) {
                    console.error('error: 중복 editor id. (' + sel + ')');
                    return false;
                }

                if(editorParent.editorList.length > 0) {
                    var selValid = true;
                    for(var i = 0, max = editorParent.editorList.length; i < max; i += 1) {
                        if(editorParent.editorList[i] === sel) {
                            selValid = false;

                            console.error();
                            break;
                        }
                    }

                    if(!selValid) {
                        return false;
                    }
                }

                return true;
            },
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

                for(var i = 0, max = requireOptions.tools.property.length; i < max; i += 1) {
                    if(!obj.hasOwnProperty(requireOptions.tools.property[i])) {
                        console.error('구현 필요 [XEeditor.tools.define => fn:' + requireOptions.tools.property[i] + ']');
                        valid = false;
                    }
                }

                for(var i = 0, max = requireOptions.tools.events.length; i < max; i += 1) {
                    if(!obj.events.hasOwnProperty(requireOptions.tools.events[i])) {
                        console.error('구현 필요[XEeditor.tools.define => event' + requireOptions.tools.events[i] + ']');
                        valid = false;
                    }
                }

                return valid;
            }
        }
    })();



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