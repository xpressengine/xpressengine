
(function (window, $, XE) {
    'use strict'

    var categoryTree = {
        init: function (container, urls) {
            container = $(container)[0];

            var o = new Tree(
                container,
                $.extend({}, this.defaultUrls, urls)
            );

            o.init();

            return o;
        },
        defaultUrls: {
            load: null,
            add: null,
            modify: null,
            remove: null,
            move: null
        }
    };

    function Tree(container, urls)
    {
        this.container = container;
        this.urls = urls;

        this.newBoxClass = 'sortable-new';

        this.boxClass = 'sortable';
        this.treeBox = null;

        this.repo = new DataCache();
    }

    Tree.prototype = {
        init: function () {
            $('<ol>').addClass(this.boxClass + ' item-box').appendTo(this.container);
            this.treeBox = $('> ol', this.container)[0];

            $(this.treeBox).nestedSortable({
                forcePlaceholderSize: true,
                handle: 'header',
                helper:	'clone',
                items: 'li',
                opacity: .6,
                placeholder: 'placeholder',
                tolerance: 'pointer',
                toleranceElement: '> div',
                isTree: true,
                // startCollapsed: true,
                relocate: function (e, locate) {
                    // console.log(arguments);

                    this.move(locate.item[0]);
                }.bind(this),
                isAllowed: function ($placeholder, $parent, $item) {
                    if ($parent && $parent.data('is_loading') === true) {
                        return false;
                    }

                    return true;
                }
            });

            this.drawNew();

            this.attachToggleChildren();
            this.attachActive();
            this.attachToggleBtns();

            this.load(null, function (nodes) {
                for (var i in nodes) {
                    this.add(nodes[i], null);
                }
            }.bind(this));
        },
        drawNew: function () {
            var self = this;
            var $item = itemMaker.makeNew();

            $('header', $item).click(function () {
                var collapsed = $item.find('.collapse').hasClass('in') ? false : true;

                self.closeBodyAll();

                if (collapsed) {
                    var $form = formProvider.make('create', null, self.onCreate.bind(self));
                    $('.__xe_content_body', $item).empty().append($form);
                    $form.find('.lang-editor-box').each(function () {
                        langEditorBoxRender($(this));
                    });
                    $item.find('.collapse').collapse('show');
                }


                //closeBodyAll
            });

            $('<ol>').addClass(this.newBoxClass + ' item-box item-box-new')
                .append($item)
                .prependTo(this.container);
        },
        load: function (parentId, callback) {
            var data = parentId ? {id: parentId} : null;

            XE.ajax({
                url: this.urls.load,
                type: 'get',
                data: data,
                dataType: 'json',
                success: function (nodes) {
                    callback(nodes);
                }
            });
        },
        add: function (data, parentId) {
            var box = this.getChildrenBox(parentId);
            if ($('#' + itemMaker.makeIdAttr(data.id)).is('li') !== true) {
                $(box).append(itemMaker.make(data));
            }

            this.repo.set(data);
        },
        move: function (item) {
            var id = itemMaker.extractId(item);
            var info = this.getNestedInfo(id);
            var parentInfo = this.getNestedInfo(info.parent_id);
            var ordering = 0;
            var children = this.getChildrenInfo(parentInfo.item_id);

            $.each(children, function (i, o) {
                if (o.item_id == id) {
                    ordering = i;
                    return false;
                }
            });

            XE.ajax({
                url: this.urls.move,
                type: 'post',
                data: {id: id, parentId: parentInfo.item_id, ordering: ordering},
                success: function () {
                    var $parent = $('#' + itemMaker.makeIdAttr(parentInfo.item_id));
                    if ($parent.data('is_loaded') !== true) {
                        $('> .panel .__xe_btn_toggle_children', $parent).trigger('click');
                    }
                }
            });
        },
        onRemove: function (e, data) {
            $('#' + itemMaker.makeIdAttr(data.id)).remove();
            this.repo.remove(data.id);

            XE.ajax({
                url: this.urls.remove,
                type: 'post',
                data: {id: data.id}
            });
        },
        onCreate: function (e, form) {
            e.preventDefault();
            var self = this;
            var data = this.serializeObject(form);
            // todo: validation 임시 제거
            // if (!data.word || $.trim(data.word) == '') {
            //     XE.toast('warning', XE.Lang.trans('xe::required', {name: XE.Lang.trans('xe::word')}));
            //     return false;
            // }

            $('button', form).prop('disabled', true);

            XE.ajax({
                url: this.urls.add,
                type: 'post',
                dataType: 'json',
                data: data,
                success: function (node) {
                    if (data.parentId) {
                        var $parent = $('#' + itemMaker.makeIdAttr(data.parentId));
                        self.closeBody($parent);
                        if ($parent.data('is_loaded') !== true) {
                            $('> .panel .__xe_btn_toggle_children', $parent).trigger('click');
                            return;
                        }
                    }

                    // create new form close
                    $('> .' + self.newBoxClass, self.container).find('.collapse.in').collapse('hide');

                    self.add(node, data.parentId);
                },
                complete: function () {
                    $('button', form).prop('disabled', false);
                }
            });
        },
        onEdit: function (e, form) {
            e.preventDefault();
            var self = this;
            var data = this.serializeObject(form);

            if (!data.id || $.trim(data.id) == '') {
                XE.toast('warning', XE.Lang.trans('xe::required', {name: 'id'}));
                return false;
            }

            // todo: validation 임시 제거
            // if (!data.word || $.trim(data.word) == '') {
            //     XE.toast('warning', XE.Lang.trans('xe::required', {name: XE.Lang.trans('xe::word')}));
            //     return false;
            // }

            $('button', form).prop('disabled', true);

            XE.ajax({
                url: this.urls.modify,
                type: 'post',
                dataType: 'json',
                data: data,
                success: function (node) {
                    var $item = $('#' + itemMaker.makeIdAttr(node.id));
                    // $('> .__xe_item_block .__xe_word', $item).text(node.word);
                    $('> .__xe_item_block .__xe_word', $item).text(node.readableWord);
                    self.repo.set(node);

                    self.closeBody($item);
                },
                complete: function () {
                    $('button', form).prop('disabled', false);
                }
            });
        },
        serializeObject: function (form) {
            var fields = $(form).serializeArray(),
                obj = {};
            $.each(fields, function (i, field) {
                obj[field.name] = field.value;
            });

            return obj;
        },
        getChildrenBox: function (id) {
            if (!id) {
                return this.treeBox;
            }

            return $('> ol', '#' + itemMaker.makeIdAttr(id))[0];
        },
        getNestedInfo: function (id) {
            var arr = $(this.treeBox).nestedSortable('toArray', {startDepthCount: 0});
            var info = null;
            $.each(arr, function (i, o) {
                if (o.item_id == id) {
                    info = o;
                    return false;
                }
            });

            return info;
        },
        getChildrenInfo: function (id) {
            var arr = $(this.treeBox).nestedSortable('toArray', {startDepthCount: 0});
            var children = [];
            $.each(arr, function (i, o) {
                if (o.parent_id == id && o.item_id) {
                    children.push(o);
                }
            });
            children = children.sort(function (a, b) {
                if (a.left == b.left) {
                    return 0;
                }

                return a.left < b.left ? -1 : 1;
            });

            return children;
        },
        getBreadcrumbs: function (id) {
            var info = this.getNestedInfo(id), breadcrumbs = [];

            if (info.parent_id !== null) {
                breadcrumbs = this.getBreadcrumbs(info.parent_id);
            }

            breadcrumbs.push(id);

            return breadcrumbs;
        },
        attachToggleChildren: function () {
            var self = this;

            $(this.treeBox).on('click', '.__xe_btn_toggle_children', function (e) {
                e.stopPropagation();

                var $item = $(this).closest('li');
                var id = itemMaker.extractId($item[0]);

                if ($item.data('is_loading') === true) {
                    return false;
                }

                $($item).toggleClass('__xe_state_open').toggleClass('__xe_state_close');

                if ($item.data('is_loaded') !== true) {
                    $item.data('is_loading', true);
                    self.load(id, function (nodes) {
                        if ($(self.getChildrenBox(id)).is('ol') !== true) {
                            $('<ol>').appendTo('#' + itemMaker.makeIdAttr(id));
                        }

                        for (var i in nodes) {
                            self.add(nodes[i], id);
                        }

                        $item.data('is_loaded', true);
                        $item.data('is_loading', false);

                        self.setToggleChildrenIcon($item);
                    });
                }

                self.setToggleChildrenIcon($item);
            });
        },
        attachActive: function () {
            var self = this;
            $(this.treeBox).on('click', '.__xe_item_block', function (e) {
                $(this).closest('.' + self.boxClass).find('.__xe_item_block').removeClass('active');
                $(this).addClass('active');

                var $item = $(this).closest('.' + self.boxClass).find('.collapse.in').closest('li');
                if ($('> .__xe_item_block', $item).hasClass('active') !== true) {
                    self.closeBody($item);
                }
            });
        },
        attachToggleBtns: function () {
            var self = this;
            $(this.treeBox).on('click', '.toggle-btns > span', function () {
                if ($(this).hasClass('active')) {
                    self.closeBody($(this).closest('li'));
                    return;
                }

                $(self.treeBox).find('.toggle-btns > span').removeClass('active');
                $(this).addClass('active');


                var action = $(this).attr('data-action');
                var submitHandler = action === 'child' ? self.onCreate : self.onEdit;
                var id = itemMaker.extractId($(this).closest('li')[0]);

                var $form = formProvider.make(action, self.repo.get(id), submitHandler.bind(self), self.onRemove.bind(self));

                $('.__xe_content_body', $(this).closest('.__xe_item_block')).empty().append($form);
                $form.find('.lang-editor-box').each(function () {
                    langEditorBoxRender($(this));
                });


                if ($(this).closest('.__xe_item_block').children('.collapse').hasClass('in') !== true) {
                    self.closeBodyAll();
                    $(this).closest('.__xe_item_block').children('.collapse').collapse('show');
                }
            });
        },
        closeBody: function ($item) {
            var $itemBlock = $('> .__xe_item_block', $item);
            var btn = $('.toggle-btns > span.active', $itemBlock);
            $itemBlock.children('.collapse')
                .one('hidden.bs.collapse', function () {
                    $(btn).removeClass('active');
                })
                .collapse('hide');
        },
        closeBodyAll: function () {
            $('> .' + this.newBoxClass, this.container).find('.collapse.in').collapse('hide');

            this.closeBody($(this.treeBox).find('.collapse.in').closest('li'));
        },
        setToggleChildrenIcon: function ($item) {
            var $btn = $('> .__xe_item_block .__xe_btn_toggle_children', $item);

            $('i', $btn).removeClass('xi-angle-right xi-angle-down xi-spinner-1 xi-spin');

            if ($item.data('is_loading') === true) {
                $('i', $btn).addClass('xi-spinner-1 xi-spin');
            } else {
                if ($item.hasClass('__xe_state_open')) {
                    $('i', $btn).addClass('xi-angle-down');
                } else {
                    $('i', $btn).addClass('xi-angle-right');
                }
            }

            if ($item.hasClass('__xe_state_open')) {
                $('> ol', $item).show();
            } else {
                $('> ol', $item).hide();
            }
        }
    };

    function DataCache()
    {
        this.cache = {};
    }

    DataCache.prototype = {
        set: function (data) {
            this.cache[data.id] = data;
        },
        get: function (id) {
            return this.cache[id];
        },
        remove: function (id) {
            delete this.cache[id];
        }
    };

    var itemMaker = {
        prefix: 'item',
        expression: '_',
        makeIdAttr: function (id) {
            return this.prefix + this.expression + id;
        },
        extractId: function (elem) {
            var idAttr = $(elem).attr('id');
            if (!idAttr) {
                return null;
            }

            return idAttr.replace(this.prefix + this.expression, '');
        },
        makeNew: function () {
            var item = $('<li>')
                .append(
                    $('<div>').addClass('panel panel-default __xe_item_block')
                            .append(
                                $('<header>').addClass('panel-heading')
                                    .append($('<span>').addClass('head-bth').append($('<i>').addClass('xi-plus')))
                                    .append($('<span>').text(XE.Lang.trans('xe::addItem')))
                            )
                            .append(this.getBody())
                );

            return item;
        },
        make: function (data) {
            var item = $('<li>')
                .attr('id', this.makeIdAttr(data.id))
                .addClass('__xe_state_close')
                .append(
                    $('<div>').addClass('panel panel-default __xe_item_block')
                            .append(this.getHeader(data))
                            .append(this.getBody())
                );//.append($('<ol>').css('display', 'none'));

            return item;
        },
        getHeader: function (data) {
            var header = $('<header>').addClass('panel-heading');

            $('<span>').addClass('head-bth __xe_btn_toggle_children')
                    .append($('<i>').addClass('xi-angle-right')).appendTo(header);
            // $('<span>').addClass('__xe_word').text(data.word).appendTo(header);
            $('<span>').addClass('__xe_word').text(data.readableWord).appendTo(header);
            $('<span>').addClass('pull-right toggle-btns')
                    .append(
                        $('<span>').addClass('head-bth')
                            .attr('data-action', 'edit')
                            .append($('<i>').addClass('xi-pen'))
                    )
                    .append(
                        $('<span>').addClass('head-bth')
                            .attr('data-action', 'child')
                            .append($('<i>').addClass('xi-plus'))
                    )
                    .appendTo(header);

            return header;
        },
        getBody: function () {
            var body = $('<div>').addClass('panel-collapse collapse')
                    .append($('<div>').addClass('panel-body __xe_content_body'));

            return body;
        }
    };

    var formProvider = {
        make: function (action, data, submitHandler, removeHandler) {
            var $form = this.getForm(action, data);
            $form.submit(function (e) {
                submitHandler(e, this);
            });
            var $legend = $('<h1>').text(this.getTitleText(action));

            if (action == 'edit') {
                $legend.append(this.removeBtn(data, removeHandler));
            }

            var $p = $('<p>').css({
                'border-bottom': '1px solid #000',
                'padding-bottom': '10px',
                'margin-bottom': '20px'
            }).append($legend);

            return $('<div>').append($p)
                .append($('<div>').append($form));
        },
        getTitleText: function (action) {
            switch (action) {
                case 'create':
                    return XE.Lang.trans('xe::create');
                break;
                case 'child':
                    return XE.Lang.trans('xe::createChild');
                break;
                case 'edit':
                    return XE.Lang.trans('xe::edit');
                break;
                default:
                    return XE.Lang.trans('xe::unknown');
                break;
            }
        },
        removeBtn: function (data, removeHandler) {
            return $('<span>').addClass('pull-right').css('cursor', 'pointer').append(
                $('<i>').addClass('xi-trash')
            ).click(function (e) {
                removeHandler(e, data, this);
            });
        },
        getForm: function (action, data) {
            var id = null;
            switch (action) {
                case 'child':
                    id = data.id;
                case 'create':
                    return this._create(id);
                    break;
                case 'edit':
                    return this._edit(data);
                    break;
            }

        },
        _create: function (parentId) {
            var $form = $('<form>');

            $('<div>').addClass('form-group')
                .append($('<label>').addClass('control-label').text(XE.Lang.trans('xe::word')))
                .append(
                    $('<div>').addClass('lang-editor-box').data('name', 'word')
                    // $('<input>').addClass('form-control').attr('name', 'word')
                ).appendTo($form);
            $('<div>').addClass('form-group')
                .append($('<label>').addClass('control-label').text(XE.Lang.trans('xe::description')))
                .append(
                    $('<div>').addClass('lang-editor-box').data('name', 'description').data('multiline', true)
                    // $('<textarea>').addClass('form-control').attr('name', 'description')
                ).appendTo($form);
            $('<button>').attr('type', 'submit').addClass('btn btn-primary').text(XE.Lang.trans('xe::save')).appendTo($form);

            if (parentId) {
                $('<input>').attr({type: 'hidden', name: 'parentId'}).val(parentId).appendTo($form);
            }

            return $form;
        },
        _edit: function (data) {
            var $form = $('<form>');

            $('<input>').attr({type: 'hidden', name: 'id'}).val(data.id).appendTo($form);

            $('<div>').addClass('form-group')
                .append($('<label>').addClass('control-label').text(XE.Lang.trans('xe::word')))
                .append(
                    $('<div>').addClass('lang-editor-box').data('name', 'word').data('lang-key', data.word)
                    // $('<input>').addClass('form-control').attr('name', 'word').val(data.word)
                ).appendTo($form);
            $('<div>').addClass('form-group')
                .append($('<label>').addClass('control-label').text(XE.Lang.trans('xe::description')))
                .append(
                    $('<div>').addClass('lang-editor-box').data('name', 'description').data('lang-key', data.description).data('multiline', true)
                    // $('<textarea>').addClass('form-control').attr('name', 'description').val(data.description)
                ).appendTo($form);
            $('<button>').attr('type', 'submit').addClass('btn btn-primary').text(XE.Lang.trans('xe::save')).appendTo($form);

            return $form;
        }
    };

    window.categoryTree = categoryTree;

    return categoryTree;
})(typeof window !== "undefined" ? window : this, jQuery, XE);
