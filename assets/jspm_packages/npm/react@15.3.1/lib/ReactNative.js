/* */ 
'use strict';
var ReactNativeComponentTree = require('./ReactNativeComponentTree');
var ReactNativeDefaultInjection = require('./ReactNativeDefaultInjection');
var ReactElement = require('./ReactElement');
var ReactNativeMount = require('./ReactNativeMount');
var ReactUpdates = require('./ReactUpdates');
var findNodeHandle = require('./findNodeHandle');
ReactNativeDefaultInjection.inject();
var render = function(element, mountInto, callback) {
  return ReactNativeMount.renderComponent(element, mountInto, callback);
};
var ReactNative = {
  hasReactNativeInitialized: false,
  findNodeHandle: findNodeHandle,
  render: render,
  unmountComponentAtNode: ReactNativeMount.unmountComponentAtNode,
  unstable_batchedUpdates: ReactUpdates.batchedUpdates,
  unmountComponentAtNodeAndRemoveContainer: ReactNativeMount.unmountComponentAtNodeAndRemoveContainer
};
if (typeof __REACT_DEVTOOLS_GLOBAL_HOOK__ !== 'undefined' && typeof __REACT_DEVTOOLS_GLOBAL_HOOK__.inject === 'function') {
  __REACT_DEVTOOLS_GLOBAL_HOOK__.inject({
    ComponentTree: {
      getClosestInstanceFromNode: function(node) {
        return ReactNativeComponentTree.getClosestInstanceFromNode(node);
      },
      getNodeFromInstance: function(inst) {
        while (inst._renderedComponent) {
          inst = inst._renderedComponent;
        }
        if (inst) {
          return ReactNativeComponentTree.getNodeFromInstance(inst);
        } else {
          return null;
        }
      }
    },
    Mount: ReactNativeMount,
    Reconciler: require('./ReactReconciler')
  });
}
module.exports = ReactNative;
