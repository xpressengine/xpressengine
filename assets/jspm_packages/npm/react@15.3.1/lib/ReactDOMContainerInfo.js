/* */ 
(function(process) {
  'use strict';
  var validateDOMNesting = require('./validateDOMNesting');
  var DOC_NODE_TYPE = 9;
  function ReactDOMContainerInfo(topLevelWrapper, node) {
    var info = {
      _topLevelWrapper: topLevelWrapper,
      _idCounter: 1,
      _ownerDocument: node ? node.nodeType === DOC_NODE_TYPE ? node : node.ownerDocument : null,
      _node: node,
      _tag: node ? node.nodeName.toLowerCase() : null,
      _namespaceURI: node ? node.namespaceURI : null
    };
    if (process.env.NODE_ENV !== 'production') {
      info._ancestorInfo = node ? validateDOMNesting.updatedAncestorInfo(null, info._tag, null) : null;
    }
    return info;
  }
  module.exports = ReactDOMContainerInfo;
})(require('process'));
