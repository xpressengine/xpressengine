/* */ 
(function(process) {
  'use strict';
  var _prodInvariant = require('./reactProdInvariant');
  var DOMProperty = require('./DOMProperty');
  var ReactDOMComponentFlags = require('./ReactDOMComponentFlags');
  var invariant = require('fbjs/lib/invariant');
  var ATTR_NAME = DOMProperty.ID_ATTRIBUTE_NAME;
  var Flags = ReactDOMComponentFlags;
  var internalInstanceKey = '__reactInternalInstance$' + Math.random().toString(36).slice(2);
  function getRenderedHostOrTextFromComponent(component) {
    var rendered;
    while (rendered = component._renderedComponent) {
      component = rendered;
    }
    return component;
  }
  function precacheNode(inst, node) {
    var hostInst = getRenderedHostOrTextFromComponent(inst);
    hostInst._hostNode = node;
    node[internalInstanceKey] = hostInst;
  }
  function uncacheNode(inst) {
    var node = inst._hostNode;
    if (node) {
      delete node[internalInstanceKey];
      inst._hostNode = null;
    }
  }
  function precacheChildNodes(inst, node) {
    if (inst._flags & Flags.hasCachedChildNodes) {
      return;
    }
    var children = inst._renderedChildren;
    var childNode = node.firstChild;
    outer: for (var name in children) {
      if (!children.hasOwnProperty(name)) {
        continue;
      }
      var childInst = children[name];
      var childID = getRenderedHostOrTextFromComponent(childInst)._domID;
      if (childID === 0) {
        continue;
      }
      for (; childNode !== null; childNode = childNode.nextSibling) {
        if (childNode.nodeType === 1 && childNode.getAttribute(ATTR_NAME) === String(childID) || childNode.nodeType === 8 && childNode.nodeValue === ' react-text: ' + childID + ' ' || childNode.nodeType === 8 && childNode.nodeValue === ' react-empty: ' + childID + ' ') {
          precacheNode(childInst, childNode);
          continue outer;
        }
      }
      !false ? process.env.NODE_ENV !== 'production' ? invariant(false, 'Unable to find element with ID %s.', childID) : _prodInvariant('32', childID) : void 0;
    }
    inst._flags |= Flags.hasCachedChildNodes;
  }
  function getClosestInstanceFromNode(node) {
    if (node[internalInstanceKey]) {
      return node[internalInstanceKey];
    }
    var parents = [];
    while (!node[internalInstanceKey]) {
      parents.push(node);
      if (node.parentNode) {
        node = node.parentNode;
      } else {
        return null;
      }
    }
    var closest;
    var inst;
    for (; node && (inst = node[internalInstanceKey]); node = parents.pop()) {
      closest = inst;
      if (parents.length) {
        precacheChildNodes(inst, node);
      }
    }
    return closest;
  }
  function getInstanceFromNode(node) {
    var inst = getClosestInstanceFromNode(node);
    if (inst != null && inst._hostNode === node) {
      return inst;
    } else {
      return null;
    }
  }
  function getNodeFromInstance(inst) {
    !(inst._hostNode !== undefined) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'getNodeFromInstance: Invalid argument.') : _prodInvariant('33') : void 0;
    if (inst._hostNode) {
      return inst._hostNode;
    }
    var parents = [];
    while (!inst._hostNode) {
      parents.push(inst);
      !inst._hostParent ? process.env.NODE_ENV !== 'production' ? invariant(false, 'React DOM tree root should always have a node reference.') : _prodInvariant('34') : void 0;
      inst = inst._hostParent;
    }
    for (; parents.length; inst = parents.pop()) {
      precacheChildNodes(inst, inst._hostNode);
    }
    return inst._hostNode;
  }
  var ReactDOMComponentTree = {
    getClosestInstanceFromNode: getClosestInstanceFromNode,
    getInstanceFromNode: getInstanceFromNode,
    getNodeFromInstance: getNodeFromInstance,
    precacheChildNodes: precacheChildNodes,
    precacheNode: precacheNode,
    uncacheNode: uncacheNode
  };
  module.exports = ReactDOMComponentTree;
})(require('process'));
