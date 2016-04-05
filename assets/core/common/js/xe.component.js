(function (root, factory) {
  if (typeof define === 'function' && define.amd) {
    define(['exports'], factory);
  } else if (typeof exports === 'object' && typeof exports.nodeName !== 'string') {
    // CommonJS
    factory(exports);
  } else {
    factory({});
  }
}(this, function (exports, Translator) {
  'use strict';

  $(function() {
    /*
     * @Component Timeago
     *
     * <span data-xe-timeago="{timestmap|ISO8601}">2016-04-04 07:05:44</span>
     * <span data-xe-timeago="{timestmap|ISO8601}" title="2016-04-04 07:05:44" />3 Hours ago</span>
     */
    $(document).on('xe.timeago', '[data-xe-timeago]', function() {
      var $this = $(this);
      if($this.data().xeTimeagoCalled === true) false;

      System.import('xevendor:/moment/moment.min').then(function(moment) {
        console.group('@ timeago');
        var dataDate = $this.data('xe-timeago');
        var isTimestamp = (parseInt(dataDate) == dataDate);
        console.log('isTimestamp', isTimestamp);

        if(isTimestamp) {
          dataDate = moment.unix(dataDate);
        } else {
          dataDate = moment(dataDate);
        }

        console.log(dataDate);

        $this.text(dataDate.fromNow());
        $this.data().xeTimeagoCalled = true;
        console.groupEnd('@ timeago');
      });
    });

    boot();
  });

  function boot() {
    exports.timeago();
  }

  exports.timeago = function() {
    $('[data-xe-timeago]').trigger('xe.timeago');
  };

}));
