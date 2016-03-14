(function (root, factory) {
  if (typeof define === 'function' && define.amd) {
    // AMD
    define([
      'exports',
      'jquery',
      'resources/assets/core/xe-ui-component/js/_dropdown',
      'resources/assets/core/xe-ui-component/js/_modal'
    ], function (
      exports,
      jQuery,
      XeDropdown,
      XeModal
    ) {
      factory(
        (root.commonJsStrictGlobal = exports),
        jQuery.noConflict(true),
        require('resources/assets/core/xe-ui-component/js/_dropdown'),
        require('resources/assets/core/xe-ui-component/js/_modal')
      );
    });
  } else if (typeof exports === 'object' && typeof exports.nodeName !== 'string') {
    // CommonJS
    factory(exports, require('jquery').noConflict(true));
  } else {
    // Browser globals
    factory((root.commonJsStrictGlobal = {}), root.jQuery.noConflict(true));
  }
}(this, function (exports, $, XeDropdown, XeModal) {

}));
