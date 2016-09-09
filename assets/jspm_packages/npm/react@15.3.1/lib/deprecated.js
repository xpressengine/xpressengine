/* */ 
(function(process) {
  'use strict';
  var _assign = require('object-assign');
  var warning = require('fbjs/lib/warning');
  function deprecated(fnName, newModule, newPackage, ctx, fn) {
    var warned = false;
    if (process.env.NODE_ENV !== 'production') {
      var newFn = function() {
        process.env.NODE_ENV !== 'production' ? warning(warned, 'React.%s is deprecated. Please use %s.%s from require' + '(\'%s\') ' + 'instead.', fnName, newModule, fnName, newPackage) : void 0;
        warned = true;
        return fn.apply(ctx, arguments);
      };
      _assign(newFn, fn);
      return newFn;
    }
    return fn;
  }
  module.exports = deprecated;
})(require('process'));
