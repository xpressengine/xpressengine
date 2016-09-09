/* */ 
(function(process) {
  'use strict';
  var invariant = require('invariant');
  var injected = false;
  var ReactComponentEnvironment = {
    unmountIDFromEnvironment: null,
    replaceNodeWithMarkupByID: null,
    processChildrenUpdates: null,
    injection: {injectEnvironment: function(environment) {
        invariant(!injected, 'ReactCompositeComponent: injectEnvironment() can only be called once.');
        ReactComponentEnvironment.unmountIDFromEnvironment = environment.unmountIDFromEnvironment;
        ReactComponentEnvironment.replaceNodeWithMarkupByID = environment.replaceNodeWithMarkupByID;
        ReactComponentEnvironment.processChildrenUpdates = environment.processChildrenUpdates;
        injected = true;
      }}
  };
  module.exports = ReactComponentEnvironment;
})(require('process'));
