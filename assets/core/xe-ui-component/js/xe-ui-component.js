(function (root, factory) {
  if (typeof define === 'function' && define.amd) {
    // AMD
    define([
      'exports',
      'xecore:/xe-ui-component/js/_dropdown',
      'xecore:/xe-ui-component/js/_modal',
      'xecore:/xe-ui-component/js/_tooltip'
    ], function (
      exports,
      XeDropdown,
      XeModal,
      Xetooltip
    ) {
      factory(
        exports,
        require('xecore:/xe-ui-component/js/_dropdown'),
        require('xecore:/xe-ui-component/js/_modal'),
        require('xecore:/xe-ui-component/js/_tooltip')
      );
    });
  } else if (typeof exports === 'object' && typeof exports.nodeName !== 'string') {
    // CommonJS
    factory(exports, require('xecore:/xe-ui-component/js/_dropdown'), require('xecore:/xe-ui-component/js/_modal'), require('xecore:/xe-ui-component/js/_tooltip'));
  } else {
    // Browser globals
    factory({}, root.jQuery);
  }
}(this, function (exports, XeDropdown, XeModal, Xetooltip) {

}));
