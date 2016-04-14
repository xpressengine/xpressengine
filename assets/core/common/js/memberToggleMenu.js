/**
 * <MemberToggleMenu type="comment@instnaceId" identifier={} class="btn btn-default btn-xs" icon="glyphicon glyphicon-cog" text="관리" itemClass="" data={} />
 */
var MemberToggleMenu = React.createClass({

    getItems: function () {
        if (this.props.items.length > 0) {
            return this.props.items.map(function (item, i) {
                var props = $.extend({}, item);
                return React.createElement(MemberToggleMenu.Item, React.__spread({},  props, {key: i}));
            }.bind(this));
        }
    },

    render: function () {
        return (
            React.DOM.ul({className: "list-unstyled", role: "menu"}, this.getItems())
        );
    }
});

MemberToggleMenu.Item = React.createClass({

    componentWillMount: function () {
        if (this.props.script && $('script[src="' + this.props.script + '"]').is('script') !== true) {
            $.getScript(this.props.script);
        }
    },

    itemClick: function (e) {
    },

    render: function () {
        if (this.props.type == "raw") {
            return React.DOM.li({className:'list-group-item', onClick: this.itemClick, dangerouslySetInnerHTML: {__html: this.props.action}}, null);
        }
        var attr;
        switch (this.props.type) {
            case 'func' :
                attr = {href: '#', onClick: function (e) {
                    (eval(this.props.action))(this.props.data);
                    e.preventDefault();
                }.bind(this)};
                break;
            case 'exec' :
                attr = {href: '#', onClick: function (e) {
                    eval(this.props.action);
                    e.preventDefault();
                }.bind(this)};
                break;
            case 'link' :
                attr = {href: this.props.action};
                break;
        }

        return (
            React.DOM.li({className:'list-group-item', onClick: this.itemClick},
                React.DOM.a(attr, this.props.text)
            )
        );
    }
});

// member toggle menu
$(function($) {
    $(document).on('click', function(){
        $('.__xe_member').popover('destroy');
    })

    $(document).on('click', '.__xe_member', function(e){
        e.preventDefault();

        var $this = $(this);
        $('.__xe_member').popover('destroy');
        $.ajax({
            url: '/plugin/toggleMenu',
            type: 'get',
            dataType: 'json',
            data: {type: 'member', id: $this.attr('data-id')},
            success: function (json) {
                var $div = $('<div style="margin:-9px -14px;"></div>');
                var $this = $(this);

                $this.popover({
                    'html': true,
                    'placement': 'top',
                    'content': function(){
                        React.render(
                            React.createElement(MemberToggleMenu, {
                                items: json,
                                type: "member"
                            }),
                            $div.get(0)
                        );
                        return $div;
                    }
                }).popover('show');


            }.bind(this)
        });
        return false;
    })

    /*$('.__xe_member').on('hide.bs.popover', function(){
     console.log('hide');
     $(this).next('.popover').empty();
     });
     $('.__xe_member').on('shown.bs.popover', function(){
     console.log('shown');
     var $this = $(this);
     var $content = $this.next('.popover');
     var $div = $('<div></div>');
     $('.__xe_member').not(this).popover('hide');
     React.render(
     React.createElement(MemberToggleMenu, {
     type: "member",
     identifier: $this.attr('data-id'),
     }),
     $div.get(0)
     );

     $content.empty().append($div)

     });*/


});
