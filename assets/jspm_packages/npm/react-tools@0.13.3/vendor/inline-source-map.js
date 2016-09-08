/* */ 
(function(Buffer) {
  'use strict';
  var Buffer = require('buffer').Buffer;
  function inlineSourceMap(sourceMap, sourceCode, sourceFilename) {
    var json = sourceMap;
    if (typeof sourceMap.toJSON === 'function') {
      json = sourceMap.toJSON();
    }
    json.sources = [sourceFilename];
    json.sourcesContent = [sourceCode];
    var base64 = Buffer(JSON.stringify(json)).toString('base64');
    return '//# sourceMappingURL=data:application/json;base64,' + base64;
  }
  module.exports = inlineSourceMap;
})(require('buffer').Buffer);
