/* */ 
(function(process) {
  'use strict';
  var _prodInvariant = require('./reactProdInvariant');
  var ReactCurrentOwner = require('./ReactCurrentOwner');
  var ReactElement = require('./ReactElement');
  var getIteratorFn = require('./getIteratorFn');
  var invariant = require('fbjs/lib/invariant');
  var KeyEscapeUtils = require('./KeyEscapeUtils');
  var warning = require('fbjs/lib/warning');
  var SEPARATOR = '.';
  var SUBSEPARATOR = ':';
  var didWarnAboutMaps = false;
  function getComponentKey(component, index) {
    if (component && typeof component === 'object' && component.key != null) {
      return KeyEscapeUtils.escape(component.key);
    }
    return index.toString(36);
  }
  function traverseAllChildrenImpl(children, nameSoFar, callback, traverseContext) {
    var type = typeof children;
    if (type === 'undefined' || type === 'boolean') {
      children = null;
    }
    if (children === null || type === 'string' || type === 'number' || ReactElement.isValidElement(children)) {
      callback(traverseContext, children, nameSoFar === '' ? SEPARATOR + getComponentKey(children, 0) : nameSoFar);
      return 1;
    }
    var child;
    var nextName;
    var subtreeCount = 0;
    var nextNamePrefix = nameSoFar === '' ? SEPARATOR : nameSoFar + SUBSEPARATOR;
    if (Array.isArray(children)) {
      for (var i = 0; i < children.length; i++) {
        child = children[i];
        nextName = nextNamePrefix + getComponentKey(child, i);
        subtreeCount += traverseAllChildrenImpl(child, nextName, callback, traverseContext);
      }
    } else {
      var iteratorFn = getIteratorFn(children);
      if (iteratorFn) {
        var iterator = iteratorFn.call(children);
        var step;
        if (iteratorFn !== children.entries) {
          var ii = 0;
          while (!(step = iterator.next()).done) {
            child = step.value;
            nextName = nextNamePrefix + getComponentKey(child, ii++);
            subtreeCount += traverseAllChildrenImpl(child, nextName, callback, traverseContext);
          }
        } else {
          if (process.env.NODE_ENV !== 'production') {
            var mapsAsChildrenAddendum = '';
            if (ReactCurrentOwner.current) {
              var mapsAsChildrenOwnerName = ReactCurrentOwner.current.getName();
              if (mapsAsChildrenOwnerName) {
                mapsAsChildrenAddendum = ' Check the render method of `' + mapsAsChildrenOwnerName + '`.';
              }
            }
            process.env.NODE_ENV !== 'production' ? warning(didWarnAboutMaps, 'Using Maps as children is not yet fully supported. It is an ' + 'experimental feature that might be removed. Convert it to a ' + 'sequence / iterable of keyed ReactElements instead.%s', mapsAsChildrenAddendum) : void 0;
            didWarnAboutMaps = true;
          }
          while (!(step = iterator.next()).done) {
            var entry = step.value;
            if (entry) {
              child = entry[1];
              nextName = nextNamePrefix + KeyEscapeUtils.escape(entry[0]) + SUBSEPARATOR + getComponentKey(child, 0);
              subtreeCount += traverseAllChildrenImpl(child, nextName, callback, traverseContext);
            }
          }
        }
      } else if (type === 'object') {
        var addendum = '';
        if (process.env.NODE_ENV !== 'production') {
          addendum = ' If you meant to render a collection of children, use an array ' + 'instead or wrap the object using createFragment(object) from the ' + 'React add-ons.';
          if (children._isReactElement) {
            addendum = ' It looks like you\'re using an element created by a different ' + 'version of React. Make sure to use only one copy of React.';
          }
          if (ReactCurrentOwner.current) {
            var name = ReactCurrentOwner.current.getName();
            if (name) {
              addendum += ' Check the render method of `' + name + '`.';
            }
          }
        }
        var childrenString = String(children);
        !false ? process.env.NODE_ENV !== 'production' ? invariant(false, 'Objects are not valid as a React child (found: %s).%s', childrenString === '[object Object]' ? 'object with keys {' + Object.keys(children).join(', ') + '}' : childrenString, addendum) : _prodInvariant('31', childrenString === '[object Object]' ? 'object with keys {' + Object.keys(children).join(', ') + '}' : childrenString, addendum) : void 0;
      }
    }
    return subtreeCount;
  }
  function traverseAllChildren(children, callback, traverseContext) {
    if (children == null) {
      return 0;
    }
    return traverseAllChildrenImpl(children, '', callback, traverseContext);
  }
  module.exports = traverseAllChildren;
})(require('process'));
