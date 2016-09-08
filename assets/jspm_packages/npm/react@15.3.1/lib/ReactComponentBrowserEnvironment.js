/* */ 
(function(process) {
  'use strict';
  var DOMChildrenOperations = require('./DOMChildrenOperations');
  var ReactDOMIDOperations = require('./ReactDOMIDOperations');
  var ReactComponentBrowserEnvironment = {
    processChildrenUpdates: ReactDOMIDOperations.dangerouslyProcessChildrenUpdates,
    replaceNodeWithMarkup: DOMChildrenOperations.dangerouslyReplaceNodeWithMarkup
  };
  module.exports = ReactComponentBrowserEnvironment;
})(require('process'));
