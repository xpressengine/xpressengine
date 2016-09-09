/* */ 
(function(process) {
  'use strict';
  var ReactComponentTreeHook = require('./ReactComponentTreeHook');
  var warning = require('fbjs/lib/warning');
  var didWarnValueNull = false;
  function handleElement(debugID, element) {
    if (element == null) {
      return;
    }
    if (element.type !== 'input' && element.type !== 'textarea' && element.type !== 'select') {
      return;
    }
    if (element.props != null && element.props.value === null && !didWarnValueNull) {
      process.env.NODE_ENV !== 'production' ? warning(false, '`value` prop on `%s` should not be null. ' + 'Consider using the empty string to clear the component or `undefined` ' + 'for uncontrolled components.%s', element.type, ReactComponentTreeHook.getStackAddendumByID(debugID)) : void 0;
      didWarnValueNull = true;
    }
  }
  var ReactDOMNullInputValuePropHook = {
    onBeforeMountComponent: function(debugID, element) {
      handleElement(debugID, element);
    },
    onBeforeUpdateComponent: function(debugID, element) {
      handleElement(debugID, element);
    }
  };
  module.exports = ReactDOMNullInputValuePropHook;
})(require('process'));
