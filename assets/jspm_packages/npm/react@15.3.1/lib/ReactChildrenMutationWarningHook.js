/* */ 
(function(process) {
  'use strict';
  var ReactComponentTreeHook = require('./ReactComponentTreeHook');
  var warning = require('fbjs/lib/warning');
  function handleElement(debugID, element) {
    if (element == null) {
      return;
    }
    if (element._shadowChildren === undefined) {
      return;
    }
    if (element._shadowChildren === element.props.children) {
      return;
    }
    var isMutated = false;
    if (Array.isArray(element._shadowChildren)) {
      if (element._shadowChildren.length === element.props.children.length) {
        for (var i = 0; i < element._shadowChildren.length; i++) {
          if (element._shadowChildren[i] !== element.props.children[i]) {
            isMutated = true;
          }
        }
      } else {
        isMutated = true;
      }
    }
    if (!Array.isArray(element._shadowChildren) || isMutated) {
      process.env.NODE_ENV !== 'production' ? warning(false, 'Component\'s children should not be mutated.%s', ReactComponentTreeHook.getStackAddendumByID(debugID)) : void 0;
    }
  }
  var ReactChildrenMutationWarningHook = {
    onMountComponent: function(debugID) {
      handleElement(debugID, ReactComponentTreeHook.getElement(debugID));
    },
    onUpdateComponent: function(debugID) {
      handleElement(debugID, ReactComponentTreeHook.getElement(debugID));
    }
  };
  module.exports = ReactChildrenMutationWarningHook;
})(require('process'));
