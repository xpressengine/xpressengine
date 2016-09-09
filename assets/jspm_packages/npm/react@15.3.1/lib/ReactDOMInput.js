/* */ 
(function(process) {
  'use strict';
  var _prodInvariant = require('./reactProdInvariant'),
      _assign = require('object-assign');
  var DisabledInputUtils = require('./DisabledInputUtils');
  var DOMPropertyOperations = require('./DOMPropertyOperations');
  var LinkedValueUtils = require('./LinkedValueUtils');
  var ReactDOMComponentTree = require('./ReactDOMComponentTree');
  var ReactUpdates = require('./ReactUpdates');
  var invariant = require('fbjs/lib/invariant');
  var warning = require('fbjs/lib/warning');
  var didWarnValueLink = false;
  var didWarnCheckedLink = false;
  var didWarnValueDefaultValue = false;
  var didWarnCheckedDefaultChecked = false;
  var didWarnControlledToUncontrolled = false;
  var didWarnUncontrolledToControlled = false;
  function forceUpdateIfMounted() {
    if (this._rootNodeID) {
      ReactDOMInput.updateWrapper(this);
    }
  }
  function isControlled(props) {
    var usesChecked = props.type === 'checkbox' || props.type === 'radio';
    return usesChecked ? props.checked !== undefined : props.value !== undefined;
  }
  var ReactDOMInput = {
    getHostProps: function(inst, props) {
      var value = LinkedValueUtils.getValue(props);
      var checked = LinkedValueUtils.getChecked(props);
      var hostProps = _assign({
        type: undefined,
        step: undefined,
        min: undefined,
        max: undefined
      }, DisabledInputUtils.getHostProps(inst, props), {
        defaultChecked: undefined,
        defaultValue: undefined,
        value: value != null ? value : inst._wrapperState.initialValue,
        checked: checked != null ? checked : inst._wrapperState.initialChecked,
        onChange: inst._wrapperState.onChange
      });
      return hostProps;
    },
    mountWrapper: function(inst, props) {
      if (process.env.NODE_ENV !== 'production') {
        LinkedValueUtils.checkPropTypes('input', props, inst._currentElement._owner);
        var owner = inst._currentElement._owner;
        if (props.valueLink !== undefined && !didWarnValueLink) {
          process.env.NODE_ENV !== 'production' ? warning(false, '`valueLink` prop on `input` is deprecated; set `value` and `onChange` instead.') : void 0;
          didWarnValueLink = true;
        }
        if (props.checkedLink !== undefined && !didWarnCheckedLink) {
          process.env.NODE_ENV !== 'production' ? warning(false, '`checkedLink` prop on `input` is deprecated; set `value` and `onChange` instead.') : void 0;
          didWarnCheckedLink = true;
        }
        if (props.checked !== undefined && props.defaultChecked !== undefined && !didWarnCheckedDefaultChecked) {
          process.env.NODE_ENV !== 'production' ? warning(false, '%s contains an input of type %s with both checked and defaultChecked props. ' + 'Input elements must be either controlled or uncontrolled ' + '(specify either the checked prop, or the defaultChecked prop, but not ' + 'both). Decide between using a controlled or uncontrolled input ' + 'element and remove one of these props. More info: ' + 'https://fb.me/react-controlled-components', owner && owner.getName() || 'A component', props.type) : void 0;
          didWarnCheckedDefaultChecked = true;
        }
        if (props.value !== undefined && props.defaultValue !== undefined && !didWarnValueDefaultValue) {
          process.env.NODE_ENV !== 'production' ? warning(false, '%s contains an input of type %s with both value and defaultValue props. ' + 'Input elements must be either controlled or uncontrolled ' + '(specify either the value prop, or the defaultValue prop, but not ' + 'both). Decide between using a controlled or uncontrolled input ' + 'element and remove one of these props. More info: ' + 'https://fb.me/react-controlled-components', owner && owner.getName() || 'A component', props.type) : void 0;
          didWarnValueDefaultValue = true;
        }
      }
      var defaultValue = props.defaultValue;
      inst._wrapperState = {
        initialChecked: props.checked != null ? props.checked : props.defaultChecked,
        initialValue: props.value != null ? props.value : defaultValue,
        listeners: null,
        onChange: _handleChange.bind(inst)
      };
      if (process.env.NODE_ENV !== 'production') {
        inst._wrapperState.controlled = isControlled(props);
      }
    },
    updateWrapper: function(inst) {
      var props = inst._currentElement.props;
      if (process.env.NODE_ENV !== 'production') {
        var controlled = isControlled(props);
        var owner = inst._currentElement._owner;
        if (!inst._wrapperState.controlled && controlled && !didWarnUncontrolledToControlled) {
          process.env.NODE_ENV !== 'production' ? warning(false, '%s is changing an uncontrolled input of type %s to be controlled. ' + 'Input elements should not switch from uncontrolled to controlled (or vice versa). ' + 'Decide between using a controlled or uncontrolled input ' + 'element for the lifetime of the component. More info: https://fb.me/react-controlled-components', owner && owner.getName() || 'A component', props.type) : void 0;
          didWarnUncontrolledToControlled = true;
        }
        if (inst._wrapperState.controlled && !controlled && !didWarnControlledToUncontrolled) {
          process.env.NODE_ENV !== 'production' ? warning(false, '%s is changing a controlled input of type %s to be uncontrolled. ' + 'Input elements should not switch from controlled to uncontrolled (or vice versa). ' + 'Decide between using a controlled or uncontrolled input ' + 'element for the lifetime of the component. More info: https://fb.me/react-controlled-components', owner && owner.getName() || 'A component', props.type) : void 0;
          didWarnControlledToUncontrolled = true;
        }
      }
      var checked = props.checked;
      if (checked != null) {
        DOMPropertyOperations.setValueForProperty(ReactDOMComponentTree.getNodeFromInstance(inst), 'checked', checked || false);
      }
      var node = ReactDOMComponentTree.getNodeFromInstance(inst);
      var value = LinkedValueUtils.getValue(props);
      if (value != null) {
        var newValue = '' + value;
        if (newValue !== node.value) {
          node.value = newValue;
        }
      } else {
        if (props.value == null && props.defaultValue != null) {
          node.defaultValue = '' + props.defaultValue;
        }
        if (props.checked == null && props.defaultChecked != null) {
          node.defaultChecked = !!props.defaultChecked;
        }
      }
    },
    postMountWrapper: function(inst) {
      var props = inst._currentElement.props;
      var node = ReactDOMComponentTree.getNodeFromInstance(inst);
      switch (props.type) {
        case 'submit':
        case 'reset':
          break;
        case 'color':
        case 'date':
        case 'datetime':
        case 'datetime-local':
        case 'month':
        case 'time':
        case 'week':
          node.value = '';
          node.value = node.defaultValue;
          break;
        default:
          node.value = node.value;
          break;
      }
      var name = node.name;
      if (name !== '') {
        node.name = '';
      }
      node.defaultChecked = !node.defaultChecked;
      node.defaultChecked = !node.defaultChecked;
      if (name !== '') {
        node.name = name;
      }
    }
  };
  function _handleChange(event) {
    var props = this._currentElement.props;
    var returnValue = LinkedValueUtils.executeOnChange(props, event);
    ReactUpdates.asap(forceUpdateIfMounted, this);
    var name = props.name;
    if (props.type === 'radio' && name != null) {
      var rootNode = ReactDOMComponentTree.getNodeFromInstance(this);
      var queryRoot = rootNode;
      while (queryRoot.parentNode) {
        queryRoot = queryRoot.parentNode;
      }
      var group = queryRoot.querySelectorAll('input[name=' + JSON.stringify('' + name) + '][type="radio"]');
      for (var i = 0; i < group.length; i++) {
        var otherNode = group[i];
        if (otherNode === rootNode || otherNode.form !== rootNode.form) {
          continue;
        }
        var otherInstance = ReactDOMComponentTree.getInstanceFromNode(otherNode);
        !otherInstance ? process.env.NODE_ENV !== 'production' ? invariant(false, 'ReactDOMInput: Mixing React and non-React radio inputs with the same `name` is not supported.') : _prodInvariant('90') : void 0;
        ReactUpdates.asap(forceUpdateIfMounted, otherInstance);
      }
    }
    return returnValue;
  }
  module.exports = ReactDOMInput;
})(require('process'));
