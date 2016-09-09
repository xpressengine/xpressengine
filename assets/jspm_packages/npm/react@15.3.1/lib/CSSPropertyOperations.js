/* */ 
(function(process) {
  'use strict';
  var CSSProperty = require('./CSSProperty');
  var ExecutionEnvironment = require('fbjs/lib/ExecutionEnvironment');
  var ReactInstrumentation = require('./ReactInstrumentation');
  var camelizeStyleName = require('fbjs/lib/camelizeStyleName');
  var dangerousStyleValue = require('./dangerousStyleValue');
  var hyphenateStyleName = require('fbjs/lib/hyphenateStyleName');
  var memoizeStringOnly = require('fbjs/lib/memoizeStringOnly');
  var warning = require('fbjs/lib/warning');
  var processStyleName = memoizeStringOnly(function(styleName) {
    return hyphenateStyleName(styleName);
  });
  var hasShorthandPropertyBug = false;
  var styleFloatAccessor = 'cssFloat';
  if (ExecutionEnvironment.canUseDOM) {
    var tempStyle = document.createElement('div').style;
    try {
      tempStyle.font = '';
    } catch (e) {
      hasShorthandPropertyBug = true;
    }
    if (document.documentElement.style.cssFloat === undefined) {
      styleFloatAccessor = 'styleFloat';
    }
  }
  if (process.env.NODE_ENV !== 'production') {
    var badVendoredStyleNamePattern = /^(?:webkit|moz|o)[A-Z]/;
    var badStyleValueWithSemicolonPattern = /;\s*$/;
    var warnedStyleNames = {};
    var warnedStyleValues = {};
    var warnedForNaNValue = false;
    var warnHyphenatedStyleName = function(name, owner) {
      if (warnedStyleNames.hasOwnProperty(name) && warnedStyleNames[name]) {
        return;
      }
      warnedStyleNames[name] = true;
      process.env.NODE_ENV !== 'production' ? warning(false, 'Unsupported style property %s. Did you mean %s?%s', name, camelizeStyleName(name), checkRenderMessage(owner)) : void 0;
    };
    var warnBadVendoredStyleName = function(name, owner) {
      if (warnedStyleNames.hasOwnProperty(name) && warnedStyleNames[name]) {
        return;
      }
      warnedStyleNames[name] = true;
      process.env.NODE_ENV !== 'production' ? warning(false, 'Unsupported vendor-prefixed style property %s. Did you mean %s?%s', name, name.charAt(0).toUpperCase() + name.slice(1), checkRenderMessage(owner)) : void 0;
    };
    var warnStyleValueWithSemicolon = function(name, value, owner) {
      if (warnedStyleValues.hasOwnProperty(value) && warnedStyleValues[value]) {
        return;
      }
      warnedStyleValues[value] = true;
      process.env.NODE_ENV !== 'production' ? warning(false, 'Style property values shouldn\'t contain a semicolon.%s ' + 'Try "%s: %s" instead.', checkRenderMessage(owner), name, value.replace(badStyleValueWithSemicolonPattern, '')) : void 0;
    };
    var warnStyleValueIsNaN = function(name, value, owner) {
      if (warnedForNaNValue) {
        return;
      }
      warnedForNaNValue = true;
      process.env.NODE_ENV !== 'production' ? warning(false, '`NaN` is an invalid value for the `%s` css style property.%s', name, checkRenderMessage(owner)) : void 0;
    };
    var checkRenderMessage = function(owner) {
      if (owner) {
        var name = owner.getName();
        if (name) {
          return ' Check the render method of `' + name + '`.';
        }
      }
      return '';
    };
    var warnValidStyle = function(name, value, component) {
      var owner;
      if (component) {
        owner = component._currentElement._owner;
      }
      if (name.indexOf('-') > -1) {
        warnHyphenatedStyleName(name, owner);
      } else if (badVendoredStyleNamePattern.test(name)) {
        warnBadVendoredStyleName(name, owner);
      } else if (badStyleValueWithSemicolonPattern.test(value)) {
        warnStyleValueWithSemicolon(name, value, owner);
      }
      if (typeof value === 'number' && isNaN(value)) {
        warnStyleValueIsNaN(name, value, owner);
      }
    };
  }
  var CSSPropertyOperations = {
    createMarkupForStyles: function(styles, component) {
      var serialized = '';
      for (var styleName in styles) {
        if (!styles.hasOwnProperty(styleName)) {
          continue;
        }
        var styleValue = styles[styleName];
        if (process.env.NODE_ENV !== 'production') {
          warnValidStyle(styleName, styleValue, component);
        }
        if (styleValue != null) {
          serialized += processStyleName(styleName) + ':';
          serialized += dangerousStyleValue(styleName, styleValue, component) + ';';
        }
      }
      return serialized || null;
    },
    setValueForStyles: function(node, styles, component) {
      if (process.env.NODE_ENV !== 'production') {
        ReactInstrumentation.debugTool.onHostOperation(component._debugID, 'update styles', styles);
      }
      var style = node.style;
      for (var styleName in styles) {
        if (!styles.hasOwnProperty(styleName)) {
          continue;
        }
        if (process.env.NODE_ENV !== 'production') {
          warnValidStyle(styleName, styles[styleName], component);
        }
        var styleValue = dangerousStyleValue(styleName, styles[styleName], component);
        if (styleName === 'float' || styleName === 'cssFloat') {
          styleName = styleFloatAccessor;
        }
        if (styleValue) {
          style[styleName] = styleValue;
        } else {
          var expansion = hasShorthandPropertyBug && CSSProperty.shorthandPropertyExpansions[styleName];
          if (expansion) {
            for (var individualStyleName in expansion) {
              style[individualStyleName] = '';
            }
          } else {
            style[styleName] = '';
          }
        }
      }
    }
  };
  module.exports = CSSPropertyOperations;
})(require('process'));
