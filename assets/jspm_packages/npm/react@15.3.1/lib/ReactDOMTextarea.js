/* */ 
(function(process) {
  'use strict';
  var _prodInvariant = require('./reactProdInvariant'),
      _assign = require('object-assign');
  var DisabledInputUtils = require('./DisabledInputUtils');
  var LinkedValueUtils = require('./LinkedValueUtils');
  var ReactDOMComponentTree = require('./ReactDOMComponentTree');
  var ReactUpdates = require('./ReactUpdates');
  var invariant = require('fbjs/lib/invariant');
  var warning = require('fbjs/lib/warning');
  var didWarnValueLink = false;
  var didWarnValDefaultVal = false;
  function forceUpdateIfMounted() {
    if (this._rootNodeID) {
      ReactDOMTextarea.updateWrapper(this);
    }
  }
  var ReactDOMTextarea = {
    getHostProps: function(inst, props) {
      !(props.dangerouslySetInnerHTML == null) ? process.env.NODE_ENV !== 'production' ? invariant(false, '`dangerouslySetInnerHTML` does not make sense on <textarea>.') : _prodInvariant('91') : void 0;
      var hostProps = _assign({}, DisabledInputUtils.getHostProps(inst, props), {
        value: undefined,
        defaultValue: undefined,
        children: '' + inst._wrapperState.initialValue,
        onChange: inst._wrapperState.onChange
      });
      return hostProps;
    },
    mountWrapper: function(inst, props) {
      if (process.env.NODE_ENV !== 'production') {
        LinkedValueUtils.checkPropTypes('textarea', props, inst._currentElement._owner);
        if (props.valueLink !== undefined && !didWarnValueLink) {
          process.env.NODE_ENV !== 'production' ? warning(false, '`valueLink` prop on `textarea` is deprecated; set `value` and `onChange` instead.') : void 0;
          didWarnValueLink = true;
        }
        if (props.value !== undefined && props.defaultValue !== undefined && !didWarnValDefaultVal) {
          process.env.NODE_ENV !== 'production' ? warning(false, 'Textarea elements must be either controlled or uncontrolled ' + '(specify either the value prop, or the defaultValue prop, but not ' + 'both). Decide between using a controlled or uncontrolled textarea ' + 'and remove one of these props. More info: ' + 'https://fb.me/react-controlled-components') : void 0;
          didWarnValDefaultVal = true;
        }
      }
      var value = LinkedValueUtils.getValue(props);
      var initialValue = value;
      if (value == null) {
        var defaultValue = props.defaultValue;
        var children = props.children;
        if (children != null) {
          if (process.env.NODE_ENV !== 'production') {
            process.env.NODE_ENV !== 'production' ? warning(false, 'Use the `defaultValue` or `value` props instead of setting ' + 'children on <textarea>.') : void 0;
          }
          !(defaultValue == null) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'If you supply `defaultValue` on a <textarea>, do not pass children.') : _prodInvariant('92') : void 0;
          if (Array.isArray(children)) {
            !(children.length <= 1) ? process.env.NODE_ENV !== 'production' ? invariant(false, '<textarea> can only have at most one child.') : _prodInvariant('93') : void 0;
            children = children[0];
          }
          defaultValue = '' + children;
        }
        if (defaultValue == null) {
          defaultValue = '';
        }
        initialValue = defaultValue;
      }
      inst._wrapperState = {
        initialValue: '' + initialValue,
        listeners: null,
        onChange: _handleChange.bind(inst)
      };
    },
    updateWrapper: function(inst) {
      var props = inst._currentElement.props;
      var node = ReactDOMComponentTree.getNodeFromInstance(inst);
      var value = LinkedValueUtils.getValue(props);
      if (value != null) {
        var newValue = '' + value;
        if (newValue !== node.value) {
          node.value = newValue;
        }
        if (props.defaultValue == null) {
          node.defaultValue = newValue;
        }
      }
      if (props.defaultValue != null) {
        node.defaultValue = props.defaultValue;
      }
    },
    postMountWrapper: function(inst) {
      var node = ReactDOMComponentTree.getNodeFromInstance(inst);
      node.value = node.textContent;
    }
  };
  function _handleChange(event) {
    var props = this._currentElement.props;
    var returnValue = LinkedValueUtils.executeOnChange(props, event);
    ReactUpdates.asap(forceUpdateIfMounted, this);
    return returnValue;
  }
  module.exports = ReactDOMTextarea;
})(require('process'));
