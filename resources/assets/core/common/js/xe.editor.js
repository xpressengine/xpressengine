(function(exports) {
    'use strict';

    //define시 필수 구현되어야 하는 object
    var requireOptions = [
            'name',
            'getContents', 'setContents', 'addContents',
            'initialize'
        ],
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

    var Editor = function(options) {
        for(var o in options) {
            this[o] = options[o];
        }
    };

    Editor.prototype = {
        create: function(sel, options) {
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

        },
        addPlugins: function(plugins) {

        }
    };

    var XEeditor = {
        define: function(options) {
            if(this.isValidOptions(options)) {
                editorOptionSet[options.name] = options;
                editorSet[options.name] = new Editor(options);
            }
        },
        isValidOptions: function(options) {
            var valid = true;
            for(var option in requireOptions) {
                if(!options.hasOwnProperty(requireOptions[option])) {
                    console.error('구현 필요 [fn:' + requireOptions[option] + ']');
                    valid = false;
                }
                
                if(options.hasOwnProperty('components')
                    && options.components instanceof Array
                    && options.components.length > 0
                    && !options.hasOwnProperty('addComponents')) {
                    console.error('구현 필요 [fn:addComponents]');
                }
                
                if(options.hasOwnProperty('plugins')
                    && options.plugins instanceof Array
                    && options.plugins.length > 0
                    && !options.hasOwnProperty('addPlugins')) {
                    console.error('구현 필요 [fn:addPlugins]');
                }
            }

            if(!!editorSet.hasOwnProperty(options.name)) {
                console.error('등록된 에디터 있음 [' + options.name + ']');
                valid = false;
            }

            if(!valid) {
                return false;
            }

            return true;
        },
        getEditor: function(name) {
            return editorSet[name];
        }
    };

    exports.XEeditor = XEeditor;
})(window);

// <textarea name="test" id="editor1" cols="30" rows="10"></textarea>
// <textarea name="test2" id="editor2" cols="30" rows="10"></textarea>


// var components = [{
//     name: 'Code',
//     options: {
//         label: 'Wrap code',
//         command: 'wrapCode'
//     },
//     exec: function(editor) {
//         editor.insertText( '```diagram\n' + editor.getSelection().getSelectedText() + '\n```' );
//     }
// }, {
//     name: 'Diagram',
//     options: {
//         label: 'Wrap diagram',
//         command: 'wrapDiagram'
//     },
//     exec: function (editor) {
//         editor.insertText( '```diagram\n' + editor.getSelection().getSelectedText() + '\n```' );
//     }
// }
// ];
//
// //ckeditor
// XEeditor.define({
//     name: 'editor.ckeditor',
//     components: components,
//     plugins: [],
//     initialize: function (selector, options) {
//
//         var options = $.extend({
//             "height": 200,
//             "fileUpload":{
//                 "upload_url": "/file/upload",
//                 "source_url": "/file/source",
//                 "download_url": "/file/download"
//             },
//             "suggestion":{
//                 "hashtag_api": "/suggestion/hashTag",
//                 "mention_api": "/suggestion/mention"
//             }
//         }, options);
//
//         var editor = CKEDITOR.replace(selector, options || {});
//
//         console.log('editor', editor);
//         editor.on('change', function(e) {
//             e.editor.updateElement();
//         });
//
//         this.addProps({
//             editor: editor
//             , selector: selector
//             , options: options
//         });
//     },
//     getContents: function () {
//         return CKEDITOR.instances[this.props.selector].getData();
//     },
//     setContents: function (text) {
//         CKEDITOR.instances[this.props.selector].setData(text);
//     },
//     addContents: function (text) {
//         CKEDITOR.instances[this.props.selector].insertHtml(text);
//     },
//     addComponents: function (components) {
//         console.log("addComponents", components);
//
//         var editor = this.props.editor;
//
//         for(var i = 0, max = components.length; i < max; i += 1) {
//             var component = components[i];
//
//             editor.ui.add( component.name, CKEDITOR.UI_BUTTON, component.options);
//
//             if(component.hasOwnProperty('options')
//                 && component.options.hasOwnProperty('command')) {
//                 editor.addCommand(component.options.command, {
//                     exec: component.exec
//                 });
//             }
//         }
//     }
// });
//
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