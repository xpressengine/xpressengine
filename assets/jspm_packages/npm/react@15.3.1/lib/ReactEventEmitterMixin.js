/* */ 
'use strict';
var EventPluginHub = require('./EventPluginHub');
function runEventQueueInBatch(events) {
  EventPluginHub.enqueueEvents(events);
  EventPluginHub.processEventQueue(false);
}
var ReactEventEmitterMixin = {handleTopLevel: function(topLevelType, targetInst, nativeEvent, nativeEventTarget) {
    var events = EventPluginHub.extractEvents(topLevelType, targetInst, nativeEvent, nativeEventTarget);
    runEventQueueInBatch(events);
  }};
module.exports = ReactEventEmitterMixin;
