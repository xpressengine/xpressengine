/* */ 
(function(process) {
  'use strict';
  var CSSProperty = require('./CSSProperty');
  var warning = require('fbjs/lib/warning');
  var isUnitlessNumber = CSSProperty.isUnitlessNumber;
  var styleWarnings = {};
  function dangerousStyleValue(name, value, component) {
    var isEmpty = value == null || typeof value === 'boolean' || value === '';
    if (isEmpty) {
      return '';
    }
    var isNonNumeric = isNaN(value);
    if (isNonNumeric || value === 0 || isUnitlessNumber.hasOwnProperty(name) && isUnitlessNumber[name]) {
      return '' + value;
    }
    if (typeof value === 'string') {
      if (process.env.NODE_ENV !== 'production') {
        if (component && value !== '0') {
          var owner = component._currentElement._owner;
          var ownerName = owner ? owner.getName() : null;
          if (ownerName && !styleWarnings[ownerName]) {
            styleWarnings[ownerName] = {};
          }
          var warned = false;
          if (ownerName) {
            var warnings = styleWarnings[ownerName];
            warned = warnings[name];
            if (!warned) {
              warnings[name] = true;
            }
          }
          if (!warned) {
            process.env.NODE_ENV !== 'production' ? warning(false, 'a `%s` tag (owner: `%s`) was passed a numeric string value ' + 'for CSS property `%s` (value: `%s`) which will be treated ' + 'as a unitless number in a future version of React.', component._currentElement.type, ownerName || 'unknown', name, value) : void 0;
          }
        }
      }
      value = value.trim();
    }
    return value + 'px';
  }
  module.exports = dangerousStyleValue;
})(require('process'));
