/* */ 
(function(process) {
  'use strict';
  var _prodInvariant = require('./reactProdInvariant');
  var ReactChildren = require('./ReactChildren');
  var ReactElement = require('./ReactElement');
  var emptyFunction = require('fbjs/lib/emptyFunction');
  var invariant = require('fbjs/lib/invariant');
  var warning = require('fbjs/lib/warning');
  var numericPropertyRegex = /^\d+$/;
  var warnedAboutNumeric = false;
  var ReactFragment = {create: function(object) {
      if (typeof object !== 'object' || !object || Array.isArray(object)) {
        process.env.NODE_ENV !== 'production' ? warning(false, 'React.addons.createFragment only accepts a single object. Got: %s', object) : void 0;
        return object;
      }
      if (ReactElement.isValidElement(object)) {
        process.env.NODE_ENV !== 'production' ? warning(false, 'React.addons.createFragment does not accept a ReactElement ' + 'without a wrapper object.') : void 0;
        return object;
      }
      !(object.nodeType !== 1) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'React.addons.createFragment(...): Encountered an invalid child; DOM elements are not valid children of React components.') : _prodInvariant('0') : void 0;
      var result = [];
      for (var key in object) {
        if (process.env.NODE_ENV !== 'production') {
          if (!warnedAboutNumeric && numericPropertyRegex.test(key)) {
            process.env.NODE_ENV !== 'production' ? warning(false, 'React.addons.createFragment(...): Child objects should have ' + 'non-numeric keys so ordering is preserved.') : void 0;
            warnedAboutNumeric = true;
          }
        }
        ReactChildren.mapIntoWithKeyPrefixInternal(object[key], result, key, emptyFunction.thatReturnsArgument);
      }
      return result;
    }};
  module.exports = ReactFragment;
})(require('process'));
