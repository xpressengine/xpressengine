/* */ 
(function(process) {
  'use strict';
  var visitors = require('./vendor/fbtransform/visitors');
  var transform = require('jstransform').transform;
  var typesSyntax = require('jstransform/visitors/type-syntax');
  var inlineSourceMap = require('./vendor/inline-source-map');
  module.exports = {
    transform: function(input, options) {
      options = processOptions(options);
      var output = innerTransform(input, options);
      var result = output.code;
      if (options.sourceMap) {
        var map = inlineSourceMap(output.sourceMap, input, options.filename);
        result += '\n' + map;
      }
      return result;
    },
    transformWithDetails: function(input, options) {
      options = processOptions(options);
      var output = innerTransform(input, options);
      var result = {};
      result.code = output.code;
      if (options.sourceMap) {
        result.sourceMap = output.sourceMap.toJSON();
      }
      if (options.filename) {
        result.sourceMap.sources = [options.filename];
      }
      return result;
    }
  };
  function processOptions(opts) {
    opts = opts || {};
    var options = {};
    options.harmony = opts.harmony;
    options.stripTypes = opts.stripTypes;
    options.sourceMap = opts.sourceMap;
    options.filename = opts.sourceFilename;
    if (opts.es6module) {
      options.sourceType = 'module';
    }
    if (opts.nonStrictEs6module) {
      options.sourceType = 'nonStrictModule';
    }
    options.es3 = opts.target === 'es3';
    options.es5 = !options.es3;
    return options;
  }
  function innerTransform(input, options) {
    var visitorSets = ['react'];
    if (options.harmony) {
      visitorSets.push('harmony');
    }
    if (options.es3) {
      visitorSets.push('es3');
    }
    if (options.stripTypes) {
      input = transform(typesSyntax.visitorList, input, options).code;
    }
    var visitorList = visitors.getVisitorsBySet(visitorSets);
    return transform(visitorList, input, options);
  }
})(require('process'));
