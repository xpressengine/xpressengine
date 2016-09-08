/* */ 
(function(process) {
  'use strict';
  var _prodInvariant = require('./reactProdInvariant');
  var EventConstants = require('./EventConstants');
  var ReactErrorUtils = require('./ReactErrorUtils');
  var invariant = require('fbjs/lib/invariant');
  var warning = require('fbjs/lib/warning');
  var ComponentTree;
  var TreeTraversal;
  var injection = {
    injectComponentTree: function(Injected) {
      ComponentTree = Injected;
      if (process.env.NODE_ENV !== 'production') {
        process.env.NODE_ENV !== 'production' ? warning(Injected && Injected.getNodeFromInstance && Injected.getInstanceFromNode, 'EventPluginUtils.injection.injectComponentTree(...): Injected ' + 'module is missing getNodeFromInstance or getInstanceFromNode.') : void 0;
      }
    },
    injectTreeTraversal: function(Injected) {
      TreeTraversal = Injected;
      if (process.env.NODE_ENV !== 'production') {
        process.env.NODE_ENV !== 'production' ? warning(Injected && Injected.isAncestor && Injected.getLowestCommonAncestor, 'EventPluginUtils.injection.injectTreeTraversal(...): Injected ' + 'module is missing isAncestor or getLowestCommonAncestor.') : void 0;
      }
    }
  };
  var topLevelTypes = EventConstants.topLevelTypes;
  function isEndish(topLevelType) {
    return topLevelType === topLevelTypes.topMouseUp || topLevelType === topLevelTypes.topTouchEnd || topLevelType === topLevelTypes.topTouchCancel;
  }
  function isMoveish(topLevelType) {
    return topLevelType === topLevelTypes.topMouseMove || topLevelType === topLevelTypes.topTouchMove;
  }
  function isStartish(topLevelType) {
    return topLevelType === topLevelTypes.topMouseDown || topLevelType === topLevelTypes.topTouchStart;
  }
  var validateEventDispatches;
  if (process.env.NODE_ENV !== 'production') {
    validateEventDispatches = function(event) {
      var dispatchListeners = event._dispatchListeners;
      var dispatchInstances = event._dispatchInstances;
      var listenersIsArr = Array.isArray(dispatchListeners);
      var listenersLen = listenersIsArr ? dispatchListeners.length : dispatchListeners ? 1 : 0;
      var instancesIsArr = Array.isArray(dispatchInstances);
      var instancesLen = instancesIsArr ? dispatchInstances.length : dispatchInstances ? 1 : 0;
      process.env.NODE_ENV !== 'production' ? warning(instancesIsArr === listenersIsArr && instancesLen === listenersLen, 'EventPluginUtils: Invalid `event`.') : void 0;
    };
  }
  function executeDispatch(event, simulated, listener, inst) {
    var type = event.type || 'unknown-event';
    event.currentTarget = EventPluginUtils.getNodeFromInstance(inst);
    if (simulated) {
      ReactErrorUtils.invokeGuardedCallbackWithCatch(type, listener, event);
    } else {
      ReactErrorUtils.invokeGuardedCallback(type, listener, event);
    }
    event.currentTarget = null;
  }
  function executeDispatchesInOrder(event, simulated) {
    var dispatchListeners = event._dispatchListeners;
    var dispatchInstances = event._dispatchInstances;
    if (process.env.NODE_ENV !== 'production') {
      validateEventDispatches(event);
    }
    if (Array.isArray(dispatchListeners)) {
      for (var i = 0; i < dispatchListeners.length; i++) {
        if (event.isPropagationStopped()) {
          break;
        }
        executeDispatch(event, simulated, dispatchListeners[i], dispatchInstances[i]);
      }
    } else if (dispatchListeners) {
      executeDispatch(event, simulated, dispatchListeners, dispatchInstances);
    }
    event._dispatchListeners = null;
    event._dispatchInstances = null;
  }
  function executeDispatchesInOrderStopAtTrueImpl(event) {
    var dispatchListeners = event._dispatchListeners;
    var dispatchInstances = event._dispatchInstances;
    if (process.env.NODE_ENV !== 'production') {
      validateEventDispatches(event);
    }
    if (Array.isArray(dispatchListeners)) {
      for (var i = 0; i < dispatchListeners.length; i++) {
        if (event.isPropagationStopped()) {
          break;
        }
        if (dispatchListeners[i](event, dispatchInstances[i])) {
          return dispatchInstances[i];
        }
      }
    } else if (dispatchListeners) {
      if (dispatchListeners(event, dispatchInstances)) {
        return dispatchInstances;
      }
    }
    return null;
  }
  function executeDispatchesInOrderStopAtTrue(event) {
    var ret = executeDispatchesInOrderStopAtTrueImpl(event);
    event._dispatchInstances = null;
    event._dispatchListeners = null;
    return ret;
  }
  function executeDirectDispatch(event) {
    if (process.env.NODE_ENV !== 'production') {
      validateEventDispatches(event);
    }
    var dispatchListener = event._dispatchListeners;
    var dispatchInstance = event._dispatchInstances;
    !!Array.isArray(dispatchListener) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'executeDirectDispatch(...): Invalid `event`.') : _prodInvariant('103') : void 0;
    event.currentTarget = dispatchListener ? EventPluginUtils.getNodeFromInstance(dispatchInstance) : null;
    var res = dispatchListener ? dispatchListener(event) : null;
    event.currentTarget = null;
    event._dispatchListeners = null;
    event._dispatchInstances = null;
    return res;
  }
  function hasDispatches(event) {
    return !!event._dispatchListeners;
  }
  var EventPluginUtils = {
    isEndish: isEndish,
    isMoveish: isMoveish,
    isStartish: isStartish,
    executeDirectDispatch: executeDirectDispatch,
    executeDispatchesInOrder: executeDispatchesInOrder,
    executeDispatchesInOrderStopAtTrue: executeDispatchesInOrderStopAtTrue,
    hasDispatches: hasDispatches,
    getInstanceFromNode: function(node) {
      return ComponentTree.getInstanceFromNode(node);
    },
    getNodeFromInstance: function(node) {
      return ComponentTree.getNodeFromInstance(node);
    },
    isAncestor: function(a, b) {
      return TreeTraversal.isAncestor(a, b);
    },
    getLowestCommonAncestor: function(a, b) {
      return TreeTraversal.getLowestCommonAncestor(a, b);
    },
    getParentInstance: function(inst) {
      return TreeTraversal.getParentInstance(inst);
    },
    traverseTwoPhase: function(target, fn, arg) {
      return TreeTraversal.traverseTwoPhase(target, fn, arg);
    },
    traverseEnterLeave: function(from, to, fn, argFrom, argTo) {
      return TreeTraversal.traverseEnterLeave(from, to, fn, argFrom, argTo);
    },
    injection: injection
  };
  module.exports = EventPluginUtils;
})(require('process'));
