/* */ 
(function(process) {
  'use strict';
  var _assign = require('object-assign');
  var CallbackQueue = require('./CallbackQueue');
  var PooledClass = require('./PooledClass');
  var Transaction = require('./Transaction');
  var ReactInstrumentation = require('./ReactInstrumentation');
  var ReactUpdateQueue = require('./ReactUpdateQueue');
  var ON_DOM_READY_QUEUEING = {
    initialize: function() {
      this.reactMountReady.reset();
    },
    close: function() {
      this.reactMountReady.notifyAll();
    }
  };
  var TRANSACTION_WRAPPERS = [ON_DOM_READY_QUEUEING];
  if (process.env.NODE_ENV !== 'production') {
    TRANSACTION_WRAPPERS.push({
      initialize: ReactInstrumentation.debugTool.onBeginFlush,
      close: ReactInstrumentation.debugTool.onEndFlush
    });
  }
  function ReactNativeReconcileTransaction() {
    this.reinitializeTransaction();
    this.reactMountReady = CallbackQueue.getPooled(null);
  }
  var Mixin = {
    getTransactionWrappers: function() {
      return TRANSACTION_WRAPPERS;
    },
    getReactMountReady: function() {
      return this.reactMountReady;
    },
    getUpdateQueue: function() {
      return ReactUpdateQueue;
    },
    destructor: function() {
      CallbackQueue.release(this.reactMountReady);
      this.reactMountReady = null;
    }
  };
  _assign(ReactNativeReconcileTransaction.prototype, Transaction.Mixin, ReactNativeReconcileTransaction, Mixin);
  PooledClass.addPoolingTo(ReactNativeReconcileTransaction);
  module.exports = ReactNativeReconcileTransaction;
})(require('process'));
