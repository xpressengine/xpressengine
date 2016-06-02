/*
 <form action=... method=... data-callback=... data-submit="xe-ajax"></form>
*/
;(function(XE) {

    var _formCommon = function() {
        return {
            init: function() {

                this.bindEvents();

                return this;
            },
            bindEvents: function() {
                $(document).on("submit", "form[data-submit=xe-ajax]", function(e) {
                    e.preventDefault();

                    var $this = $(this);
                    var callback = $this.data('callback');

                    var objStack = callback.split(".");
                    var callbackFunc = window;

                    if(objStack.length > 0) {
                        for(var i = 0, max = objStack.length; i < max; i += 1) {
                            callbackFunc = callbackFunc[objStack[i]];
                        }
                    }

                    var options = {
                        url: $this.attr('action')
                        , type: $this.attr("method")
                        , param: $this.serialize()
                        , dataType: 'json'
                        , success: callbackFunc
                    };

                    if(_formCommon.isValidForm(options, callback)) {
                        XE.ajax(options);
                    }

                });
            },
            isValidForm: function(options) {
                if(!options.url) {
                    console.error("form action값이 없음");
                    return false;
                }
                if(!options.type) {
                    console.error("form method값이 없음");
                    return false;
                }

                return true;
            }
        }
    }().init();

})(XE);