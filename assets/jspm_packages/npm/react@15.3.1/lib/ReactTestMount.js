/* */ 
(function(process) {
  'use strict';
  var _prodInvariant = require('./reactProdInvariant');
  var ReactElement = require('./ReactElement');
  var ReactReconciler = require('./ReactReconciler');
  var ReactUpdates = require('./ReactUpdates');
  var emptyObject = require('fbjs/lib/emptyObject');
  var getHostComponentFromComposite = require('./getHostComponentFromComposite');
  var instantiateReactComponent = require('./instantiateReactComponent');
  var invariant = require('fbjs/lib/invariant');
  var TopLevelWrapper = function() {};
  TopLevelWrapper.prototype.isReactComponent = {};
  if (process.env.NODE_ENV !== 'production') {
    TopLevelWrapper.displayName = 'TopLevelWrapper';
  }
  TopLevelWrapper.prototype.render = function() {
    return this.props;
  };
  function mountComponentIntoNode(componentInstance, transaction) {
    var image = ReactReconciler.mountComponent(componentInstance, transaction, null, null, emptyObject);
    componentInstance._renderedComponent._topLevelWrapper = componentInstance;
    return image;
  }
  function batchedMountComponentIntoNode(componentInstance) {
    var transaction = ReactUpdates.ReactReconcileTransaction.getPooled();
    var image = transaction.perform(mountComponentIntoNode, null, componentInstance, transaction);
    ReactUpdates.ReactReconcileTransaction.release(transaction);
    return image;
  }
  var ReactTestInstance = function(component) {
    this._component = component;
  };
  ReactTestInstance.prototype.getInstance = function() {
    return this._component._renderedComponent.getPublicInstance();
  };
  ReactTestInstance.prototype.update = function(nextElement) {
    !this._component ? process.env.NODE_ENV !== 'production' ? invariant(false, 'ReactTestRenderer: .update() can\'t be called after unmount.') : _prodInvariant('139') : void 0;
    var nextWrappedElement = new ReactElement(TopLevelWrapper, null, null, null, null, null, nextElement);
    var component = this._component;
    ReactUpdates.batchedUpdates(function() {
      var transaction = ReactUpdates.ReactReconcileTransaction.getPooled(true);
      transaction.perform(function() {
        ReactReconciler.receiveComponent(component, nextWrappedElement, transaction, emptyObject);
      });
      ReactUpdates.ReactReconcileTransaction.release(transaction);
    });
  };
  ReactTestInstance.prototype.unmount = function(nextElement) {
    var component = this._component;
    ReactUpdates.batchedUpdates(function() {
      var transaction = ReactUpdates.ReactReconcileTransaction.getPooled(true);
      transaction.perform(function() {
        ReactReconciler.unmountComponent(component, false);
      });
      ReactUpdates.ReactReconcileTransaction.release(transaction);
    });
    this._component = null;
  };
  ReactTestInstance.prototype.toJSON = function() {
    var inst = getHostComponentFromComposite(this._component);
    if (inst === null) {
      return null;
    }
    return inst.toJSON();
  };
  var ReactTestMount = {render: function(nextElement) {
      var nextWrappedElement = new ReactElement(TopLevelWrapper, null, null, null, null, null, nextElement);
      var instance = instantiateReactComponent(nextWrappedElement, false);
      ReactUpdates.batchedUpdates(batchedMountComponentIntoNode, instance);
      return new ReactTestInstance(instance);
    }};
  module.exports = ReactTestMount;
})(require('process'));
