/* */ 
(function(process) {
  'use strict';
  var _assign = require('object-assign');
  var PooledClass = require('./PooledClass');
  var Transaction = require('./Transaction');
  var ReactInstrumentation = require('./ReactInstrumentation');
  var ReactServerUpdateQueue = require('./ReactServerUpdateQueue');
  var TRANSACTION_WRAPPERS = [];
  if (process.env.NODE_ENV !== 'production') {
    TRANSACTION_WRAPPERS.push({
      initialize: ReactInstrumentation.debugTool.onBeginFlush,
      close: ReactInstrumentation.debugTool.onEndFlush
    });
  }
  var noopCallbackQueue = {enqueue: function() {}};
  function ReactServerRenderingTransaction(renderToStaticMarkup) {
    this.reinitializeTransaction();
    this.renderToStaticMarkup = renderToStaticMarkup;
    this.useCreateElement = false;
    this.updateQueue = new ReactServerUpdateQueue(this);
  }
  var Mixin = {
    getTransactionWrappers: function() {
      return TRANSACTION_WRAPPERS;
    },
    getReactMountReady: function() {
      return noopCallbackQueue;
    },
    getUpdateQueue: function() {
      return this.updateQueue;
    },
    destructor: function() {},
    checkpoint: function() {},
    rollback: function() {}
  };
  _assign(ReactServerRenderingTransaction.prototype, Transaction.Mixin, Mixin);
  PooledClass.addPoolingTo(ReactServerRenderingTransaction);
  module.exports = ReactServerRenderingTransaction;
})(require('process'));
