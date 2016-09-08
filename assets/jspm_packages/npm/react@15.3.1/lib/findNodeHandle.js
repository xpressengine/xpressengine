/* */ 
(function(process) {
  'use strict';
  var _prodInvariant = require('./reactProdInvariant');
  var ReactCurrentOwner = require('./ReactCurrentOwner');
  var ReactInstanceMap = require('./ReactInstanceMap');
  var invariant = require('fbjs/lib/invariant');
  var warning = require('fbjs/lib/warning');
  function findNodeHandle(componentOrHandle) {
    if (process.env.NODE_ENV !== 'production') {
      var owner = ReactCurrentOwner.current;
      if (owner !== null) {
        process.env.NODE_ENV !== 'production' ? warning(owner._warnedAboutRefsInRender, '%s is accessing findNodeHandle inside its render(). ' + 'render() should be a pure function of props and state. It should ' + 'never access something that requires stale data from the previous ' + 'render, such as refs. Move this logic to componentDidMount and ' + 'componentDidUpdate instead.', owner.getName() || 'A component') : void 0;
        owner._warnedAboutRefsInRender = true;
      }
    }
    if (componentOrHandle == null) {
      return null;
    }
    if (typeof componentOrHandle === 'number') {
      return componentOrHandle;
    }
    var component = componentOrHandle;
    var internalInstance = ReactInstanceMap.get(component);
    if (internalInstance) {
      return internalInstance.getHostNode();
    } else {
      var rootNodeID = component._rootNodeID;
      if (rootNodeID) {
        return rootNodeID;
      } else {
        !(typeof component === 'object' && '_rootNodeID' in component || component.render != null && typeof component.render === 'function') ? process.env.NODE_ENV !== 'production' ? invariant(false, 'findNodeHandle(...): Argument is not a component (type: %s, keys: %s)', typeof component, Object.keys(component)) : _prodInvariant('21', typeof component, Object.keys(component)) : void 0;
        !false ? process.env.NODE_ENV !== 'production' ? invariant(false, 'findNodeHandle(...): Unable to find node handle for unmounted component.') : _prodInvariant('22') : void 0;
      }
    }
  }
  module.exports = findNodeHandle;
})(require('process'));
