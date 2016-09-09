/* */ 
(function(process) {
  'use strict';
  var _assign = require('object-assign');
  var PooledClass = require('./PooledClass');
  var emptyFunction = require('fbjs/lib/emptyFunction');
  var warning = require('fbjs/lib/warning');
  var didWarnForAddedNewProperty = false;
  var isProxySupported = typeof Proxy === 'function';
  var shouldBeReleasedProperties = ['dispatchConfig', '_targetInst', 'nativeEvent', 'isDefaultPrevented', 'isPropagationStopped', '_dispatchListeners', '_dispatchInstances'];
  var EventInterface = {
    type: null,
    target: null,
    currentTarget: emptyFunction.thatReturnsNull,
    eventPhase: null,
    bubbles: null,
    cancelable: null,
    timeStamp: function(event) {
      return event.timeStamp || Date.now();
    },
    defaultPrevented: null,
    isTrusted: null
  };
  function SyntheticEvent(dispatchConfig, targetInst, nativeEvent, nativeEventTarget) {
    if (process.env.NODE_ENV !== 'production') {
      delete this.nativeEvent;
      delete this.preventDefault;
      delete this.stopPropagation;
    }
    this.dispatchConfig = dispatchConfig;
    this._targetInst = targetInst;
    this.nativeEvent = nativeEvent;
    var Interface = this.constructor.Interface;
    for (var propName in Interface) {
      if (!Interface.hasOwnProperty(propName)) {
        continue;
      }
      if (process.env.NODE_ENV !== 'production') {
        delete this[propName];
      }
      var normalize = Interface[propName];
      if (normalize) {
        this[propName] = normalize(nativeEvent);
      } else {
        if (propName === 'target') {
          this.target = nativeEventTarget;
        } else {
          this[propName] = nativeEvent[propName];
        }
      }
    }
    var defaultPrevented = nativeEvent.defaultPrevented != null ? nativeEvent.defaultPrevented : nativeEvent.returnValue === false;
    if (defaultPrevented) {
      this.isDefaultPrevented = emptyFunction.thatReturnsTrue;
    } else {
      this.isDefaultPrevented = emptyFunction.thatReturnsFalse;
    }
    this.isPropagationStopped = emptyFunction.thatReturnsFalse;
    return this;
  }
  _assign(SyntheticEvent.prototype, {
    preventDefault: function() {
      this.defaultPrevented = true;
      var event = this.nativeEvent;
      if (!event) {
        return;
      }
      if (event.preventDefault) {
        event.preventDefault();
      } else {
        event.returnValue = false;
      }
      this.isDefaultPrevented = emptyFunction.thatReturnsTrue;
    },
    stopPropagation: function() {
      var event = this.nativeEvent;
      if (!event) {
        return;
      }
      if (event.stopPropagation) {
        event.stopPropagation();
      } else if (typeof event.cancelBubble !== 'unknown') {
        event.cancelBubble = true;
      }
      this.isPropagationStopped = emptyFunction.thatReturnsTrue;
    },
    persist: function() {
      this.isPersistent = emptyFunction.thatReturnsTrue;
    },
    isPersistent: emptyFunction.thatReturnsFalse,
    destructor: function() {
      var Interface = this.constructor.Interface;
      for (var propName in Interface) {
        if (process.env.NODE_ENV !== 'production') {
          Object.defineProperty(this, propName, getPooledWarningPropertyDefinition(propName, Interface[propName]));
        } else {
          this[propName] = null;
        }
      }
      for (var i = 0; i < shouldBeReleasedProperties.length; i++) {
        this[shouldBeReleasedProperties[i]] = null;
      }
      if (process.env.NODE_ENV !== 'production') {
        Object.defineProperty(this, 'nativeEvent', getPooledWarningPropertyDefinition('nativeEvent', null));
        Object.defineProperty(this, 'preventDefault', getPooledWarningPropertyDefinition('preventDefault', emptyFunction));
        Object.defineProperty(this, 'stopPropagation', getPooledWarningPropertyDefinition('stopPropagation', emptyFunction));
      }
    }
  });
  SyntheticEvent.Interface = EventInterface;
  if (process.env.NODE_ENV !== 'production') {
    if (isProxySupported) {
      SyntheticEvent = new Proxy(SyntheticEvent, {
        construct: function(target, args) {
          return this.apply(target, Object.create(target.prototype), args);
        },
        apply: function(constructor, that, args) {
          return new Proxy(constructor.apply(that, args), {set: function(target, prop, value) {
              if (prop !== 'isPersistent' && !target.constructor.Interface.hasOwnProperty(prop) && shouldBeReleasedProperties.indexOf(prop) === -1) {
                process.env.NODE_ENV !== 'production' ? warning(didWarnForAddedNewProperty || target.isPersistent(), 'This synthetic event is reused for performance reasons. If you\'re ' + 'seeing this, you\'re adding a new property in the synthetic event object. ' + 'The property is never released. See ' + 'https://fb.me/react-event-pooling for more information.') : void 0;
                didWarnForAddedNewProperty = true;
              }
              target[prop] = value;
              return true;
            }});
        }
      });
    }
  }
  SyntheticEvent.augmentClass = function(Class, Interface) {
    var Super = this;
    var E = function() {};
    E.prototype = Super.prototype;
    var prototype = new E();
    _assign(prototype, Class.prototype);
    Class.prototype = prototype;
    Class.prototype.constructor = Class;
    Class.Interface = _assign({}, Super.Interface, Interface);
    Class.augmentClass = Super.augmentClass;
    PooledClass.addPoolingTo(Class, PooledClass.fourArgumentPooler);
  };
  PooledClass.addPoolingTo(SyntheticEvent, PooledClass.fourArgumentPooler);
  module.exports = SyntheticEvent;
  function getPooledWarningPropertyDefinition(propName, getVal) {
    var isFunction = typeof getVal === 'function';
    return {
      configurable: true,
      set: set,
      get: get
    };
    function set(val) {
      var action = isFunction ? 'setting the method' : 'setting the property';
      warn(action, 'This is effectively a no-op');
      return val;
    }
    function get() {
      var action = isFunction ? 'accessing the method' : 'accessing the property';
      var result = isFunction ? 'This is a no-op function' : 'This is set to null';
      warn(action, result);
      return getVal;
    }
    function warn(action, result) {
      var warningCondition = false;
      process.env.NODE_ENV !== 'production' ? warning(warningCondition, 'This synthetic event is reused for performance reasons. If you\'re seeing this, ' + 'you\'re %s `%s` on a released/nullified synthetic event. %s. ' + 'If you must keep the original synthetic event around, use event.persist(). ' + 'See https://fb.me/react-event-pooling for more information.', action, propName, result) : void 0;
    }
  }
})(require('process'));
