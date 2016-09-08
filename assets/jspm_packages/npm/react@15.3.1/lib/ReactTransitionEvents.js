/* */ 
'use strict';
var ExecutionEnvironment = require('fbjs/lib/ExecutionEnvironment');
var getVendorPrefixedEventName = require('./getVendorPrefixedEventName');
var endEvents = [];
function detectEvents() {
  var animEnd = getVendorPrefixedEventName('animationend');
  var transEnd = getVendorPrefixedEventName('transitionend');
  if (animEnd) {
    endEvents.push(animEnd);
  }
  if (transEnd) {
    endEvents.push(transEnd);
  }
}
if (ExecutionEnvironment.canUseDOM) {
  detectEvents();
}
function addEventListener(node, eventName, eventListener) {
  node.addEventListener(eventName, eventListener, false);
}
function removeEventListener(node, eventName, eventListener) {
  node.removeEventListener(eventName, eventListener, false);
}
var ReactTransitionEvents = {
  addEndEventListener: function(node, eventListener) {
    if (endEvents.length === 0) {
      window.setTimeout(eventListener, 0);
      return;
    }
    endEvents.forEach(function(endEvent) {
      addEventListener(node, endEvent, eventListener);
    });
  },
  removeEndEventListener: function(node, eventListener) {
    if (endEvents.length === 0) {
      return;
    }
    endEvents.forEach(function(endEvent) {
      removeEventListener(node, endEvent, eventListener);
    });
  }
};
module.exports = ReactTransitionEvents;
