/* */ 
(function(process) {
  'use strict';
  var _prodInvariant = require('./reactProdInvariant');
  var ReactNativeAttributePayload = require('./ReactNativeAttributePayload');
  var TextInputState = require('react-native/lib/TextInputState');
  var UIManager = require('react-native/lib/UIManager');
  var findNodeHandle = require('./findNodeHandle');
  var invariant = require('fbjs/lib/invariant');
  function warnForStyleProps(props, validAttributes) {
    for (var key in validAttributes.style) {
      if (!(validAttributes[key] || props[key] === undefined)) {
        console.error('You are setting the style `{ ' + key + ': ... }` as a prop. You ' + 'should nest it in a style object. ' + 'E.g. `{ style: { ' + key + ': ... } }`');
      }
    }
  }
  var NativeMethodsMixin = {
    measure: function(callback) {
      UIManager.measure(findNodeHandle(this), mountSafeCallback(this, callback));
    },
    measureInWindow: function(callback) {
      UIManager.measureInWindow(findNodeHandle(this), mountSafeCallback(this, callback));
    },
    measureLayout: function(relativeToNativeNode, onSuccess, onFail) {
      UIManager.measureLayout(findNodeHandle(this), relativeToNativeNode, mountSafeCallback(this, onFail), mountSafeCallback(this, onSuccess));
    },
    setNativeProps: function(nativeProps) {
      if (process.env.NODE_ENV !== 'production') {
        warnForStyleProps(nativeProps, this.viewConfig.validAttributes);
      }
      var updatePayload = ReactNativeAttributePayload.create(nativeProps, this.viewConfig.validAttributes);
      UIManager.updateView(findNodeHandle(this), this.viewConfig.uiViewClassName, updatePayload);
    },
    focus: function() {
      TextInputState.focusTextInput(findNodeHandle(this));
    },
    blur: function() {
      TextInputState.blurTextInput(findNodeHandle(this));
    }
  };
  function throwOnStylesProp(component, props) {
    if (props.styles !== undefined) {
      var owner = component._owner || null;
      var name = component.constructor.displayName;
      var msg = '`styles` is not a supported property of `' + name + '`, did ' + 'you mean `style` (singular)?';
      if (owner && owner.constructor && owner.constructor.displayName) {
        msg += '\n\nCheck the `' + owner.constructor.displayName + '` parent ' + ' component.';
      }
      throw new Error(msg);
    }
  }
  if (process.env.NODE_ENV !== 'production') {
    var NativeMethodsMixin_DEV = NativeMethodsMixin;
    !(!NativeMethodsMixin_DEV.componentWillMount && !NativeMethodsMixin_DEV.componentWillReceiveProps) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'Do not override existing functions.') : _prodInvariant('16') : void 0;
    NativeMethodsMixin_DEV.componentWillMount = function() {
      throwOnStylesProp(this, this.props);
    };
    NativeMethodsMixin_DEV.componentWillReceiveProps = function(newProps) {
      throwOnStylesProp(this, newProps);
    };
  }
  function mountSafeCallback(context, callback) {
    return function() {
      if (!callback || context.isMounted && !context.isMounted()) {
        return undefined;
      }
      return callback.apply(context, arguments);
    };
  }
  module.exports = NativeMethodsMixin;
})(require('process'));
