/* */ 
(function(process) {
  'use strict';
  var _prodInvariant = require('./reactProdInvariant'),
      _assign = require('object-assign');
  var ReactCompositeComponent = require('./ReactCompositeComponent');
  var ReactEmptyComponent = require('./ReactEmptyComponent');
  var ReactHostComponent = require('./ReactHostComponent');
  var invariant = require('fbjs/lib/invariant');
  var warning = require('fbjs/lib/warning');
  var ReactCompositeComponentWrapper = function(element) {
    this.construct(element);
  };
  _assign(ReactCompositeComponentWrapper.prototype, ReactCompositeComponent.Mixin, {_instantiateReactComponent: instantiateReactComponent});
  function getDeclarationErrorAddendum(owner) {
    if (owner) {
      var name = owner.getName();
      if (name) {
        return ' Check the render method of `' + name + '`.';
      }
    }
    return '';
  }
  function isInternalComponentType(type) {
    return typeof type === 'function' && typeof type.prototype !== 'undefined' && typeof type.prototype.mountComponent === 'function' && typeof type.prototype.receiveComponent === 'function';
  }
  var nextDebugID = 1;
  function instantiateReactComponent(node, shouldHaveDebugID) {
    var instance;
    if (node === null || node === false) {
      instance = ReactEmptyComponent.create(instantiateReactComponent);
    } else if (typeof node === 'object') {
      var element = node;
      !(element && (typeof element.type === 'function' || typeof element.type === 'string')) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'Element type is invalid: expected a string (for built-in components) or a class/function (for composite components) but got: %s.%s', element.type == null ? element.type : typeof element.type, getDeclarationErrorAddendum(element._owner)) : _prodInvariant('130', element.type == null ? element.type : typeof element.type, getDeclarationErrorAddendum(element._owner)) : void 0;
      if (typeof element.type === 'string') {
        instance = ReactHostComponent.createInternalComponent(element);
      } else if (isInternalComponentType(element.type)) {
        instance = new element.type(element);
        if (!instance.getHostNode) {
          instance.getHostNode = instance.getNativeNode;
        }
      } else {
        instance = new ReactCompositeComponentWrapper(element);
      }
    } else if (typeof node === 'string' || typeof node === 'number') {
      instance = ReactHostComponent.createInstanceForText(node);
    } else {
      !false ? process.env.NODE_ENV !== 'production' ? invariant(false, 'Encountered invalid React node of type %s', typeof node) : _prodInvariant('131', typeof node) : void 0;
    }
    if (process.env.NODE_ENV !== 'production') {
      process.env.NODE_ENV !== 'production' ? warning(typeof instance.mountComponent === 'function' && typeof instance.receiveComponent === 'function' && typeof instance.getHostNode === 'function' && typeof instance.unmountComponent === 'function', 'Only React Components can be mounted.') : void 0;
    }
    instance._mountIndex = 0;
    instance._mountImage = null;
    if (process.env.NODE_ENV !== 'production') {
      instance._debugID = shouldHaveDebugID ? nextDebugID++ : 0;
    }
    if (process.env.NODE_ENV !== 'production') {
      if (Object.preventExtensions) {
        Object.preventExtensions(instance);
      }
    }
    return instance;
  }
  module.exports = instantiateReactComponent;
})(require('process'));
