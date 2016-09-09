/* */ 
(function(process) {
  'use strict';
  var _prodInvariant = require('./reactProdInvariant');
  var ReactCurrentOwner = require('./ReactCurrentOwner');
  var ReactDOMComponentTree = require('./ReactDOMComponentTree');
  var ReactInstanceMap = require('./ReactInstanceMap');
  var getHostComponentFromComposite = require('./getHostComponentFromComposite');
  var invariant = require('fbjs/lib/invariant');
  var warning = require('fbjs/lib/warning');
  function findDOMNode(componentOrElement) {
    if (process.env.NODE_ENV !== 'production') {
      var owner = ReactCurrentOwner.current;
      if (owner !== null) {
        process.env.NODE_ENV !== 'production' ? warning(owner._warnedAboutRefsInRender, '%s is accessing findDOMNode inside its render(). ' + 'render() should be a pure function of props and state. It should ' + 'never access something that requires stale data from the previous ' + 'render, such as refs. Move this logic to componentDidMount and ' + 'componentDidUpdate instead.', owner.getName() || 'A component') : void 0;
        owner._warnedAboutRefsInRender = true;
      }
    }
    if (componentOrElement == null) {
      return null;
    }
    if (componentOrElement.nodeType === 1) {
      return componentOrElement;
    }
    var inst = ReactInstanceMap.get(componentOrElement);
    if (inst) {
      inst = getHostComponentFromComposite(inst);
      return inst ? ReactDOMComponentTree.getNodeFromInstance(inst) : null;
    }
    if (typeof componentOrElement.render === 'function') {
      !false ? process.env.NODE_ENV !== 'production' ? invariant(false, 'findDOMNode was called on an unmounted component.') : _prodInvariant('44') : void 0;
    } else {
      !false ? process.env.NODE_ENV !== 'production' ? invariant(false, 'Element appears to be neither ReactComponent nor DOMNode (keys: %s)', Object.keys(componentOrElement)) : _prodInvariant('45', Object.keys(componentOrElement)) : void 0;
    }
  }
  module.exports = findDOMNode;
})(require('process'));
