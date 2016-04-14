(function (root, factory) {
  module.exports = factory();
}(this, function () {
  'use strict';

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

  return {
    timeago: timeago
  };

}));
