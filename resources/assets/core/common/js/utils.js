var Utils = (function (exports) {

  var _this;

  return {
    init: function () {
      _this = this;

      return this;
    },

    isImage: function (mime) {
      return $.inArray(mime, ['image/jpg', 'image/jpeg', 'image/png', 'image/gif']) === -1 ? false : true;
    },

    formatSizeUnits: function (bytes) {
      if (bytes >= 1073741824) {
        bytes = (bytes / 1073741824).toFixed(2) + 'GB';
      } else if (bytes >= 1048576) {
        bytes = (bytes / 1048576).toFixed(2) + 'MB';
      } else if (bytes >= 1024) {
        bytes = (bytes / 1024).toFixed(2) + 'KB';
      } else if (bytes > 1) {
        bytes = bytes + 'bytes';
      } else if (bytes == 1) {
        bytes = bytes + 'byte';
      } else {
        bytes = '0MB';
      }

      return bytes;
    },

    isURL: function (s) {
      return /(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/.test(s);
    },

    asset: function (url) {
      var loc = window.location;
      var retURL = '';

      if (!_this.isURL(url)) {
        if (xeBaseURL) {
          if (xeBaseURL.substr(-1) === '/') {
            retURL += xeBaseURL.substr(0, (xeBaseURL.length - 1));
          } else {
            retURL += xeBaseURL;
          }

        } else {
          retURL += loc.protocol + '//' + loc.host;
        }

        if (url.substr(0, 1) === '/') {
          retURL += url;
        } else {
          retURL += '/' + url;
        }

      } else {
        retURL = url;

      }

      return retURL.split(/[?#]/)[0];
    },

    getUri: function (url) {
      var path = url.split(window.location.protocol + '//')[1];
      var returnUri;

      if (path.indexOf('/') === -1) {
        returnUri = '/';

      } else {
        returnUri = path.substr(path.indexOf('/'));

      }

      return returnUri;
    },
  }.init();
})(window);
