/* */ 
(function(process) {
  'use strict';
  var DOMChildrenOperations = require('./DOMChildrenOperations');
  var ReactDOMComponentTree = require('./ReactDOMComponentTree');
  var ReactDOMIDOperations = {dangerouslyProcessChildrenUpdates: function(parentInst, updates) {
      var node = ReactDOMComponentTree.getNodeFromInstance(parentInst);
      DOMChildrenOperations.processUpdates(node, updates);
    }};
  module.exports = ReactDOMIDOperations;
})(require('process'));
