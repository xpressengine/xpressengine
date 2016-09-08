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
  var EventPropagators = require('./EventPropagators');
  var SyntheticEvent = require('./SyntheticEvent');
  var UIManager = require('react-native/lib/UIManager');
  var warning = require('fbjs/lib/warning');
  var customBubblingEventTypes = UIManager.customBubblingEventTypes;
  var customDirectEventTypes = UIManager.customDirectEventTypes;
  var allTypesByEventName = {};
  for (var bubblingTypeName in customBubblingEventTypes) {
    allTypesByEventName[bubblingTypeName] = customBubblingEventTypes[bubblingTypeName];
  }
  for (var directTypeName in customDirectEventTypes) {
    process.env.NODE_ENV !== 'production' ? warning(!customBubblingEventTypes[directTypeName], 'Event cannot be both direct and bubbling: %s', directTypeName) : void 0;
    allTypesByEventName[directTypeName] = customDirectEventTypes[directTypeName];
  }
  var ReactNativeBridgeEventPlugin = {
    eventTypes: _extends({}, customBubblingEventTypes, customDirectEventTypes),
    extractEvents: function(topLevelType, targetInst, nativeEvent, nativeEventTarget) {
      var bubbleDispatchConfig = customBubblingEventTypes[topLevelType];
      var directDispatchConfig = customDirectEventTypes[topLevelType];
      var event = SyntheticEvent.getPooled(bubbleDispatchConfig || directDispatchConfig, targetInst, nativeEvent, nativeEventTarget);
      if (bubbleDispatchConfig) {
        EventPropagators.accumulateTwoPhaseDispatches(event);
      } else if (directDispatchConfig) {
        EventPropagators.accumulateDirectDispatches(event);
      } else {
        return null;
      }
      return event;
    }
  };
  module.exports = ReactNativeBridgeEventPlugin;
})(require('process'));
