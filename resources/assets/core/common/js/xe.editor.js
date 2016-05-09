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



