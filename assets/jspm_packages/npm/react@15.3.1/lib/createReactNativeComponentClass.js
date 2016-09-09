/* */ 
'use strict';
var ReactNativeBaseComponent = require('./ReactNativeBaseComponent');
var createReactNativeComponentClass = function(viewConfig) {
  var Constructor = function(element) {
    this._currentElement = element;
    this._topLevelWrapper = null;
    this._hostParent = null;
    this._hostContainerInfo = null;
    this._rootNodeID = 0;
    this._renderedChildren = null;
  };
  Constructor.displayName = viewConfig.uiViewClassName;
  Constructor.viewConfig = viewConfig;
  Constructor.propTypes = viewConfig.propTypes;
  Constructor.prototype = new ReactNativeBaseComponent(viewConfig);
  Constructor.prototype.constructor = Constructor;
  return Constructor;
};
module.exports = createReactNativeComponentClass;
