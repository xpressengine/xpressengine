/* */ 
(function(process) {
  'use strict';
  var ReactNativePropRegistry = require('./ReactNativePropRegistry');
  var deepDiffer = require('react-native/lib/deepDiffer');
  var flattenStyle = require('react-native/lib/flattenStyle');
  var emptyObject = {};
  var removedKeys = null;
  var removedKeyCount = 0;
  function defaultDiffer(prevProp, nextProp) {
    if (typeof nextProp !== 'object' || nextProp === null) {
      return true;
    } else {
      return deepDiffer(prevProp, nextProp);
    }
  }
  function resolveObject(idOrObject) {
    if (typeof idOrObject === 'number') {
      return ReactNativePropRegistry.getByID(idOrObject);
    }
    return idOrObject;
  }
  function restoreDeletedValuesInNestedArray(updatePayload, node, validAttributes) {
    if (Array.isArray(node)) {
      var i = node.length;
      while (i-- && removedKeyCount > 0) {
        restoreDeletedValuesInNestedArray(updatePayload, node[i], validAttributes);
      }
    } else if (node && removedKeyCount > 0) {
      var obj = resolveObject(node);
      for (var propKey in removedKeys) {
        if (!removedKeys[propKey]) {
          continue;
        }
        var nextProp = obj[propKey];
        if (nextProp === undefined) {
          continue;
        }
        var attributeConfig = validAttributes[propKey];
        if (!attributeConfig) {
          continue;
        }
        if (typeof nextProp === 'function') {
          nextProp = true;
        }
        if (typeof nextProp === 'undefined') {
          nextProp = null;
        }
        if (typeof attributeConfig !== 'object') {
          updatePayload[propKey] = nextProp;
        } else if (typeof attributeConfig.diff === 'function' || typeof attributeConfig.process === 'function') {
          var nextValue = typeof attributeConfig.process === 'function' ? attributeConfig.process(nextProp) : nextProp;
          updatePayload[propKey] = nextValue;
        }
        removedKeys[propKey] = false;
        removedKeyCount--;
      }
    }
  }
  function diffNestedArrayProperty(updatePayload, prevArray, nextArray, validAttributes) {
    var minLength = prevArray.length < nextArray.length ? prevArray.length : nextArray.length;
    var i;
    for (i = 0; i < minLength; i++) {
      updatePayload = diffNestedProperty(updatePayload, prevArray[i], nextArray[i], validAttributes);
    }
    for (; i < prevArray.length; i++) {
      updatePayload = clearNestedProperty(updatePayload, prevArray[i], validAttributes);
    }
    for (; i < nextArray.length; i++) {
      updatePayload = addNestedProperty(updatePayload, nextArray[i], validAttributes);
    }
    return updatePayload;
  }
  function diffNestedProperty(updatePayload, prevProp, nextProp, validAttributes) {
    if (!updatePayload && prevProp === nextProp) {
      return updatePayload;
    }
    if (!prevProp || !nextProp) {
      if (nextProp) {
        return addNestedProperty(updatePayload, nextProp, validAttributes);
      }
      if (prevProp) {
        return clearNestedProperty(updatePayload, prevProp, validAttributes);
      }
      return updatePayload;
    }
    if (!Array.isArray(prevProp) && !Array.isArray(nextProp)) {
      return diffProperties(updatePayload, resolveObject(prevProp), resolveObject(nextProp), validAttributes);
    }
    if (Array.isArray(prevProp) && Array.isArray(nextProp)) {
      return diffNestedArrayProperty(updatePayload, prevProp, nextProp, validAttributes);
    }
    if (Array.isArray(prevProp)) {
      return diffProperties(updatePayload, flattenStyle(prevProp), resolveObject(nextProp), validAttributes);
    }
    return diffProperties(updatePayload, resolveObject(prevProp), flattenStyle(nextProp), validAttributes);
  }
  function addNestedProperty(updatePayload, nextProp, validAttributes) {
    if (!nextProp) {
      return updatePayload;
    }
    if (!Array.isArray(nextProp)) {
      return addProperties(updatePayload, resolveObject(nextProp), validAttributes);
    }
    for (var i = 0; i < nextProp.length; i++) {
      updatePayload = addNestedProperty(updatePayload, nextProp[i], validAttributes);
    }
    return updatePayload;
  }
  function clearNestedProperty(updatePayload, prevProp, validAttributes) {
    if (!prevProp) {
      return updatePayload;
    }
    if (!Array.isArray(prevProp)) {
      return clearProperties(updatePayload, resolveObject(prevProp), validAttributes);
    }
    for (var i = 0; i < prevProp.length; i++) {
      updatePayload = clearNestedProperty(updatePayload, prevProp[i], validAttributes);
    }
    return updatePayload;
  }
  function diffProperties(updatePayload, prevProps, nextProps, validAttributes) {
    var attributeConfig;
    var nextProp;
    var prevProp;
    for (var propKey in nextProps) {
      attributeConfig = validAttributes[propKey];
      if (!attributeConfig) {
        continue;
      }
      prevProp = prevProps[propKey];
      nextProp = nextProps[propKey];
      if (typeof nextProp === 'function') {
        nextProp = true;
        if (typeof prevProp === 'function') {
          prevProp = true;
        }
      }
      if (typeof nextProp === 'undefined') {
        nextProp = null;
        if (typeof prevProp === 'undefined') {
          prevProp = null;
        }
      }
      if (removedKeys) {
        removedKeys[propKey] = false;
      }
      if (updatePayload && updatePayload[propKey] !== undefined) {
        if (typeof attributeConfig !== 'object') {
          updatePayload[propKey] = nextProp;
        } else if (typeof attributeConfig.diff === 'function' || typeof attributeConfig.process === 'function') {
          var nextValue = typeof attributeConfig.process === 'function' ? attributeConfig.process(nextProp) : nextProp;
          updatePayload[propKey] = nextValue;
        }
        continue;
      }
      if (prevProp === nextProp) {
        continue;
      }
      if (typeof attributeConfig !== 'object') {
        if (defaultDiffer(prevProp, nextProp)) {
          (updatePayload || (updatePayload = {}))[propKey] = nextProp;
        }
      } else if (typeof attributeConfig.diff === 'function' || typeof attributeConfig.process === 'function') {
        var shouldUpdate = prevProp === undefined || (typeof attributeConfig.diff === 'function' ? attributeConfig.diff(prevProp, nextProp) : defaultDiffer(prevProp, nextProp));
        if (shouldUpdate) {
          nextValue = typeof attributeConfig.process === 'function' ? attributeConfig.process(nextProp) : nextProp;
          (updatePayload || (updatePayload = {}))[propKey] = nextValue;
        }
      } else {
        removedKeys = null;
        removedKeyCount = 0;
        updatePayload = diffNestedProperty(updatePayload, prevProp, nextProp, attributeConfig);
        if (removedKeyCount > 0 && updatePayload) {
          restoreDeletedValuesInNestedArray(updatePayload, nextProp, attributeConfig);
          removedKeys = null;
        }
      }
    }
    for (propKey in prevProps) {
      if (nextProps[propKey] !== undefined) {
        continue;
      }
      attributeConfig = validAttributes[propKey];
      if (!attributeConfig) {
        continue;
      }
      if (updatePayload && updatePayload[propKey] !== undefined) {
        continue;
      }
      prevProp = prevProps[propKey];
      if (prevProp === undefined) {
        continue;
      }
      if (typeof attributeConfig !== 'object' || typeof attributeConfig.diff === 'function' || typeof attributeConfig.process === 'function') {
        (updatePayload || (updatePayload = {}))[propKey] = null;
        if (!removedKeys) {
          removedKeys = {};
        }
        if (!removedKeys[propKey]) {
          removedKeys[propKey] = true;
          removedKeyCount++;
        }
      } else {
        updatePayload = clearNestedProperty(updatePayload, prevProp, attributeConfig);
      }
    }
    return updatePayload;
  }
  function addProperties(updatePayload, props, validAttributes) {
    return diffProperties(updatePayload, emptyObject, props, validAttributes);
  }
  function clearProperties(updatePayload, prevProps, validAttributes) {
    return diffProperties(updatePayload, prevProps, emptyObject, validAttributes);
  }
  var ReactNativeAttributePayload = {
    create: function(props, validAttributes) {
      return addProperties(null, props, validAttributes);
    },
    diff: function(prevProps, nextProps, validAttributes) {
      return diffProperties(null, prevProps, nextProps, validAttributes);
    }
  };
  module.exports = ReactNativeAttributePayload;
})(require('process'));
