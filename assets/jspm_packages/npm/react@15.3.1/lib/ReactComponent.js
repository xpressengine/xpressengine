/* */ 
(function(process) {
  'use strict';
  var _prodInvariant = require('./reactProdInvariant');
  var ReactNoopUpdateQueue = require('./ReactNoopUpdateQueue');
  var canDefineProperty = require('./canDefineProperty');
  var emptyObject = require('fbjs/lib/emptyObject');
  var invariant = require('fbjs/lib/invariant');
  var warning = require('fbjs/lib/warning');
  function ReactComponent(props, context, updater) {
    this.props = props;
    this.context = context;
    this.refs = emptyObject;
    this.updater = updater || ReactNoopUpdateQueue;
  }
  ReactComponent.prototype.isReactComponent = {};
  ReactComponent.prototype.setState = function(partialState, callback) {
    !(typeof partialState === 'object' || typeof partialState === 'function' || partialState == null) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'setState(...): takes an object of state variables to update or a function which returns an object of state variables.') : _prodInvariant('85') : void 0;
    this.updater.enqueueSetState(this, partialState);
    if (callback) {
      this.updater.enqueueCallback(this, callback, 'setState');
    }
  };
  ReactComponent.prototype.forceUpdate = function(callback) {
    this.updater.enqueueForceUpdate(this);
    if (callback) {
      this.updater.enqueueCallback(this, callback, 'forceUpdate');
    }
  };
  if (process.env.NODE_ENV !== 'production') {
    var deprecatedAPIs = {
      isMounted: ['isMounted', 'Instead, make sure to clean up subscriptions and pending requests in ' + 'componentWillUnmount to prevent memory leaks.'],
      replaceState: ['replaceState', 'Refactor your code to use setState instead (see ' + 'https://github.com/facebook/react/issues/3236).']
    };
    var defineDeprecationWarning = function(methodName, info) {
      if (canDefineProperty) {
        Object.defineProperty(ReactComponent.prototype, methodName, {get: function() {
            process.env.NODE_ENV !== 'production' ? warning(false, '%s(...) is deprecated in plain JavaScript React classes. %s', info[0], info[1]) : void 0;
            return undefined;
          }});
      }
    };
    for (var fnName in deprecatedAPIs) {
      if (deprecatedAPIs.hasOwnProperty(fnName)) {
        defineDeprecationWarning(fnName, deprecatedAPIs[fnName]);
      }
    }
  }
  module.exports = ReactComponent;
})(require('process'));
