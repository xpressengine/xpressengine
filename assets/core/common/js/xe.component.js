(function(exports) {
  exports.XE.Component = function() {
    return {
      timeago: function() {
        $('[data-xe-timeago]').trigger('boot.xe.timeago');
      },
      boot: function() {
        this.timeago();
        $('[data-toggle=xe-dropdown]').trigger('boot.xe.dropdown');
        $('[data-toggle=xe-modal]').trigger('boot.xe.modal');
        $('[data-toggle=xe-tooltip]').trigger('boot.xe.tooltip');
        $('[data-toggle=dropdown]').trigger('boot.dropdown');
      }
    };
  }();
})(window);

$(function() {
  /*
   * @Component Timeago
   *
   * <span data-xe-timeago="{timestmap|ISO8601}">2016-04-04 07:05:44</span>
   * <span data-xe-timeago="{timestmap|ISO8601}" title="2016-04-04 07:05:44" />3 Hours ago</span>
   */
  System.import('vendor:/moment').then(function(moment) {
    moment.locale(XE.getLocale());
  });



  $(document).on('boot.xe.timeago', '[data-xe-timeago]', function() {
    var $this = $(this);
    if($this.data().xeTimeagoCalled === true) false;

    System.import('vendor:/moment').then(function(moment) {
      var dataDate = $this.data('xe-timeago');
      var isTimestamp = (parseInt(dataDate) == dataDate);

      if(isTimestamp) {
        dataDate = moment.unix(dataDate);
      } else {
        dataDate = moment(dataDate);
      }

      $this.text(dataDate.fromNow());
      $this.data().xeTimeagoCalled = true;
    });
  });

  $(document).on('boot.xe.dropdown', '[data-toggle=xe-dropdown]', function() {
    var $this = $(this);
    System.import("xe.component.dropdown").then(function() {
      $this.xeDropdown();
    });
  });

  $(document).on('boot.xe.modal', '[data-toggle=xe-modal]', function() {
    var $this = $(this);
    System.import("xe.component.transition");
    System.import("xe.component.modal").then(function() {

    });
  });

  $(document).on('boot.xe.tooltip', '[data-toggle=xe-tooltip]', function() {
    var $this = $(this);
    System.import("xe.component.transition");
    System.import("xe.component.tooltip").then(function() {
      $this.xeTooltip();
    });

  });

  XE.Component.boot();

});

(function($) {

  // xeModal =========================================================
  $.fn.xeModal = function(options) {
    var $el = this;

    System.import('xe.component.transition');
    System.import('xe.component.modal').then(function() {
      $el.xeModal(options);
    });

    XE.cssLoad("/assets/core/xe-ui-component/xe-ui-component.css");

  };

  // xeDropdown ======================================================
  $.fn.xeDropdown = function(options) {
    var $el = this;

    System.import("xe.component.dropdown").then(function() {
      $el.xeDropdown(options);
    });

    XE.cssLoad("/assets/core/xe-ui-component/xe-ui-component.css");

  };

  // xeTooltip =======================================================
  $.fn.xeTooltip = function(options) {
    var $el = this;

    System.import("xe.component.transition");
    System.import("xe.component.tooltip").then(function() {
      $el.xeTooltip(options);
    });


    XE.cssLoad("/assets/core/xe-ui-component/xe-ui-component.css");

  };

})(jQuery);
