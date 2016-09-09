/* */ 
(function(process) {
  'use strict';
  var flattenChildren = require('./flattenChildren');
  var ReactTransitionChildMapping = {
    getChildMapping: function(children, selfDebugID) {
      if (!children) {
        return children;
      }
      if (process.env.NODE_ENV !== 'production') {
        return flattenChildren(children, selfDebugID);
      }
      return flattenChildren(children);
    },
    mergeChildMappings: function(prev, next) {
      prev = prev || {};
      next = next || {};
      function getValueForKey(key) {
        if (next.hasOwnProperty(key)) {
          return next[key];
        } else {
          return prev[key];
        }
      }
      var nextKeysPending = {};
      var pendingKeys = [];
      for (var prevKey in prev) {
        if (next.hasOwnProperty(prevKey)) {
          if (pendingKeys.length) {
            nextKeysPending[prevKey] = pendingKeys;
            pendingKeys = [];
          }
        } else {
          pendingKeys.push(prevKey);
        }
      }
      var i;
      var childMapping = {};
      for (var nextKey in next) {
        if (nextKeysPending.hasOwnProperty(nextKey)) {
          for (i = 0; i < nextKeysPending[nextKey].length; i++) {
            var pendingNextKey = nextKeysPending[nextKey][i];
            childMapping[nextKeysPending[nextKey][i]] = getValueForKey(pendingNextKey);
          }
        }
        childMapping[nextKey] = getValueForKey(nextKey);
      }
      for (i = 0; i < pendingKeys.length; i++) {
        childMapping[pendingKeys[i]] = getValueForKey(pendingKeys[i]);
      }
      return childMapping;
    }
  };
  module.exports = ReactTransitionChildMapping;
})(require('process'));
