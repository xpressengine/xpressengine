/* */ 
(function(process) {
  'use strict';
  var DOMProperty = require('./DOMProperty');
  var ReactDOMComponentTree = require('./ReactDOMComponentTree');
  var ReactInstrumentation = require('./ReactInstrumentation');
  var quoteAttributeValueForBrowser = require('./quoteAttributeValueForBrowser');
  var warning = require('fbjs/lib/warning');
  var VALID_ATTRIBUTE_NAME_REGEX = new RegExp('^[' + DOMProperty.ATTRIBUTE_NAME_START_CHAR + '][' + DOMProperty.ATTRIBUTE_NAME_CHAR + ']*$');
  var illegalAttributeNameCache = {};
  var validatedAttributeNameCache = {};
  function isAttributeNameSafe(attributeName) {
    if (validatedAttributeNameCache.hasOwnProperty(attributeName)) {
      return true;
    }
    if (illegalAttributeNameCache.hasOwnProperty(attributeName)) {
      return false;
    }
    if (VALID_ATTRIBUTE_NAME_REGEX.test(attributeName)) {
      validatedAttributeNameCache[attributeName] = true;
      return true;
    }
    illegalAttributeNameCache[attributeName] = true;
    process.env.NODE_ENV !== 'production' ? warning(false, 'Invalid attribute name: `%s`', attributeName) : void 0;
    return false;
  }
  function shouldIgnoreValue(propertyInfo, value) {
    return value == null || propertyInfo.hasBooleanValue && !value || propertyInfo.hasNumericValue && isNaN(value) || propertyInfo.hasPositiveNumericValue && value < 1 || propertyInfo.hasOverloadedBooleanValue && value === false;
  }
  var DOMPropertyOperations = {
    createMarkupForID: function(id) {
      return DOMProperty.ID_ATTRIBUTE_NAME + '=' + quoteAttributeValueForBrowser(id);
    },
    setAttributeForID: function(node, id) {
      node.setAttribute(DOMProperty.ID_ATTRIBUTE_NAME, id);
    },
    createMarkupForRoot: function() {
      return DOMProperty.ROOT_ATTRIBUTE_NAME + '=""';
    },
    setAttributeForRoot: function(node) {
      node.setAttribute(DOMProperty.ROOT_ATTRIBUTE_NAME, '');
    },
    createMarkupForProperty: function(name, value) {
      var propertyInfo = DOMProperty.properties.hasOwnProperty(name) ? DOMProperty.properties[name] : null;
      if (propertyInfo) {
        if (shouldIgnoreValue(propertyInfo, value)) {
          return '';
        }
        var attributeName = propertyInfo.attributeName;
        if (propertyInfo.hasBooleanValue || propertyInfo.hasOverloadedBooleanValue && value === true) {
          return attributeName + '=""';
        }
        return attributeName + '=' + quoteAttributeValueForBrowser(value);
      } else if (DOMProperty.isCustomAttribute(name)) {
        if (value == null) {
          return '';
        }
        return name + '=' + quoteAttributeValueForBrowser(value);
      }
      return null;
    },
    createMarkupForCustomAttribute: function(name, value) {
      if (!isAttributeNameSafe(name) || value == null) {
        return '';
      }
      return name + '=' + quoteAttributeValueForBrowser(value);
    },
    setValueForProperty: function(node, name, value) {
      var propertyInfo = DOMProperty.properties.hasOwnProperty(name) ? DOMProperty.properties[name] : null;
      if (propertyInfo) {
        var mutationMethod = propertyInfo.mutationMethod;
        if (mutationMethod) {
          mutationMethod(node, value);
        } else if (shouldIgnoreValue(propertyInfo, value)) {
          this.deleteValueForProperty(node, name);
          return;
        } else if (propertyInfo.mustUseProperty) {
          node[propertyInfo.propertyName] = value;
        } else {
          var attributeName = propertyInfo.attributeName;
          var namespace = propertyInfo.attributeNamespace;
          if (namespace) {
            node.setAttributeNS(namespace, attributeName, '' + value);
          } else if (propertyInfo.hasBooleanValue || propertyInfo.hasOverloadedBooleanValue && value === true) {
            node.setAttribute(attributeName, '');
          } else {
            node.setAttribute(attributeName, '' + value);
          }
        }
      } else if (DOMProperty.isCustomAttribute(name)) {
        DOMPropertyOperations.setValueForAttribute(node, name, value);
        return;
      }
      if (process.env.NODE_ENV !== 'production') {
        var payload = {};
        payload[name] = value;
        ReactInstrumentation.debugTool.onHostOperation(ReactDOMComponentTree.getInstanceFromNode(node)._debugID, 'update attribute', payload);
      }
    },
    setValueForAttribute: function(node, name, value) {
      if (!isAttributeNameSafe(name)) {
        return;
      }
      if (value == null) {
        node.removeAttribute(name);
      } else {
        node.setAttribute(name, '' + value);
      }
      if (process.env.NODE_ENV !== 'production') {
        var payload = {};
        payload[name] = value;
        ReactInstrumentation.debugTool.onHostOperation(ReactDOMComponentTree.getInstanceFromNode(node)._debugID, 'update attribute', payload);
      }
    },
    deleteValueForAttribute: function(node, name) {
      node.removeAttribute(name);
      if (process.env.NODE_ENV !== 'production') {
        ReactInstrumentation.debugTool.onHostOperation(ReactDOMComponentTree.getInstanceFromNode(node)._debugID, 'remove attribute', name);
      }
    },
    deleteValueForProperty: function(node, name) {
      var propertyInfo = DOMProperty.properties.hasOwnProperty(name) ? DOMProperty.properties[name] : null;
      if (propertyInfo) {
        var mutationMethod = propertyInfo.mutationMethod;
        if (mutationMethod) {
          mutationMethod(node, undefined);
        } else if (propertyInfo.mustUseProperty) {
          var propName = propertyInfo.propertyName;
          if (propertyInfo.hasBooleanValue) {
            node[propName] = false;
          } else {
            node[propName] = '';
          }
        } else {
          node.removeAttribute(propertyInfo.attributeName);
        }
      } else if (DOMProperty.isCustomAttribute(name)) {
        node.removeAttribute(name);
      }
      if (process.env.NODE_ENV !== 'production') {
        ReactInstrumentation.debugTool.onHostOperation(ReactDOMComponentTree.getInstanceFromNode(node)._debugID, 'remove attribute', name);
      }
    }
  };
  module.exports = DOMPropertyOperations;
})(require('process'));
