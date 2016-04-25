!function(e){function r(e,r,o){return 4===arguments.length?t.apply(this,arguments):void n(e,{declarative:!0,deps:r,declare:o})}function t(e,r,t,o){n(e,{declarative:!1,deps:r,executingRequire:t,execute:o})}function n(e,r){r.name=e,e in p||(p[e]=r),r.normalizedDeps=r.deps}function o(e,r){if(r[e.groupIndex]=r[e.groupIndex]||[],-1==v.call(r[e.groupIndex],e)){r[e.groupIndex].push(e);for(var t=0,n=e.normalizedDeps.length;n>t;t++){var a=e.normalizedDeps[t],u=p[a];if(u&&!u.evaluated){var d=e.groupIndex+(u.declarative!=e.declarative);if(void 0===u.groupIndex||u.groupIndex<d){if(void 0!==u.groupIndex&&(r[u.groupIndex].splice(v.call(r[u.groupIndex],u),1),0==r[u.groupIndex].length))throw new TypeError("Mixed dependency cycle detected");u.groupIndex=d}o(u,r)}}}}function a(e){var r=p[e];r.groupIndex=0;var t=[];o(r,t);for(var n=!!r.declarative==t.length%2,a=t.length-1;a>=0;a--){for(var u=t[a],i=0;i<u.length;i++){var s=u[i];n?d(s):l(s)}n=!n}}function u(e){return x[e]||(x[e]={name:e,dependencies:[],exports:{},importers:[]})}function d(r){if(!r.module){var t=r.module=u(r.name),n=r.module.exports,o=r.declare.call(e,function(e,r){if(t.locked=!0,"object"==typeof e)for(var o in e)n[o]=e[o];else n[e]=r;for(var a=0,u=t.importers.length;u>a;a++){var d=t.importers[a];if(!d.locked)for(var i=0;i<d.dependencies.length;++i)d.dependencies[i]===t&&d.setters[i](n)}return t.locked=!1,r},r.name);t.setters=o.setters,t.execute=o.execute;for(var a=0,i=r.normalizedDeps.length;i>a;a++){var l,s=r.normalizedDeps[a],c=p[s],v=x[s];v?l=v.exports:c&&!c.declarative?l=c.esModule:c?(d(c),v=c.module,l=v.exports):l=f(s),v&&v.importers?(v.importers.push(t),t.dependencies.push(v)):t.dependencies.push(null),t.setters[a]&&t.setters[a](l)}}}function i(e){var r,t=p[e];if(t)t.declarative?c(e,[]):t.evaluated||l(t),r=t.module.exports;else if(r=f(e),!r)throw new Error("Unable to load dependency "+e+".");return(!t||t.declarative)&&r&&r.__useDefault?r["default"]:r}function l(r){if(!r.module){var t={},n=r.module={exports:t,id:r.name};if(!r.executingRequire)for(var o=0,a=r.normalizedDeps.length;a>o;o++){var u=r.normalizedDeps[o],d=p[u];d&&l(d)}r.evaluated=!0;var c=r.execute.call(e,function(e){for(var t=0,n=r.deps.length;n>t;t++)if(r.deps[t]==e)return i(r.normalizedDeps[t]);throw new TypeError("Module "+e+" not declared as a dependency.")},t,n);c&&(n.exports=c),t=n.exports,t&&t.__esModule?r.esModule=t:r.esModule=s(t)}}function s(r){if(r===e)return r;var t={};if("object"==typeof r||"function"==typeof r)if(g){var n;for(var o in r)(n=Object.getOwnPropertyDescriptor(r,o))&&h(t,o,n)}else{var a=r&&r.hasOwnProperty;for(var o in r)(!a||r.hasOwnProperty(o))&&(t[o]=r[o])}return t["default"]=r,h(t,"__useDefault",{value:!0}),t}function c(r,t){var n=p[r];if(n&&!n.evaluated&&n.declarative){t.push(r);for(var o=0,a=n.normalizedDeps.length;a>o;o++){var u=n.normalizedDeps[o];-1==v.call(t,u)&&(p[u]?c(u,t):f(u))}n.evaluated||(n.evaluated=!0,n.module.execute.call(e))}}function f(e){if(D[e])return D[e];if("@node/"==e.substr(0,6))return y(e.substr(6));var r=p[e];if(!r)throw"Module "+e+" not present.";return a(e),c(e,[]),p[e]=void 0,r.declarative&&h(r.module.exports,"__esModule",{value:!0}),D[e]=r.declarative?r.module.exports:r.esModule}var p={},v=Array.prototype.indexOf||function(e){for(var r=0,t=this.length;t>r;r++)if(this[r]===e)return r;return-1},g=!0;try{Object.getOwnPropertyDescriptor({a:0},"a")}catch(m){g=!1}var h;!function(){try{Object.defineProperty({},"a",{})&&(h=Object.defineProperty)}catch(e){h=function(e,r,t){try{e[r]=t.value||t.get.call(e)}catch(n){}}}}();var x={},y="undefined"!=typeof System&&System._nodeRequire||"undefined"!=typeof require&&require.resolve&&"undefined"!=typeof process&&require,D={"@empty":{}};return function(e,n,o){return function(a){a(function(a){for(var u={_nodeRequire:y,register:r,registerDynamic:t,get:f,set:function(e,r){D[e]=r},newModule:function(e){return e}},d=0;d<n.length;d++)(function(e,r){r&&r.__esModule?D[e]=r:D[e]=s(r)})(n[d],arguments[d]);o(u);var i=f(e[0]);if(e.length>1)for(var d=1;d<e.length;d++)f(e[d]);return i.__useDefault?i["default"]:i})}}}("undefined"!=typeof self?self:global)

(["1"], [], function($__System) {

$__System.registerDynamic("2", [], true, function($__require, exports, module) {
  ;
  var define,
      global = this,
      GLOBAL = this;
  var MIN_QUERY_LENGTH = 2;
  var MenuSearchSuggestion = React.createClass({
    displayName: "MenuSearchSuggestion",
    propTypes: {
      query: React.PropTypes.string.isRequired,
      handleClick: React.PropTypes.func.isRequired,
      handleHover: React.PropTypes.func.isRequired,
      searchingCnt: React.PropTypes.number
    },
    markIt(item, query) {
      var escapedRegex = query.trim().replace(/[-\\^$*+?.()|[\]{}]/g, "\\$&");
      var r = RegExp(escapedRegex, "gi");
      var itemName = item.node.title;
      if (!this.isMenuEntity(item.node)) {
        itemName = XE.Lang.trans(item.node.title);
      }
      return {__html: itemName.replace(r, "<em>$&</em>")};
    },
    isMenuEntity: function(node) {
      return (node.entity && (node.entity == 'menu'));
    },
    render() {
      var props = this.props;
      var suggestions = this.props.suggestions.map((function(item, i) {
        return (React.createElement("li", {
          key: i,
          onClick: props.handleClick.bind(null, i),
          onMouseOver: props.handleHover.bind(null, i),
          className: cx({on: i == props.selectedIndex})
        }, React.createElement("a", {
          href: "#",
          dangerouslySetInnerHTML: this.markIt(item, props.query)
        })));
      }).bind(this));
      if ((suggestions && suggestions.length === 0) || props.query.length < MIN_QUERY_LENGTH) {
        return (React.createElement("div", {className: "search-list"}));
      }
      return (React.createElement("div", {className: "search-list"}, React.createElement("ul", null, suggestions)));
    }
  });
  module.exports = MenuSearchSuggestion;
  return module.exports;
});

$__System.registerDynamic("3", ["2"], true, function($__require, exports, module) {
  ;
  var define,
      global = this,
      GLOBAL = this;
  var MenuSearchSuggestion = $__require('2');
  var MenuSearchBar = React.createClass({
    displayName: 'MenuSearchBar',
    propTypes: {
      tree: React.PropTypes.object,
      placeholder: React.PropTypes.string,
      handleSearch: React.PropTypes.func,
      menuRoutes: React.PropTypes.object
    },
    getDefaultProps: function() {
      return {
        placeholder: 'Search...',
        tree: new Tree({})
      };
    },
    componentDidMount: function() {},
    getInitialState: function() {
      return {
        query: '',
        suggestions: [],
        selectedIndex: -1,
        selectionMode: false,
        searchingCnt: 0
      };
    },
    handleChange: function(e) {
      var query = e.target.value.trim();
      this.setState({query: query});
      this.searchMenu(query);
      if (query.length == 0) {
        this.setState({
          suggestions: [],
          searchingCnt: 0
        });
      }
    },
    searchMenu(keyword) {
      var self = this;
      var searchingCnt = this.state.searchingCnt + 1;
      var suggestions;
      var tree = this.props.tree;
      this.setState({searchingCnt: searchingCnt});
      suggestions = _.filter(tree.indexes, function(index) {
        if (index.id == 0)
          return false;
        var title = index.node.title;
        if (!self.isMenuEntity(index.node)) {
          title = XE.Lang.trans(index.node.title);
        }
        return !!(title && title.indexOf(keyword) !== -1);
      });
      searchingCnt = this.state.searchingCnt;
      searchingCnt = searchingCnt - 1;
      self.setState({
        suggestions: suggestions,
        searchingCnt: searchingCnt
      });
    },
    isMenuEntity: function(node) {
      return (node.entity && (node.entity == 'menu'));
    },
    resetSearch: function() {
      var input = this.refs.input.getDOMNode();
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
      if (e.keyCode === Keys.UP_ARROW) {
        e.preventDefault();
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
      if (e.keyCode === Keys.DOWN_ARROW) {
        e.preventDefault();
        this.setState({
          selectedIndex: (this.state.selectedIndex + 1) % suggestions.length,
          selectionMode: true
        });
      }
    },
    selection(index) {
      var input = this.refs.input.getDOMNode();
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
          placeholder = this.props.placeholder;
      var trans = {addMenu: XE.Lang.trans('xe::addMenu')};
      return (React.createElement("div", {className: "panel-heading"}, React.createElement("div", {className: "pull-left"}, React.createElement("div", {className: cx({
          "input-group": true,
          "search-group": true,
          open: query.length > 0
        })}, React.createElement("input", {
        type: "text",
        className: "form-control",
        "aria-label": "Text input with dropdown button",
        placeholder: placeholder,
        ref: "input",
        onChange: this.handleChange,
        onKeyDown: this.handleKeyDown
      }), React.createElement("button", {
        className: "btn-link",
        onClick: this.resetSearch
      }, React.createElement("i", {className: "xi-magnifier"}), React.createElement("span", {className: "sr-only"}, "검색")), React.createElement(MenuSearchSuggestion, {
        query: query,
        suggestions: suggestions,
        selectedIndex: selectedIndex,
        handleClick: this.handleSuggestionClick,
        handleHover: this.handleSuggestionHover
      }))), React.createElement("div", {className: "pull-right"}, React.createElement("a", {
        href: this.props.menuRoutes.createMenu,
        className: "btn btn-primary pull-right"
      }, React.createElement("i", {className: "xi-plus"}), " ", trans.addMenu))));
    }
  });
  module.exports = MenuSearchBar;
  return module.exports;
});

$__System.registerDynamic("4", [], true, function($__require, exports, module) {
  ;
  var define,
      global = this,
      GLOBAL = this;
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
      if (this.props.onCollapse)
        this.props.onCollapse(nodeId);
    },
    render() {
      var index = this.props.index;
      var node = index.node;
      var nodeUrl = this.props.getBaseUrl() + '/menus/' + node.id;
      var addItemUrl = this.props.getBaseUrl() + '/menus/' + node.id + '/types';
      var trans = {addItem: XE.Lang.trans('xe::addItem')};
      var nodeId = 'xe_tree_node_' + node.id;
      return (React.createElement("div", {
        className: "panel-heading",
        id: nodeId
      }, React.createElement("div", {className: "pull-left"}, React.createElement("a", {href: nodeUrl}, React.createElement("h3", null, React.createElement("i", {className: "xi-folder"}), node.title))), React.createElement("div", {className: "pull-right"}, React.createElement("a", {
        href: addItemUrl,
        className: "btn btn-primary"
      }, React.createElement("i", {className: "xi-plus"}), React.createElement("span", null, trans.addItem)))));
    }
  });
  module.exports = MenuEntity;
  return module.exports;
});

$__System.registerDynamic("5", [], true, function($__require, exports, module) {
  ;
  var define,
      global = this,
      GLOBAL = this;
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
    onClickLink(node) {
      if (node.type !== "xpressengine@directLink") {
        location.href = '/' + node.url;
      } else {
        location.href = node.url;
      }
    },
    componentDidUpdate: function() {
      var searched = this.props.getSearchedNode();
      var node = this.props.index.node;
      if (searched === node) {
        $('html, body').animate({scrollTop: $('#xe_tree_node_' + node.id).offset().top - 20}, 500);
        this.props.setSearchedNode(null);
      }
    },
    onClickHome(node) {
      this.props.clickHome(node);
    },
    handleMouseDown(e) {
      var nodeId = this.props.index.id;
      var dom = this.refs.inner.getDOMNode();
      this.props.mouseDown(nodeId, dom, e);
    },
    onClickSetNode(node) {
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
      var trans = {
        title: XE.Lang.trans(title),
        setHome: XE.Lang.trans('xe::setHome'),
        goLink: XE.Lang.trans('xe::goLink')
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
        homeElement = React.createElement("button", {
          type: "button",
          className: "btn-link hidden-xs home-on"
        }, React.createElement("i", {className: "xi-home"}));
      } else {
        if (node.activated === 1) {
          homeElement = React.createElement("button", {
            type: "button",
            className: "btn btn-link hidden-xs",
            onClick: this.onClickHome.bind(null, node)
          }, React.createElement("i", {className: "xi-home"}));
        } else {
          homeElement = null;
        }
      }
      var controlElement;
      var selected = this.props.getSelectedNode();
      if (selected == node) {
        controlElement = React.createElement("div", {
          className: "visible-xs more-area",
          style: {display: "block"}
        }, React.createElement("button", {
          className: "btn",
          type: "button",
          onClick: this.onClickHome.bind(null, node)
        }, trans.setHome), React.createElement("a", {
          href: url,
          className: "btn"
        }, trans.goLink));
      }
      var nodeId = 'xe_tree_node_' + node.id;
      return (React.createElement("div", {
        className: "item-content",
        ref: "inner",
        id: nodeId
      }, React.createElement("button", {
        className: "btn handler",
        onMouseDown: this.handleMouseDown
      }, React.createElement("i", {className: "xi-bullet-point"})), React.createElement("div", {className: "item-info"}, React.createElement("i", {className: "xi-paper"}), React.createElement("dl", null, React.createElement("dt", {className: "sr-only"}, trans.title), React.createElement("dd", {className: "ellipsis"}, React.createElement("a", {href: nodeUrl}, trans.title)), React.createElement("dt", {className: "sr-only"}, url), React.createElement("dd", {className: "text-blue ellipsis"}, React.createElement("a", {href: url}, url), React.createElement("em", null, "[", type, "]")))), React.createElement("div", {className: "btn-group pull-right"}, React.createElement("button", {
        type: "button",
        className: "btn-more visible-xs",
        onClick: this.onClickSetNode.bind(null, node)
      }, React.createElement("i", {className: "xi-ellipsis-v"})), homeElement), controlElement));
    }
  });
  module.exports = MenuItem;
  return module.exports;
});

$__System.registerDynamic("6", ["4", "5"], true, function($__require, exports, module) {
  ;
  var define,
      global = this,
      GLOBAL = this;
  var MenuEntity = $__require('4');
  var MenuItem = $__require('5');
  var TreeNode = React.createClass({
    displayName: 'TreeNode',
    propTypes: {
      index: React.PropTypes.object,
      tree: React.PropTypes.object,
      home: React.PropTypes.string,
      dragging: React.PropTypes.object,
      onDragStart: React.PropTypes.func,
      onCollapse: React.PropTypes.func,
      getBaseUrl: React.PropTypes.func,
      clickHome: React.PropTypes.func,
      getSelectedNode: React.PropTypes.func,
      setSelectedNode: React.PropTypes.func,
      getSearchedNode: React.PropTypes.func,
      setSearchedNode: React.PropTypes.func
    },
    renderChildren() {
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
        var childNodes = children.map(function(child) {
          var childIndex = tree.getIndex(child);
          return (React.createElement(TreeNode, {
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
            getBaseUrl: getBaseUrl
          }));
        });
        return (React.createElement("div", {
          className: cx({
            'item-container': true,
            'move': isDragging
          }),
          style: childrenStyles
        }, childNodes));
      }
      return null;
    },
    render() {
      var props = this.props;
      var index = props.index;
      var home = props.home;
      var node = index.node;
      var isPlaceHolder = this.isPlaceHolder(props);
      if (this.isMenuEntity(node)) {
        return (React.createElement("div", {className: "menu-type"}, React.createElement(MenuEntity, {
          index: index,
          getBaseUrl: props.getBaseUrl,
          onCollapse: props.onCollapse
        }), this.renderChildren()));
      } else {
        return (React.createElement("div", {className: cx({
            'node': true,
            'item': true,
            'copy': isPlaceHolder,
            'off': (node.activated !== 1)
          })}, React.createElement(MenuItem, {
          index: index,
          home: home,
          getBaseUrl: props.getBaseUrl,
          clickHome: props.clickHome,
          mouseDown: this.handleMouseDown,
          getSelectedNode: props.getSelectedNode,
          setSelectedNode: props.setSelectedNode,
          getSearchedNode: props.getSearchedNode,
          setSearchedNode: props.setSearchedNode
        }), this.renderChildren()));
      }
    },
    handleMouseDown(nodeId, dom, e) {
      if (this.props.onDragStart) {
        this.props.onDragStart(nodeId, dom, e);
      }
    },
    isMenuEntity(node) {
      return (node.entity && (node.entity == 'menu'));
    },
    isPlaceHolder(props) {
      var index = props.index;
      var dragging = props.dragging;
      return ((index.id === dragging) || props.isPlaceHolder);
    }
  });
  module.exports = TreeNode;
  return module.exports;
});

$__System.registerDynamic("7", ["6"], true, function($__require, exports, module) {
  ;
  var define,
      global = this,
      GLOBAL = this;
  var TreeNode = $__require('6');
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
    getDefaultProps() {
      return {paddingLeft: 48};
    },
    getInitialState() {
      return this.init(this.props);
    },
    componentWillReceiveProps(nextProps) {
      if (!this._update) {
        this.setState(this.init(nextProps));
      } else {
        this._update = false;
      }
    },
    init(props) {
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
    getDraggingDom() {
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
        return (React.createElement("div", {
          className: "m-draggable move",
          style: draggingStyles
        }, React.createElement(TreeNode, {
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
          isDragging: true
        })));
      }
      return null;
    },
    render() {
      var tree = this.state.tree;
      var dragging = this.state.dragging;
      var draggingDom = this.getDraggingDom();
      var that = this;
      var home = this.props.home;
      var rootIndex = tree.getIndex(0);
      var treeItems = rootIndex.children.map(function(data) {
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
          isDragging: false
        });
      });
      return (React.createElement("div", {
        className: "menu-content",
        id: "uitree"
      }, draggingDom, treeItems));
    },
    dragStart(id, dom, e) {
      var tree = this.state.tree;
      var node = tree.get(id);
      if (node.entity && node.entity == 'menu')
        return;
      this.setState({tempTree: new Tree(tree.obj)});
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
    drag(e) {
      if (this._start) {
        this.setState({dragging: this.dragging});
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
      if (index.depth == 2 && (diffX < 0))
        diffX = 0;
      if (diffX < 0) {
        if (index.parent && !index.next) {
          newIndex = tree.move(index.id, index.parent, 'after');
        }
      } else if (diffX > paddingLeft) {
        if (index.prev && !tree.getIndex(index.prev).collapsed) {
          newIndex = tree.move(index.id, index.prev, 'append');
        }
      }
      if (newIndex) {
        index = newIndex;
        newIndex.collapsed = collapsed;
        dragging.id = newIndex.id;
      }
      if (diffY < 0) {
        var above = tree.getNodeByTop(index.top - 1);
        newIndex = tree.move(index.id, above.id, 'before');
      } else if (diffY > dragging.h) {
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
    dragStop(e) {
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
    dragEnd() {
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
            this.props.moveNode({
              id: dragging.id,
              parent: dragging.targetParent,
              position: dragging.lastOrdering
            });
        }
      } else {
        this.props.moveNode({
          id: dragging.id,
          parent: dragging.targetParent,
          position: dragging.lastOrdering
        });
      }
      document.body.removeEventListener('mousemove', this.drag);
      document.body.removeEventListener('mouseup', this.dragEnd);
      document.body.removeEventListener('keydown', this.dragStop);
    },
    rollbackTree() {
      var rollbackTree = this.state.tempTree;
      if (!rollbackTree)
        return;
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
    toggleCollapse: function(nodeId) {
      var tree = this.state.tree;
      var index = tree.getIndex(nodeId);
      var node = tree.get(nodeId);
      index.collapsed = !index.collapsed;
      node.collapsed = !node.collapsed;
      tree.updateNodesPosition();
      this.setState({tree: tree});
    }
  });
  module.exports = UITree;
  return module.exports;
});

$__System.registerDynamic("1", ["3", "7"], true, function($__require, exports, module) {
  ;
  var define,
      global = this,
      GLOBAL = this;
  var MenuSearchBar = $__require('3');
  var UITree = $__require('7');
  var MenuTree = React.createClass({
    displayName: "MenuTree",
    getInitialState: function() {
      return {
        rawTree: this.props.menus,
        dataTree: new Tree({
          title: "root",
          items: this.props.menus
        }),
        selected: null,
        searched: null,
        home: this.props.home,
        menuRoutes: this.props.menuRoutes
      };
    },
    componentDidMount: function() {
      this.state.dataTree.movementFilter = this.movementFilter;
    },
    getSearchedNode: function() {
      return this.state.searched;
    },
    setSearchedNode: function(node) {
      this.setState({searched: node});
    },
    getSelectedNode: function() {
      return this.state.selected;
    },
    setSelectedNode(node) {
      this.setState({selected: node});
    },
    movementFilter: function(param) {
      var tree = param.tree;
      var destNode = tree.get(param.toId);
      var destIndex = tree.getIndex(param.toId);
      var srcNode = tree.get(param.fromId);
      if (this.isMenuEntity(srcNode))
        return;
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
        success: function(data) {
          XE.toast('success', 'Item moved');
        }.bind(this)
      });
    },
    getBaseUrl() {
      return this.props.baseUrl;
    },
    onClickHome: function(node) {
      var homeItemUrl = this.props.baseUrl + '/setHome';
      var oldHome = this.state.home;
      this.setState({home: node.id});
      XE.ajax({
        url: homeItemUrl,
        context: $('#uitree'),
        type: 'put',
        dataType: 'json',
        data: {itemId: node.id},
        success: function(data) {
          XE.toast('success', node.title + ' is home!');
        }.bind(this),
        error: function(data) {
          XE.toast('error', 'home setting was failed!');
          this.setState({home: oldHome});
        }.bind(this)
      });
    },
    render: function() {
      return (React.createElement("div", {className: "col-sm-12"}, React.createElement("div", {className: "panel"}, React.createElement(MenuSearchBar, {
        tree: this.state.dataTree,
        handleSearch: this.setSearchedNode,
        menuRoutes: this.state.menuRoutes
      }), React.createElement("div", {className: "panel-body"}, React.createElement(UITree, {
        paddingLeft: 25,
        tree: this.state.dataTree,
        home: this.state.home,
        getBaseUrl: this.getBaseUrl,
        clickHome: this.onClickHome,
        getSearchedNode: this.getSearchedNode,
        setSearchedNode: this.setSearchedNode,
        getSelectedNode: this.getSelectedNode,
        setSelectedNode: this.setSelectedNode,
        moveNode: this.moveMenuItem
      })))));
    },
    isMenuEntity(node) {
      return (node.entity && (node.entity == 'menu'));
    }
  });
  window["MenuTree"] = MenuTree;
  module.exports = MenuTree;
  return module.exports;
});

})
(function(factory) {
  factory();
});