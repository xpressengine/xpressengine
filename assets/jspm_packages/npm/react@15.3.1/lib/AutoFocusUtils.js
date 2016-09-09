/* */ 
'use strict';
var ReactDOMComponentTree = require('./ReactDOMComponentTree');
var focusNode = require('fbjs/lib/focusNode');
var AutoFocusUtils = {focusDOMComponent: function() {
    focusNode(ReactDOMComponentTree.getNodeFromInstance(this));
  }};
module.exports = AutoFocusUtils;
