/* */ 
(function(process) {
  'use strict';
  var _assign = require('object-assign');
  var _extends = _assign || function(target) {
    for (var i = 1; i < arguments.length; i++) {
      var source = arguments[i];
      for (var key in source) {
        if (Object.prototype.hasOwnProperty.call(source, key)) {
          target[key] = source[key];
        }
      }
    }
    return target;
  };
  var EventConstants = require('./EventConstants');
  var EventPluginHub = require('./EventPluginHub');
  var EventPluginRegistry = require('./EventPluginRegistry');
  var ReactEventEmitterMixin = require('./ReactEventEmitterMixin');
  var ReactNativeComponentTree = require('./ReactNativeComponentTree');
  var ReactNativeTagHandles = require('./ReactNativeTagHandles');
  var ReactUpdates = require('./ReactUpdates');
  var warning = require('fbjs/lib/warning');
  var topLevelTypes = EventConstants.topLevelTypes;
  var EMPTY_NATIVE_EVENT = {};
  var touchSubsequence = function(touches, indices) {
    var ret = [];
    for (var i = 0; i < indices.length; i++) {
      ret.push(touches[indices[i]]);
    }
    return ret;
  };
  var removeTouchesAtIndices = function(touches, indices) {
    var rippedOut = [];
    var temp = touches;
    for (var i = 0; i < indices.length; i++) {
      var index = indices[i];
      rippedOut.push(touches[index]);
      temp[index] = null;
    }
    var fillAt = 0;
    for (var j = 0; j < temp.length; j++) {
      var cur = temp[j];
      if (cur !== null) {
        temp[fillAt++] = cur;
      }
    }
    temp.length = fillAt;
    return rippedOut;
  };
  var ReactNativeEventEmitter = _extends({}, ReactEventEmitterMixin, {
    registrationNames: EventPluginRegistry.registrationNameModules,
    putListener: EventPluginHub.putListener,
    getListener: EventPluginHub.getListener,
    deleteListener: EventPluginHub.deleteListener,
    deleteAllListeners: EventPluginHub.deleteAllListeners,
    _receiveRootNodeIDEvent: function(rootNodeID, topLevelType, nativeEventParam) {
      var nativeEvent = nativeEventParam || EMPTY_NATIVE_EVENT;
      var inst = ReactNativeComponentTree.getInstanceFromNode(rootNodeID);
      if (!inst) {
        return;
      }
      ReactUpdates.batchedUpdates(function() {
        ReactNativeEventEmitter.handleTopLevel(topLevelType, inst, nativeEvent, nativeEvent.target);
      });
    },
    receiveEvent: function(tag, topLevelType, nativeEventParam) {
      var rootNodeID = tag;
      ReactNativeEventEmitter._receiveRootNodeIDEvent(rootNodeID, topLevelType, nativeEventParam);
    },
    receiveTouches: function(eventTopLevelType, touches, changedIndices) {
      var changedTouches = eventTopLevelType === topLevelTypes.topTouchEnd || eventTopLevelType === topLevelTypes.topTouchCancel ? removeTouchesAtIndices(touches, changedIndices) : touchSubsequence(touches, changedIndices);
      for (var jj = 0; jj < changedTouches.length; jj++) {
        var touch = changedTouches[jj];
        touch.changedTouches = changedTouches;
        touch.touches = touches;
        var nativeEvent = touch;
        var rootNodeID = null;
        var target = nativeEvent.target;
        if (target !== null && target !== undefined) {
          if (target < ReactNativeTagHandles.tagsStartAt) {
            if (process.env.NODE_ENV !== 'production') {
              process.env.NODE_ENV !== 'production' ? warning(false, 'A view is reporting that a touch occured on tag zero.') : void 0;
            }
          } else {
            rootNodeID = target;
          }
        }
        ReactNativeEventEmitter._receiveRootNodeIDEvent(rootNodeID, eventTopLevelType, nativeEvent);
      }
    }
  });
  module.exports = ReactNativeEventEmitter;
})(require('process'));
