define(function(XE) {
    'use strict';

    var path = require.toUrl('griper'),
        cssPath = (path.substr(0, path.lastIndexOf('/')) + '/style.css');
    XE.cssLoad(cssPath);

    var Griper = {};

    Griper.options = {
        toastContainer: {
            template: '<div class="__xe_toast_container xo-toast_container"></div>',
            boxTemplate: '<div class="toast_box"></div>'
        },
        toast: {
            iconClass: {danger: 'xi-ban-circle', info: 'xi-information-circle', warning: 'xi-info-triangle', success: 'xi-check'},
            expireTimes: {danger: 0, info: 5, warning: 10, success: 2},
            status: {500: 'warning', 401: 'info'},
            template: '<div class="alert-dismissable xo-alert" style="display:none;"><button type="button" class="__xe_close btn_alert_close" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
            '<span class="message"></span></div>'
        },
        form: {
            selectors: {
                elementGroup: '.form-group',
                errorText: '.__xe_error_text'
            },
            classes: {
                message: ['error-text', '__xe_error_text']
            },
            tags: {
                message: 'p'
            }
        }
    };

    Griper.toast = function(type, message) {
        this.toast.fn.add(type, message);;
    };

    var toast_box = null;
    Griper.toast.fn = Griper.toast.prototype = {
        constructor: Griper.toast,
        options: Griper.options.toast,
        statusToType: function(status) {
            var type = this.options.status[status];
            return type === undefined ? 'danger' : type;
        },
        add: function(type, message) {
            Griper.toast.fn.create(type, message);
            return this;
        },

        create: function(type, message) {
            var expireTime = 0;
            if (this.options.expireTimes[type] != 0) {
                expireTime = parseInt(new Date().getTime() / 1000)  + this.options.expireTimes[type];
            }

            var alert = $(this.options.template);
            alert.attr('data-expire-time', expireTime).addClass(type);
            //alert.find('.icon').addClass(this.options.iconClass[type]);
            alert.append(message);

            Griper.toast.fn.container().append(alert);
            this.show(alert);
        },
        show: function(alert) {
            alert.slideDown('slow');
        },
        destroy: function(alert) {
            alert.slideUp('slow', function () {
                alert.remove();
            });
        },
        container: function() {
            if (toast_box != null) {
                return toast_box;
            }

            toast_box = $(Griper.options.toastContainer.boxTemplate);
            var container = $(Griper.options.toastContainer.template).append(toast_box);
            $('body').append(container);

            container.on('click', 'button.__xe_close', function (e) {
                Griper.toast.fn.destroy($(this).parents('.alert'));
                e.preventDefault();
            });

            setInterval(function() {
                var time = parseInt(new Date().getTime() / 1000);
                toast_box
                    .find('div.alert')
                    .each(function() {
                        var expireTime = parseInt($(this).data('expire-time'));
                        if (expireTime != 0 && time > expireTime) {
                            Griper.toast.fn.destroy($(this));
                        }
                    });
            }, 1000);

            return toast_box;
        }
    };

    Griper.form = function($element, message) {
        Griper.form.fn.putByElement($element, message);
    };

    Griper.form.fn = Griper.form.prototype = {
        constructor: Griper.form,
        options: Griper.options.form,
        getGroup: function($element) {
            return $element.closest(this.options.selectors.elementGroup);
        },
        putByElement: function($element, message) {
            this.put(this.getGroup($element), message, $element);
        },
        put: function($group, message, $element) {
            // $group 이 1 보다 클땐 어찌 될지 모르겠음...
            if ($group.length == 1) {
                $group.append(
                    $('<'+this.options.tags.message+'>')
                        .addClass(this.options.classes.message.join(' '))
                        .text(message)
                );
            } else if ($group.length == 0) {
                $element.after(
                    $('<'+this.options.tags.message+'>')
                        .addClass(this.options.classes.message.join(' '))
                        .text(message)
                );
            }
        },
        clear: function($form) {
            $form.find(this.options.tags.message+this.options.selectors.errorText).remove();
        }
    };

    return Griper;
}(XE));
