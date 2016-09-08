/* */ 
(function(process) {
  'use strict';
  var EventConstants = require('EventConstants');
  var EventPluginUtils = require('EventPluginUtils');
  var EventPropagators = require('EventPropagators');
  var SyntheticEvent = require('SyntheticEvent');
  var accumulateInto = require('accumulateInto');
  var keyOf = require('keyOf');
  var isStartish = EventPluginUtils.isStartish;
  var isMoveish = EventPluginUtils.isMoveish;
  var isEndish = EventPluginUtils.isEndish;
  var executeDirectDispatch = EventPluginUtils.executeDirectDispatch;
  var hasDispatches = EventPluginUtils.hasDispatches;
  var executeDispatchesInOrderStopAtTrue = EventPluginUtils.executeDispatchesInOrderStopAtTrue;
  var responderID = null;
  var isPressing = false;
  var eventTypes = {
    startShouldSetResponder: {phasedRegistrationNames: {
        bubbled: keyOf({onStartShouldSetResponder: null}),
        captured: keyOf({onStartShouldSetResponderCapture: null})
      }},
    scrollShouldSetResponder: {phasedRegistrationNames: {
        bubbled: keyOf({onScrollShouldSetResponder: null}),
        captured: keyOf({onScrollShouldSetResponderCapture: null})
      }},
    moveShouldSetResponder: {phasedRegistrationNames: {
        bubbled: keyOf({onMoveShouldSetResponder: null}),
        captured: keyOf({onMoveShouldSetResponderCapture: null})
      }},
    responderMove: {registrationName: keyOf({onResponderMove: null})},
    responderRelease: {registrationName: keyOf({onResponderRelease: null})},
    responderTerminationRequest: {registrationName: keyOf({onResponderTerminationRequest: null})},
    responderGrant: {registrationName: keyOf({onResponderGrant: null})},
    responderReject: {registrationName: keyOf({onResponderReject: null})},
    responderTerminate: {registrationName: keyOf({onResponderTerminate: null})}
  };
  function setResponderAndExtractTransfer(topLevelType, topLevelTargetID, nativeEvent) {
    var shouldSetEventType = isStartish(topLevelType) ? eventTypes.startShouldSetResponder : isMoveish(topLevelType) ? eventTypes.moveShouldSetResponder : eventTypes.scrollShouldSetResponder;
    var bubbleShouldSetFrom = responderID || topLevelTargetID;
    var shouldSetEvent = SyntheticEvent.getPooled(shouldSetEventType, bubbleShouldSetFrom, nativeEvent);
    EventPropagators.accumulateTwoPhaseDispatches(shouldSetEvent);
    var wantsResponderID = executeDispatchesInOrderStopAtTrue(shouldSetEvent);
    if (!shouldSetEvent.isPersistent()) {
      shouldSetEvent.constructor.release(shouldSetEvent);
    }
    if (!wantsResponderID || wantsResponderID === responderID) {
      return null;
    }
    var extracted;
    var grantEvent = SyntheticEvent.getPooled(eventTypes.responderGrant, wantsResponderID, nativeEvent);
    EventPropagators.accumulateDirectDispatches(grantEvent);
    if (responderID) {
      var terminationRequestEvent = SyntheticEvent.getPooled(eventTypes.responderTerminationRequest, responderID, nativeEvent);
      EventPropagators.accumulateDirectDispatches(terminationRequestEvent);
      var shouldSwitch = !hasDispatches(terminationRequestEvent) || executeDirectDispatch(terminationRequestEvent);
      if (!terminationRequestEvent.isPersistent()) {
        terminationRequestEvent.constructor.release(terminationRequestEvent);
      }
      if (shouldSwitch) {
        var terminateType = eventTypes.responderTerminate;
        var terminateEvent = SyntheticEvent.getPooled(terminateType, responderID, nativeEvent);
        EventPropagators.accumulateDirectDispatches(terminateEvent);
        extracted = accumulateInto(extracted, [grantEvent, terminateEvent]);
        responderID = wantsResponderID;
      } else {
        var rejectEvent = SyntheticEvent.getPooled(eventTypes.responderReject, wantsResponderID, nativeEvent);
        EventPropagators.accumulateDirectDispatches(rejectEvent);
        extracted = accumulateInto(extracted, rejectEvent);
      }
    } else {
      extracted = accumulateInto(extracted, grantEvent);
      responderID = wantsResponderID;
    }
    return extracted;
  }
  function canTriggerTransfer(topLevelType) {
    return topLevelType === EventConstants.topLevelTypes.topScroll || isStartish(topLevelType) || (isPressing && isMoveish(topLevelType));
  }
  var ResponderEventPlugin = {
    getResponderID: function() {
      return responderID;
    },
    eventTypes: eventTypes,
    extractEvents: function(topLevelType, topLevelTarget, topLevelTargetID, nativeEvent) {
      var extracted;
      if (responderID && isStartish(topLevelType)) {
        responderID = null;
      }
      if (isStartish(topLevelType)) {
        isPressing = true;
      } else if (isEndish(topLevelType)) {
        isPressing = false;
      }
      if (canTriggerTransfer(topLevelType)) {
        var transfer = setResponderAndExtractTransfer(topLevelType, topLevelTargetID, nativeEvent);
        if (transfer) {
          extracted = accumulateInto(extracted, transfer);
        }
      }
      var type = isMoveish(topLevelType) ? eventTypes.responderMove : isEndish(topLevelType) ? eventTypes.responderRelease : isStartish(topLevelType) ? eventTypes.responderStart : null;
      if (type) {
        var gesture = SyntheticEvent.getPooled(type, responderID || '', nativeEvent);
        EventPropagators.accumulateDirectDispatches(gesture);
        extracted = accumulateInto(extracted, gesture);
      }
      if (type === eventTypes.responderRelease) {
        responderID = null;
      }
      return extracted;
    }
  };
  module.exports = ResponderEventPlugin;
})(require('process'));
