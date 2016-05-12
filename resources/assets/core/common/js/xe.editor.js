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
        this.name = options.name;
        this.editorList = {};

        for(var o in options) {
            this[o] = options[o];
        }
    };

    Editor.prototype = {
        create: function(sel, options) {
            this.editorList[sel] = new instanceObj(this.name, sel, options);
            this.initialize.call(this.editorList[sel], sel, options);

            if(this.hasOwnProperty('components') && this.components.length > 0) {
                this.addComponent(this.components);
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
        addComponent: function(components) {

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
                    && !options.hasOwnProperty('addComponent')) {
                    console.error('구현 필요 [fn:addComponent]');
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


