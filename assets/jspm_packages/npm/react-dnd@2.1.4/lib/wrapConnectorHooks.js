/* */ 
'use strict';
exports.__esModule = true;
exports['default'] = wrapConnectorHooks;
function _interopRequireDefault(obj) {
  return obj && obj.__esModule ? obj : {'default': obj};
}
var _utilsCloneWithRef = require('./utils/cloneWithRef');
var _utilsCloneWithRef2 = _interopRequireDefault(_utilsCloneWithRef);
var _react = require('react');
function throwIfCompositeComponentElement(element) {
  if (typeof element.type === 'string') {
    return;
  }
  var displayName = element.type.displayName || element.type.name || 'the component';
  throw new Error('Only native element nodes can now be passed to React DnD connectors. ' + ('You can either wrap ' + displayName + ' into a <div>, or turn it into a ') + 'drag source or a drop target itself.');
}
function wrapHookToRecognizeElement(hook) {
  return function() {
    var elementOrNode = arguments.length <= 0 || arguments[0] === undefined ? null : arguments[0];
    var options = arguments.length <= 1 || arguments[1] === undefined ? null : arguments[1];
    if (!_react.isValidElement(elementOrNode)) {
      var node = elementOrNode;
      hook(node, options);
      return;
    }
    var element = elementOrNode;
    throwIfCompositeComponentElement(element);
    var ref = options ? function(node) {
      return hook(node, options);
    } : hook;
    return _utilsCloneWithRef2['default'](element, ref);
  };
}
function wrapConnectorHooks(hooks) {
  var wrappedHooks = {};
  Object.keys(hooks).forEach(function(key) {
    var hook = hooks[key];
    var wrappedHook = wrapHookToRecognizeElement(hook);
    wrappedHooks[key] = function() {
      return wrappedHook;
    };
  });
  return wrappedHooks;
}
module.exports = exports['default'];
