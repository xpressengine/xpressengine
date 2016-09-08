/* */ 
(function(process) {
  'use strict';
  var _prodInvariant = require('./reactProdInvariant'),
      _assign = require('object-assign');
  var invariant = require('fbjs/lib/invariant');
  var genericComponentClass = null;
  var tagToComponentClass = {};
  var textComponentClass = null;
  var ReactHostComponentInjection = {
    injectGenericComponentClass: function(componentClass) {
      genericComponentClass = componentClass;
    },
    injectTextComponentClass: function(componentClass) {
      textComponentClass = componentClass;
    },
    injectComponentClasses: function(componentClasses) {
      _assign(tagToComponentClass, componentClasses);
    }
  };
  function createInternalComponent(element) {
    !genericComponentClass ? process.env.NODE_ENV !== 'production' ? invariant(false, 'There is no registered component for the tag %s', element.type) : _prodInvariant('111', element.type) : void 0;
    return new genericComponentClass(element);
  }
  function createInstanceForText(text) {
    return new textComponentClass(text);
  }
  function isTextComponent(component) {
    return component instanceof textComponentClass;
  }
  var ReactHostComponent = {
    createInternalComponent: createInternalComponent,
    createInstanceForText: createInstanceForText,
    isTextComponent: isTextComponent,
    injection: ReactHostComponentInjection
  };
  module.exports = ReactHostComponent;
})(require('process'));
