import React from 'react';
import createReactClass from 'create-react-class';
import PropTypes from 'prop-types';

export default createReactClass({
  displayName: 'MenuEntity',

  propTypes: {
    index: PropTypes.object,
    onCollapse: PropTypes.func,
    getBaseUrl: PropTypes.func,
  },

  handleCollapse: function (e) {
    e.stopPropagation();
    var nodeId = this.props.index.id;
    if (this.props.onCollapse) this.props.onCollapse(nodeId);
  },

  render: function () {
    var index = this.props.index;
    var node = index.node;
    var nodeUrl = this.props.getBaseUrl() + '/menus/' + node.id;
    var addItemUrl = this.props.getBaseUrl() + '/menus/' + node.id + '/types';

    // trans
    var trans = {
      addItem: XE.Lang.trans('xe::addItem'),
    };

    var nodeId = 'xe_tree_node_' + node.id;
    return (
      <div className="panel-heading" id={nodeId}>
					<div className="pull-left">
						<a href={nodeUrl}><h3><i className="xi-folder"></i>{node.title}</h3></a>
					</div>
					<div className="pull-right">
						<a href={addItemUrl} className="btn btn-primary"><i
          className="xi-plus"></i><span>{trans.addItem}</span></a>
					</div>
				</div>
    );
  },
});
