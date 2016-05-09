(function(exports) {
    'use strict';

    //define시 필수 구현되어야 하는 object
    var requireOptions = [
            'name', 'editorType', 'editorRoot',
            'getContents', 'setContents',
            'initialize'
        ],
        editorSet = {},
        editorType = [],
        editorOptionSet = {};

    var instanceObj = function(editorName, sel, options) {
        this.editorName = editorName;
        this.selector = sel;
        this.options = options;

    };

    instanceObj.prototype = {
        props: {},
        getInstance: function() {
            return editorSet[this.editorName].editorList[this.selector];
        },
        getContents: function() {
            return editorSet[this.editorName].getContents.call(this.getInstance());
        },
        setContents: function() {
            editorSet[this.editorName].setContents.bind(this.getInstance());
        },
        addProps: function(obj) {
            for(var o in obj) {
                //this['props'][o] = obj[o];
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
        },
        setEditorType: function(types) {

            if(types instanceof Array) {

            }else if(typeof types === 'string'){

            }

        }
    };

    exports.XEeditor = XEeditor;
})(window);



// editor 개발자가 해당 editor를 define한다. name으로 맵핑
XEeditor.define({
    name: 'editor.ckeditor',
    editorType: 'ckeditor',
    editorRoot: CKEDITOR,
    initialize: function(sel, options) {
        CKEDITOR.replace(sel, options || {});

        this.addProps({
            selector: sel
            , options: options
        });

        // this.sel = sel;
        // this.options = options;
        // this.editorRoot.replace(sel, options || {});
    }
    ,
    getContents: function() {
        return CKEDITOR.instances.editor1.getData();
    },
    setContents: function() {

    }
});

// editor 개발자가 해당 editor를 define한다. name으로 맵핑
XEeditor.define({
    name: 'editor.tinyMCE',
    editorType: 'tinyMCE',
    editorRoot: tinymce || {},
    initialize: function(sel, options) {
        this.editorRoot.init({
            selector: sel,
            setup: function (editor) {
                editor.on('keyup', function (e) {

                });
            }
        });
    },
    getContents: function() {
        console.log("test");
        console.log(this.props);
    },
    setContents: function() {

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
    var editor22 = ckEditor.create('editor2', {});
    // var editor1_1 = tinyEditor.create('editor3', {});


    window.editor11 = editor11;
    window.editor22 = editor22;

});


