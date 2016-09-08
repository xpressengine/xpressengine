/* */ 
(function(process) {
  'use strict';
  var ReactCurrentOwner = require('./ReactCurrentOwner');
  var ReactComponentTreeHook = require('./ReactComponentTreeHook');
  var ReactElement = require('./ReactElement');
  var ReactPropTypeLocations = require('./ReactPropTypeLocations');
  var checkReactTypeSpec = require('./checkReactTypeSpec');
  var canDefineProperty = require('./canDefineProperty');
  var getIteratorFn = require('./getIteratorFn');
  var warning = require('fbjs/lib/warning');
  function getDeclarationErrorAddendum() {
    if (ReactCurrentOwner.current) {
      var name = ReactCurrentOwner.current.getName();
      if (name) {
        return ' Check the render method of `' + name + '`.';
      }
    }
    return '';
  }
  var ownerHasKeyUseWarning = {};
  function getCurrentComponentErrorInfo(parentType) {
    var info = getDeclarationErrorAddendum();
    if (!info) {
      var parentName = typeof parentType === 'string' ? parentType : parentType.displayName || parentType.name;
      if (parentName) {
        info = ' Check the top-level render call using <' + parentName + '>.';
      }
    }
    return info;
  }
  function validateExplicitKey(element, parentType) {
    if (!element._store || element._store.validated || element.key != null) {
      return;
    }
    element._store.validated = true;
    var memoizer = ownerHasKeyUseWarning.uniqueKey || (ownerHasKeyUseWarning.uniqueKey = {});
    var currentComponentErrorInfo = getCurrentComponentErrorInfo(parentType);
    if (memoizer[currentComponentErrorInfo]) {
      return;
    }
    memoizer[currentComponentErrorInfo] = true;
    var childOwner = '';
    if (element && element._owner && element._owner !== ReactCurrentOwner.current) {
      childOwner = ' It was passed a child from ' + element._owner.getName() + '.';
    }
    process.env.NODE_ENV !== 'production' ? warning(false, 'Each child in an array or iterator should have a unique "key" prop.' + '%s%s See https://fb.me/react-warning-keys for more information.%s', currentComponentErrorInfo, childOwner, ReactComponentTreeHook.getCurrentStackAddendum(element)) : void 0;
  }
  function validateChildKeys(node, parentType) {
    if (typeof node !== 'object') {
      return;
    }
    if (Array.isArray(node)) {
      for (var i = 0; i < node.length; i++) {
        var child = node[i];
        if (ReactElement.isValidElement(child)) {
          validateExplicitKey(child, parentType);
        }
      }
    } else if (ReactElement.isValidElement(node)) {
      if (node._store) {
        node._store.validated = true;
      }
    } else if (node) {
      var iteratorFn = getIteratorFn(node);
      if (iteratorFn) {
        if (iteratorFn !== node.entries) {
          var iterator = iteratorFn.call(node);
          var step;
          while (!(step = iterator.next()).done) {
            if (ReactElement.isValidElement(step.value)) {
              validateExplicitKey(step.value, parentType);
            }
          }
        }
      }
    }
  }
  function validatePropTypes(element) {
    var componentClass = element.type;
    if (typeof componentClass !== 'function') {
      return;
    }
    var name = componentClass.displayName || componentClass.name;
    if (componentClass.propTypes) {
      checkReactTypeSpec(componentClass.propTypes, element.props, ReactPropTypeLocations.prop, name, element, null);
    }
    if (typeof componentClass.getDefaultProps === 'function') {
      process.env.NODE_ENV !== 'production' ? warning(componentClass.getDefaultProps.isReactClassApproved, 'getDefaultProps is only used on classic React.createClass ' + 'definitions. Use a static property named `defaultProps` instead.') : void 0;
    }
  }
  var ReactElementValidator = {
    createElement: function(type, props, children) {
      var validType = typeof type === 'string' || typeof type === 'function';
      if (!validType) {
        process.env.NODE_ENV !== 'production' ? warning(false, 'React.createElement: type should not be null, undefined, boolean, or ' + 'number. It should be a string (for DOM elements) or a ReactClass ' + '(for composite components).%s', getDeclarationErrorAddendum()) : void 0;
      }
      var element = ReactElement.createElement.apply(this, arguments);
      if (element == null) {
        return element;
      }
      if (validType) {
        for (var i = 2; i < arguments.length; i++) {
          validateChildKeys(arguments[i], type);
        }
      }
      validatePropTypes(element);
      return element;
    },
    createFactory: function(type) {
      var validatedFactory = ReactElementValidator.createElement.bind(null, type);
      validatedFactory.type = type;
      if (process.env.NODE_ENV !== 'production') {
        if (canDefineProperty) {
          Object.defineProperty(validatedFactory, 'type', {
            enumerable: false,
            get: function() {
              process.env.NODE_ENV !== 'production' ? warning(false, 'Factory.type is deprecated. Access the class directly ' + 'before passing it to createFactory.') : void 0;
              Object.defineProperty(this, 'type', {value: type});
              return type;
            }
          });
        }
      }
      return validatedFactory;
    },
    cloneElement: function(element, props, children) {
      var newElement = ReactElement.cloneElement.apply(this, arguments);
      for (var i = 2; i < arguments.length; i++) {
        validateChildKeys(arguments[i], newElement.type);
      }
      validatePropTypes(newElement);
      return newElement;
    }
  };
  module.exports = ReactElementValidator;
})(require('process'));
