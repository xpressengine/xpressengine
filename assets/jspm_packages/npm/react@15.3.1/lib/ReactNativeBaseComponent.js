/* */ 
(function(process) {
  'use strict';
  var _assign = require('object-assign');
  var NativeMethodsMixin = require('./NativeMethodsMixin');
  var ReactNativeAttributePayload = require('./ReactNativeAttributePayload');
  var ReactNativeComponentTree = require('./ReactNativeComponentTree');
  var ReactNativeEventEmitter = require('./ReactNativeEventEmitter');
  var ReactNativeTagHandles = require('./ReactNativeTagHandles');
  var ReactMultiChild = require('./ReactMultiChild');
  var UIManager = require('react-native/lib/UIManager');
  var deepFreezeAndThrowOnMutationInDev = require('react-native/lib/deepFreezeAndThrowOnMutationInDev');
  var registrationNames = ReactNativeEventEmitter.registrationNames;
  var putListener = ReactNativeEventEmitter.putListener;
  var deleteListener = ReactNativeEventEmitter.deleteListener;
  var deleteAllListeners = ReactNativeEventEmitter.deleteAllListeners;
  var ReactNativeBaseComponent = function(viewConfig) {
    this.viewConfig = viewConfig;
  };
  ReactNativeBaseComponent.Mixin = {
    getPublicInstance: function() {
      return this;
    },
    unmountComponent: function() {
      ReactNativeComponentTree.uncacheNode(this);
      deleteAllListeners(this);
      this.unmountChildren();
      this._rootNodeID = 0;
    },
    initializeChildren: function(children, containerTag, transaction, context) {
      var mountImages = this.mountChildren(children, transaction, context);
      if (mountImages.length) {
        var createdTags = [];
        for (var i = 0,
            l = mountImages.length; i < l; i++) {
          var mountImage = mountImages[i];
          var childTag = mountImage;
          createdTags[i] = childTag;
        }
        UIManager.setChildren(containerTag, createdTags);
      }
    },
    receiveComponent: function(nextElement, transaction, context) {
      var prevElement = this._currentElement;
      this._currentElement = nextElement;
      if (process.env.NODE_ENV !== 'production') {
        for (var key in this.viewConfig.validAttributes) {
          if (nextElement.props.hasOwnProperty(key)) {
            deepFreezeAndThrowOnMutationInDev(nextElement.props[key]);
          }
        }
      }
      var updatePayload = ReactNativeAttributePayload.diff(prevElement.props, nextElement.props, this.viewConfig.validAttributes);
      if (updatePayload) {
        UIManager.updateView(this._rootNodeID, this.viewConfig.uiViewClassName, updatePayload);
      }
      this._reconcileListenersUponUpdate(prevElement.props, nextElement.props);
      this.updateChildren(nextElement.props.children, transaction, context);
    },
    _registerListenersUponCreation: function(initialProps) {
      for (var key in initialProps) {
        if (registrationNames[key] && initialProps[key]) {
          var listener = initialProps[key];
          putListener(this, key, listener);
        }
      }
    },
    _reconcileListenersUponUpdate: function(prevProps, nextProps) {
      for (var key in nextProps) {
        if (registrationNames[key] && nextProps[key] !== prevProps[key]) {
          if (nextProps[key]) {
            putListener(this, key, nextProps[key]);
          } else {
            deleteListener(this, key);
          }
        }
      }
    },
    getHostNode: function() {
      return this._rootNodeID;
    },
    mountComponent: function(transaction, hostParent, hostContainerInfo, context) {
      var tag = ReactNativeTagHandles.allocateTag();
      this._rootNodeID = tag;
      this._hostParent = hostParent;
      this._hostContainerInfo = hostContainerInfo;
      if (process.env.NODE_ENV !== 'production') {
        for (var key in this.viewConfig.validAttributes) {
          if (this._currentElement.props.hasOwnProperty(key)) {
            deepFreezeAndThrowOnMutationInDev(this._currentElement.props[key]);
          }
        }
      }
      var updatePayload = ReactNativeAttributePayload.create(this._currentElement.props, this.viewConfig.validAttributes);
      var nativeTopRootTag = hostContainerInfo._tag;
      UIManager.createView(tag, this.viewConfig.uiViewClassName, nativeTopRootTag, updatePayload);
      ReactNativeComponentTree.precacheNode(this, tag);
      this._registerListenersUponCreation(this._currentElement.props);
      this.initializeChildren(this._currentElement.props.children, tag, transaction, context);
      return tag;
    }
  };
  _assign(ReactNativeBaseComponent.prototype, ReactMultiChild.Mixin, ReactNativeBaseComponent.Mixin, NativeMethodsMixin);
  module.exports = ReactNativeBaseComponent;
})(require('process'));
