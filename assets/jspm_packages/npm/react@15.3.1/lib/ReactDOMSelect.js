/* */ 
(function(process) {
  'use strict';
  var _assign = require('object-assign');
  var DisabledInputUtils = require('./DisabledInputUtils');
  var LinkedValueUtils = require('./LinkedValueUtils');
  var ReactDOMComponentTree = require('./ReactDOMComponentTree');
  var ReactUpdates = require('./ReactUpdates');
  var warning = require('fbjs/lib/warning');
  var didWarnValueLink = false;
  var didWarnValueDefaultValue = false;
  function updateOptionsIfPendingUpdateAndMounted() {
    if (this._rootNodeID && this._wrapperState.pendingUpdate) {
      this._wrapperState.pendingUpdate = false;
      var props = this._currentElement.props;
      var value = LinkedValueUtils.getValue(props);
      if (value != null) {
        updateOptions(this, Boolean(props.multiple), value);
      }
    }
  }
  function getDeclarationErrorAddendum(owner) {
    if (owner) {
      var name = owner.getName();
      if (name) {
        return ' Check the render method of `' + name + '`.';
      }
    }
    return '';
  }
  var valuePropNames = ['value', 'defaultValue'];
  function checkSelectPropTypes(inst, props) {
    var owner = inst._currentElement._owner;
    LinkedValueUtils.checkPropTypes('select', props, owner);
    if (props.valueLink !== undefined && !didWarnValueLink) {
      process.env.NODE_ENV !== 'production' ? warning(false, '`valueLink` prop on `select` is deprecated; set `value` and `onChange` instead.') : void 0;
      didWarnValueLink = true;
    }
    for (var i = 0; i < valuePropNames.length; i++) {
      var propName = valuePropNames[i];
      if (props[propName] == null) {
        continue;
      }
      var isArray = Array.isArray(props[propName]);
      if (props.multiple && !isArray) {
        process.env.NODE_ENV !== 'production' ? warning(false, 'The `%s` prop supplied to <select> must be an array if ' + '`multiple` is true.%s', propName, getDeclarationErrorAddendum(owner)) : void 0;
      } else if (!props.multiple && isArray) {
        process.env.NODE_ENV !== 'production' ? warning(false, 'The `%s` prop supplied to <select> must be a scalar ' + 'value if `multiple` is false.%s', propName, getDeclarationErrorAddendum(owner)) : void 0;
      }
    }
  }
  function updateOptions(inst, multiple, propValue) {
    var selectedValue,
        i;
    var options = ReactDOMComponentTree.getNodeFromInstance(inst).options;
    if (multiple) {
      selectedValue = {};
      for (i = 0; i < propValue.length; i++) {
        selectedValue['' + propValue[i]] = true;
      }
      for (i = 0; i < options.length; i++) {
        var selected = selectedValue.hasOwnProperty(options[i].value);
        if (options[i].selected !== selected) {
          options[i].selected = selected;
        }
      }
    } else {
      selectedValue = '' + propValue;
      for (i = 0; i < options.length; i++) {
        if (options[i].value === selectedValue) {
          options[i].selected = true;
          return;
        }
      }
      if (options.length) {
        options[0].selected = true;
      }
    }
  }
  var ReactDOMSelect = {
    getHostProps: function(inst, props) {
      return _assign({}, DisabledInputUtils.getHostProps(inst, props), {
        onChange: inst._wrapperState.onChange,
        value: undefined
      });
    },
    mountWrapper: function(inst, props) {
      if (process.env.NODE_ENV !== 'production') {
        checkSelectPropTypes(inst, props);
      }
      var value = LinkedValueUtils.getValue(props);
      inst._wrapperState = {
        pendingUpdate: false,
        initialValue: value != null ? value : props.defaultValue,
        listeners: null,
        onChange: _handleChange.bind(inst),
        wasMultiple: Boolean(props.multiple)
      };
      if (props.value !== undefined && props.defaultValue !== undefined && !didWarnValueDefaultValue) {
        process.env.NODE_ENV !== 'production' ? warning(false, 'Select elements must be either controlled or uncontrolled ' + '(specify either the value prop, or the defaultValue prop, but not ' + 'both). Decide between using a controlled or uncontrolled select ' + 'element and remove one of these props. More info: ' + 'https://fb.me/react-controlled-components') : void 0;
        didWarnValueDefaultValue = true;
      }
    },
    getSelectValueContext: function(inst) {
      return inst._wrapperState.initialValue;
    },
    postUpdateWrapper: function(inst) {
      var props = inst._currentElement.props;
      inst._wrapperState.initialValue = undefined;
      var wasMultiple = inst._wrapperState.wasMultiple;
      inst._wrapperState.wasMultiple = Boolean(props.multiple);
      var value = LinkedValueUtils.getValue(props);
      if (value != null) {
        inst._wrapperState.pendingUpdate = false;
        updateOptions(inst, Boolean(props.multiple), value);
      } else if (wasMultiple !== Boolean(props.multiple)) {
        if (props.defaultValue != null) {
          updateOptions(inst, Boolean(props.multiple), props.defaultValue);
        } else {
          updateOptions(inst, Boolean(props.multiple), props.multiple ? [] : '');
        }
      }
    }
  };
  function _handleChange(event) {
    var props = this._currentElement.props;
    var returnValue = LinkedValueUtils.executeOnChange(props, event);
    if (this._rootNodeID) {
      this._wrapperState.pendingUpdate = true;
    }
    ReactUpdates.asap(updateOptionsIfPendingUpdateAndMounted, this);
    return returnValue;
  }
  module.exports = ReactDOMSelect;
})(require('process'));
