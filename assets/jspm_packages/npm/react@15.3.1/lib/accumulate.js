/* */ 
(function(process) {
  'use strict';
  var _prodInvariant = require('./reactProdInvariant');
  var invariant = require('fbjs/lib/invariant');
  function accumulate(current, next) {
    !(next != null) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'accumulate(...): Accumulated items must be not be null or undefined.') : _prodInvariant('29') : void 0;
    if (current == null) {
      return next;
    }
    if (Array.isArray(current)) {
      return current.concat(next);
    }
    if (Array.isArray(next)) {
      return [current].concat(next);
    }
    return [current, next];
  }
  module.exports = accumulate;
})(require('process'));
