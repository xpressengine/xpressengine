/* */ 
(function(process) {
  'use strict';
  var ReactComponent = require('ReactComponent');
  var ReactCurrentOwner = require('ReactCurrentOwner');
  var ReactElement = require('ReactElement');
  var ReactErrorUtils = require('ReactErrorUtils');
  var ReactInstanceMap = require('ReactInstanceMap');
  var ReactLifeCycle = require('ReactLifeCycle');
  var ReactPropTypeLocations = require('ReactPropTypeLocations');
  var ReactPropTypeLocationNames = require('ReactPropTypeLocationNames');
  var ReactUpdateQueue = require('ReactUpdateQueue');
  var assign = require('Object.assign');
  var invariant = require('invariant');
  var keyMirror = require('keyMirror');
  var keyOf = require('keyOf');
  var warning = require('warning');
  var MIXINS_KEY = keyOf({mixins: null});
  var SpecPolicy = keyMirror({
    DEFINE_ONCE: null,
    DEFINE_MANY: null,
    OVERRIDE_BASE: null,
    DEFINE_MANY_MERGED: null
  });
  var injectedMixins = [];
  var ReactClassInterface = {
    mixins: SpecPolicy.DEFINE_MANY,
    statics: SpecPolicy.DEFINE_MANY,
    propTypes: SpecPolicy.DEFINE_MANY,
    contextTypes: SpecPolicy.DEFINE_MANY,
    childContextTypes: SpecPolicy.DEFINE_MANY,
    getDefaultProps: SpecPolicy.DEFINE_MANY_MERGED,
    getInitialState: SpecPolicy.DEFINE_MANY_MERGED,
    getChildContext: SpecPolicy.DEFINE_MANY_MERGED,
    render: SpecPolicy.DEFINE_ONCE,
    componentWillMount: SpecPolicy.DEFINE_MANY,
    componentDidMount: SpecPolicy.DEFINE_MANY,
    componentWillReceiveProps: SpecPolicy.DEFINE_MANY,
    shouldComponentUpdate: SpecPolicy.DEFINE_ONCE,
    componentWillUpdate: SpecPolicy.DEFINE_MANY,
    componentDidUpdate: SpecPolicy.DEFINE_MANY,
    componentWillUnmount: SpecPolicy.DEFINE_MANY,
    updateComponent: SpecPolicy.OVERRIDE_BASE
  };
  var RESERVED_SPEC_KEYS = {
    displayName: function(Constructor, displayName) {
      Constructor.displayName = displayName;
    },
    mixins: function(Constructor, mixins) {
      if (mixins) {
        for (var i = 0; i < mixins.length; i++) {
          mixSpecIntoComponent(Constructor, mixins[i]);
        }
      }
    },
    childContextTypes: function(Constructor, childContextTypes) {
      if (__DEV__) {
        validateTypeDef(Constructor, childContextTypes, ReactPropTypeLocations.childContext);
      }
      Constructor.childContextTypes = assign({}, Constructor.childContextTypes, childContextTypes);
    },
    contextTypes: function(Constructor, contextTypes) {
      if (__DEV__) {
        validateTypeDef(Constructor, contextTypes, ReactPropTypeLocations.context);
      }
      Constructor.contextTypes = assign({}, Constructor.contextTypes, contextTypes);
    },
    getDefaultProps: function(Constructor, getDefaultProps) {
      if (Constructor.getDefaultProps) {
        Constructor.getDefaultProps = createMergedResultFunction(Constructor.getDefaultProps, getDefaultProps);
      } else {
        Constructor.getDefaultProps = getDefaultProps;
      }
    },
    propTypes: function(Constructor, propTypes) {
      if (__DEV__) {
        validateTypeDef(Constructor, propTypes, ReactPropTypeLocations.prop);
      }
      Constructor.propTypes = assign({}, Constructor.propTypes, propTypes);
    },
    statics: function(Constructor, statics) {
      mixStaticSpecIntoComponent(Constructor, statics);
    }
  };
  function validateTypeDef(Constructor, typeDef, location) {
    for (var propName in typeDef) {
      if (typeDef.hasOwnProperty(propName)) {
        warning(typeof typeDef[propName] === 'function', '%s: %s type `%s` is invalid; it must be a function, usually from ' + 'React.PropTypes.', Constructor.displayName || 'ReactClass', ReactPropTypeLocationNames[location], propName);
      }
    }
  }
  function validateMethodOverride(proto, name) {
    var specPolicy = ReactClassInterface.hasOwnProperty(name) ? ReactClassInterface[name] : null;
    if (ReactClassMixin.hasOwnProperty(name)) {
      invariant(specPolicy === SpecPolicy.OVERRIDE_BASE, 'ReactClassInterface: You are attempting to override ' + '`%s` from your class specification. Ensure that your method names ' + 'do not overlap with React methods.', name);
    }
    if (proto.hasOwnProperty(name)) {
      invariant(specPolicy === SpecPolicy.DEFINE_MANY || specPolicy === SpecPolicy.DEFINE_MANY_MERGED, 'ReactClassInterface: You are attempting to define ' + '`%s` on your component more than once. This conflict may be due ' + 'to a mixin.', name);
    }
  }
  function mixSpecIntoComponent(Constructor, spec) {
    if (!spec) {
      return;
    }
    invariant(typeof spec !== 'function', 'ReactClass: You\'re attempting to ' + 'use a component class as a mixin. Instead, just use a regular object.');
    invariant(!ReactElement.isValidElement(spec), 'ReactClass: You\'re attempting to ' + 'use a component as a mixin. Instead, just use a regular object.');
    var proto = Constructor.prototype;
    if (spec.hasOwnProperty(MIXINS_KEY)) {
      RESERVED_SPEC_KEYS.mixins(Constructor, spec.mixins);
    }
    for (var name in spec) {
      if (!spec.hasOwnProperty(name)) {
        continue;
      }
      if (name === MIXINS_KEY) {
        continue;
      }
      var property = spec[name];
      validateMethodOverride(proto, name);
      if (RESERVED_SPEC_KEYS.hasOwnProperty(name)) {
        RESERVED_SPEC_KEYS[name](Constructor, property);
      } else {
        var isReactClassMethod = ReactClassInterface.hasOwnProperty(name);
        var isAlreadyDefined = proto.hasOwnProperty(name);
        var markedDontBind = property && property.__reactDontBind;
        var isFunction = typeof property === 'function';
        var shouldAutoBind = isFunction && !isReactClassMethod && !isAlreadyDefined && !markedDontBind;
        if (shouldAutoBind) {
          if (!proto.__reactAutoBindMap) {
            proto.__reactAutoBindMap = {};
          }
          proto.__reactAutoBindMap[name] = property;
          proto[name] = property;
        } else {
          if (isAlreadyDefined) {
            var specPolicy = ReactClassInterface[name];
            invariant(isReactClassMethod && (specPolicy === SpecPolicy.DEFINE_MANY_MERGED || specPolicy === SpecPolicy.DEFINE_MANY), 'ReactClass: Unexpected spec policy %s for key %s ' + 'when mixing in component specs.', specPolicy, name);
            if (specPolicy === SpecPolicy.DEFINE_MANY_MERGED) {
              proto[name] = createMergedResultFunction(proto[name], property);
            } else if (specPolicy === SpecPolicy.DEFINE_MANY) {
              proto[name] = createChainedFunction(proto[name], property);
            }
          } else {
            proto[name] = property;
            if (__DEV__) {
              if (typeof property === 'function' && spec.displayName) {
                proto[name].displayName = spec.displayName + '_' + name;
              }
            }
          }
        }
      }
    }
  }
  function mixStaticSpecIntoComponent(Constructor, statics) {
    if (!statics) {
      return;
    }
    for (var name in statics) {
      var property = statics[name];
      if (!statics.hasOwnProperty(name)) {
        continue;
      }
      var isReserved = name in RESERVED_SPEC_KEYS;
      invariant(!isReserved, 'ReactClass: You are attempting to define a reserved ' + 'property, `%s`, that shouldn\'t be on the "statics" key. Define it ' + 'as an instance property instead; it will still be accessible on the ' + 'constructor.', name);
      var isInherited = name in Constructor;
      invariant(!isInherited, 'ReactClass: You are attempting to define ' + '`%s` on your component more than once. This conflict may be ' + 'due to a mixin.', name);
      Constructor[name] = property;
    }
  }
  function mergeIntoWithNoDuplicateKeys(one, two) {
    invariant(one && two && typeof one === 'object' && typeof two === 'object', 'mergeIntoWithNoDuplicateKeys(): Cannot merge non-objects.');
    for (var key in two) {
      if (two.hasOwnProperty(key)) {
        invariant(one[key] === undefined, 'mergeIntoWithNoDuplicateKeys(): ' + 'Tried to merge two objects with the same key: `%s`. This conflict ' + 'may be due to a mixin; in particular, this may be caused by two ' + 'getInitialState() or getDefaultProps() methods returning objects ' + 'with clashing keys.', key);
        one[key] = two[key];
      }
    }
    return one;
  }
  function createMergedResultFunction(one, two) {
    return function mergedResult() {
      var a = one.apply(this, arguments);
      var b = two.apply(this, arguments);
      if (a == null) {
        return b;
      } else if (b == null) {
        return a;
      }
      var c = {};
      mergeIntoWithNoDuplicateKeys(c, a);
      mergeIntoWithNoDuplicateKeys(c, b);
      return c;
    };
  }
  function createChainedFunction(one, two) {
    return function chainedFunction() {
      one.apply(this, arguments);
      two.apply(this, arguments);
    };
  }
  function bindAutoBindMethod(component, method) {
    var boundMethod = method.bind(component);
    if (__DEV__) {
      boundMethod.__reactBoundContext = component;
      boundMethod.__reactBoundMethod = method;
      boundMethod.__reactBoundArguments = null;
      var componentName = component.constructor.displayName;
      var _bind = boundMethod.bind;
      boundMethod.bind = function(newThis, ...args) {
        if (newThis !== component && newThis !== null) {
          warning(false, 'bind(): React component methods may only be bound to the ' + 'component instance. See %s', componentName);
        } else if (!args.length) {
          warning(false, 'bind(): You are binding a component method to the component. ' + 'React does this for you automatically in a high-performance ' + 'way, so you can safely remove this call. See %s', componentName);
          return boundMethod;
        }
        var reboundMethod = _bind.apply(boundMethod, arguments);
        reboundMethod.__reactBoundContext = component;
        reboundMethod.__reactBoundMethod = method;
        reboundMethod.__reactBoundArguments = args;
        return reboundMethod;
      };
    }
    return boundMethod;
  }
  function bindAutoBindMethods(component) {
    for (var autoBindKey in component.__reactAutoBindMap) {
      if (component.__reactAutoBindMap.hasOwnProperty(autoBindKey)) {
        var method = component.__reactAutoBindMap[autoBindKey];
        component[autoBindKey] = bindAutoBindMethod(component, ReactErrorUtils.guard(method, component.constructor.displayName + '.' + autoBindKey));
      }
    }
  }
  var typeDeprecationDescriptor = {
    enumerable: false,
    get: function() {
      var displayName = this.displayName || this.name || 'Component';
      warning(false, '%s.type is deprecated. Use %s directly to access the class.', displayName, displayName);
      Object.defineProperty(this, 'type', {value: this});
      return this;
    }
  };
  var ReactClassMixin = {
    replaceState: function(newState, callback) {
      ReactUpdateQueue.enqueueReplaceState(this, newState);
      if (callback) {
        ReactUpdateQueue.enqueueCallback(this, callback);
      }
    },
    isMounted: function() {
      if (__DEV__) {
        var owner = ReactCurrentOwner.current;
        if (owner !== null) {
          warning(owner._warnedAboutRefsInRender, '%s is accessing isMounted inside its render() function. ' + 'render() should be a pure function of props and state. It should ' + 'never access something that requires stale data from the previous ' + 'render, such as refs. Move this logic to componentDidMount and ' + 'componentDidUpdate instead.', owner.getName() || 'A component');
          owner._warnedAboutRefsInRender = true;
        }
      }
      var internalInstance = ReactInstanceMap.get(this);
      return (internalInstance && internalInstance !== ReactLifeCycle.currentlyMountingInstance);
    },
    setProps: function(partialProps, callback) {
      ReactUpdateQueue.enqueueSetProps(this, partialProps);
      if (callback) {
        ReactUpdateQueue.enqueueCallback(this, callback);
      }
    },
    replaceProps: function(newProps, callback) {
      ReactUpdateQueue.enqueueReplaceProps(this, newProps);
      if (callback) {
        ReactUpdateQueue.enqueueCallback(this, callback);
      }
    }
  };
  var ReactClassComponent = function() {};
  assign(ReactClassComponent.prototype, ReactComponent.prototype, ReactClassMixin);
  var ReactClass = {
    createClass: function(spec) {
      var Constructor = function(props, context) {
        if (__DEV__) {
          warning(this instanceof Constructor, 'Something is calling a React component directly. Use a factory or ' + 'JSX instead. See: https://fb.me/react-legacyfactory');
        }
        if (this.__reactAutoBindMap) {
          bindAutoBindMethods(this);
        }
        this.props = props;
        this.context = context;
        this.state = null;
        var initialState = this.getInitialState ? this.getInitialState() : null;
        if (__DEV__) {
          if (typeof initialState === 'undefined' && this.getInitialState._isMockFunction) {
            initialState = null;
          }
        }
        invariant(typeof initialState === 'object' && !Array.isArray(initialState), '%s.getInitialState(): must return an object or null', Constructor.displayName || 'ReactCompositeComponent');
        this.state = initialState;
      };
      Constructor.prototype = new ReactClassComponent();
      Constructor.prototype.constructor = Constructor;
      injectedMixins.forEach(mixSpecIntoComponent.bind(null, Constructor));
      mixSpecIntoComponent(Constructor, spec);
      if (Constructor.getDefaultProps) {
        Constructor.defaultProps = Constructor.getDefaultProps();
      }
      if (__DEV__) {
        if (Constructor.getDefaultProps) {
          Constructor.getDefaultProps.isReactClassApproved = {};
        }
        if (Constructor.prototype.getInitialState) {
          Constructor.prototype.getInitialState.isReactClassApproved = {};
        }
      }
      invariant(Constructor.prototype.render, 'createClass(...): Class specification must implement a `render` method.');
      if (__DEV__) {
        warning(!Constructor.prototype.componentShouldUpdate, '%s has a method called ' + 'componentShouldUpdate(). Did you mean shouldComponentUpdate()? ' + 'The name is phrased as a question because the function is ' + 'expected to return a value.', spec.displayName || 'A component');
      }
      for (var methodName in ReactClassInterface) {
        if (!Constructor.prototype[methodName]) {
          Constructor.prototype[methodName] = null;
        }
      }
      Constructor.type = Constructor;
      if (__DEV__) {
        try {
          Object.defineProperty(Constructor, 'type', typeDeprecationDescriptor);
        } catch (x) {}
      }
      return Constructor;
    },
    injection: {injectMixin: function(mixin) {
        injectedMixins.push(mixin);
      }}
  };
  module.exports = ReactClass;
})(require('process'));
