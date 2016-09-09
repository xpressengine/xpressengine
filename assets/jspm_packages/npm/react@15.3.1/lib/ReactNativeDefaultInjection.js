/* */ 
(function(process) {
  'use strict';
  var _prodInvariant = require('./reactProdInvariant');
  require('react-native/lib/InitializeJavaScriptAppEngine');
  var EventPluginHub = require('./EventPluginHub');
  var EventPluginUtils = require('./EventPluginUtils');
  var RCTEventEmitter = require('react-native/lib/RCTEventEmitter');
  var ReactComponentEnvironment = require('./ReactComponentEnvironment');
  var ReactDefaultBatchingStrategy = require('./ReactDefaultBatchingStrategy');
  var ReactElement = require('./ReactElement');
  var ReactEmptyComponent = require('./ReactEmptyComponent');
  var ReactNativeBridgeEventPlugin = require('./ReactNativeBridgeEventPlugin');
  var ReactHostComponent = require('./ReactHostComponent');
  var ReactNativeComponentEnvironment = require('./ReactNativeComponentEnvironment');
  var ReactNativeComponentTree = require('./ReactNativeComponentTree');
  var ReactNativeEventEmitter = require('./ReactNativeEventEmitter');
  var ReactNativeEventPluginOrder = require('./ReactNativeEventPluginOrder');
  var ReactNativeGlobalResponderHandler = require('./ReactNativeGlobalResponderHandler');
  var ReactNativeTextComponent = require('./ReactNativeTextComponent');
  var ReactNativeTreeTraversal = require('./ReactNativeTreeTraversal');
  var ReactSimpleEmptyComponent = require('./ReactSimpleEmptyComponent');
  var ReactUpdates = require('./ReactUpdates');
  var ResponderEventPlugin = require('./ResponderEventPlugin');
  var invariant = require('fbjs/lib/invariant');
  function inject() {
    RCTEventEmitter.register(ReactNativeEventEmitter);
    EventPluginHub.injection.injectEventPluginOrder(ReactNativeEventPluginOrder);
    EventPluginUtils.injection.injectComponentTree(ReactNativeComponentTree);
    EventPluginUtils.injection.injectTreeTraversal(ReactNativeTreeTraversal);
    ResponderEventPlugin.injection.injectGlobalResponderHandler(ReactNativeGlobalResponderHandler);
    EventPluginHub.injection.injectEventPluginsByName({
      'ResponderEventPlugin': ResponderEventPlugin,
      'ReactNativeBridgeEventPlugin': ReactNativeBridgeEventPlugin
    });
    ReactUpdates.injection.injectReconcileTransaction(ReactNativeComponentEnvironment.ReactReconcileTransaction);
    ReactUpdates.injection.injectBatchingStrategy(ReactDefaultBatchingStrategy);
    ReactComponentEnvironment.injection.injectEnvironment(ReactNativeComponentEnvironment);
    var EmptyComponent = function(instantiate) {
      var View = require('react-native/lib/View');
      return new ReactSimpleEmptyComponent(ReactElement.createElement(View, {
        collapsable: true,
        style: {position: 'absolute'}
      }), instantiate);
    };
    ReactEmptyComponent.injection.injectEmptyComponentFactory(EmptyComponent);
    ReactHostComponent.injection.injectTextComponentClass(ReactNativeTextComponent);
    ReactHostComponent.injection.injectGenericComponentClass(function(tag) {
      var info = '';
      if (typeof tag === 'string' && /^[a-z]/.test(tag)) {
        info += ' Each component name should start with an uppercase letter.';
      }
      !false ? process.env.NODE_ENV !== 'production' ? invariant(false, 'Expected a component class, got %s.%s', tag, info) : _prodInvariant('18', tag, info) : void 0;
    });
  }
  module.exports = {inject: inject};
})(require('process'));
