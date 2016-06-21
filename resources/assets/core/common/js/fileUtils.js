;(function(exports) {
    exports.FileUtils = function() {
        var self;

        return {
            isImage: function(mime) {
                return $.inArray(mime, ["image/jpg", "image/jpeg", "image/png", "image/gif"]) === -1 ? false : true;
            },
            humanFileSize: function(bytes, si) {
                var thresh = si ? 1000 : 1024;
                if(Math.abs(bytes) < thresh) {
                    return bytes + 'B';
                }
                var units = si
                    ? ['KB','MB','GB','TB','PB','EB','ZB','YB']
                    : ['KiB','MiB','GiB','TiB','PiB','EiB','ZiB','YiB'];
                var u = -1;
                do {
                    bytes /= thresh;
                    ++u;
                } while(Math.abs(bytes) >= thresh && u < units.length - 1);
                return bytes.toFixed(1)+units[u];
            }
        }
    }();
})(window);