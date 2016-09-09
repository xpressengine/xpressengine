/* */ 
(function(process) {
  'use strict';
  function _classCallCheck(instance, Constructor) {
    if (!(instance instanceof Constructor)) {
      throw new TypeError("Cannot call a class as a function");
    }
  }
  var ReactUpdateQueue = require('./ReactUpdateQueue');
  var Transaction = require('./Transaction');
  var warning = require('fbjs/lib/warning');
  function warnNoop(publicInstance, callerName) {
    if (process.env.NODE_ENV !== 'production') {
      var constructor = publicInstance.constructor;
      process.env.NODE_ENV !== 'production' ? warning(false, '%s(...): Can only update a mounting component. ' + 'This usually means you called %s() outside componentWillMount() on the server. ' + 'This is a no-op. Please check the code for the %s component.', callerName, callerName, constructor && (constructor.displayName || constructor.name) || 'ReactClass') : void 0;
    }
  }
  var ReactServerUpdateQueue = function() {
    function ReactServerUpdateQueue(transaction) {
      _classCallCheck(this, ReactServerUpdateQueue);
      this.transaction = transaction;
    }
    ReactServerUpdateQueue.prototype.isMounted = function isMounted(publicInstance) {
      return false;
    };
    ReactServerUpdateQueue.prototype.enqueueCallback = function enqueueCallback(publicInstance, callback, callerName) {
      if (this.transaction.isInTransaction()) {
        ReactUpdateQueue.enqueueCallback(publicInstance, callback, callerName);
      }
    };
    ReactServerUpdateQueue.prototype.enqueueForceUpdate = function enqueueForceUpdate(publicInstance) {
      if (this.transaction.isInTransaction()) {
        ReactUpdateQueue.enqueueForceUpdate(publicInstance);
      } else {
        warnNoop(publicInstance, 'forceUpdate');
      }
    };
    ReactServerUpdateQueue.prototype.enqueueReplaceState = function enqueueReplaceState(publicInstance, completeState) {
      if (this.transaction.isInTransaction()) {
        ReactUpdateQueue.enqueueReplaceState(publicInstance, completeState);
      } else {
        warnNoop(publicInstance, 'replaceState');
      }
    };
    ReactServerUpdateQueue.prototype.enqueueSetState = function enqueueSetState(publicInstance, partialState) {
      if (this.transaction.isInTransaction()) {
        ReactUpdateQueue.enqueueSetState(publicInstance, partialState);
      } else {
        warnNoop(publicInstance, 'setState');
      }
    };
    return ReactServerUpdateQueue;
  }();
  module.exports = ReactServerUpdateQueue;
})(require('process'));
