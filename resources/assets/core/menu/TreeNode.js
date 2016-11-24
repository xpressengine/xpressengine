import React from 'react';

import MenuEntity from './MenuEntity';
import MenuItem from './MenuItem';

let TreeNode = React.createClass({
  displayName: 'TreeNode',

  propTypes: {
    index: React.PropTypes.object,
    tree: React.PropTypes.object,
    home: React.PropTypes.string,
    dragging: React.PropTypes.string,
    onDragStart: React.PropTypes.func,
    onCollapse: React.PropTypes.func,
    getBaseUrl: React.PropTypes.func,
    clickHome: React.PropTypes.func,
    getSelectedNode: React.PropTypes.func,
    setSelectedNode: React.PropTypes.func,
    getSearchedNode: React.PropTypes.func,
    setSearchedNode: React.PropTypes.func,
  },

  renderChildren: function () {
    var props = this.props;
    var index = props.index;
    var tree = props.tree;
    var dragging = props.dragging;
    var home = props.home;
    var getBaseUrl = props.getBaseUrl;
    var onDragStart = props.onDragStart;
    var isDragging = props.isDragging;

    var isPlaceHolder = (index.id === dragging) || this.props.isPlaceHolder;
    if (index.children && index.children.length) {
      var childrenStyles = {};
      var children = index.children;
      if (index.collapsed) {
        var searched = props.getSearchedNode();
        if ((searched === null) || (index.id != searched.menuId)) {
          childrenStyles.display = 'none';
        } else {
          index.collapsed = !index.collapsed;
        }
      }

      var childNodes = children.map(function (child) {
        var childIndex = tree.getIndex(child);
        return (
          <TreeNode
            tree={tree}
            index={childIndex}
            key={childIndex.id}

            dragging={dragging}
            home={home}

            onDragStart={onDragStart}
            isDragging={isDragging}
            isPlaceHolder={isPlaceHolder}

            clickHome={props.clickHome}

            getSelectedNode={props.getSelectedNode}
            setSelectedNode={props.setSelectedNode}

            getSearchedNode={props.getSearchedNode}
            setSearchedNode={props.setSearchedNode}

            getBaseUrl={getBaseUrl}
          />
        );
      });

      return (
        <div className={cx({
                  'item-container': true,
                  move: isDragging,
                })} style={childrenStyles}>
						{childNodes}
					</div>
      );
    }

    return null;
  },

  render: function () {
    var props = this.props;
    var index = props.index;
    var home = props.home;
    var node = index.node;

    var isPlaceHolder = this.isPlaceHolder(props);

    if (this.isMenuEntity(node)) {
      return (
        <div className="menu-type">
						<MenuEntity
           index={index}
           getBaseUrl={props.getBaseUrl}
           onCollapse={props.onCollapse}
         />
						{this.renderChildren()}
					</div>
      );
    } else {
      return (
        <div className={cx({
                      node: true,
                      item: true,
                      copy: isPlaceHolder,
                      off: (node.activated !== 1),
                    })}>
						<MenuItem
           index={index}
           home={home}
           getBaseUrl={props.getBaseUrl}
           clickHome={props.clickHome}
           mouseDown={this.handleMouseDown}

           getSelectedNode={props.getSelectedNode}
           setSelectedNode={props.setSelectedNode}

           getSearchedNode={props.getSearchedNode}
           setSearchedNode={props.setSearchedNode}
         />
						{this.renderChildren()}
					</div>

      );
    }
  },

  handleMouseDown: function (nodeId, dom, e) {
    if (this.props.onDragStart) {
      this.props.onDragStart(nodeId, dom, e);
    }
  },

  isMenuEntity: function (node) {
    return (node.entity && (node.entity == 'menu'));
  },

  isPlaceHolder: function (props) {
    var index = props.index;
    var dragging = props.dragging;
    return ((index.id === dragging) || props.isPlaceHolder);
  },
});

export default TreeNode;
