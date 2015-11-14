/*global QUnit:false */

(function($, module, test) {
  "use strict";


  module("jQuery#zeroclipboard");

  test("Should exist", function(assert) {
    assert.expect(4);

    assert.ok($.event.special.beforecopy);
    assert.ok($.event.special.copy);
    assert.ok($.event.special.aftercopy);
    assert.ok($.event.special["copy-error"]);
  });

})(jQuery, QUnit.module, QUnit.test);
