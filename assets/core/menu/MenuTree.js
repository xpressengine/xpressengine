var MenuSearchBar = require('./MenuSearchBar.js!jsx');
var UITree = require('./UITree.js!jsx');

var MenuTree = React.createClass({
  getInitialState: function () {
    return {
      rawTree: this.props.menus,
      dataTree: new Tree({title: "root", items: this.props.menus}),
      selected: null,
      searched: null,
      home: this.props.home,
      menuRoutes: this.props.menuRoutes
    };
  },
  componentDidMount: function () {
    this.state.dataTree.movementFilter = this.movementFilter;
  },

  getSearchedNode: function () {
    return this.state.searched;
  },

  setSearchedNode: function (node) {
    this.setState({
      searched: node
    });
  },

  getSelectedNode: function () {
    return this.state.selected;
  },

  setSelectedNode(node) {
    this.setState({
      selected: node
    });
  },

  movementFilter: function (param) {
    var tree = param.tree;

    var destNode = tree.get(param.toId);
    var destIndex = tree.getIndex(param.toId);
    var srcNode = tree.get(param.fromId);

    if (this.isMenuEntity(srcNode)) return;

    if (this.isMenuEntity(destNode)) {
      if (param.placement == 'after') {
        param.placement = 'prepend';
        return param;
      } else if (param.placement == 'before') {
        if (destIndex.prev && destIndex.prev != null) {
          var newDestIndex = tree.getIndex(destIndex.prev);
          param.toId = destIndex.prev;
          if (!newDestIndex.collapsed) {
            param.placement = 'append';
          }
          return param;
        } else {
          return;
        }
      }
      return param;
    } else {

      if ((param.placement == 'append') || (param.placement == 'prepend')) {
        if (destIndex.depth > MaxDepth) {
          return;
        }
      }
      return param;
    }
  },

  moveMenuItem(target) {
    var moveItemUrl = this.props.baseUrl + '/moveItem';
    XE.ajax({
      url: moveItemUrl,
      context: $('#uitree'),
      type: 'put',
      dataType: 'json',
      data: {
        itemId: target.id,
        parent: target.parent,
        ordering: target.position
      },
      success: function (data) {
        XE.toast('success', 'Item moved');
      }.bind(this)
    });

  },

  getBaseUrl() {
    return this.props.baseUrl;
  },

  onClickHome: function (node) {
    var homeItemUrl = this.props.baseUrl + '/setHome';
    var oldHome = this.state.home;

    this.setState({home: node.id});
    XE.ajax({
      url: homeItemUrl,
      context: $('#uitree'),
      type: 'put',
      dataType: 'json',
      data: {
        itemId: node.id
      },
      success: function (data) {
        XE.toast('success', node.title + ' is home!');
      }.bind(this),
      error: function (data) {
        XE.toast('error', 'home setting was failed!');
        this.setState({home: oldHome});
      }.bind(this)
    });
  },

  render: function () {
    return (
      <div className="col-sm-12">
        <div className="panel">
          <MenuSearchBar tree={this.state.dataTree} handleSearch={this.setSearchedNode} menuRoutes={this.state.menuRoutes}/>
          <div className="panel-body">
            <UITree paddingLeft={25}
                    tree={this.state.dataTree}
                    home={this.state.home}
                    getBaseUrl={this.getBaseUrl}
                    clickHome={this.onClickHome}
                    getSearchedNode={this.getSearchedNode}
                    setSearchedNode={this.setSearchedNode}
                    getSelectedNode={this.getSelectedNode}
                    setSelectedNode={this.setSelectedNode}
                    moveNode={this.moveMenuItem}/>
          </div>
        </div>
      </div>
    );
  },

  isMenuEntity(node) {
    return (node.entity && (node.entity == 'menu'));
  }
});
window["MenuTree"] = MenuTree;
module.exports = MenuTree;
