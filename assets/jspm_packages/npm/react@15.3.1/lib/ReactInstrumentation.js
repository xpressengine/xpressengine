/* */ 
(function(process) {
  'use strict';
  var debugTool = null;
  if (process.env.NODE_ENV !== 'production') {
    var ReactDebugTool = require('./ReactDebugTool');
    debugTool = ReactDebugTool;
  }
  module.exports = {debugTool: debugTool};
})(require('process'));
