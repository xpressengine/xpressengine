import React from 'react';
import createReactClass from 'create-react-class';
import PropTypes from 'prop-types';
import TreeNode from './TreeNode';

export default createReactClass({
  displayName: 'UITree',

  propTypes: {
    tree: PropTypes.object,
    home: PropTypes.string,

    paddingLeft: PropTypes.number,

    getBaseUrl: PropTypes.func,

    clickHome: PropTypes.func,

    getSelectedNode: PropTypes.func,
    setSelectedNode: PropTypes.func,

    getSearchedNode: PropTypes.func,
    setSearchedNode: PropTypes.func,

    moveNode: PropTypes.func,
  },

  getDefaultProps: function () {
    return {
      paddingLeft: 48,
    };
  },

  getInitialState: function () {
    return this.init(this.props);
  },

  componentWillReceiveProps: function (nextProps) {
    if (!this._update) {
      this.setState(this.init(nextProps));
    } else {
      this._update = false;
    }
  },

  init: function (props) {
    var tree = props.tree;
    tree.updateNodesPosition();

    return {
      tempTree: null,
      tree: tree,
      dragging: {
        id: null,
        x: null,
        y: null,
        w: null,
        h: null,
        originalParent: null,
        targetParent: null,
      },
    };
  },

  getDraggingDom: function () {
    var tree = this.state.tree;
    var dragging = this.state.dragging;
    var home = this.props.home;

    if (dragging && dragging.id) {
      var draggingIndex = tree.getIndex(dragging.id);
      var draggingStyles = {
        top: dragging.y,
        left: dragging.x,
        width: dragging.w,
      };

      return (
        <div className="m-draggable move" style={draggingStyles}>
						<TreeNode
           getBaseUrl={this.props.getBaseUrl}
           clickHome={this.props.clickHome}
           getSelectedNode={this.props.getSelectedNode}
           setSelectedNode={this.props.setSelectedNode}
           getSearchedNode={this.props.getSearchedNode}
           setSearchedNode={this.props.setSearchedNode}
           tree={tree}
           home={home}
           index={draggingIndex}
           key={dragging.id}
           isDragging={true}
         />
					</div>
      );
    }

    return null;
  },

  render: function () {
    var tree = this.state.tree;
    var dragging = this.state.dragging;
    var draggingDom = this.getDraggingDom();
    var _this = this;
    var home = this.props.home;

    var rootIndex = tree.getIndex(0);

    var treeItems = rootIndex.children.map(function (data) {
      return <TreeNode
        tree={tree}
        home={home}
        index={tree.getIndex(data)}
        getBaseUrl={_this.props.getBaseUrl}
        clickHome={_this.props.clickHome}

        getSelectedNode={_this.props.getSelectedNode}
        setSelectedNode={_this.props.setSelectedNode}

        getSearchedNode={_this.props.getSearchedNode}
        setSearchedNode={_this.props.setSearchedNode}

        key={data}

        onDragStart={_this.dragStart}
        onCollapse={_this.toggleCollapse}
        dragging={dragging && dragging.id}
        isDragging={false}
      />;
    });

    return (
      <div className="menu-content" id="uitree">
					{draggingDom}
					{treeItems}
				</div>
    );
  },

  dragStart: function (id, dom, e) {
    var tree = this.state.tree;
    var node = tree.get(id);
    if (node.entity && node.entity == 'menu')
     return;
    this.setState({
      tempTree: new Tree(tree.obj),
    });

    this.dragging = {
      id: id,
      w: dom.offsetWidth,
      h: dom.offsetHeight,
      x: dom.offsetLeft,
      y: dom.offsetTop,
      originalParent: tree.get(id).parentId,
      targetParent: tree.get(id).parentId,
      originalOrdering: tree.get(id).ordering,
      lastOrdering: tree.get(id).ordering,
    };

    this._startX = dom.offsetLeft;
    this._startY = dom.offsetTop;
    this._offsetX = e.clientX;
    this._offsetY = e.clientY;
    this._start = true;

    document.body.addEventListener('keydown', this.dragStop);
    document.body.addEventListener('mousemove', this.drag);
    document.body.addEventListener('mouseup', this.dragEnd);

  },

  drag: function (e) {
    if (this._start) {
      this.setState({
        dragging: this.dragging,
      });
      this._start = false;
    }

    var tree = this.state.tree;
    var dragging = this.state.dragging;
    var paddingLeft = this.props.paddingLeft;
    var newIndex = null;
    var index = tree.getIndex(dragging.id);
    var collapsed = index.collapsed;

    var _startX = this._startX;
    var _startY = this._startY;
    var _offsetX = this._offsetX;
    var _offsetY = this._offsetY;

    var pos = {
      x: _startX + e.clientX - _offsetX,
      y: _startY + e.clientY - _offsetY,
    };
    dragging.x = pos.x;
    dragging.y = pos.y;

    var diffX = dragging.x - paddingLeft / 2 - (index.left - 3) * paddingLeft;
    var diffY = dragging.y - dragging.h / 2 - (index.top - 2) * dragging.h;

    if (index.depth == 2 && (diffX < 0)) diffX = 0;
    if (diffX < 0) { // left
      if (index.parent && !index.next) {
        newIndex = tree.move(index.id, index.parent, 'after');
      }
    } else if (diffX > paddingLeft) { // right
      if (index.prev && !tree.getIndex(index.prev).collapsed) {
        newIndex = tree.move(index.id, index.prev, 'append');
      }
    }

    if (newIndex) {
      index = newIndex;
      newIndex.collapsed = collapsed;
      dragging.id = newIndex.id;
    }

    if (diffY < 0) { // up
      var above = tree.getNodeByTop(index.top - 1);
      newIndex = tree.move(index.id, above.id, 'before');
    } else if (diffY > dragging.h) { // down
      var below;
      if (index.next) {
        below = tree.getIndex(index.next);
        if (below.children && below.children.length && !below.collapsed) {
          newIndex = tree.move(index.id, index.next, 'prepend');
        } else {
          newIndex = tree.move(index.id, index.next, 'after');
        }
      } else {
        below = tree.getNodeByTop(index.top + index.height);
        if (below && below.parent !== index.id) {
          if (below.children && below.children.length) {
            newIndex = tree.move(index.id, below.id, 'prepend');
          } else {
            newIndex = tree.move(index.id, below.id, 'after');
          }
        }
      }
    }

    if (newIndex) {
      newIndex.collapsed = collapsed;
      dragging.id = newIndex.id;
      var newParent = tree.get(newIndex.parent);
      dragging.targetParent = newParent.id;
      dragging.lastOrdering = newIndex.ordering;
      dragging.children = newIndex.children;
    }

    this.setState({
      tree: tree,
      dragging: dragging,
    });
  },

  dragStop: function (e) {

    var Keys = {
      ENTER: 13,
      TAB: 9,
      BACKSPACE: 8,
      UP_ARROW: 38,
      DOWN_ARROW: 40,
      ESCAPE: 27,
    };

    if (e.keyCode === Keys.ESCAPE) {
      e.preventDefault();

    }

    this.rollbackTree();

    document.body.removeEventListener('mousemove', this.drag);
    document.body.removeEventListener('mouseup', this.dragEnd);
    document.body.removeEventListener('keydown', this.dragStop);
  },

  dragEnd: function () {
    this.setState({
      tempTree: null,
      dragging: {
        id: null,
        x: null,
        y: null,
        w: null,
        h: null,
        originalParent: null,
        targetParent: null,
      },
    });

    var dragging = this.dragging;

    if (dragging.originalParent == dragging.targetParent) {
      if (dragging.originalOrdering != dragging.lastOrdering) {
        var targetNode = this.state.tree.get(dragging.id);
        if (targetNode.entity != 'menu')
         this.props.moveNode(
           {
            id: dragging.id,
            parent: dragging.targetParent,
            position: dragging.lastOrdering,
          }
         );
      }
    } else {
      if (dragging.children.length > 0) {
        this.props.moveNode({
          id: dragging.id,
          parent: dragging.targetParent,
          position: dragging.lastOrdering,
          children: dragging.children,
        });

      } else {
        this.props.moveNode({
          id: dragging.id,
          parent: dragging.targetParent,
          position: dragging.lastOrdering,
        });
      }
    }

    document.body.removeEventListener('mousemove', this.drag);
    document.body.removeEventListener('mouseup', this.dragEnd);
    document.body.removeEventListener('keydown', this.dragStop);
  },

  rollbackTree: function () {

    var rollbackTree = this.state.tempTree;
    if (!rollbackTree) return;
    var currentProps = this.props;
    currentProps.tree = rollbackTree;
    this.setState(this.init(currentProps));

    this.setState({
      tree: rollbackTree,
      dragging: {
        id: null,
        x: null,
        y: null,
        w: null,
        h: null,
        originalParent: null,
        targetParent: null,
      },
    });

  },

  toggleCollapse: function (nodeId) {
    var tree = this.state.tree;
    var index = tree.getIndex(nodeId);
    var node = tree.get(nodeId);

    index.collapsed = !index.collapsed;
    node.collapsed = !node.collapsed;

    tree.updateNodesPosition();
    this.setState({
      tree: tree,
    });
  },
});
