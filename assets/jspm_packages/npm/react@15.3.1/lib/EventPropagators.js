/* */ 
(function(process) {
  'use strict';
  var EventConstants = require('./EventConstants');
  var EventPluginHub = require('./EventPluginHub');
  var EventPluginUtils = require('./EventPluginUtils');
  var accumulateInto = require('./accumulateInto');
  var forEachAccumulated = require('./forEachAccumulated');
  var warning = require('fbjs/lib/warning');
  var PropagationPhases = EventConstants.PropagationPhases;
  var getListener = EventPluginHub.getListener;
  function listenerAtPhase(inst, event, propagationPhase) {
    var registrationName = event.dispatchConfig.phasedRegistrationNames[propagationPhase];
    return getListener(inst, registrationName);
  }
  function accumulateDirectionalDispatches(inst, upwards, event) {
    if (process.env.NODE_ENV !== 'production') {
      process.env.NODE_ENV !== 'production' ? warning(inst, 'Dispatching inst must not be null') : void 0;
    }
    var phase = upwards ? PropagationPhases.bubbled : PropagationPhases.captured;
    var listener = listenerAtPhase(inst, event, phase);
    if (listener) {
      event._dispatchListeners = accumulateInto(event._dispatchListeners, listener);
      event._dispatchInstances = accumulateInto(event._dispatchInstances, inst);
    }
  }
  function accumulateTwoPhaseDispatchesSingle(event) {
    if (event && event.dispatchConfig.phasedRegistrationNames) {
      EventPluginUtils.traverseTwoPhase(event._targetInst, accumulateDirectionalDispatches, event);
    }
  }
  function accumulateTwoPhaseDispatchesSingleSkipTarget(event) {
    if (event && event.dispatchConfig.phasedRegistrationNames) {
      var targetInst = event._targetInst;
      var parentInst = targetInst ? EventPluginUtils.getParentInstance(targetInst) : null;
      EventPluginUtils.traverseTwoPhase(parentInst, accumulateDirectionalDispatches, event);
    }
  }
  function accumulateDispatches(inst, ignoredDirection, event) {
    if (event && event.dispatchConfig.registrationName) {
      var registrationName = event.dispatchConfig.registrationName;
      var listener = getListener(inst, registrationName);
      if (listener) {
        event._dispatchListeners = accumulateInto(event._dispatchListeners, listener);
        event._dispatchInstances = accumulateInto(event._dispatchInstances, inst);
      }
    }
  }
  function accumulateDirectDispatchesSingle(event) {
    if (event && event.dispatchConfig.registrationName) {
      accumulateDispatches(event._targetInst, null, event);
    }
  }
  function accumulateTwoPhaseDispatches(events) {
    forEachAccumulated(events, accumulateTwoPhaseDispatchesSingle);
  }
  function accumulateTwoPhaseDispatchesSkipTarget(events) {
    forEachAccumulated(events, accumulateTwoPhaseDispatchesSingleSkipTarget);
  }
  function accumulateEnterLeaveDispatches(leave, enter, from, to) {
    EventPluginUtils.traverseEnterLeave(from, to, accumulateDispatches, leave, enter);
  }
  function accumulateDirectDispatches(events) {
    forEachAccumulated(events, accumulateDirectDispatchesSingle);
  }
  var EventPropagators = {
    accumulateTwoPhaseDispatches: accumulateTwoPhaseDispatches,
    accumulateTwoPhaseDispatchesSkipTarget: accumulateTwoPhaseDispatchesSkipTarget,
    accumulateDirectDispatches: accumulateDirectDispatches,
    accumulateEnterLeaveDispatches: accumulateEnterLeaveDispatches
  };
  module.exports = EventPropagators;
})(require('process'));
