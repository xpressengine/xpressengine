var MenuEntity = React.createClass({
  displayName: 'MenuEntity',

  propTypes: {
    index: React.PropTypes.object,
    onCollapse: React.PropTypes.func,
    getBaseUrl: React.PropTypes.func
  },

  handleCollapse(e) {
    e.stopPropagation();
    var nodeId = this.props.index.id;
    if (this.props.onCollapse) this.props.onCollapse(nodeId);
  },

  render() {
    var index = this.props.index;
    var node = index.node;
    var nodeUrl = this.props.getBaseUrl() + '/menus/' + node.id;
    var addItemUrl = this.props.getBaseUrl() + '/menus/' + node.id + '/types';

    var nodeId = 'xe_tree_node_' + node.id;
    return (
      <div className="row" id={nodeId}>

        <div className="col-sm-6">
          <button className="btn_clse ico_gray pull-left" onClick={this.handleCollapse}>
            <i className={cx({"xi-angle-down" : !index.collapsed,
                        "xi-angle-right" : index.collapsed
                        })}></i>
          </button>
          <a href={nodeUrl}><h3><i className="xi-folder"></i>{node.title}</h3></a>
        </div>
        <div className="col-sm-6">
          <div className="btn_group txt_group pull-right">
            <a className="btn btn_blue" href={addItemUrl}>
              <i className="xi-plus"></i>{XE.Lang.trans('xe::addItem')}
            </a>
          </div>
        </div>
      </div>
    );
  }
});

module.exports = MenuEntity;
