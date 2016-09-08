/* */ 
(function(process) {
  'use strict';
  var KeyEscapeUtils = require('./KeyEscapeUtils');
  var traverseAllChildren = require('./traverseAllChildren');
  var warning = require('fbjs/lib/warning');
  var ReactComponentTreeHook;
  if (typeof process !== 'undefined' && process.env && process.env.NODE_ENV === 'test') {
    ReactComponentTreeHook = require('./ReactComponentTreeHook');
  }
  function flattenSingleChildIntoContext(traverseContext, child, name, selfDebugID) {
    if (traverseContext && typeof traverseContext === 'object') {
      var result = traverseContext;
      var keyUnique = result[name] === undefined;
      if (process.env.NODE_ENV !== 'production') {
        if (!ReactComponentTreeHook) {
          ReactComponentTreeHook = require('./ReactComponentTreeHook');
        }
        if (!keyUnique) {
          process.env.NODE_ENV !== 'production' ? warning(false, 'flattenChildren(...): Encountered two children with the same key, ' + '`%s`. Child keys must be unique; when two children share a key, only ' + 'the first child will be used.%s', KeyEscapeUtils.unescape(name), ReactComponentTreeHook.getStackAddendumByID(selfDebugID)) : void 0;
        }
      }
      if (keyUnique && child != null) {
        result[name] = child;
      }
    }
  }
  function flattenChildren(children, selfDebugID) {
    if (children == null) {
      return children;
    }
    var result = {};
    if (process.env.NODE_ENV !== 'production') {
      traverseAllChildren(children, function(traverseContext, child, name) {
        return flattenSingleChildIntoContext(traverseContext, child, name, selfDebugID);
      }, result);
    } else {
      traverseAllChildren(children, flattenSingleChildIntoContext, result);
    }
    return result;
  }
  module.exports = flattenChildren;
})(require('process'));
