;(function(exports) {
    exports.Utils = function() {
        var self;

        return {
            init: function() {
                self = this;

                return this;
            },
            isImage: function(mime) {
                return $.inArray(mime, ["image/jpg", "image/jpeg", "image/png", "image/gif"]) === -1 ? false : true;
            },
            formatSizeUnits: function(bytes) {
                if      (bytes>=1073741824) {bytes=(bytes/1073741824).toFixed(2)+'GB';}
                else if (bytes>=1048576)    {bytes=(bytes/1048576).toFixed(2)+'MB';}
                else if (bytes>=1024)       {bytes=(bytes/1024).toFixed(2)+'KB';}
                else if (bytes>1)           {bytes=bytes+'bytes';}
                else if (bytes==1)          {bytes=bytes+'byte';}
                else                        {bytes='0MB';}
                return bytes;
            },
            isURL: function(s) {
                /(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/.test(s);
            },
            asset: function(url) {
                var loc = window.location;
                var baseURL = (self.isURL(url))? xeBaseURL : loc.protocol + '//' + loc.host + '/';
                var url = (url.substr(0, 1) === '/')? url.substr(1) : url;

                return (baseURL.substr(-1) === '/')? baseURL + url : baseURL + '/' + url;
            }
        }
    }().init();
})(window);