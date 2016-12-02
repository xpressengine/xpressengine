import moment from 'moment';
import 'xe-transition';
import 'xe-modal';
import 'xe-dropdown';
import 'xe-tooltip';
import griper from 'griper';

var Component = (function (exports) {
  return {
    timeago: function () {
      $('[data-xe-timeago]').trigger('boot.xe.timeago');
    },

    boot: function () {
      this.timeago();
      $('[data-toggle=xe-dropdown]').trigger('boot.xe.dropdown');
      $('[data-toggle=xe-modal]').trigger('boot.xe.modal');
      $('[data-toggle=xe-tooltip]').trigger('boot.xe.tooltip');
      $('[data-toggle=dropdown]').trigger('boot.dropdown');
    },
  };
})(window);

DynamicLoadManager.cssLoad('/assets/core/xe-ui-component/xe-ui-component.css');

$(function () {
  /*
   * @Component Timeago
   *
   * <span data-xe-timeago="{timestmap|ISO8601}">2016-04-04 07:05:44</span>
   * <span data-xe-timeago="{timestmap|ISO8601}" title="2016-04-04 07:05:44" />3 Hours ago</span>
   */

  moment.locale(XE.getLocale());

  $(document).on('boot.xe.timeago', '[data-xe-timeago]', function () {
    var $this = $(this);
    if ($this.data().xeTimeagoCalled === true) false;

    var dataDate = $this.data('xe-timeago');
    var isTimestamp = (parseInt(dataDate) == dataDate);

    if (isTimestamp) {
      dataDate = moment.unix(dataDate);
    } else {
      dataDate = moment(dataDate);
    }

    $this.text(dataDate.fromNow());
    $this.data().xeTimeagoCalled = true;

  });

  $(document).on('boot.xe.dropdown', '[data-toggle=xe-dropdown]', function () {
    var $this = $(this);
    $this.xeDropdown();
  });

  $(document).on('boot.xe.modal', '[data-toggle=xe-modal]', function () {
    var $this = $(this);

  });

  $(document).on('boot.xe.tooltip', '[data-toggle=xe-tooltip]', function () {
    var $this = $(this);
    $this.xeTooltip();
  });

  Component.boot();
});

// // xeModal =========================================================
// $.fn.xeModal = function (options) {
//   var _this = this;
//
//   _this.xeModal(options);
//   DynamicLoadManager.cssLoad('/assets/core/xe-ui-component/xe-ui-component.css');
// };
//
// // xeDropdown ======================================================
// $.fn.xeDropdown = function (options) {
//   var _this = this;
//
//   _this.xeDropdown(options);
//   DynamicLoadManager.cssLoad('/assets/core/xe-ui-component/xe-ui-component.css');
// };
//
// // xeTooltip =======================================================
// $.fn.xeTooltip = function (options) {
//   var _this = this;
//
//   _this.xeTooltip(options);
//   DynamicLoadManager.cssLoad('/assets/core/xe-ui-component/xe-ui-component.css');
// };

export default Component;
