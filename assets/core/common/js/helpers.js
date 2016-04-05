System.import('xecore:/common/js/xe.bundle').then(function() {
  // @DEPRECATED
  XE.parseUrl = function (url) {
    if (url == undefined) {
      url = window.location.href;
    }

    var match = url.match(/^(https?\:)\/\/(([^:\/?#]*)(?:\:([0-9]+))?)(\/[^?#]*)(\?[^#]*|)(#.*|)$/);

    return {
      protocol: match[1],
      host: match[2],
      hostname: match[3],
      port: match[4],
      pathname: match[5],
      search: match[6],
      hash: match[7]
    };
  };

  // @DEPRECATED
  XE.toUrl = function (parsedUrl) {
    var url = parsedUrl.protocol + '://' + parsedUrl.host;
    if (parsedUrl.port != undefined && parsedUrl.port != '') {
      url += ':' + parsedUrl.port;
    }
    if (parsedUrl.pathname != undefined && parsedUrl.pathname != '') {
      url += parsedUrl.pathname;
    }
    if (parsedUrl.hash != undefined && parsedUrl.hash != '') {
      url += parsedUrl.hash;
    }
    return url;
  };

  // @DEPRECATED
  XE.shortDate = function () {
    // $('.__xe_short_date').each(function () {
    //   var time = parseInt($(this).attr('data-timestamp'));
    //   var timeLag = parseInt(new Date().getTime() / 1000) - time + XE.options.timeLag;
    //   $(this).text(getShortDate(timeLag)).show();
    // });
  };


  // @DEPRECATED
  function getShortDate(timeLag) {
    if (timeLag > 365 * 86400) {
      return this.props.data.createdAt.substr(0, 10);
    }
    if (timeLag > 30 * 86400) {
      return parseInt((timeLag / (30 * 86400))).toString() + '개월 전';
    }
    if (timeLag > 86400) {
      return parseInt((timeLag / 86400)).toString() + '일 전';
    }
    if (timeLag > 3600) {
      return parseInt((timeLag / 3600)).toString() + '시간 전';
    }
    if (timeLag > 60) {
      return parseInt((timeLag / 60)).toString() + '분 전';
    }

    return timeLag.toString() + '초 전';
  }
});


// @DEPRECATED
function alertBox(type, message)
{
  XE.toast(type, message);
}
