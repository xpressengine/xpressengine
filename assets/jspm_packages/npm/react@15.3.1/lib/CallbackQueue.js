/* */ 
(function(process) {
  'use strict';
  var _prodInvariant = require('./reactProdInvariant'),
      _assign = require('object-assign');
  var PooledClass = require('./PooledClass');
  var invariant = require('fbjs/lib/invariant');
  function CallbackQueue() {
    this._callbacks = null;
    this._contexts = null;
  }
  _assign(CallbackQueue.prototype, {
    enqueue: function(callback, context) {
      this._callbacks = this._callbacks || [];
      this._contexts = this._contexts || [];
      this._callbacks.push(callback);
      this._contexts.push(context);
    },
    notifyAll: function() {
      var callbacks = this._callbacks;
      var contexts = this._contexts;
      if (callbacks) {
        !(callbacks.length === contexts.length) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'Mismatched list of contexts in callback queue') : _prodInvariant('24') : void 0;
        this._callbacks = null;
        this._contexts = null;
        for (var i = 0; i < callbacks.length; i++) {
          callbacks[i].call(contexts[i]);
        }
        callbacks.length = 0;
        contexts.length = 0;
      }
    },
    checkpoint: function() {
      return this._callbacks ? this._callbacks.length : 0;
    },
    rollback: function(len) {
      if (this._callbacks) {
        this._callbacks.length = len;
        this._contexts.length = len;
      }
    },
    reset: function() {
      this._callbacks = null;
      this._contexts = null;
    },
    destructor: function() {
      this.reset();
    }
  });
  PooledClass.addPoolingTo(CallbackQueue);
  module.exports = CallbackQueue;
})(require('process'));
