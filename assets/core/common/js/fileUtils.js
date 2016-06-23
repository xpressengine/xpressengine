;(function(exports) {
    exports.FileUtils = function() {
        var self;

        return {
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
            }
        }
    }();
})(window);