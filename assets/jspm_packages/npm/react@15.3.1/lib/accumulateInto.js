/* */ 
(function(process) {
  'use strict';
  var _prodInvariant = require('./reactProdInvariant');
  var invariant = require('fbjs/lib/invariant');
  function accumulateInto(current, next) {
    !(next != null) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'accumulateInto(...): Accumulated items must not be null or undefined.') : _prodInvariant('30') : void 0;
    if (current == null) {
      return next;
    }
    if (Array.isArray(current)) {
      if (Array.isArray(next)) {
        current.push.apply(current, next);
        return current;
      }
      current.push(next);
      return current;
    }
    if (Array.isArray(next)) {
      return [current].concat(next);
    }
    return [current, next];
  }
  module.exports = accumulateInto;
})(require('process'));
