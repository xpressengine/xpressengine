/* */ 
'use strict';
var _assign = require('object-assign');
var DOMLazyTree = require('./DOMLazyTree');
var ReactDOMComponentTree = require('./ReactDOMComponentTree');
var ReactDOMEmptyComponent = function(instantiate) {
  this._currentElement = null;
  this._hostNode = null;
  this._hostParent = null;
  this._hostContainerInfo = null;
  this._domID = 0;
};
_assign(ReactDOMEmptyComponent.prototype, {
  mountComponent: function(transaction, hostParent, hostContainerInfo, context) {
    var domID = hostContainerInfo._idCounter++;
    this._domID = domID;
    this._hostParent = hostParent;
    this._hostContainerInfo = hostContainerInfo;
    var nodeValue = ' react-empty: ' + this._domID + ' ';
    if (transaction.useCreateElement) {
      var ownerDocument = hostContainerInfo._ownerDocument;
      var node = ownerDocument.createComment(nodeValue);
      ReactDOMComponentTree.precacheNode(this, node);
      return DOMLazyTree(node);
    } else {
      if (transaction.renderToStaticMarkup) {
        return '';
      }
      return '<!--' + nodeValue + '-->';
    }
  },
  receiveComponent: function() {},
  getHostNode: function() {
    return ReactDOMComponentTree.getNodeFromInstance(this);
  },
  unmountComponent: function() {
    ReactDOMComponentTree.uncacheNode(this);
  }
});
module.exports = ReactDOMEmptyComponent;
