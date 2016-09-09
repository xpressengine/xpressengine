/* */ 
(function(process) {
  'use strict';
  var DOMProperty = require('./DOMProperty');
  var EventPluginRegistry = require('./EventPluginRegistry');
  var ReactComponentTreeHook = require('./ReactComponentTreeHook');
  var warning = require('fbjs/lib/warning');
  if (process.env.NODE_ENV !== 'production') {
    var reactProps = {
      children: true,
      dangerouslySetInnerHTML: true,
      key: true,
      ref: true,
      autoFocus: true,
      defaultValue: true,
      valueLink: true,
      defaultChecked: true,
      checkedLink: true,
      innerHTML: true,
      suppressContentEditableWarning: true,
      onFocusIn: true,
      onFocusOut: true
    };
    var warnedProperties = {};
    var validateProperty = function(tagName, name, debugID) {
      if (DOMProperty.properties.hasOwnProperty(name) || DOMProperty.isCustomAttribute(name)) {
        return true;
      }
      if (reactProps.hasOwnProperty(name) && reactProps[name] || warnedProperties.hasOwnProperty(name) && warnedProperties[name]) {
        return true;
      }
      if (EventPluginRegistry.registrationNameModules.hasOwnProperty(name)) {
        return true;
      }
      warnedProperties[name] = true;
      var lowerCasedName = name.toLowerCase();
      var standardName = DOMProperty.isCustomAttribute(lowerCasedName) ? lowerCasedName : DOMProperty.getPossibleStandardName.hasOwnProperty(lowerCasedName) ? DOMProperty.getPossibleStandardName[lowerCasedName] : null;
      var registrationName = EventPluginRegistry.possibleRegistrationNames.hasOwnProperty(lowerCasedName) ? EventPluginRegistry.possibleRegistrationNames[lowerCasedName] : null;
      if (standardName != null) {
        process.env.NODE_ENV !== 'production' ? warning(false, 'Unknown DOM property %s. Did you mean %s?%s', name, standardName, ReactComponentTreeHook.getStackAddendumByID(debugID)) : void 0;
        return true;
      } else if (registrationName != null) {
        process.env.NODE_ENV !== 'production' ? warning(false, 'Unknown event handler property %s. Did you mean `%s`?%s', name, registrationName, ReactComponentTreeHook.getStackAddendumByID(debugID)) : void 0;
        return true;
      } else {
        return false;
      }
    };
  }
  var warnUnknownProperties = function(debugID, element) {
    var unknownProps = [];
    for (var key in element.props) {
      var isValid = validateProperty(element.type, key, debugID);
      if (!isValid) {
        unknownProps.push(key);
      }
    }
    var unknownPropString = unknownProps.map(function(prop) {
      return '`' + prop + '`';
    }).join(', ');
    if (unknownProps.length === 1) {
      process.env.NODE_ENV !== 'production' ? warning(false, 'Unknown prop %s on <%s> tag. Remove this prop from the element. ' + 'For details, see https://fb.me/react-unknown-prop%s', unknownPropString, element.type, ReactComponentTreeHook.getStackAddendumByID(debugID)) : void 0;
    } else if (unknownProps.length > 1) {
      process.env.NODE_ENV !== 'production' ? warning(false, 'Unknown props %s on <%s> tag. Remove these props from the element. ' + 'For details, see https://fb.me/react-unknown-prop%s', unknownPropString, element.type, ReactComponentTreeHook.getStackAddendumByID(debugID)) : void 0;
    }
  };
  function handleElement(debugID, element) {
    if (element == null || typeof element.type !== 'string') {
      return;
    }
    if (element.type.indexOf('-') >= 0 || element.props.is) {
      return;
    }
    warnUnknownProperties(debugID, element);
  }
  var ReactDOMUnknownPropertyHook = {
    onBeforeMountComponent: function(debugID, element) {
      handleElement(debugID, element);
    },
    onBeforeUpdateComponent: function(debugID, element) {
      handleElement(debugID, element);
    }
  };
  module.exports = ReactDOMUnknownPropertyHook;
})(require('process'));
