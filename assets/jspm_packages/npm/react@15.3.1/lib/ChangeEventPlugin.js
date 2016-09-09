/* */ 
(function(process) {
  'use strict';
  var EventConstants = require('./EventConstants');
  var EventPluginHub = require('./EventPluginHub');
  var EventPropagators = require('./EventPropagators');
  var ExecutionEnvironment = require('fbjs/lib/ExecutionEnvironment');
  var ReactDOMComponentTree = require('./ReactDOMComponentTree');
  var ReactUpdates = require('./ReactUpdates');
  var SyntheticEvent = require('./SyntheticEvent');
  var getEventTarget = require('./getEventTarget');
  var isEventSupported = require('./isEventSupported');
  var isTextInputElement = require('./isTextInputElement');
  var keyOf = require('fbjs/lib/keyOf');
  var topLevelTypes = EventConstants.topLevelTypes;
  var eventTypes = {change: {
      phasedRegistrationNames: {
        bubbled: keyOf({onChange: null}),
        captured: keyOf({onChangeCapture: null})
      },
      dependencies: [topLevelTypes.topBlur, topLevelTypes.topChange, topLevelTypes.topClick, topLevelTypes.topFocus, topLevelTypes.topInput, topLevelTypes.topKeyDown, topLevelTypes.topKeyUp, topLevelTypes.topSelectionChange]
    }};
  var activeElement = null;
  var activeElementInst = null;
  var activeElementValue = null;
  var activeElementValueProp = null;
  function shouldUseChangeEvent(elem) {
    var nodeName = elem.nodeName && elem.nodeName.toLowerCase();
    return nodeName === 'select' || nodeName === 'input' && elem.type === 'file';
  }
  var doesChangeEventBubble = false;
  if (ExecutionEnvironment.canUseDOM) {
    doesChangeEventBubble = isEventSupported('change') && (!('documentMode' in document) || document.documentMode > 8);
  }
  function manualDispatchChangeEvent(nativeEvent) {
    var event = SyntheticEvent.getPooled(eventTypes.change, activeElementInst, nativeEvent, getEventTarget(nativeEvent));
    EventPropagators.accumulateTwoPhaseDispatches(event);
    ReactUpdates.batchedUpdates(runEventInBatch, event);
  }
  function runEventInBatch(event) {
    EventPluginHub.enqueueEvents(event);
    EventPluginHub.processEventQueue(false);
  }
  function startWatchingForChangeEventIE8(target, targetInst) {
    activeElement = target;
    activeElementInst = targetInst;
    activeElement.attachEvent('onchange', manualDispatchChangeEvent);
  }
  function stopWatchingForChangeEventIE8() {
    if (!activeElement) {
      return;
    }
    activeElement.detachEvent('onchange', manualDispatchChangeEvent);
    activeElement = null;
    activeElementInst = null;
  }
  function getTargetInstForChangeEvent(topLevelType, targetInst) {
    if (topLevelType === topLevelTypes.topChange) {
      return targetInst;
    }
  }
  function handleEventsForChangeEventIE8(topLevelType, target, targetInst) {
    if (topLevelType === topLevelTypes.topFocus) {
      stopWatchingForChangeEventIE8();
      startWatchingForChangeEventIE8(target, targetInst);
    } else if (topLevelType === topLevelTypes.topBlur) {
      stopWatchingForChangeEventIE8();
    }
  }
  var isInputEventSupported = false;
  if (ExecutionEnvironment.canUseDOM) {
    isInputEventSupported = isEventSupported('input') && (!('documentMode' in document) || document.documentMode > 11);
  }
  var newValueProp = {
    get: function() {
      return activeElementValueProp.get.call(this);
    },
    set: function(val) {
      activeElementValue = '' + val;
      activeElementValueProp.set.call(this, val);
    }
  };
  function startWatchingForValueChange(target, targetInst) {
    activeElement = target;
    activeElementInst = targetInst;
    activeElementValue = target.value;
    activeElementValueProp = Object.getOwnPropertyDescriptor(target.constructor.prototype, 'value');
    Object.defineProperty(activeElement, 'value', newValueProp);
    if (activeElement.attachEvent) {
      activeElement.attachEvent('onpropertychange', handlePropertyChange);
    } else {
      activeElement.addEventListener('propertychange', handlePropertyChange, false);
    }
  }
  function stopWatchingForValueChange() {
    if (!activeElement) {
      return;
    }
    delete activeElement.value;
    if (activeElement.detachEvent) {
      activeElement.detachEvent('onpropertychange', handlePropertyChange);
    } else {
      activeElement.removeEventListener('propertychange', handlePropertyChange, false);
    }
    activeElement = null;
    activeElementInst = null;
    activeElementValue = null;
    activeElementValueProp = null;
  }
  function handlePropertyChange(nativeEvent) {
    if (nativeEvent.propertyName !== 'value') {
      return;
    }
    var value = nativeEvent.srcElement.value;
    if (value === activeElementValue) {
      return;
    }
    activeElementValue = value;
    manualDispatchChangeEvent(nativeEvent);
  }
  function getTargetInstForInputEvent(topLevelType, targetInst) {
    if (topLevelType === topLevelTypes.topInput) {
      return targetInst;
    }
  }
  function handleEventsForInputEventIE(topLevelType, target, targetInst) {
    if (topLevelType === topLevelTypes.topFocus) {
      stopWatchingForValueChange();
      startWatchingForValueChange(target, targetInst);
    } else if (topLevelType === topLevelTypes.topBlur) {
      stopWatchingForValueChange();
    }
  }
  function getTargetInstForInputEventIE(topLevelType, targetInst) {
    if (topLevelType === topLevelTypes.topSelectionChange || topLevelType === topLevelTypes.topKeyUp || topLevelType === topLevelTypes.topKeyDown) {
      if (activeElement && activeElement.value !== activeElementValue) {
        activeElementValue = activeElement.value;
        return activeElementInst;
      }
    }
  }
  function shouldUseClickEvent(elem) {
    return elem.nodeName && elem.nodeName.toLowerCase() === 'input' && (elem.type === 'checkbox' || elem.type === 'radio');
  }
  function getTargetInstForClickEvent(topLevelType, targetInst) {
    if (topLevelType === topLevelTypes.topClick) {
      return targetInst;
    }
  }
  var ChangeEventPlugin = {
    eventTypes: eventTypes,
    extractEvents: function(topLevelType, targetInst, nativeEvent, nativeEventTarget) {
      var targetNode = targetInst ? ReactDOMComponentTree.getNodeFromInstance(targetInst) : window;
      var getTargetInstFunc,
          handleEventFunc;
      if (shouldUseChangeEvent(targetNode)) {
        if (doesChangeEventBubble) {
          getTargetInstFunc = getTargetInstForChangeEvent;
        } else {
          handleEventFunc = handleEventsForChangeEventIE8;
        }
      } else if (isTextInputElement(targetNode)) {
        if (isInputEventSupported) {
          getTargetInstFunc = getTargetInstForInputEvent;
        } else {
          getTargetInstFunc = getTargetInstForInputEventIE;
          handleEventFunc = handleEventsForInputEventIE;
        }
      } else if (shouldUseClickEvent(targetNode)) {
        getTargetInstFunc = getTargetInstForClickEvent;
      }
      if (getTargetInstFunc) {
        var inst = getTargetInstFunc(topLevelType, targetInst);
        if (inst) {
          var event = SyntheticEvent.getPooled(eventTypes.change, inst, nativeEvent, nativeEventTarget);
          event.type = 'change';
          EventPropagators.accumulateTwoPhaseDispatches(event);
          return event;
        }
      }
      if (handleEventFunc) {
        handleEventFunc(topLevelType, targetNode, targetInst);
      }
    }
  };
  module.exports = ChangeEventPlugin;
})(require('process'));
