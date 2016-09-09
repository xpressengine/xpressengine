/* */ 
(function(process) {
  'use strict';
  var _assign = require('object-assign');
  function _objectWithoutProperties(obj, keys) {
    var target = {};
    for (var i in obj) {
      if (keys.indexOf(i) >= 0)
        continue;
      if (!Object.prototype.hasOwnProperty.call(obj, i))
        continue;
      target[i] = obj[i];
    }
    return target;
  }
  var ReactComponentEnvironment = require('./ReactComponentEnvironment');
  var ReactDefaultBatchingStrategy = require('./ReactDefaultBatchingStrategy');
  var ReactEmptyComponent = require('./ReactEmptyComponent');
  var ReactMultiChild = require('./ReactMultiChild');
  var ReactHostComponent = require('./ReactHostComponent');
  var ReactTestMount = require('./ReactTestMount');
  var ReactTestReconcileTransaction = require('./ReactTestReconcileTransaction');
  var ReactUpdates = require('./ReactUpdates');
  var renderSubtreeIntoContainer = require('./renderSubtreeIntoContainer');
  function getRenderedHostOrTextFromComponent(component) {
    var rendered;
    while (rendered = component._renderedComponent) {
      component = rendered;
    }
    return component;
  }
  var ReactTestComponent = function(element) {
    this._currentElement = element;
    this._renderedChildren = null;
    this._topLevelWrapper = null;
  };
  ReactTestComponent.prototype.mountComponent = function(transaction, nativeParent, nativeContainerInfo, context) {
    var element = this._currentElement;
    this.mountChildren(element.props.children, transaction, context);
  };
  ReactTestComponent.prototype.receiveComponent = function(nextElement, transaction, context) {
    this._currentElement = nextElement;
    this.updateChildren(nextElement.props.children, transaction, context);
  };
  ReactTestComponent.prototype.getHostNode = function() {};
  ReactTestComponent.prototype.getPublicInstance = function() {
    return null;
  };
  ReactTestComponent.prototype.unmountComponent = function() {};
  ReactTestComponent.prototype.toJSON = function() {
    var _currentElement$props = this._currentElement.props;
    var children = _currentElement$props.children;
    var props = _objectWithoutProperties(_currentElement$props, ['children']);
    var childrenJSON = [];
    for (var key in this._renderedChildren) {
      var inst = this._renderedChildren[key];
      inst = getRenderedHostOrTextFromComponent(inst);
      var json = inst.toJSON();
      if (json !== undefined) {
        childrenJSON.push(json);
      }
    }
    var object = {
      type: this._currentElement.type,
      props: props,
      children: childrenJSON.length ? childrenJSON : null
    };
    Object.defineProperty(object, '$$typeof', {value: Symbol['for']('react.test.json')});
    return object;
  };
  _assign(ReactTestComponent.prototype, ReactMultiChild.Mixin);
  var ReactTestTextComponent = function(element) {
    this._currentElement = element;
  };
  ReactTestTextComponent.prototype.mountComponent = function() {};
  ReactTestTextComponent.prototype.receiveComponent = function(nextElement) {
    this._currentElement = nextElement;
  };
  ReactTestTextComponent.prototype.getHostNode = function() {};
  ReactTestTextComponent.prototype.unmountComponent = function() {};
  ReactTestTextComponent.prototype.toJSON = function() {
    return this._currentElement;
  };
  var ReactTestEmptyComponent = function(element) {
    this._currentElement = null;
  };
  ReactTestEmptyComponent.prototype.mountComponent = function() {};
  ReactTestEmptyComponent.prototype.receiveComponent = function() {};
  ReactTestEmptyComponent.prototype.getHostNode = function() {};
  ReactTestEmptyComponent.prototype.unmountComponent = function() {};
  ReactTestEmptyComponent.prototype.toJSON = function() {};
  ReactUpdates.injection.injectReconcileTransaction(ReactTestReconcileTransaction);
  ReactUpdates.injection.injectBatchingStrategy(ReactDefaultBatchingStrategy);
  ReactHostComponent.injection.injectGenericComponentClass(ReactTestComponent);
  ReactHostComponent.injection.injectTextComponentClass(ReactTestTextComponent);
  ReactEmptyComponent.injection.injectEmptyComponentFactory(function() {
    return new ReactTestEmptyComponent();
  });
  ReactComponentEnvironment.injection.injectEnvironment({
    processChildrenUpdates: function() {},
    replaceNodeWithMarkup: function() {}
  });
  var ReactTestRenderer = {
    create: ReactTestMount.render,
    unstable_batchedUpdates: ReactUpdates.batchedUpdates,
    unstable_renderSubtreeIntoContainer: renderSubtreeIntoContainer
  };
  module.exports = ReactTestRenderer;
})(require('process'));
