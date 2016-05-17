System.amdDefine('xe.component', [], function() {

  return {
    timeago: timeago
  };

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

    
    
    $(document).on('xe.timeago', '[data-xe-timeago]', function() {
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

    boot();
  });

  function boot() {
    timeago();
  }

  function timeago() {
    $('[data-xe-timeago]').trigger('xe.timeago');
  };

});

(function($) {
  var loadedCSS = false;

  // xeModal =========================================================
  $.fn.xeModal = function(options) {
    var $el = this;

    System.import("xe.component.modal").then(function() {
      $el.xeModal(options);
    });

    if(!loadedCSS) {
      XE.cssLoad("/assets/core/xe-ui-component/xe-ui-component.css");
      loadedCSS = true;
    }
  };

  // xeDropdown ======================================================
  $.fn.xeDropdown = function(options) {
    var $el = this;

    System.import("xe.component.dropdown").then(function() {
      $el.xeDropdown(options);
    });

    if(!loadedCSS) {
      XE.cssLoad("/assets/core/xe-ui-component/xe-ui-component.css");
      loadedCSS = true;
    }
  };

  // xeTooltip =======================================================
  $.fn.xeTooltip = function(options) {
    var $el = this;

    System.import("xe.component.tooltip").then(function() {
      $el.xeTooltip(options);
    });

    if(!loadedCSS) {
      XE.cssLoad("/assets/core/xe-ui-component/xe-ui-component.css");
      loadedCSS = true;
    }
  };

})(jQuery);
