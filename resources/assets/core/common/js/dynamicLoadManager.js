(function(exports) {
    'use strict';

    exports.DynamicLoadManager = function() {
        var _assets = {
            js: {}
            , css: {}
        };

        return {
            toDOM: function(html) {
                var d=document,
                    a = d.createElement("div"),
                    b = d.createDocumentFragment(),
                    i;

                a.innerHTML = html;

                while(i=a.firstChild) {
                    b.appendChild(i);
                }

                return b;
            },
            jsLoadMultiple: function(arrjs) {
                var html = "";

                for(var i = 0, max = arrjs.length; i < max; i += 1) {
                    html += "<script src='" + arrjs[i] + "' type='text/javascript'></script>";
                }

                var scripts = this.toDOM(html);


                console.log(scripts);

                document.head.appendChild(scripts);
            },
            jsLoad: function(url, load, error) {

                var src = url.split('?')[0];

                if(!_assets.js.hasOwnProperty(src)) {
                    var el = document.createElement( 'script' );
                    el.src = url;
                    //el.async = true;
                    
                    if(load) {
                        el.onload = load;
                    }

                    if(error) {
                        el.onerror = error;
                    }

                    document.head.appendChild(el);

                    _assets.js[src] = "";

                }else {
                    if(load) {
                        load();
                    }
                }
            },
            cssLoad: function(url, load, error) {
                var src = url.split("?")[0];

                if(!_assets.css.hasOwnProperty(src)) {

                    var link = document.createElement('link');
                    el.src = url;
                    el.async = true;

                    if(load) {
                        el.onload = load;
                    }

                    if(error) {
                        el.onerror = error;
                    }

                    document.head.appendChild(link);

                    _assets.css[src] = "";
                }else {
                    if(load) {
                        load();
                    }
                }
            }
        };
    }();
})(window);