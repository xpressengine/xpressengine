import React from 'react';
import ReactDOM from 'react-dom';

export default React.createClass({
  displayName: 'MenuItem',

  propTypes: {
    index: React.PropTypes.object,
    home: React.PropTypes.string,
    getBaseUrl: React.PropTypes.func,
    clickHome: React.PropTypes.func,
    mouseDown: React.PropTypes.func,

    getSelectedNode: React.PropTypes.func,
    setSelectedNode: React.PropTypes.func,
  },

  onClickLink: function (node) {
    if (node.type !== 'xpressengine@directLink') {
      location.href = '/' + node.url;
    } else {
      location.href = node.url;
    }
  },

  componentDidUpdate: function () {
    var searched = this.props.getSearchedNode();
    var node = this.props.index.node;
    if (searched === node) {
      $('html, body').animate({
        scrollTop: $('#xe_tree_node_' + node.id).offset().top - 20,
      }, 500);
      this.props.setSearchedNode(null);
    }
  },

  onClickHome: function (node) {
    this.props.clickHome(node);
  },

  handleMouseDown: function (e) {
    var nodeId = this.props.index.id;
    var dom = ReactDOM.findDOMNode(this.refs.inner);
    this.props.mouseDown(nodeId, dom, e);
  },

  onClickSetNode: function (node) {

    var selected = this.props.getSelectedNode();

    if (selected === node) {
      this.props.setSelectedNode(null);
    } else {
      this.props.setSelectedNode(node);
    }
  },

  render: function () {
    var node = this.props.index.node;

    var title = node.title || '';
    var type = node.type;
    var url = '';

    var trans = {
      title: XE.Lang.trans(title),
      setHome: XE.Lang.trans('xe::setHome'),
      goLink: XE.Lang.trans('xe::goLink'),
    };

    if (node.type !== 'xpressengine@directLink') {
      if (node.id == this.props.home) {
        url = '/';
      } else {
        url = '/' + node.url;
      }

      url = Utils.getUri(xeBaseURL + url);

    } else {
      url = node.url;
    }

    var nodeUrl = this.props.getBaseUrl() + '/menus/' + node.menuId + '/items/' + node.id;
    var homeElement;
    if (node.id == this.props.home) {
      homeElement =
        <button type="button" className="btn-link hidden-xs home-on">
						<i className="xi-home"></i>
					</button>;
    } else {
      if (node.activated === 1) {
        homeElement =
          <button type="button" className="btn btn-link hidden-xs"
              onClick={this.onClickHome.bind(null, node)}>
							<i className="xi-home"></i>
						</button>;
      } else {
        homeElement = null;
      }
    }

    var controlElement;
    var selected = this.props.getSelectedNode();
    if (selected == node) {
      controlElement = <div className="visible-xs more-area" style={{ display: 'block' }}>
				<button className="btn" type="button"
           onClick={this.onClickHome.bind(null, node)}>{trans.setHome}</button>
				<a href={url} className="btn">{trans.goLink}</a>
			</div>;
    }

    var nodeId = 'xe_tree_node_' + node.id;
    return (
      <div className="item-content" ref="inner" id={nodeId}>
					<button className="btn handler" onMouseDown={this.handleMouseDown}>
						<i className="xi-bullet-point"></i>
					</button>
					<div className="item-info">
						<i className="xi-paper"></i>
						<dl>
							<dt className="sr-only">{trans.title}</dt>
							<dd className="ellipsis"><a href={nodeUrl}>{trans.title}</a></dd>
							<dt className="sr-only">{url}</dt>
							<dd className="text-blue ellipsis">
								<a href={url}>{url}</a>
								<em>[{type}]</em>
							</dd>
						</dl>
					</div>
					<div className="btn-group pull-right">
						<button type="button" className="btn-more visible-xs"
            onClick={this.onClickSetNode.bind(null, node)}>
							<i className="xi-ellipsis-v"></i>
						</button>
						{homeElement}
					</div>
					{controlElement}
				</div>
    );
  },
});
