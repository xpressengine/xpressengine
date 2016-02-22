var MenuItem = React.createClass({
    displayName: 'MenuItem',

    propTypes: {
        index: React.PropTypes.object,
        home : React.PropTypes.string,
        getBaseUrl: React.PropTypes.func,
        clickHome: React.PropTypes.func,
        mouseDown: React.PropTypes.func,

        getSelectedNode: React.PropTypes.func,
        setSelectedNode: React.PropTypes.func
    },

    onClickLink(node) {
        if (node.type !== "xpressengine@directLink") {
            location.href = '/' + node.url;
        }else {
            location.href = node.url;
        }
    },

    componentDidUpdate: function () {
        var searched = this.props.getSearchedNode();
        var node = this.props.index.node;
        if (searched === node) {
            $('html, body').animate({
                scrollTop: $('#xe_tree_node_' + node.id).offset().top - 20
            }, 500);
            this.props.setSearchedNode(null);
        }
    },

    onClickHome(node){
        this.props.clickHome(node);
    },

    handleMouseDown(e){
        var nodeId = this.props.index.id;
        var dom = this.refs.inner.getDOMNode();
        this.props.mouseDown(nodeId, dom, e);
    },

    onClickSetNode(node){

        var selected = this.props.getSelectedNode();

        if (selected === node) {
            this.props.setSelectedNode(null);
        } else {
            this.props.setSelectedNode(node);
        }
    },

    render() {
        var node = this.props.index.node;

        var title = node.title || '';
        var type = node.type;
        var url = '';

        title = XE.Lang.trans(title);

        if (node.type !== "xpressengine@directLink") {
            if(node.id == this.props.home){
                url = '/';
            }else{
                url = '/' + node.url;
            }
        } else {
            url = node.url;
        }

        var nodeUrl = this.props.getBaseUrl() + '/menus/' + node.menuId + '/items/' + node.id;
        var homeElement;
        if( node.id == this.props.home){
            homeElement =
                <button type="button" className="btn_txt hidden-xs home_on">
                    <i className="xi-home"></i>
                </button>;
        } else {
            if (node.activated === 1) {
                homeElement =
                    <button type="button" className="btn_txt hidden-xs" onClick={this.onClickHome.bind(null, node)}>
                        <i className="xi-home"></i>
                    </button>;
            } else {
                homeElement = null;
            }
        }

        var controlElement;
        var selected = this.props.getSelectedNode();
        if (selected == node) {
            controlElement = <div className="visible-xs more_area" style={{display:"block"}}>
                <button className="btn" type="button"
                        onClick={this.onClickHome.bind(null, node)}>{XE.Lang.trans('xe::setHome')}</button>
                <a href={url} className="btn">{XE.Lang.trans('xe::goLink')}</a>
            </div>;
        }

        var nodeId = 'xe_tree_node_' + node.id;
        return (
            <div className="item_con" ref="inner" id={nodeId}>
                <button className="btn handler" onMouseDown={this.handleMouseDown}>
                    <i className="xi-bullet-point"></i>
                </button>
                <div className="item_cont">
                    <i className="xi-paper"></i>
                    <dl>
                        <dt className="blind">{title}</dt>
                        <dd className="one_line"><a href={nodeUrl}>{title}</a></dd>
                        <dt className="blind">{url}</dt>
                        <dd className="txt_blue one_line">
                            <a href={url}>{url}</a>
                            <em>[{type}]</em>
                        </dd>
                    </dl>
                </div>
                <div className="btn_group pull-right">
                    <button type="button" className="btn_more visible-xs"
                            onClick={this.onClickSetNode.bind(null, node)}>
                        <i className="xi-ellipsis-v"></i>
                    </button>
                    {homeElement}
                </div>
                {controlElement}
            </div>
        );
    }
});
