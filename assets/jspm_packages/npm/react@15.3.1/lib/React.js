/* */ 
(function(process) {
  'use strict';
  var _assign = require('object-assign');
  var ReactChildren = require('./ReactChildren');
  var ReactComponent = require('./ReactComponent');
  var ReactPureComponent = require('./ReactPureComponent');
  var ReactClass = require('./ReactClass');
  var ReactDOMFactories = require('./ReactDOMFactories');
  var ReactElement = require('./ReactElement');
  var ReactPropTypes = require('./ReactPropTypes');
  var ReactVersion = require('./ReactVersion');
  var onlyChild = require('./onlyChild');
  var warning = require('fbjs/lib/warning');
  var createElement = ReactElement.createElement;
  var createFactory = ReactElement.createFactory;
  var cloneElement = ReactElement.cloneElement;
  if (process.env.NODE_ENV !== 'production') {
    var ReactElementValidator = require('./ReactElementValidator');
    createElement = ReactElementValidator.createElement;
    createFactory = ReactElementValidator.createFactory;
    cloneElement = ReactElementValidator.cloneElement;
  }
  var __spread = _assign;
  if (process.env.NODE_ENV !== 'production') {
    var warned = false;
    __spread = function() {
      process.env.NODE_ENV !== 'production' ? warning(warned, 'React.__spread is deprecated and should not be used. Use ' + 'Object.assign directly or another helper function with similar ' + 'semantics. You may be seeing this warning due to your compiler. ' + 'See https://fb.me/react-spread-deprecation for more details.') : void 0;
      warned = true;
      return _assign.apply(null, arguments);
    };
  }
  var React = {
    Children: {
      map: ReactChildren.map,
      forEach: ReactChildren.forEach,
      count: ReactChildren.count,
      toArray: ReactChildren.toArray,
      only: onlyChild
    },
    Component: ReactComponent,
    PureComponent: ReactPureComponent,
    createElement: createElement,
    cloneElement: cloneElement,
    isValidElement: ReactElement.isValidElement,
    PropTypes: ReactPropTypes,
    createClass: ReactClass.createClass,
    createFactory: createFactory,
    createMixin: function(mixin) {
      return mixin;
    },
    DOM: ReactDOMFactories,
    version: ReactVersion,
    __spread: __spread
  };
  module.exports = React;
})(require('process'));
