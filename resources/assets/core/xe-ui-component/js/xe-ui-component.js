(function (root, factory) {
  if (typeof define === 'function' && define.amd) {
    // AMD
    define([
      'exports',
      'xecore:/xe-ui-component/js/_dropdown',
      'xecore:/xe-ui-component/js/_modal'
    ], function (
      exports,
      XeDropdown,
      XeModal
    ) {
      factory(
        exports,
        require('xecore:/xe-ui-component/js/_dropdown'),
        require('xecore:/xe-ui-component/js/_modal')
      );
    });
  } else if (typeof exports === 'object' && typeof exports.nodeName !== 'string') {
    // CommonJS
    factory(exports, require('xecore:/xe-ui-component/js/_dropdown'), require('xecore:/xe-ui-component/js/_modal'));
  } else {
    // Browser globals
    factory({}, root.jQuery);
  }
}(this, function (exports, XeDropdown, XeModal) {
}));
