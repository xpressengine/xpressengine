/* */ 
(function(process) {
  'use strict';
  var _assign = require('object-assign');
  var ReactCurrentOwner = require('./ReactCurrentOwner');
  var warning = require('fbjs/lib/warning');
  var canDefineProperty = require('./canDefineProperty');
  var hasOwnProperty = Object.prototype.hasOwnProperty;
  var REACT_ELEMENT_TYPE = typeof Symbol === 'function' && Symbol['for'] && Symbol['for']('react.element') || 0xeac7;
  var RESERVED_PROPS = {
    key: true,
    ref: true,
    __self: true,
    __source: true
  };
  var specialPropKeyWarningShown,
      specialPropRefWarningShown;
  function hasValidRef(config) {
    if (process.env.NODE_ENV !== 'production') {
      if (hasOwnProperty.call(config, 'ref')) {
        var getter = Object.getOwnPropertyDescriptor(config, 'ref').get;
        if (getter && getter.isReactWarning) {
          return false;
        }
      }
    }
    return config.ref !== undefined;
  }
  function hasValidKey(config) {
    if (process.env.NODE_ENV !== 'production') {
      if (hasOwnProperty.call(config, 'key')) {
        var getter = Object.getOwnPropertyDescriptor(config, 'key').get;
        if (getter && getter.isReactWarning) {
          return false;
        }
      }
    }
    return config.key !== undefined;
  }
  function defineKeyPropWarningGetter(props, displayName) {
    var warnAboutAccessingKey = function() {
      if (!specialPropKeyWarningShown) {
        specialPropKeyWarningShown = true;
        process.env.NODE_ENV !== 'production' ? warning(false, '%s: `key` is not a prop. Trying to access it will result ' + 'in `undefined` being returned. If you need to access the same ' + 'value within the child component, you should pass it as a different ' + 'prop. (https://fb.me/react-special-props)', displayName) : void 0;
      }
    };
    warnAboutAccessingKey.isReactWarning = true;
    Object.defineProperty(props, 'key', {
      get: warnAboutAccessingKey,
      configurable: true
    });
  }
  function defineRefPropWarningGetter(props, displayName) {
    var warnAboutAccessingRef = function() {
      if (!specialPropRefWarningShown) {
        specialPropRefWarningShown = true;
        process.env.NODE_ENV !== 'production' ? warning(false, '%s: `ref` is not a prop. Trying to access it will result ' + 'in `undefined` being returned. If you need to access the same ' + 'value within the child component, you should pass it as a different ' + 'prop. (https://fb.me/react-special-props)', displayName) : void 0;
      }
    };
    warnAboutAccessingRef.isReactWarning = true;
    Object.defineProperty(props, 'ref', {
      get: warnAboutAccessingRef,
      configurable: true
    });
  }
  var ReactElement = function(type, key, ref, self, source, owner, props) {
    var element = {
      $$typeof: REACT_ELEMENT_TYPE,
      type: type,
      key: key,
      ref: ref,
      props: props,
      _owner: owner
    };
    if (process.env.NODE_ENV !== 'production') {
      element._store = {};
      var shadowChildren = Array.isArray(props.children) ? props.children.slice(0) : props.children;
      if (canDefineProperty) {
        Object.defineProperty(element._store, 'validated', {
          configurable: false,
          enumerable: false,
          writable: true,
          value: false
        });
        Object.defineProperty(element, '_self', {
          configurable: false,
          enumerable: false,
          writable: false,
          value: self
        });
        Object.defineProperty(element, '_shadowChildren', {
          configurable: false,
          enumerable: false,
          writable: false,
          value: shadowChildren
        });
        Object.defineProperty(element, '_source', {
          configurable: false,
          enumerable: false,
          writable: false,
          value: source
        });
      } else {
        element._store.validated = false;
        element._self = self;
        element._shadowChildren = shadowChildren;
        element._source = source;
      }
      if (Object.freeze) {
        Object.freeze(element.props);
        Object.freeze(element);
      }
    }
    return element;
  };
  ReactElement.createElement = function(type, config, children) {
    var propName;
    var props = {};
    var key = null;
    var ref = null;
    var self = null;
    var source = null;
    if (config != null) {
      if (process.env.NODE_ENV !== 'production') {
        process.env.NODE_ENV !== 'production' ? warning(config.__proto__ == null || config.__proto__ === Object.prototype, 'React.createElement(...): Expected props argument to be a plain object. ' + 'Properties defined in its prototype chain will be ignored.') : void 0;
      }
      if (hasValidRef(config)) {
        ref = config.ref;
      }
      if (hasValidKey(config)) {
        key = '' + config.key;
      }
      self = config.__self === undefined ? null : config.__self;
      source = config.__source === undefined ? null : config.__source;
      for (propName in config) {
        if (hasOwnProperty.call(config, propName) && !RESERVED_PROPS.hasOwnProperty(propName)) {
          props[propName] = config[propName];
        }
      }
    }
    var childrenLength = arguments.length - 2;
    if (childrenLength === 1) {
      props.children = children;
    } else if (childrenLength > 1) {
      var childArray = Array(childrenLength);
      for (var i = 0; i < childrenLength; i++) {
        childArray[i] = arguments[i + 2];
      }
      props.children = childArray;
    }
    if (type && type.defaultProps) {
      var defaultProps = type.defaultProps;
      for (propName in defaultProps) {
        if (props[propName] === undefined) {
          props[propName] = defaultProps[propName];
        }
      }
    }
    if (process.env.NODE_ENV !== 'production') {
      if (key || ref) {
        if (typeof props.$$typeof === 'undefined' || props.$$typeof !== REACT_ELEMENT_TYPE) {
          var displayName = typeof type === 'function' ? type.displayName || type.name || 'Unknown' : type;
          if (key) {
            defineKeyPropWarningGetter(props, displayName);
          }
          if (ref) {
            defineRefPropWarningGetter(props, displayName);
          }
        }
      }
    }
    return ReactElement(type, key, ref, self, source, ReactCurrentOwner.current, props);
  };
  ReactElement.createFactory = function(type) {
    var factory = ReactElement.createElement.bind(null, type);
    factory.type = type;
    return factory;
  };
  ReactElement.cloneAndReplaceKey = function(oldElement, newKey) {
    var newElement = ReactElement(oldElement.type, newKey, oldElement.ref, oldElement._self, oldElement._source, oldElement._owner, oldElement.props);
    return newElement;
  };
  ReactElement.cloneElement = function(element, config, children) {
    var propName;
    var props = _assign({}, element.props);
    var key = element.key;
    var ref = element.ref;
    var self = element._self;
    var source = element._source;
    var owner = element._owner;
    if (config != null) {
      if (process.env.NODE_ENV !== 'production') {
        process.env.NODE_ENV !== 'production' ? warning(config.__proto__ == null || config.__proto__ === Object.prototype, 'React.cloneElement(...): Expected props argument to be a plain object. ' + 'Properties defined in its prototype chain will be ignored.') : void 0;
      }
      if (hasValidRef(config)) {
        ref = config.ref;
        owner = ReactCurrentOwner.current;
      }
      if (hasValidKey(config)) {
        key = '' + config.key;
      }
      var defaultProps;
      if (element.type && element.type.defaultProps) {
        defaultProps = element.type.defaultProps;
      }
      for (propName in config) {
        if (hasOwnProperty.call(config, propName) && !RESERVED_PROPS.hasOwnProperty(propName)) {
          if (config[propName] === undefined && defaultProps !== undefined) {
            props[propName] = defaultProps[propName];
          } else {
            props[propName] = config[propName];
          }
        }
      }
    }
    var childrenLength = arguments.length - 2;
    if (childrenLength === 1) {
      props.children = children;
    } else if (childrenLength > 1) {
      var childArray = Array(childrenLength);
      for (var i = 0; i < childrenLength; i++) {
        childArray[i] = arguments[i + 2];
      }
      props.children = childArray;
    }
    return ReactElement(element.type, key, ref, self, source, owner, props);
  };
  ReactElement.isValidElement = function(object) {
    return typeof object === 'object' && object !== null && object.$$typeof === REACT_ELEMENT_TYPE;
  };
  ReactElement.REACT_ELEMENT_TYPE = REACT_ELEMENT_TYPE;
  module.exports = ReactElement;
})(require('process'));
