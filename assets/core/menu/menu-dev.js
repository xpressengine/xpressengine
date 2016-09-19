System.amdDefine('MenuEntity', ['react'], function(React) {

  'use strict';
  
  var MenuEntity = React.createClass({
    displayName: 'MenuEntity',

    propTypes: {
      index: React.PropTypes.object,
      onCollapse: React.PropTypes.func,
      getBaseUrl: React.PropTypes.func
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
        addItem: XE.Lang.trans('xe::addItem')
      };

      var nodeId = 'xe_tree_node_' + node.id;
      return (
          React.createElement("div", {className: "panel-heading", id: nodeId}, 
            React.createElement("div", {className: "pull-left"}, 
              React.createElement("a", {href: nodeUrl}, React.createElement("h3", null, React.createElement("i", {className: "xi-folder"}), node.title))
            ), 
            React.createElement("div", {className: "pull-right"}, 
              React.createElement("a", {href: addItemUrl, className: "btn btn-primary"}, React.createElement("i", {className: "xi-plus"}), React.createElement("span", null, trans.addItem))
            )
          )
      );
    }
  });

  return MenuEntity;
});
System.amdDefine('MenuItem', ['react', 'react-dom'], function(React, ReactDOM) {

  'use strict';

  var MenuItem = React.createClass({
    displayName: 'MenuItem',

    propTypes: {
      index: React.PropTypes.object,
      home: React.PropTypes.string,
      getBaseUrl: React.PropTypes.func,
      clickHome: React.PropTypes.func,
      mouseDown: React.PropTypes.func,

      getSelectedNode: React.PropTypes.func,
      setSelectedNode: React.PropTypes.func
    },

    onClickLink: function (node) {
      if (node.type !== "xpressengine@directLink") {
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
          scrollTop: $('#xe_tree_node_' + node.id).offset().top - 20
        }, 500);
        this.props.setSearchedNode(null);
      }
    },

    onClickHome: function (node){
      this.props.clickHome(node);
    },

    handleMouseDown: function (e){
      var nodeId = this.props.index.id;
      var dom = ReactDOM.findDOMNode(this.refs.inner);
      this.props.mouseDown(nodeId, dom, e);
    },

    onClickSetNode: function (node){

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

      if (node.type !== "xpressengine@directLink") {
        if (node.id == this.props.home) {
          url = '/';
        } else {
          url = '/' + node.url;
        }
      } else {
        url = node.url;
      }

      var nodeUrl = this.props.getBaseUrl() + '/menus/' + node.menuId + '/items/' + node.id;
      var homeElement;
      if (node.id == this.props.home) {
        homeElement =
            React.createElement("button", {type: "button", className: "btn-link hidden-xs home-on"}, 
              React.createElement("i", {className: "xi-home"})
            );
      } else {
        if (node.activated === 1) {
          homeElement =
              React.createElement("button", {type: "button", className: "btn btn-link hidden-xs", onClick: this.onClickHome.bind(null, node)}, 
                React.createElement("i", {className: "xi-home"})
              );
        } else {
          homeElement = null;
        }
      }

      var controlElement;
      var selected = this.props.getSelectedNode();
      if (selected == node) {
        controlElement = React.createElement("div", {className: "visible-xs more-area", style: {display:"block"}}, 
          React.createElement("button", {className: "btn", type: "button", 
                  onClick: this.onClickHome.bind(null, node)}, trans.setHome), 
          React.createElement("a", {href: url, className: "btn"}, trans.goLink)
        );
      }

      var nodeId = 'xe_tree_node_' + node.id;
      return (
          React.createElement("div", {className: "item-content", ref: "inner", id: nodeId}, 
            React.createElement("button", {className: "btn handler", onMouseDown: this.handleMouseDown}, 
              React.createElement("i", {className: "xi-bullet-point"})
            ), 
            React.createElement("div", {className: "item-info"}, 
              React.createElement("i", {className: "xi-paper"}), 
              React.createElement("dl", null, 
                React.createElement("dt", {className: "sr-only"}, trans.title), 
                React.createElement("dd", {className: "ellipsis"}, React.createElement("a", {href: nodeUrl}, trans.title)), 
                React.createElement("dt", {className: "sr-only"}, url), 
                React.createElement("dd", {className: "text-blue ellipsis"}, 
                  React.createElement("a", {href: url}, url), 
                  React.createElement("em", null, "[", type, "]")
                )
              )
            ), 
            React.createElement("div", {className: "btn-group pull-right"}, 
              React.createElement("button", {type: "button", className: "btn-more visible-xs", 
                      onClick: this.onClickSetNode.bind(null, node)}, 
                React.createElement("i", {className: "xi-ellipsis-v"})
              ), 
              homeElement
            ), 
            controlElement
          )
      );
    }
  });

  return MenuItem;
});
System.amdDefine('TreeNode', ['react', 'MenuEntity', 'MenuItem'], function(React, MenuEntity, MenuItem) {

  'use strict';
  
  var TreeNode = React.createClass({
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
      setSearchedNode: React.PropTypes.func
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
          if ((searched === null ) || (index.id != searched.menuId)) {
            childrenStyles.display = 'none';
          } else {
            index.collapsed = !index.collapsed;
          }
        }

        var childNodes = children.map(function (child) {
          var childIndex = tree.getIndex(child);
          return (
              React.createElement(TreeNode, {
                  tree: tree, 
                  index: childIndex, 
                  key: childIndex.id, 

                  dragging: dragging, 
                  home: home, 

                  onDragStart: onDragStart, 
                  isDragging: isDragging, 
                  isPlaceHolder: isPlaceHolder, 

                  clickHome: props.clickHome, 

                  getSelectedNode: props.getSelectedNode, 
                  setSelectedNode: props.setSelectedNode, 

                  getSearchedNode: props.getSearchedNode, 
                  setSearchedNode: props.setSearchedNode, 

                  getBaseUrl: getBaseUrl}
              )
          );
        });
        return (
            React.createElement("div", {className: cx({
                'item-container': true,
                'move': isDragging
                }), style: childrenStyles}, 
              childNodes
            )
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
            React.createElement("div", {className: "menu-type"}, 
              React.createElement(MenuEntity, {
                  index: index, 
                  getBaseUrl: props.getBaseUrl, 
                  onCollapse: props.onCollapse}
              ), 
              this.renderChildren()
            )
        );
      } else {
        return (
            React.createElement("div", {className: cx({
                    'node' : true,
                    'item' : true,
                    'copy' : isPlaceHolder,
                    'off' : (node.activated !== 1)
                    })}, 
              React.createElement(MenuItem, {
                  index: index, 
                  home: home, 
                  getBaseUrl: props.getBaseUrl, 
                  clickHome: props.clickHome, 
                  mouseDown: this.handleMouseDown, 

                  getSelectedNode: props.getSelectedNode, 
                  setSelectedNode: props.setSelectedNode, 

                  getSearchedNode: props.getSearchedNode, 
                  setSearchedNode: props.setSearchedNode}
              ), 
              this.renderChildren()
            )

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
    }
  });

  return TreeNode;
});
System.amdDefine('MenuSearchBar', ['react', 'react-dom', 'MenuSearchSuggestion'], function(React, ReactDOM, MenuSearchSuggestion) {

  'use strict';

  var MenuSearchBar = React.createClass({
    displayName: 'MenuSearchBar',

    propTypes: {
      tree: React.PropTypes.object,
      placeholder: React.PropTypes.string,
      handleSearch: React.PropTypes.func,
      menuRoutes: React.PropTypes.object
    },
    getDefaultProps: function () {
      return {
        placeholder: 'Search...',
        tree: new Tree({})
      };
    },
    componentDidMount: function () {
    },
    getInitialState: function () {
      return {
        query: '',
        suggestions: [],
        selectedIndex: -1,
        selectionMode: false,
        searchingCnt: 0
      };
    },
    handleChange: function (e) {
      var query = e.target.value.trim();
      this.setState({
        query: query
      });

      this.searchMenu(query);
      if (query.length == 0) {
        this.setState({
          suggestions: [],
          searchingCnt: 0
        });
      }
    },

    searchMenu: function (keyword) {
      var self = this;
      var searchingCnt = this.state.searchingCnt + 1;
      var suggestions;
      var tree = this.props.tree;

      this.setState({
        searchingCnt: searchingCnt
      });

      suggestions = _.filter(tree.indexes, function (index) {

        if (index.id == 0) return false;

        var title = index.node.title;
        if (!self.isMenuEntity(index.node)) {
          title = XE.Lang.trans(index.node.title);
        }
        return !!(title && title.indexOf(keyword) !== -1);
      });

      searchingCnt = this.state.searchingCnt;
      searchingCnt = searchingCnt - 1;
      self.setState(
          {
            suggestions: suggestions,
            searchingCnt: searchingCnt
          }
      );

    },

    isMenuEntity: function (node) {
      return (node.entity && (node.entity == 'menu'));
    },

    resetSearch: function () {
      var input = ReactDOM.findDOMNode(this.refs.input);

      this.setState({
        query: '',
        selectedIndex: -1,
        selectionMode: false,
        suggestions: []
      });

      input.value = '';
      input.focus();
    },

    handleKeyDown: function handleKeyDown(e) {
      var _state = this.state;
      var query = _state.query;
      var selectedIndex = _state.selectedIndex;
      var suggestions = _state.suggestions;

      // hide suggestions menu on escape
      if (e.keyCode === Keys.ESCAPE) {
        e.preventDefault();
        this.resetSearch();
      }

      if ((e.keyCode === Keys.ENTER || e.keyCode === Keys.TAB) && query != '') {
        e.preventDefault();
        if (this.state.selectionMode) {
          this.selection(this.state.suggestions[this.state.selectedIndex]);
        }
      }

      // up arrow
      if (e.keyCode === Keys.UP_ARROW) {
        e.preventDefault();
        // last item, cycle to the top
        if (selectedIndex <= 0) {
          this.setState({
            selectedIndex: this.state.suggestions.length - 1,
            selectionMode: true
          });
        } else {
          this.setState({
            selectedIndex: selectedIndex - 1,
            selectionMode: true
          });
        }
      }

      // down arrow
      if (e.keyCode === Keys.DOWN_ARROW) {
        e.preventDefault();
        this.setState({
          selectedIndex: (this.state.selectedIndex + 1) % suggestions.length,
          selectionMode: true
        });
      }
    },

    selection: function (index) {
      var input = ReactDOM.findDOMNode(this.refs.input);

      this.props.handleSearch(index.node);

      this.setState({
        query: '',
        selectionMode: false,
        selectedIndex: -1
      });

      input.value = '';
      input.focus();
    },
    handleSuggestionClick: function handleSuggestionClick(i, e) {
      e.preventDefault();
      this.selection(this.state.suggestions[i]);
    },
    handleSuggestionHover: function handleSuggestionHover(i, e) {
      this.setState({
        selectedIndex: i,
        selectionMode: true
      });
    },

    render: function render() {

      var query = this.state.query.trim(),
          selectedIndex = this.state.selectedIndex,
          suggestions = this.state.suggestions,
          placeholder = this.props.placeholder
      var trans = {
        addMenu: XE.Lang.trans('xe::addMenu')
      };

      return (
          React.createElement("div", {className: "panel-heading"}, 
            React.createElement("div", {className: "pull-left"}, 
              React.createElement("div", {className: cx({
                "input-group" : true,
                "search-group" : true,
                open : query.length > 0
            })}, 
                React.createElement("input", {type: "text", className: "form-control", "aria-label": "Text input with dropdown button", 
                       placeholder: placeholder, ref: "input", onChange: this.handleChange, onKeyDown: this.handleKeyDown}), 
                React.createElement("button", {className: "btn-link", onClick: this.resetSearch}, 
                  React.createElement("i", {className: "xi-magnifier"}), React.createElement("span", {className: "sr-only"}, "검색")
                ), 

                React.createElement(MenuSearchSuggestion, {query: query, 
                                      suggestions: suggestions, 
                                      selectedIndex: selectedIndex, 
                                      handleClick: this.handleSuggestionClick, 
                                      handleHover: this.handleSuggestionHover})
              )
            ), 
            React.createElement("div", {className: "pull-right"}, 
              React.createElement("a", {href: this.props.menuRoutes.createMenu, className: "btn btn-primary pull-right"}, React.createElement("i", {className: "xi-plus"}), " ", trans.addMenu)
            )
          )
      );
    }
  });

  return MenuSearchBar;
});
System.amdDefine('UITree', ['react', 'TreeNode'], function(React, TreeNode) {
  var UITree = React.createClass({
    displayName: 'UITree',

    propTypes: {
      tree: React.PropTypes.object,
      home: React.PropTypes.string,

      paddingLeft: React.PropTypes.number,

      getBaseUrl: React.PropTypes.func,

      clickHome: React.PropTypes.func,

      getSelectedNode: React.PropTypes.func,
      setSelectedNode: React.PropTypes.func,

      getSearchedNode: React.PropTypes.func,
      setSearchedNode: React.PropTypes.func,

      moveNode: React.PropTypes.func
    },

    getDefaultProps: function () {
      return {
        paddingLeft: 48
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
          targetParent: null
        }
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
          width: dragging.w
        };

        return (
            React.createElement("div", {className: "m-draggable move", style: draggingStyles}, 
              React.createElement(TreeNode, {
                  getBaseUrl: this.props.getBaseUrl, 
                  clickHome: this.props.clickHome, 
                  getSelectedNode: this.props.getSelectedNode, 
                  setSelectedNode: this.props.setSelectedNode, 
                  getSearchedNode: this.props.getSearchedNode, 
                  setSearchedNode: this.props.setSearchedNode, 
                  tree: tree, 
                  home: home, 
                  index: draggingIndex, 
                  key: dragging.id, 
                  isDragging: true}
              )
            )
        );
      }

      return null;
    },

    render: function () {
      var tree = this.state.tree;
      var dragging = this.state.dragging;
      var draggingDom = this.getDraggingDom();
      var that = this;
      var home = this.props.home;

      var rootIndex = tree.getIndex(0);

      var treeItems = rootIndex.children.map(function (data) {
        return React.createElement(TreeNode, {
            tree: tree, 
            home: home, 
            index: tree.getIndex(data), 
            getBaseUrl: that.props.getBaseUrl, 
            clickHome: that.props.clickHome, 

            getSelectedNode: that.props.getSelectedNode, 
            setSelectedNode: that.props.setSelectedNode, 

            getSearchedNode: that.props.getSearchedNode, 
            setSearchedNode: that.props.setSearchedNode, 

            key: data, 

            onDragStart: that.dragStart, 
            onCollapse: that.toggleCollapse, 
            dragging: dragging && dragging.id, 
            isDragging: false}
        );
      });
      return (
          React.createElement("div", {className: "menu-content", id: "uitree"}, 
            draggingDom, 
            treeItems
          )
      );
    },

    dragStart: function (id, dom, e) {
      var tree = this.state.tree;
      var node = tree.get(id);
      if (node.entity && node.entity == 'menu')
        return;
      this.setState({
        tempTree: new Tree(tree.obj)
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
        lastOrdering: tree.get(id).ordering
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
          dragging: this.dragging
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
        y: _startY + e.clientY - _offsetY
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

      }
      this.setState({
        tree: tree,
        dragging: dragging
      });
    },

    dragStop: function (e) {

      var Keys = {
        ENTER: 13,
        TAB: 9,
        BACKSPACE: 8,
        UP_ARROW: 38,
        DOWN_ARROW: 40,
        ESCAPE: 27
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
          targetParent: null
        }
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
                  position: dragging.lastOrdering
                }
            );
        }
      } else {
        this.props.moveNode(
            {
              id: dragging.id,
              parent: dragging.targetParent,
              position: dragging.lastOrdering
            }
        );
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
          targetParent: null
        }
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
        tree: tree
      });
    }
  });

  return UITree;
});
System.amdDefine('MenuSearchSuggestion', ['react'], function(React) {

  'use strict';

  var MIN_QUERY_LENGTH = 2;
  var MenuSearchSuggestion = React.createClass({
    displayName: "MenuSearchSuggestion",

    propTypes: {
      query: React.PropTypes.string.isRequired,
      handleClick: React.PropTypes.func.isRequired,
      handleHover: React.PropTypes.func.isRequired,
      searchingCnt: React.PropTypes.number,
      suggestions: React.PropTypes.array,
      selectedIndex: React.PropTypes.number
    },
    markIt: function (item, query) {

      var escapedRegex = query.trim().replace(/[-\\^$*+?.()|[\]{}]/g, "\\$&");
      var r = RegExp(escapedRegex, "gi");
      var itemName = item.node.title;
      if (!this.isMenuEntity(item.node)) {
        itemName = XE.Lang.trans(item.node.title);
      }
      return {
        __html: itemName.replace(r, "<em>$&</em>")
      };
    },

    isMenuEntity: function (node) {
      return (node.entity && (node.entity == 'menu'));
    },

    render: function () {

      var props = this.props;
      var suggestions = this.props.suggestions.map((function (item, i) {
        return (

            React.createElement("li", {
                key: i, 
                onClick: props.handleClick.bind(null, i), 
                onMouseOver: props.handleHover.bind(null, i), 
                className: cx({
                        on : i == props.selectedIndex
                    })
            }, 
              React.createElement("a", {href: "#", 
                 dangerouslySetInnerHTML: this.markIt(item, props.query)}
              )
            )
        );
      }).bind(this));

      if ((suggestions && suggestions.length === 0) || props.query.length < MIN_QUERY_LENGTH) {
        return (
            React.createElement("div", {className: "search-list"})
        );
      }

      return (
          React.createElement("div", {className: "search-list"}, 
            React.createElement("ul", null, 
              suggestions
            )
          )
      );
    }
  });

  return MenuSearchSuggestion;
});
System.amdDefine('MenuTree', ['react', 'MenuSearchBar', 'UITree'], function(React, MenuSearchBar, UITree) {

  'use strict';

  var MenuTree = React.createClass({displayName: "MenuTree",
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

    setSelectedNode: function (node) {
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

    moveMenuItem: function (target) {
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

    getBaseUrl: function () {
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
          React.createElement("div", {className: "col-sm-12"}, 
            React.createElement("div", {className: "panel"}, 
              React.createElement(MenuSearchBar, {tree: this.state.dataTree, handleSearch: this.setSearchedNode, menuRoutes: this.state.menuRoutes}), 
              React.createElement("div", {className: "panel-body"}, 
                React.createElement(UITree, {paddingLeft: 25, 
                        tree: this.state.dataTree, 
                        home: this.state.home, 
                        getBaseUrl: this.getBaseUrl, 
                        clickHome: this.onClickHome, 
                        getSearchedNode: this.getSearchedNode, 
                        setSearchedNode: this.setSearchedNode, 
                        getSelectedNode: this.getSelectedNode, 
                        setSelectedNode: this.setSelectedNode, 
                        moveNode: this.moveMenuItem})
              )
            )
          )
      );
    },

    isMenuEntity: function (node) {
      return (node.entity && (node.entity == 'menu'));
    }
  });

  return MenuTree;
});