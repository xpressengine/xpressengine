/* */ 
(function(process) {
  'use strict';
  var warning = require('fbjs/lib/warning');
  function warnNoop(publicInstance, callerName) {
    if (process.env.NODE_ENV !== 'production') {
      var constructor = publicInstance.constructor;
      process.env.NODE_ENV !== 'production' ? warning(false, '%s(...): Can only update a mounted or mounting component. ' + 'This usually means you called %s() on an unmounted component. ' + 'This is a no-op. Please check the code for the %s component.', callerName, callerName, constructor && (constructor.displayName || constructor.name) || 'ReactClass') : void 0;
    }
  }
  var ReactNoopUpdateQueue = {
    isMounted: function(publicInstance) {
      return false;
    },
    enqueueCallback: function(publicInstance, callback) {},
    enqueueForceUpdate: function(publicInstance) {
      warnNoop(publicInstance, 'forceUpdate');
    },
    enqueueReplaceState: function(publicInstance, completeState) {
      warnNoop(publicInstance, 'replaceState');
    },
    enqueueSetState: function(publicInstance, partialState) {
      warnNoop(publicInstance, 'setState');
    }
  };
  module.exports = ReactNoopUpdateQueue;
})(require('process'));
