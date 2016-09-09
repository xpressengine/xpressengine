/* */ 
(function(process) {
  'use strict';
  var EventPluginRegistry = require('EventPluginRegistry');
  var EventPluginUtils = require('EventPluginUtils');
  var accumulateInto = require('accumulateInto');
  var forEachAccumulated = require('forEachAccumulated');
  var invariant = require('invariant');
  var listenerBank = {};
  var eventQueue = null;
  var executeDispatchesAndRelease = function(event) {
    if (event) {
      var executeDispatch = EventPluginUtils.executeDispatch;
      var PluginModule = EventPluginRegistry.getPluginModuleForEvent(event);
      if (PluginModule && PluginModule.executeDispatch) {
        executeDispatch = PluginModule.executeDispatch;
      }
      EventPluginUtils.executeDispatchesInOrder(event, executeDispatch);
      if (!event.isPersistent()) {
        event.constructor.release(event);
      }
    }
  };
  var InstanceHandle = null;
  function validateInstanceHandle() {
    var valid = InstanceHandle && InstanceHandle.traverseTwoPhase && InstanceHandle.traverseEnterLeave;
    invariant(valid, 'InstanceHandle not injected before use!');
  }
  var EventPluginHub = {
    injection: {
      injectMount: EventPluginUtils.injection.injectMount,
      injectInstanceHandle: function(InjectedInstanceHandle) {
        InstanceHandle = InjectedInstanceHandle;
        if (__DEV__) {
          validateInstanceHandle();
        }
      },
      getInstanceHandle: function() {
        if (__DEV__) {
          validateInstanceHandle();
        }
        return InstanceHandle;
      },
      injectEventPluginOrder: EventPluginRegistry.injectEventPluginOrder,
      injectEventPluginsByName: EventPluginRegistry.injectEventPluginsByName
    },
    eventNameDispatchConfigs: EventPluginRegistry.eventNameDispatchConfigs,
    registrationNameModules: EventPluginRegistry.registrationNameModules,
    putListener: function(id, registrationName, listener) {
      invariant(!listener || typeof listener === 'function', 'Expected %s listener to be a function, instead got type %s', registrationName, typeof listener);
      var bankForRegistrationName = listenerBank[registrationName] || (listenerBank[registrationName] = {});
      bankForRegistrationName[id] = listener;
    },
    getListener: function(id, registrationName) {
      var bankForRegistrationName = listenerBank[registrationName];
      return bankForRegistrationName && bankForRegistrationName[id];
    },
    deleteListener: function(id, registrationName) {
      var bankForRegistrationName = listenerBank[registrationName];
      if (bankForRegistrationName) {
        delete bankForRegistrationName[id];
      }
    },
    deleteAllListeners: function(id) {
      for (var registrationName in listenerBank) {
        delete listenerBank[registrationName][id];
      }
    },
    extractEvents: function(topLevelType, topLevelTarget, topLevelTargetID, nativeEvent) {
      var events;
      var plugins = EventPluginRegistry.plugins;
      for (var i = 0,
          l = plugins.length; i < l; i++) {
        var possiblePlugin = plugins[i];
        if (possiblePlugin) {
          var extractedEvents = possiblePlugin.extractEvents(topLevelType, topLevelTarget, topLevelTargetID, nativeEvent);
          if (extractedEvents) {
            events = accumulateInto(events, extractedEvents);
          }
        }
      }
      return events;
    },
    enqueueEvents: function(events) {
      if (events) {
        eventQueue = accumulateInto(eventQueue, events);
      }
    },
    processEventQueue: function() {
      var processingEventQueue = eventQueue;
      eventQueue = null;
      forEachAccumulated(processingEventQueue, executeDispatchesAndRelease);
      invariant(!eventQueue, 'processEventQueue(): Additional events were enqueued while processing ' + 'an event queue. Support for this has not yet been implemented.');
    },
    __purge: function() {
      listenerBank = {};
    },
    __getListenerBank: function() {
      return listenerBank;
    }
  };
  module.exports = EventPluginHub;
})(require('process'));
