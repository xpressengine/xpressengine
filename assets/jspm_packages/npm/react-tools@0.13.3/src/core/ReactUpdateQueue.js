/* */ 
(function(process) {
  'use strict';
  var ReactLifeCycle = require('ReactLifeCycle');
  var ReactCurrentOwner = require('ReactCurrentOwner');
  var ReactElement = require('ReactElement');
  var ReactInstanceMap = require('ReactInstanceMap');
  var ReactUpdates = require('ReactUpdates');
  var assign = require('Object.assign');
  var invariant = require('invariant');
  var warning = require('warning');
  function enqueueUpdate(internalInstance) {
    if (internalInstance !== ReactLifeCycle.currentlyMountingInstance) {
      ReactUpdates.enqueueUpdate(internalInstance);
    }
  }
  function getInternalInstanceReadyForUpdate(publicInstance, callerName) {
    invariant(ReactCurrentOwner.current == null, '%s(...): Cannot update during an existing state transition ' + '(such as within `render`). Render methods should be a pure function ' + 'of props and state.', callerName);
    var internalInstance = ReactInstanceMap.get(publicInstance);
    if (!internalInstance) {
      if (__DEV__) {
        warning(!callerName, '%s(...): Can only update a mounted or mounting component. ' + 'This usually means you called %s() on an unmounted ' + 'component. This is a no-op.', callerName, callerName);
      }
      return null;
    }
    if (internalInstance === ReactLifeCycle.currentlyUnmountingInstance) {
      return null;
    }
    return internalInstance;
  }
  var ReactUpdateQueue = {
    enqueueCallback: function(publicInstance, callback) {
      invariant(typeof callback === 'function', 'enqueueCallback(...): You called `setProps`, `replaceProps`, ' + '`setState`, `replaceState`, or `forceUpdate` with a callback that ' + 'isn\'t callable.');
      var internalInstance = getInternalInstanceReadyForUpdate(publicInstance);
      if (!internalInstance || internalInstance === ReactLifeCycle.currentlyMountingInstance) {
        return null;
      }
      if (internalInstance._pendingCallbacks) {
        internalInstance._pendingCallbacks.push(callback);
      } else {
        internalInstance._pendingCallbacks = [callback];
      }
      enqueueUpdate(internalInstance);
    },
    enqueueCallbackInternal: function(internalInstance, callback) {
      invariant(typeof callback === 'function', 'enqueueCallback(...): You called `setProps`, `replaceProps`, ' + '`setState`, `replaceState`, or `forceUpdate` with a callback that ' + 'isn\'t callable.');
      if (internalInstance._pendingCallbacks) {
        internalInstance._pendingCallbacks.push(callback);
      } else {
        internalInstance._pendingCallbacks = [callback];
      }
      enqueueUpdate(internalInstance);
    },
    enqueueForceUpdate: function(publicInstance) {
      var internalInstance = getInternalInstanceReadyForUpdate(publicInstance, 'forceUpdate');
      if (!internalInstance) {
        return;
      }
      internalInstance._pendingForceUpdate = true;
      enqueueUpdate(internalInstance);
    },
    enqueueReplaceState: function(publicInstance, completeState) {
      var internalInstance = getInternalInstanceReadyForUpdate(publicInstance, 'replaceState');
      if (!internalInstance) {
        return;
      }
      internalInstance._pendingStateQueue = [completeState];
      internalInstance._pendingReplaceState = true;
      enqueueUpdate(internalInstance);
    },
    enqueueSetState: function(publicInstance, partialState) {
      var internalInstance = getInternalInstanceReadyForUpdate(publicInstance, 'setState');
      if (!internalInstance) {
        return;
      }
      var queue = internalInstance._pendingStateQueue || (internalInstance._pendingStateQueue = []);
      queue.push(partialState);
      enqueueUpdate(internalInstance);
    },
    enqueueSetProps: function(publicInstance, partialProps) {
      var internalInstance = getInternalInstanceReadyForUpdate(publicInstance, 'setProps');
      if (!internalInstance) {
        return;
      }
      invariant(internalInstance._isTopLevel, 'setProps(...): You called `setProps` on a ' + 'component with a parent. This is an anti-pattern since props will ' + 'get reactively updated when rendered. Instead, change the owner\'s ' + '`render` method to pass the correct value as props to the component ' + 'where it is created.');
      var element = internalInstance._pendingElement || internalInstance._currentElement;
      var props = assign({}, element.props, partialProps);
      internalInstance._pendingElement = ReactElement.cloneAndReplaceProps(element, props);
      enqueueUpdate(internalInstance);
    },
    enqueueReplaceProps: function(publicInstance, props) {
      var internalInstance = getInternalInstanceReadyForUpdate(publicInstance, 'replaceProps');
      if (!internalInstance) {
        return;
      }
      invariant(internalInstance._isTopLevel, 'replaceProps(...): You called `replaceProps` on a ' + 'component with a parent. This is an anti-pattern since props will ' + 'get reactively updated when rendered. Instead, change the owner\'s ' + '`render` method to pass the correct value as props to the component ' + 'where it is created.');
      var element = internalInstance._pendingElement || internalInstance._currentElement;
      internalInstance._pendingElement = ReactElement.cloneAndReplaceProps(element, props);
      enqueueUpdate(internalInstance);
    },
    enqueueElementInternal: function(internalInstance, newElement) {
      internalInstance._pendingElement = newElement;
      enqueueUpdate(internalInstance);
    }
  };
  module.exports = ReactUpdateQueue;
})(require('process'));
