(function(exports) {
    'use strict';

    //define시 필수 구현되어야 하는 object
    var requireOptions = [
            'name',
            'getContents', 'setContents', 'addContents',
            'initialize'
        ],
        editorSet = {};

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
        this.name = options.name;
        this.editorType = options.editorType;
        this.editor = options.editor;
        this.editorList = {};

        for(var o in options) {
            this[o] = options[o];
        }
    };

    Editor.prototype = {
        create: function(sel, options) {
            this.editorList[sel] = new instanceObj(this.name, sel, options);
            this.initialize.call(this.editorList[sel], sel, options);

            return this.editorList[sel];
        },
        getContents: function() {
            console.error('Editor.getContents');
        },
        setContents: function() {
            console.error('Editor.setContents');
        },
        addContents: function() {
            console.error('Editor.addContents');
        }
    };

    var XEeditor = {
        define: function(options) {
            if(this.isValidOptions(options)) {
                editorSet[options.name] = new Editor(options);
            }
        },
        isValidOptions: function(options) {
            var valid = true;
            for(var option in requireOptions) {
                if(!options.hasOwnProperty(requireOptions[option])) {
                    console.error('구현 필요 [instance name : ' + options.name + ' fn:' + requireOptions[option] + ']');
                    valid = false;
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



// editor 개발자가 해당 editor를 define한다. name으로 맵핑
XEeditor.define({
    name: 'editor.ckeditor',
    initialize: function(selector, options) {
        CKEDITOR.replace(selector, options || {});

        this.addProps({
            selector: selector
            , options: options
        });
    }
    ,
    getContents: function() {
        return CKEDITOR.instances[this.props.selector].getData();
    },
    setContents: function(text) {
        CKEDITOR.instances[this.props.selector].setData(text);
    },
    addContents: function(text) {
        CKEDITOR.instances[this.props.selector].insertHtml(text);
    }
});

// editor 개발자가 해당 editor를 define한다. name으로 맵핑
XEeditor.define({
    name: 'editor.tinyMCE',
    initialize: function(selector, options) {
        tinymce.init({
            selector: selector,
            setup: function (editor) {
                editor.on('keyup', function (e) {

                });
            }
        });

        this.addProps({
            selector: selector
            , options: options
            , id: selector.replace('#', '')
        });
    },
    getContents: function() {
        return tinymce.get(this.props.id).getContent();
    },
    setContents: function(text) {
        tinymce.get(this.props.id).setContent(text);
    },
    addContents: function(text) {
        tinymce.get(this.props.id).execCommand('mceInsertContent', false, text);
    }
});

// 사용자
// XEeditor로 정의된 에디터를 생성한다.
//XEeditor.getEditor('editor.ckeditor').create('#textarea', {});
//ckeditor.getContents();

$(function() {
    var ckEditor = XEeditor.getEditor('editor.ckeditor');
    var tinyEditor = XEeditor.getEditor('editor.tinyMCE');

    var editor11 = ckEditor.create('editor1', {});
    var editor33 = ckEditor.create('editor3', {});
    var editor22 = tinyEditor.create('#editor2', {});
    var editor44 = tinyEditor.create('#editor4', {});


    window.editor11 = editor11;
    window.editor22 = editor22;
    window.editor33 = editor33;
    window.editor44 = editor44;
});


