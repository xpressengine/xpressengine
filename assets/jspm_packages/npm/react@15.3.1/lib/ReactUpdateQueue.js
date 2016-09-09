/* */ 
(function(process) {
  'use strict';
  var _prodInvariant = require('./reactProdInvariant');
  var ReactCurrentOwner = require('./ReactCurrentOwner');
  var ReactInstanceMap = require('./ReactInstanceMap');
  var ReactInstrumentation = require('./ReactInstrumentation');
  var ReactUpdates = require('./ReactUpdates');
  var invariant = require('fbjs/lib/invariant');
  var warning = require('fbjs/lib/warning');
  function enqueueUpdate(internalInstance) {
    ReactUpdates.enqueueUpdate(internalInstance);
  }
  function formatUnexpectedArgument(arg) {
    var type = typeof arg;
    if (type !== 'object') {
      return type;
    }
    var displayName = arg.constructor && arg.constructor.name || type;
    var keys = Object.keys(arg);
    if (keys.length > 0 && keys.length < 20) {
      return displayName + ' (keys: ' + keys.join(', ') + ')';
    }
    return displayName;
  }
  function getInternalInstanceReadyForUpdate(publicInstance, callerName) {
    var internalInstance = ReactInstanceMap.get(publicInstance);
    if (!internalInstance) {
      if (process.env.NODE_ENV !== 'production') {
        var ctor = publicInstance.constructor;
        process.env.NODE_ENV !== 'production' ? warning(!callerName, '%s(...): Can only update a mounted or mounting component. ' + 'This usually means you called %s() on an unmounted component. ' + 'This is a no-op. Please check the code for the %s component.', callerName, callerName, ctor && (ctor.displayName || ctor.name) || 'ReactClass') : void 0;
      }
      return null;
    }
    if (process.env.NODE_ENV !== 'production') {
      process.env.NODE_ENV !== 'production' ? warning(ReactCurrentOwner.current == null, '%s(...): Cannot update during an existing state transition (such as ' + 'within `render` or another component\'s constructor). Render methods ' + 'should be a pure function of props and state; constructor ' + 'side-effects are an anti-pattern, but can be moved to ' + '`componentWillMount`.', callerName) : void 0;
    }
    return internalInstance;
  }
  var ReactUpdateQueue = {
    isMounted: function(publicInstance) {
      if (process.env.NODE_ENV !== 'production') {
        var owner = ReactCurrentOwner.current;
        if (owner !== null) {
          process.env.NODE_ENV !== 'production' ? warning(owner._warnedAboutRefsInRender, '%s is accessing isMounted inside its render() function. ' + 'render() should be a pure function of props and state. It should ' + 'never access something that requires stale data from the previous ' + 'render, such as refs. Move this logic to componentDidMount and ' + 'componentDidUpdate instead.', owner.getName() || 'A component') : void 0;
          owner._warnedAboutRefsInRender = true;
        }
      }
      var internalInstance = ReactInstanceMap.get(publicInstance);
      if (internalInstance) {
        return !!internalInstance._renderedComponent;
      } else {
        return false;
      }
    },
    enqueueCallback: function(publicInstance, callback, callerName) {
      ReactUpdateQueue.validateCallback(callback, callerName);
      var internalInstance = getInternalInstanceReadyForUpdate(publicInstance);
      if (!internalInstance) {
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
      if (process.env.NODE_ENV !== 'production') {
        ReactInstrumentation.debugTool.onSetState();
        process.env.NODE_ENV !== 'production' ? warning(partialState != null, 'setState(...): You passed an undefined or null state object; ' + 'instead, use forceUpdate().') : void 0;
      }
      var internalInstance = getInternalInstanceReadyForUpdate(publicInstance, 'setState');
      if (!internalInstance) {
        return;
      }
      var queue = internalInstance._pendingStateQueue || (internalInstance._pendingStateQueue = []);
      queue.push(partialState);
      enqueueUpdate(internalInstance);
    },
    enqueueElementInternal: function(internalInstance, nextElement, nextContext) {
      internalInstance._pendingElement = nextElement;
      internalInstance._context = nextContext;
      enqueueUpdate(internalInstance);
    },
    validateCallback: function(callback, callerName) {
      !(!callback || typeof callback === 'function') ? process.env.NODE_ENV !== 'production' ? invariant(false, '%s(...): Expected the last optional `callback` argument to be a function. Instead received: %s.', callerName, formatUnexpectedArgument(callback)) : _prodInvariant('122', callerName, formatUnexpectedArgument(callback)) : void 0;
    }
  };
  module.exports = ReactUpdateQueue;
})(require('process'));
