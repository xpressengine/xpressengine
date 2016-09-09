/* */ 
(function(process) {
  'use strict';
  var _prodInvariant = require('./reactProdInvariant');
  var invariant = require('fbjs/lib/invariant');
  var injected = false;
  var ReactComponentEnvironment = {
    replaceNodeWithMarkup: null,
    processChildrenUpdates: null,
    injection: {injectEnvironment: function(environment) {
        !!injected ? process.env.NODE_ENV !== 'production' ? invariant(false, 'ReactCompositeComponent: injectEnvironment() can only be called once.') : _prodInvariant('104') : void 0;
        ReactComponentEnvironment.replaceNodeWithMarkup = environment.replaceNodeWithMarkup;
        ReactComponentEnvironment.processChildrenUpdates = environment.processChildrenUpdates;
        injected = true;
      }}
  };
  module.exports = ReactComponentEnvironment;
})(require('process'));
