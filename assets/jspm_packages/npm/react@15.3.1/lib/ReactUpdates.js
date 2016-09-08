/* */ 
(function(process) {
  'use strict';
  var _prodInvariant = require('./reactProdInvariant'),
      _assign = require('object-assign');
  var CallbackQueue = require('./CallbackQueue');
  var PooledClass = require('./PooledClass');
  var ReactFeatureFlags = require('./ReactFeatureFlags');
  var ReactReconciler = require('./ReactReconciler');
  var Transaction = require('./Transaction');
  var invariant = require('fbjs/lib/invariant');
  var dirtyComponents = [];
  var updateBatchNumber = 0;
  var asapCallbackQueue = CallbackQueue.getPooled();
  var asapEnqueued = false;
  var batchingStrategy = null;
  function ensureInjected() {
    !(ReactUpdates.ReactReconcileTransaction && batchingStrategy) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'ReactUpdates: must inject a reconcile transaction class and batching strategy') : _prodInvariant('123') : void 0;
  }
  var NESTED_UPDATES = {
    initialize: function() {
      this.dirtyComponentsLength = dirtyComponents.length;
    },
    close: function() {
      if (this.dirtyComponentsLength !== dirtyComponents.length) {
        dirtyComponents.splice(0, this.dirtyComponentsLength);
        flushBatchedUpdates();
      } else {
        dirtyComponents.length = 0;
      }
    }
  };
  var UPDATE_QUEUEING = {
    initialize: function() {
      this.callbackQueue.reset();
    },
    close: function() {
      this.callbackQueue.notifyAll();
    }
  };
  var TRANSACTION_WRAPPERS = [NESTED_UPDATES, UPDATE_QUEUEING];
  function ReactUpdatesFlushTransaction() {
    this.reinitializeTransaction();
    this.dirtyComponentsLength = null;
    this.callbackQueue = CallbackQueue.getPooled();
    this.reconcileTransaction = ReactUpdates.ReactReconcileTransaction.getPooled(true);
  }
  _assign(ReactUpdatesFlushTransaction.prototype, Transaction.Mixin, {
    getTransactionWrappers: function() {
      return TRANSACTION_WRAPPERS;
    },
    destructor: function() {
      this.dirtyComponentsLength = null;
      CallbackQueue.release(this.callbackQueue);
      this.callbackQueue = null;
      ReactUpdates.ReactReconcileTransaction.release(this.reconcileTransaction);
      this.reconcileTransaction = null;
    },
    perform: function(method, scope, a) {
      return Transaction.Mixin.perform.call(this, this.reconcileTransaction.perform, this.reconcileTransaction, method, scope, a);
    }
  });
  PooledClass.addPoolingTo(ReactUpdatesFlushTransaction);
  function batchedUpdates(callback, a, b, c, d, e) {
    ensureInjected();
    batchingStrategy.batchedUpdates(callback, a, b, c, d, e);
  }
  function mountOrderComparator(c1, c2) {
    return c1._mountOrder - c2._mountOrder;
  }
  function runBatchedUpdates(transaction) {
    var len = transaction.dirtyComponentsLength;
    !(len === dirtyComponents.length) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'Expected flush transaction\'s stored dirty-components length (%s) to match dirty-components array length (%s).', len, dirtyComponents.length) : _prodInvariant('124', len, dirtyComponents.length) : void 0;
    dirtyComponents.sort(mountOrderComparator);
    updateBatchNumber++;
    for (var i = 0; i < len; i++) {
      var component = dirtyComponents[i];
      var callbacks = component._pendingCallbacks;
      component._pendingCallbacks = null;
      var markerName;
      if (ReactFeatureFlags.logTopLevelRenders) {
        var namedComponent = component;
        if (component._currentElement.props === component._renderedComponent._currentElement) {
          namedComponent = component._renderedComponent;
        }
        markerName = 'React update: ' + namedComponent.getName();
        console.time(markerName);
      }
      ReactReconciler.performUpdateIfNecessary(component, transaction.reconcileTransaction, updateBatchNumber);
      if (markerName) {
        console.timeEnd(markerName);
      }
      if (callbacks) {
        for (var j = 0; j < callbacks.length; j++) {
          transaction.callbackQueue.enqueue(callbacks[j], component.getPublicInstance());
        }
      }
    }
  }
  var flushBatchedUpdates = function() {
    while (dirtyComponents.length || asapEnqueued) {
      if (dirtyComponents.length) {
        var transaction = ReactUpdatesFlushTransaction.getPooled();
        transaction.perform(runBatchedUpdates, null, transaction);
        ReactUpdatesFlushTransaction.release(transaction);
      }
      if (asapEnqueued) {
        asapEnqueued = false;
        var queue = asapCallbackQueue;
        asapCallbackQueue = CallbackQueue.getPooled();
        queue.notifyAll();
        CallbackQueue.release(queue);
      }
    }
  };
  function enqueueUpdate(component) {
    ensureInjected();
    if (!batchingStrategy.isBatchingUpdates) {
      batchingStrategy.batchedUpdates(enqueueUpdate, component);
      return;
    }
    dirtyComponents.push(component);
    if (component._updateBatchNumber == null) {
      component._updateBatchNumber = updateBatchNumber + 1;
    }
  }
  function asap(callback, context) {
    !batchingStrategy.isBatchingUpdates ? process.env.NODE_ENV !== 'production' ? invariant(false, 'ReactUpdates.asap: Can\'t enqueue an asap callback in a context whereupdates are not being batched.') : _prodInvariant('125') : void 0;
    asapCallbackQueue.enqueue(callback, context);
    asapEnqueued = true;
  }
  var ReactUpdatesInjection = {
    injectReconcileTransaction: function(ReconcileTransaction) {
      !ReconcileTransaction ? process.env.NODE_ENV !== 'production' ? invariant(false, 'ReactUpdates: must provide a reconcile transaction class') : _prodInvariant('126') : void 0;
      ReactUpdates.ReactReconcileTransaction = ReconcileTransaction;
    },
    injectBatchingStrategy: function(_batchingStrategy) {
      !_batchingStrategy ? process.env.NODE_ENV !== 'production' ? invariant(false, 'ReactUpdates: must provide a batching strategy') : _prodInvariant('127') : void 0;
      !(typeof _batchingStrategy.batchedUpdates === 'function') ? process.env.NODE_ENV !== 'production' ? invariant(false, 'ReactUpdates: must provide a batchedUpdates() function') : _prodInvariant('128') : void 0;
      !(typeof _batchingStrategy.isBatchingUpdates === 'boolean') ? process.env.NODE_ENV !== 'production' ? invariant(false, 'ReactUpdates: must provide an isBatchingUpdates boolean attribute') : _prodInvariant('129') : void 0;
      batchingStrategy = _batchingStrategy;
    }
  };
  var ReactUpdates = {
    ReactReconcileTransaction: null,
    batchedUpdates: batchedUpdates,
    enqueueUpdate: enqueueUpdate,
    flushBatchedUpdates: flushBatchedUpdates,
    injection: ReactUpdatesInjection,
    asap: asap
  };
  module.exports = ReactUpdates;
})(require('process'));
