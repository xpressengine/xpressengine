/* */ 
(function(process) {
  'use strict';
  var EventConstants = require('./EventConstants');
  var EventPluginUtils = require('./EventPluginUtils');
  var EventPropagators = require('./EventPropagators');
  var ResponderSyntheticEvent = require('./ResponderSyntheticEvent');
  var ResponderTouchHistoryStore = require('./ResponderTouchHistoryStore');
  var accumulate = require('./accumulate');
  var keyOf = require('fbjs/lib/keyOf');
  var isStartish = EventPluginUtils.isStartish;
  var isMoveish = EventPluginUtils.isMoveish;
  var isEndish = EventPluginUtils.isEndish;
  var executeDirectDispatch = EventPluginUtils.executeDirectDispatch;
  var hasDispatches = EventPluginUtils.hasDispatches;
  var executeDispatchesInOrderStopAtTrue = EventPluginUtils.executeDispatchesInOrderStopAtTrue;
  var responderInst = null;
  var trackedTouchCount = 0;
  var previousActiveTouches = 0;
  var changeResponder = function(nextResponderInst, blockHostResponder) {
    var oldResponderInst = responderInst;
    responderInst = nextResponderInst;
    if (ResponderEventPlugin.GlobalResponderHandler !== null) {
      ResponderEventPlugin.GlobalResponderHandler.onChange(oldResponderInst, nextResponderInst, blockHostResponder);
    }
  };
  var eventTypes = {
    startShouldSetResponder: {phasedRegistrationNames: {
        bubbled: keyOf({onStartShouldSetResponder: null}),
        captured: keyOf({onStartShouldSetResponderCapture: null})
      }},
    scrollShouldSetResponder: {phasedRegistrationNames: {
        bubbled: keyOf({onScrollShouldSetResponder: null}),
        captured: keyOf({onScrollShouldSetResponderCapture: null})
      }},
    selectionChangeShouldSetResponder: {phasedRegistrationNames: {
        bubbled: keyOf({onSelectionChangeShouldSetResponder: null}),
        captured: keyOf({onSelectionChangeShouldSetResponderCapture: null})
      }},
    moveShouldSetResponder: {phasedRegistrationNames: {
        bubbled: keyOf({onMoveShouldSetResponder: null}),
        captured: keyOf({onMoveShouldSetResponderCapture: null})
      }},
    responderStart: {registrationName: keyOf({onResponderStart: null})},
    responderMove: {registrationName: keyOf({onResponderMove: null})},
    responderEnd: {registrationName: keyOf({onResponderEnd: null})},
    responderRelease: {registrationName: keyOf({onResponderRelease: null})},
    responderTerminationRequest: {registrationName: keyOf({onResponderTerminationRequest: null})},
    responderGrant: {registrationName: keyOf({onResponderGrant: null})},
    responderReject: {registrationName: keyOf({onResponderReject: null})},
    responderTerminate: {registrationName: keyOf({onResponderTerminate: null})}
  };
  function setResponderAndExtractTransfer(topLevelType, targetInst, nativeEvent, nativeEventTarget) {
    var shouldSetEventType = isStartish(topLevelType) ? eventTypes.startShouldSetResponder : isMoveish(topLevelType) ? eventTypes.moveShouldSetResponder : topLevelType === EventConstants.topLevelTypes.topSelectionChange ? eventTypes.selectionChangeShouldSetResponder : eventTypes.scrollShouldSetResponder;
    var bubbleShouldSetFrom = !responderInst ? targetInst : EventPluginUtils.getLowestCommonAncestor(responderInst, targetInst);
    var skipOverBubbleShouldSetFrom = bubbleShouldSetFrom === responderInst;
    var shouldSetEvent = ResponderSyntheticEvent.getPooled(shouldSetEventType, bubbleShouldSetFrom, nativeEvent, nativeEventTarget);
    shouldSetEvent.touchHistory = ResponderTouchHistoryStore.touchHistory;
    if (skipOverBubbleShouldSetFrom) {
      EventPropagators.accumulateTwoPhaseDispatchesSkipTarget(shouldSetEvent);
    } else {
      EventPropagators.accumulateTwoPhaseDispatches(shouldSetEvent);
    }
    var wantsResponderInst = executeDispatchesInOrderStopAtTrue(shouldSetEvent);
    if (!shouldSetEvent.isPersistent()) {
      shouldSetEvent.constructor.release(shouldSetEvent);
    }
    if (!wantsResponderInst || wantsResponderInst === responderInst) {
      return null;
    }
    var extracted;
    var grantEvent = ResponderSyntheticEvent.getPooled(eventTypes.responderGrant, wantsResponderInst, nativeEvent, nativeEventTarget);
    grantEvent.touchHistory = ResponderTouchHistoryStore.touchHistory;
    EventPropagators.accumulateDirectDispatches(grantEvent);
    var blockHostResponder = executeDirectDispatch(grantEvent) === true;
    if (responderInst) {
      var terminationRequestEvent = ResponderSyntheticEvent.getPooled(eventTypes.responderTerminationRequest, responderInst, nativeEvent, nativeEventTarget);
      terminationRequestEvent.touchHistory = ResponderTouchHistoryStore.touchHistory;
      EventPropagators.accumulateDirectDispatches(terminationRequestEvent);
      var shouldSwitch = !hasDispatches(terminationRequestEvent) || executeDirectDispatch(terminationRequestEvent);
      if (!terminationRequestEvent.isPersistent()) {
        terminationRequestEvent.constructor.release(terminationRequestEvent);
      }
      if (shouldSwitch) {
        var terminateEvent = ResponderSyntheticEvent.getPooled(eventTypes.responderTerminate, responderInst, nativeEvent, nativeEventTarget);
        terminateEvent.touchHistory = ResponderTouchHistoryStore.touchHistory;
        EventPropagators.accumulateDirectDispatches(terminateEvent);
        extracted = accumulate(extracted, [grantEvent, terminateEvent]);
        changeResponder(wantsResponderInst, blockHostResponder);
      } else {
        var rejectEvent = ResponderSyntheticEvent.getPooled(eventTypes.responderReject, wantsResponderInst, nativeEvent, nativeEventTarget);
        rejectEvent.touchHistory = ResponderTouchHistoryStore.touchHistory;
        EventPropagators.accumulateDirectDispatches(rejectEvent);
        extracted = accumulate(extracted, rejectEvent);
      }
    } else {
      extracted = accumulate(extracted, grantEvent);
      changeResponder(wantsResponderInst, blockHostResponder);
    }
    return extracted;
  }
  function canTriggerTransfer(topLevelType, topLevelInst, nativeEvent) {
    return topLevelInst && (topLevelType === EventConstants.topLevelTypes.topScroll && !nativeEvent.responderIgnoreScroll || trackedTouchCount > 0 && topLevelType === EventConstants.topLevelTypes.topSelectionChange || isStartish(topLevelType) || isMoveish(topLevelType));
  }
  function noResponderTouches(nativeEvent) {
    var touches = nativeEvent.touches;
    if (!touches || touches.length === 0) {
      return true;
    }
    for (var i = 0; i < touches.length; i++) {
      var activeTouch = touches[i];
      var target = activeTouch.target;
      if (target !== null && target !== undefined && target !== 0) {
        var targetInst = EventPluginUtils.getInstanceFromNode(target);
        if (EventPluginUtils.isAncestor(responderInst, targetInst)) {
          return false;
        }
      }
    }
    return true;
  }
  var ResponderEventPlugin = {
    _getResponderID: function() {
      return responderInst ? responderInst._rootNodeID : null;
    },
    eventTypes: eventTypes,
    extractEvents: function(topLevelType, targetInst, nativeEvent, nativeEventTarget) {
      if (isStartish(topLevelType)) {
        trackedTouchCount += 1;
      } else if (isEndish(topLevelType)) {
        if (trackedTouchCount >= 0) {
          trackedTouchCount -= 1;
        } else {
          console.error('Ended a touch event which was not counted in `trackedTouchCount`.');
          return null;
        }
      }
      ResponderTouchHistoryStore.recordTouchTrack(topLevelType, nativeEvent);
      var extracted = canTriggerTransfer(topLevelType, targetInst, nativeEvent) ? setResponderAndExtractTransfer(topLevelType, targetInst, nativeEvent, nativeEventTarget) : null;
      var isResponderTouchStart = responderInst && isStartish(topLevelType);
      var isResponderTouchMove = responderInst && isMoveish(topLevelType);
      var isResponderTouchEnd = responderInst && isEndish(topLevelType);
      var incrementalTouch = isResponderTouchStart ? eventTypes.responderStart : isResponderTouchMove ? eventTypes.responderMove : isResponderTouchEnd ? eventTypes.responderEnd : null;
      if (incrementalTouch) {
        var gesture = ResponderSyntheticEvent.getPooled(incrementalTouch, responderInst, nativeEvent, nativeEventTarget);
        gesture.touchHistory = ResponderTouchHistoryStore.touchHistory;
        EventPropagators.accumulateDirectDispatches(gesture);
        extracted = accumulate(extracted, gesture);
      }
      var isResponderTerminate = responderInst && topLevelType === EventConstants.topLevelTypes.topTouchCancel;
      var isResponderRelease = responderInst && !isResponderTerminate && isEndish(topLevelType) && noResponderTouches(nativeEvent);
      var finalTouch = isResponderTerminate ? eventTypes.responderTerminate : isResponderRelease ? eventTypes.responderRelease : null;
      if (finalTouch) {
        var finalEvent = ResponderSyntheticEvent.getPooled(finalTouch, responderInst, nativeEvent, nativeEventTarget);
        finalEvent.touchHistory = ResponderTouchHistoryStore.touchHistory;
        EventPropagators.accumulateDirectDispatches(finalEvent);
        extracted = accumulate(extracted, finalEvent);
        changeResponder(null);
      }
      var numberActiveTouches = ResponderTouchHistoryStore.touchHistory.numberActiveTouches;
      if (ResponderEventPlugin.GlobalInteractionHandler && numberActiveTouches !== previousActiveTouches) {
        ResponderEventPlugin.GlobalInteractionHandler.onChange(numberActiveTouches);
      }
      previousActiveTouches = numberActiveTouches;
      return extracted;
    },
    GlobalResponderHandler: null,
    GlobalInteractionHandler: null,
    injection: {
      injectGlobalResponderHandler: function(GlobalResponderHandler) {
        ResponderEventPlugin.GlobalResponderHandler = GlobalResponderHandler;
      },
      injectGlobalInteractionHandler: function(GlobalInteractionHandler) {
        ResponderEventPlugin.GlobalInteractionHandler = GlobalInteractionHandler;
      }
    }
  };
  module.exports = ResponderEventPlugin;
})(require('process'));
