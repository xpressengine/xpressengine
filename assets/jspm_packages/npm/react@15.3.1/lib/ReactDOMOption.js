/* */ 
(function(process) {
  'use strict';
  var _assign = require('object-assign');
  var ReactChildren = require('./ReactChildren');
  var ReactDOMComponentTree = require('./ReactDOMComponentTree');
  var ReactDOMSelect = require('./ReactDOMSelect');
  var warning = require('fbjs/lib/warning');
  var didWarnInvalidOptionChildren = false;
  function flattenChildren(children) {
    var content = '';
    ReactChildren.forEach(children, function(child) {
      if (child == null) {
        return;
      }
      if (typeof child === 'string' || typeof child === 'number') {
        content += child;
      } else if (!didWarnInvalidOptionChildren) {
        didWarnInvalidOptionChildren = true;
        process.env.NODE_ENV !== 'production' ? warning(false, 'Only strings and numbers are supported as <option> children.') : void 0;
      }
    });
    return content;
  }
  var ReactDOMOption = {
    mountWrapper: function(inst, props, hostParent) {
      if (process.env.NODE_ENV !== 'production') {
        process.env.NODE_ENV !== 'production' ? warning(props.selected == null, 'Use the `defaultValue` or `value` props on <select> instead of ' + 'setting `selected` on <option>.') : void 0;
      }
      var selectValue = null;
      if (hostParent != null) {
        var selectParent = hostParent;
        if (selectParent._tag === 'optgroup') {
          selectParent = selectParent._hostParent;
        }
        if (selectParent != null && selectParent._tag === 'select') {
          selectValue = ReactDOMSelect.getSelectValueContext(selectParent);
        }
      }
      var selected = null;
      if (selectValue != null) {
        var value;
        if (props.value != null) {
          value = props.value + '';
        } else {
          value = flattenChildren(props.children);
        }
        selected = false;
        if (Array.isArray(selectValue)) {
          for (var i = 0; i < selectValue.length; i++) {
            if ('' + selectValue[i] === value) {
              selected = true;
              break;
            }
          }
        } else {
          selected = '' + selectValue === value;
        }
      }
      inst._wrapperState = {selected: selected};
    },
    postMountWrapper: function(inst) {
      var props = inst._currentElement.props;
      if (props.value != null) {
        var node = ReactDOMComponentTree.getNodeFromInstance(inst);
        node.setAttribute('value', props.value);
      }
    },
    getHostProps: function(inst, props) {
      var hostProps = _assign({
        selected: undefined,
        children: undefined
      }, props);
      if (inst._wrapperState.selected != null) {
        hostProps.selected = inst._wrapperState.selected;
      }
      var content = flattenChildren(props.children);
      if (content) {
        hostProps.children = content;
      }
      return hostProps;
    }
  };
  module.exports = ReactDOMOption;
})(require('process'));
