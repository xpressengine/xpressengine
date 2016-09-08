/* */ 
(function(process) {
  'use strict';
  var _prodInvariant = require('./reactProdInvariant');
  var ReactElement = require('./ReactElement');
  var invariant = require('fbjs/lib/invariant');
  var ReactNodeTypes = {
    HOST: 0,
    COMPOSITE: 1,
    EMPTY: 2,
    getType: function(node) {
      if (node === null || node === false) {
        return ReactNodeTypes.EMPTY;
      } else if (ReactElement.isValidElement(node)) {
        if (typeof node.type === 'function') {
          return ReactNodeTypes.COMPOSITE;
        } else {
          return ReactNodeTypes.HOST;
        }
      }
      !false ? process.env.NODE_ENV !== 'production' ? invariant(false, 'Unexpected node: %s', node) : _prodInvariant('26', node) : void 0;
    }
  };
  module.exports = ReactNodeTypes;
})(require('process'));
