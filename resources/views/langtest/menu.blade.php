{{ Frontend::js('/assets/vendor/jqueryui/jquery-ui.js')->appendTo('head')->load() }}
{{ Frontend::css('/assets/vendor/jqueryui/jquery-ui.css')->load() }}
{{ Frontend::js('/assets/vendor/expanding/expanding.js')->appendTo('head')->load() }}
{{ Frontend::js('/assets/vendor/lang/LangEditorBox.js')->type('text/jsx')->appendTo('head')->load() }}
{{ Frontend::css('/assets/vendor/lang/LangEditorBox.css')->load() }}

<div id="content" data-menus="{!! htmlspecialchars($menus) !!}"></div>
<style>
    table {
        border: 1px solid black;
    }

    td {
        vertical-align: top;
    }

    td.left {
        width: 200px;
    }
</style>

<script type="text/jsx">
    $(function() {
        var Menus = React.createClass({
            getInitialState: function () {
                return {
                    selmenu: {
                        key: '',
                        title: '',
                        url: '',
                        description: ''
                    }
                };
            },
            componentDidMount: function() {
                var el = this.getDOMNode();
                var self = this;

                $(el).find('li').click(function(e) {
                    var li = $(this);
                    var key = li.data('key');
                    self.setState({selmenu: self.props.menus[key]});
                    return false;
                });

                $(el).find('button').click(function(e) {
                    var formData = $(this).closest('form').serialize();

                    XE.ajax({
                        type: 'post',
                        dataType: 'json',
                        url: '/' + XE.options.managePrefix + '/langtest/menus/save',
                        data: formData,
                        success: function(result) {
                            location.reload();
                        }.bind(this)
                    });

                    return false;
                });
            },
            render: function() {
                var indents = [];
                for (var property in this.props.menus) {
                    indents.push(<li key={property} data-key={property}>{property}</li>);
                }

                var key = null;
                if ( this.state.selmenu && this.state.selmenu['key'] ) {
                    key = <input key={'newKey' + (this.state.selmenu['key'] || '')} name="key" type="text" placeholder="Key" defaultValue={this.state.selmenu['key']} readOnly="readOnly" />
                } else {
                    key = <input key={'newKey' + (this.state.selmenu['key'] || '')} name="key" type="text" placeholder="Key" defaultValue={this.state.selmenu['key']} />
                }

                return (
                        <table>
                            <tr>
                                <td className="left">
                                    <ul>
                                        {indents}
                                    </ul>
                                </td>
                                <td>
                                    <form method="post">
                                        <label>key</label><br/>
                                        {key}<br/>
                                        <br/>

                                        <label>title</label><br/>
                                        <LangEditorBox key={'newTitle' + (this.state.selmenu['title'] || '')} name="title" langKey={this.state.selmenu['title']} /><br/>
                                        <br/>

                                        <label>url</label><br/>
                                        <input key={'newURL' + (this.state.selmenu['url'] || '')} name="url" type="text" placeholder="URL" defaultValue={this.state.selmenu['url']} /><br/>
                                        <br/>

                                        <label>description</label><br/>
                                        <LangEditorBox key={'newDescription' + (this.state.selmenu['description'] || '')} name="description" langKey={this.state.selmenu['description']} multiline="true" /><br/>
                                        <br/>

                                        <button>저장</button>
                                    </form>
                                </td>
                            </tr>
                        </table>
                );
            }
        });

        var content = $('#content');
        var menus = content.data('menus');
        React.render(<Menus menus={menus} />, content.get(0));
    })
</script>