/* */ 
(function(process) {
  'use strict';
  var ReactReconciler = require('./ReactReconciler');
  var instantiateReactComponent = require('./instantiateReactComponent');
  var KeyEscapeUtils = require('./KeyEscapeUtils');
  var shouldUpdateReactComponent = require('./shouldUpdateReactComponent');
  var traverseAllChildren = require('./traverseAllChildren');
  var warning = require('fbjs/lib/warning');
  var ReactComponentTreeHook;
  if (typeof process !== 'undefined' && process.env && process.env.NODE_ENV === 'test') {
    ReactComponentTreeHook = require('./ReactComponentTreeHook');
  }
  function instantiateChild(childInstances, child, name, selfDebugID) {
    var keyUnique = childInstances[name] === undefined;
    if (process.env.NODE_ENV !== 'production') {
      if (!ReactComponentTreeHook) {
        ReactComponentTreeHook = require('./ReactComponentTreeHook');
      }
      if (!keyUnique) {
        process.env.NODE_ENV !== 'production' ? warning(false, 'flattenChildren(...): Encountered two children with the same key, ' + '`%s`. Child keys must be unique; when two children share a key, only ' + 'the first child will be used.%s', KeyEscapeUtils.unescape(name), ReactComponentTreeHook.getStackAddendumByID(selfDebugID)) : void 0;
      }
    }
    if (child != null && keyUnique) {
      childInstances[name] = instantiateReactComponent(child, true);
    }
  }
  var ReactChildReconciler = {
    instantiateChildren: function(nestedChildNodes, transaction, context, selfDebugID) {
      if (nestedChildNodes == null) {
        return null;
      }
      var childInstances = {};
      if (process.env.NODE_ENV !== 'production') {
        traverseAllChildren(nestedChildNodes, function(childInsts, child, name) {
          return instantiateChild(childInsts, child, name, selfDebugID);
        }, childInstances);
      } else {
        traverseAllChildren(nestedChildNodes, instantiateChild, childInstances);
      }
      return childInstances;
    },
    updateChildren: function(prevChildren, nextChildren, mountImages, removedNodes, transaction, hostParent, hostContainerInfo, context, selfDebugID) {
      if (!nextChildren && !prevChildren) {
        return;
      }
      var name;
      var prevChild;
      for (name in nextChildren) {
        if (!nextChildren.hasOwnProperty(name)) {
          continue;
        }
        prevChild = prevChildren && prevChildren[name];
        var prevElement = prevChild && prevChild._currentElement;
        var nextElement = nextChildren[name];
        if (prevChild != null && shouldUpdateReactComponent(prevElement, nextElement)) {
          ReactReconciler.receiveComponent(prevChild, nextElement, transaction, context);
          nextChildren[name] = prevChild;
        } else {
          if (prevChild) {
            removedNodes[name] = ReactReconciler.getHostNode(prevChild);
            ReactReconciler.unmountComponent(prevChild, false);
          }
          var nextChildInstance = instantiateReactComponent(nextElement, true);
          nextChildren[name] = nextChildInstance;
          var nextChildMountImage = ReactReconciler.mountComponent(nextChildInstance, transaction, hostParent, hostContainerInfo, context, selfDebugID);
          mountImages.push(nextChildMountImage);
        }
      }
      for (name in prevChildren) {
        if (prevChildren.hasOwnProperty(name) && !(nextChildren && nextChildren.hasOwnProperty(name))) {
          prevChild = prevChildren[name];
          removedNodes[name] = ReactReconciler.getHostNode(prevChild);
          ReactReconciler.unmountComponent(prevChild, false);
        }
      }
    },
    unmountChildren: function(renderedChildren, safely) {
      for (var name in renderedChildren) {
        if (renderedChildren.hasOwnProperty(name)) {
          var renderedChild = renderedChildren[name];
          ReactReconciler.unmountComponent(renderedChild, safely);
        }
      }
    }
  };
  module.exports = ReactChildReconciler;
})(require('process'));
