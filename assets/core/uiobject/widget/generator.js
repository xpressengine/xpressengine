;(function(exports, $) {
    var widgetForm = '#widgetForm';
    var skinForm = '#skinForm';
    var selectWidget = '.__xe_select_widget';
    var selectWidgetSkin = '.__xe_select_widgetskin';
    var widgetCodeSel = '.__xe_widget_code';
    var widgetInputs = '.widget-inputs';
    var self;

    var _applyPlugins = function () {
        $.fn.widgetGenerator = function (opt) {

            var $container = $(this);
            var isBinding = false;

            var _bindEvents = function () {
                $container.on('change', selectWidget, function() {
                    var widget = this.value;
                    var url = $('.widget-skins').data('url');

                    $('.widget-form').empty();

                    if(widget) {
                        XE.page(url+'?widget='+widget, '.widget-skins');
                    } else {
                        $('.widget-skins').empty();
                    }
                });

                $container.on('change', selectWidgetSkin, function() {
                    var widget = this.value;

                    if(widget) {
                        var url = $(this).find('option:selected').data('url');
                        XE.page(url, '.widget-form');
                    }
                });

                $container.on('click', function() {
                    var code = $(widgetCodeSel).val();
                    var url = $(widgetInputs).data('url');

                    exports.WidgetCode.reset({
                        url: url,
                        target: '.widget-inputs',
                        code: code
                    });
                });

                $container.on('click', function() {
                    exports.WidgetCode.generate({
                        widgetForm: '#widgetForm',
                        skinForm: '#skinForm'
                    });
                });

                isBinding = true;
            };

            if(!isBinding) {
                _bindEvents();
            }

            console.log(opt, opt === undefined, opt === 'undefined');

            switch(typeof opt) {
                case 'string':

                    //switch
                    switch(opt) {
                        case 'code':
                            return $container.find(widgetCodeSel).val();
                            break;

                        case 'generate':
                            exports.WidgetCode.generate({
                                widgetForm: widgetForm,
                                skinForm: skinForm
                            });
                            break;

                        default:
                            console.error('widgetGenerator parameter error');
                    }

                    break;

                case 'object':


                    break;
                case undefined:


                    break;
                default:
                    console.error('widgetGenerator parameter error');
            }

            this.generate = function() {
                exports.WidgetCode.generate({
                    widgetForm: widgetForm,
                    skinForm: skinForm
                });
            };

            this.reset = function() {
                exports.WidgetCode.reset({
                    url: $(widgetInputs).data('url'),
                    code: $(widgetCodeSel).val(),
                    target: widgetInputs
                });
            };

            return this;
        };
    };

    var WidgetCode = (function() {
        return {
            /**
             * @param {object} options
             * <pre>
             *     - {string} widgetForm selector
             *     - {string} skinForm selector
             * </pre>
             * */
            generate: function (options) {
                var $form = $(options.widgetForm);
                var data = $form.serializeArray();

                data.push({
                    'name':'skin',
                    'value': $(options.skinForm).serializeArray()
                });

                XE.ajax({
                    url : $form.attr('action'),
                    type : $form.attr('method'),
                    cache : false,
                    data : JSON.stringify(data),
                    dataType: 'json',
                    success : function (data) {
                        $('.__xe_widget_code').val(data.code);
                    },
                    error : function(data) {
                        XE.toast(data.type, data.message);
                    }
                });
            },
            /**
             * @param {object} options
             * <pre>
             *     - {string} url
             *     - {string} target selector
             *     - {string} code
             * </pre>
             * */
            reset: function (options) {
                DynamicLoadManager.jsLoad('/assets/core/xe-ui-component/js/xe-page.js', function() {
                    var url = options.url;
                    var code = options.code;
                    var target = options.target;

                    XE.page(url, target, {
                        data: {
                            code: code
                        }
                    });
                });
            },
            init: function() {
                self = this;

                _applyPlugins();

                return this;
            }
        }
    });

    exports.WidgetCode = WidgetCode().init();

})(window, jQuery);

