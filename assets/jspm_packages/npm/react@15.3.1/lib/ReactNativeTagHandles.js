/* */ 
(function(process) {
  'use strict';
  var _prodInvariant = require('./reactProdInvariant');
  var invariant = require('fbjs/lib/invariant');
  var INITIAL_TAG_COUNT = 1;
  var ReactNativeTagHandles = {
    tagsStartAt: INITIAL_TAG_COUNT,
    tagCount: INITIAL_TAG_COUNT,
    allocateTag: function() {
      while (this.reactTagIsNativeTopRootID(ReactNativeTagHandles.tagCount)) {
        ReactNativeTagHandles.tagCount++;
      }
      var tag = ReactNativeTagHandles.tagCount;
      ReactNativeTagHandles.tagCount++;
      return tag;
    },
    assertRootTag: function(tag) {
      !this.reactTagIsNativeTopRootID(tag) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'Expect a native root tag, instead got %s', tag) : _prodInvariant('19', tag) : void 0;
    },
    reactTagIsNativeTopRootID: function(reactTag) {
      return reactTag % 10 === 1;
    }
  };
  module.exports = ReactNativeTagHandles;
})(require('process'));
