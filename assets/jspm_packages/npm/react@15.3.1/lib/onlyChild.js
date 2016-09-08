/* */ 
(function(process) {
  'use strict';
  var _prodInvariant = require('./reactProdInvariant');
  var ReactElement = require('./ReactElement');
  var invariant = require('fbjs/lib/invariant');
  function onlyChild(children) {
    !ReactElement.isValidElement(children) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'React.Children.only expected to receive a single React element child.') : _prodInvariant('143') : void 0;
    return children;
  }
  module.exports = onlyChild;
})(require('process'));
