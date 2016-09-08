/* */ 
require('./phantomjs-shims');
require('ReactTestUtils');
require('reactComponentExpect');
require('mocks');
require('mock-modules');
require('./mock-timers');
exports.enableTest = function(testID) {
  describe(testID, function() {
    beforeEach(function() {
      require('mock-modules').setMockMap(mockMap);
    });
    require('mock-modules').clearMockMap();
    require("../" + testID);
    var mockMap = require('mock-modules').getMockMap();
  });
};
exports.removeNextSiblings = function(node) {
  var parent = node && node.parentNode;
  if (parent) {
    while (node.nextSibling) {
      parent.removeChild(node.nextSibling);
    }
  }
};
