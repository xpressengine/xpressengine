/* */ 
(function(process) {
  'use strict';
  var _prodInvariant = require('./reactProdInvariant');
  var EventPluginRegistry = require('./EventPluginRegistry');
  var EventPluginUtils = require('./EventPluginUtils');
  var ReactErrorUtils = require('./ReactErrorUtils');
  var accumulateInto = require('./accumulateInto');
  var forEachAccumulated = require('./forEachAccumulated');
  var invariant = require('fbjs/lib/invariant');
  var listenerBank = {};
  var eventQueue = null;
  var executeDispatchesAndRelease = function(event, simulated) {
    if (event) {
      EventPluginUtils.executeDispatchesInOrder(event, simulated);
      if (!event.isPersistent()) {
        event.constructor.release(event);
      }
    }
  };
  var executeDispatchesAndReleaseSimulated = function(e) {
    return executeDispatchesAndRelease(e, true);
  };
  var executeDispatchesAndReleaseTopLevel = function(e) {
    return executeDispatchesAndRelease(e, false);
  };
  var getDictionaryKey = function(inst) {
    return '.' + inst._rootNodeID;
  };
  var EventPluginHub = {
    injection: {
      injectEventPluginOrder: EventPluginRegistry.injectEventPluginOrder,
      injectEventPluginsByName: EventPluginRegistry.injectEventPluginsByName
    },
    putListener: function(inst, registrationName, listener) {
      !(typeof listener === 'function') ? process.env.NODE_ENV !== 'production' ? invariant(false, 'Expected %s listener to be a function, instead got type %s', registrationName, typeof listener) : _prodInvariant('94', registrationName, typeof listener) : void 0;
      var key = getDictionaryKey(inst);
      var bankForRegistrationName = listenerBank[registrationName] || (listenerBank[registrationName] = {});
      bankForRegistrationName[key] = listener;
      var PluginModule = EventPluginRegistry.registrationNameModules[registrationName];
      if (PluginModule && PluginModule.didPutListener) {
        PluginModule.didPutListener(inst, registrationName, listener);
      }
    },
    getListener: function(inst, registrationName) {
      var bankForRegistrationName = listenerBank[registrationName];
      var key = getDictionaryKey(inst);
      return bankForRegistrationName && bankForRegistrationName[key];
    },
    deleteListener: function(inst, registrationName) {
      var PluginModule = EventPluginRegistry.registrationNameModules[registrationName];
      if (PluginModule && PluginModule.willDeleteListener) {
        PluginModule.willDeleteListener(inst, registrationName);
      }
      var bankForRegistrationName = listenerBank[registrationName];
      if (bankForRegistrationName) {
        var key = getDictionaryKey(inst);
        delete bankForRegistrationName[key];
      }
    },
    deleteAllListeners: function(inst) {
      var key = getDictionaryKey(inst);
      for (var registrationName in listenerBank) {
        if (!listenerBank.hasOwnProperty(registrationName)) {
          continue;
        }
        if (!listenerBank[registrationName][key]) {
          continue;
        }
        var PluginModule = EventPluginRegistry.registrationNameModules[registrationName];
        if (PluginModule && PluginModule.willDeleteListener) {
          PluginModule.willDeleteListener(inst, registrationName);
        }
        delete listenerBank[registrationName][key];
      }
    },
    extractEvents: function(topLevelType, targetInst, nativeEvent, nativeEventTarget) {
      var events;
      var plugins = EventPluginRegistry.plugins;
      for (var i = 0; i < plugins.length; i++) {
        var possiblePlugin = plugins[i];
        if (possiblePlugin) {
          var extractedEvents = possiblePlugin.extractEvents(topLevelType, targetInst, nativeEvent, nativeEventTarget);
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
    processEventQueue: function(simulated) {
      var processingEventQueue = eventQueue;
      eventQueue = null;
      if (simulated) {
        forEachAccumulated(processingEventQueue, executeDispatchesAndReleaseSimulated);
      } else {
        forEachAccumulated(processingEventQueue, executeDispatchesAndReleaseTopLevel);
      }
      !!eventQueue ? process.env.NODE_ENV !== 'production' ? invariant(false, 'processEventQueue(): Additional events were enqueued while processing an event queue. Support for this has not yet been implemented.') : _prodInvariant('95') : void 0;
      ReactErrorUtils.rethrowCaughtError();
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
