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
      <div className="panel-heading" id={nodeId}>
        <div className="pull-left">
          <button className="btn-close pull-left" onClick={this.handleCollapse}>
            <i className={cx({
                          "xi-angle-down" : !index.collapsed,
                          "xi-angle-right" : index.collapsed
                          })}></i>
          </button>
          <a href={nodeUrl}><h3><i className="xi-folder"></i>{node.title}</h3></a>
        </div>
        <div className="pull-right">
          <a href={addItemUrl} className="btn btn-primary"><i className="xi-plus"></i><span>{XE.Lang.trans('xe::addItem')}</span></a>
        </div>
      </div>
    );
  }
});

module.exports = MenuEntity;
