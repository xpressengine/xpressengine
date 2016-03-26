(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
    'use strict';

var MenuEntity = React.createClass({
    displayName: 'MenuEntity',

    propTypes: {
        index: React.PropTypes.object,
        onCollapse: React.PropTypes.func,
        getBaseUrl: React.PropTypes.func
    },

    handleCollapse: function handleCollapse(e) {
        e.stopPropagation();
        var nodeId = this.props.index.id;
        if (this.props.onCollapse) this.props.onCollapse(nodeId);
    },

    render: function render() {
        var index = this.props.index;
        var node = index.node;
        var nodeUrl = this.props.getBaseUrl() + '/menus/' + node.id;
        var addItemUrl = this.props.getBaseUrl() + '/menus/' + node.id + '/types';

        var nodeId = 'xe_tree_node_' + node.id;
        return React.createElement(
            'div',
            {className: 'row', id: nodeId},
            React.createElement(
                'div',
                {className: 'col-sm-6'},
                React.createElement(
                    'button',
                    {className: 'btn_clse ico_gray pull-left', onClick: this.handleCollapse},
                    React.createElement('i', {
                        className: cx({
                            "xi-angle-down": !index.collapsed,
                            "xi-angle-right": index.collapsed
                        })
                    })
                ),
                React.createElement(
                    'a',
                    {href: nodeUrl},
                    React.createElement(
                        'h3',
                        null,
                        React.createElement('i', {className: 'xi-folder'}),
                        node.title
                    )
                )
            ),
            React.createElement(
                'div',
                {className: 'col-sm-6'},
                React.createElement(
                    'div',
                    {className: 'btn_group txt_group pull-right'},
                    React.createElement(
                        'a',
                        {className: 'btn btn_blue', href: addItemUrl},
                        React.createElement('i', {className: 'xi-plus'}),
                        XE.Lang.trans('xe::addItem')
                    )
                )
            )
        );
    }
});

module.exports = MenuEntity;

}, {}], 2: [function (require, module, exports) {
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

    onClickLink: function onClickLink(node) {
        if (node.type !== "xpressengine@directLink") {
            location.href = '/' + node.url;
        } else {
            location.href = node.url;
        }
    },

    componentDidUpdate: function componentDidUpdate() {
        var searched = this.props.getSearchedNode();
        var node = this.props.index.node;
        if (searched === node) {
            $('html, body').animate({
                scrollTop: $('#xe_tree_node_' + node.id).offset().top - 20
            }, 500);
            this.props.setSearchedNode(null);
        }
    },

    onClickHome: function onClickHome(node) {
        this.props.clickHome(node);
    },

    handleMouseDown: function handleMouseDown(e) {
        var nodeId = this.props.index.id;
        var dom = this.refs.inner.getDOMNode();
        this.props.mouseDown(nodeId, dom, e);
    },

    onClickSetNode: function onClickSetNode(node) {

        var selected = this.props.getSelectedNode();

        if (selected === node) {
            this.props.setSelectedNode(null);
        } else {
            this.props.setSelectedNode(node);
        }
    },

    render: function render() {
        var node = this.props.index.node;

        var title = node.title || '';
        var type = node.type;
        var url = '';

        title = XE.Lang.trans(title);

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
            homeElement = React.createElement(
                'button',
                {type: 'button', className: 'btn_txt hidden-xs home_on'},
                React.createElement('i', {className: 'xi-home'})
            );
        } else {
            if (node.activated === 1) {
                homeElement = React.createElement(
                    'button',
                    {type: 'button', className: 'btn_txt hidden-xs', onClick: this.onClickHome.bind(null, node)},
                    React.createElement('i', {className: 'xi-home'})
                );
            } else {
                homeElement = null;
            }
        }

        var controlElement;
        var selected = this.props.getSelectedNode();
        if (selected == node) {
            controlElement = React.createElement(
                'div',
                {className: 'visible-xs more_area', style: {display: "block"}},
                React.createElement(
                    'button',
                    {
                        className: 'btn', type: 'button',
                        onClick: this.onClickHome.bind(null, node)
                    },
                    XE.Lang.trans('xe::setHome')
                ),
                React.createElement(
                    'a',
                    {href: url, className: 'btn'},
                    XE.Lang.trans('xe::goLink')
                )
            );
        }

        var nodeId = 'xe_tree_node_' + node.id;
        return React.createElement(
            'div',
            {className: 'item_con', ref: 'inner', id: nodeId},
            React.createElement(
                'button',
                {className: 'btn handler', onMouseDown: this.handleMouseDown},
                React.createElement('i', {className: 'xi-bullet-point'})
            ),
            React.createElement(
                'div',
                { className: 'item_cont' },
                React.createElement('i', { className: 'xi-paper' }),
                React.createElement(
                    'dl',
                    null,
                    React.createElement(
                        'dt',
                        { className: 'blind' },
                        title
                    ),
                    React.createElement(
                        'dd',
                        {className: 'one_line'},
                        React.createElement(
                            'a',
                            {href: nodeUrl},
                            title
                        )
                    ),
                    React.createElement(
                        'dt',
                        {className: 'blind'},
                        url
                    ),
                    React.createElement(
                        'dd',
                        { className: 'txt_blue one_line' },
                        React.createElement(
                            'a',
                            {href: url},
                            url
                        ),
                        React.createElement(
                            'em',
                            null,
                            '[',
                            type,
                            ']'
                        )
                    )
                )
            ),
            React.createElement(
                'div',
                { className: 'btn_group pull-right' },
                React.createElement(
                    'button',
                    {
                        type: 'button', className: 'btn_more visible-xs',
                        onClick: this.onClickSetNode.bind(null, node)
                    },
                    React.createElement('i', { className: 'xi-ellipsis-v' })
                ),
                homeElement
            ),
            controlElement
        );
    }
});

module.exports = MenuItem;

}, {}], 3: [function (require, module, exports) {
'use strict';

var MenuSearchSuggestion = require('./MenuSearchSuggestion.jsx');

var MenuSearchBar = React.createClass({
    displayName: 'MenuSearchBar',

    propTypes: {
        tree: React.PropTypes.object,
        placeholder: React.PropTypes.string,
        handleSearch: React.PropTypes.func
    },
    getDefaultProps: function getDefaultProps() {
        return {
            placeholder: 'Search...',
            tree: new Tree({})
        };
    },
    componentDidMount: function componentDidMount() {},
    getInitialState: function getInitialState() {
        return {
            query: '',
            suggestions: [],
            selectedIndex: -1,
            selectionMode: false,
            searchingCnt: 0
        };
    },
    handleChange: function handleChange(e) {
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

    searchMenu: function searchMenu(keyword) {

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
        self.setState({
            suggestions: suggestions,
            searchingCnt: searchingCnt
        });
    },

    isMenuEntity: function isMenuEntity(node) {
        return node.entity && node.entity == 'menu';
    },

    resetSearch: function resetSearch() {

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

    selection: function selection(index) {
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

        return React.createElement(
            'div',
            {
                className: cx({
                    "form-group": true,
                    open: query.length > 0
                })
            },
            React.createElement(
                'label',
                { 'for': 'inpt_srch' },
                React.createElement(
                    'span',
                    {className: 'blind'},
                    '검색'
                )
            ),
            React.createElement('input', { id: 'inpt_srch', type: 'text', className: 'inpt_txt', placeholder: placeholder, ref: 'input',
                onChange: this.handleChange, onKeyDown: this.handleKeyDown }),
            React.createElement(
                'button',
                {type: 'button', className: 'pull-right', onClick: this.resetSearch},
                React.createElement('i', {className: 'xi-magnifier'}),
                React.createElement('i', {className: 'xi-close'})
            ),
            React.createElement(MenuSearchSuggestion, { query: query,
                suggestions: suggestions,
                selectedIndex: selectedIndex,
                handleClick: this.handleSuggestionClick,
                handleHover: this.handleSuggestionHover })
        );
    }
});

module.exports = MenuSearchBar;

}, {"./MenuSearchSuggestion.jsx": 4}], 4: [function (require, module, exports) {
"use strict";

var MIN_QUERY_LENGTH = 2;
var MenuSearchSuggestion = React.createClass({
    displayName: "MenuSearchSuggestion",

    propTypes: {
        query: React.PropTypes.string.isRequired,
        handleClick: React.PropTypes.func.isRequired,
        handleHover: React.PropTypes.func.isRequired,
        searchingCnt: React.PropTypes.number
    },
    markIt: function markIt(item, query) {

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

    isMenuEntity: function isMenuEntity(node) {
        return node.entity && node.entity == 'menu';
    },

    render: function render() {

        var props = this.props;
        var suggestions = this.props.suggestions.map((function (item, i) {
            return React.createElement(
                "li",
                {
                    key: i,
                    onClick: props.handleClick.bind(null, i),
                    onMouseOver: props.handleHover.bind(null, i),
                    className: cx({
                        on: i == props.selectedIndex
                    })
                },
                React.createElement("a", { href: "#",
                    dangerouslySetInnerHTML: this.markIt(item, props.query)
                })
            );
        }).bind(this));

        if (suggestions && suggestions.length === 0 || props.query.length < MIN_QUERY_LENGTH) {
            return React.createElement("div", { className: "srch_lst" });
        }

        return React.createElement(
            "div",
            { className: "srch_lst" },
            React.createElement(
                "ul",
                null,
                suggestions
            )
        );
    }
});

module.exports = MenuSearchSuggestion;

}, {}], 5: [function (require, module, exports) {
'use strict';

var MenuSearchBar = require('./MenuSearchBar.jsx');
var UITree = require('./UITree.jsx');

var MenuTree = React.createClass({
    displayName: 'MenuTree',

    getInitialState: function getInitialState() {
        return {
            rawTree: this.props.menus,
            dataTree: new Tree({title: "root", items: this.props.menus}),
            selected: null,
            searched: null,
            home: this.props.home
        };
    },
    componentDidMount: function componentDidMount() {
        this.state.dataTree.movementFilter = this.movementFilter;
    },

    getSearchedNode: function getSearchedNode() {
        return this.state.searched;
    },

    setSearchedNode: function setSearchedNode(node) {
        this.setState({
            searched: node
        });
    },

    getSelectedNode: function getSelectedNode() {
        return this.state.selected;
    },

    setSelectedNode: function setSelectedNode(node) {
        this.setState({
            selected: node
        });
    },

    movementFilter: function movementFilter(param) {
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

            if (param.placement == 'append' || param.placement == 'prepend') {
                if (destIndex.depth > MaxDepth) {
                    return;
                }
            }
            return param;
        }
    },

    moveMenuItem: function moveMenuItem(target) {
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
            success: (function (data) {
                XE.toast('success', 'Item moved');
            }).bind(this)
        });
    },

    getBaseUrl: function getBaseUrl() {
        return this.props.baseUrl;
    },

    onClickHome: function onClickHome(node) {
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
            success: (function (data) {
                XE.toast('success', node.title + ' is home!');
            }).bind(this),
            error: (function (data) {
                XE.toast('error', 'home setting was failed!');
                this.setState({home: oldHome});
            }).bind(this)
        });
    },

    render: function render() {
        return React.createElement(
            'div',
            { className: 'col-sm-12' },
            React.createElement(MenuSearchBar, {tree: this.state.dataTree, handleSearch: this.setSearchedNode}),
            React.createElement(
                'div',
                {className: 'panel'},
                React.createElement(
                    'div',
                    {className: 'panel-body'},
                    React.createElement(UITree, { paddingLeft: 25,
                        tree: this.state.dataTree,
                        home: this.state.home,
                        getBaseUrl: this.getBaseUrl,
                        clickHome: this.onClickHome,
                        getSearchedNode: this.getSearchedNode,
                        setSearchedNode: this.setSearchedNode,
                        getSelectedNode: this.getSelectedNode,
                        setSelectedNode: this.setSelectedNode,
                        moveNode: this.moveMenuItem })
                )
            )
        );
    },

    isMenuEntity: function isMenuEntity(node) {
        return node.entity && node.entity == 'menu';
    }
});

window["MenuTree"] = MenuTree;
module.exports = MenuTree;

}, {"./MenuSearchBar.jsx": 3, "./UITree.jsx": 7}], 6: [function (require, module, exports) {
//var cx = require('classnames');
'use strict';

var MenuEntity = require('./MenuEntity.jsx');
var MenuItem = require('./MenuItem.jsx');

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

    renderChildren: function renderChildren() {
        var props = this.props;
        var index = props.index;
        var tree = props.tree;
        var dragging = props.dragging;
        var home = props.home;
        var getBaseUrl = props.getBaseUrl;
        var onDragStart = props.onDragStart;
        var isDragging = props.isDragging;
        var isPlaceHolder = index.id === dragging || this.props.isPlaceHolder;
        if (index.children && index.children.length) {
            var childrenStyles = {};
            var children = index.children;
            if (index.collapsed) {
                var searched = props.getSearchedNode();
                if (searched === null || index.id != searched.menuId) {
                    childrenStyles.display = 'none';
                } else {
                    index.collapsed = !index.collapsed;
                }
            }

            var childNodes = children.map(function (child) {
                var childIndex = tree.getIndex(child);
                return React.createElement(TreeNode, {
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
                });
            });
            return React.createElement(
                'div',
                { className: cx({
                        'item_container': true,
                        'move': isDragging
                    }), style: childrenStyles },
                childNodes
            );
        }

        return null;
    },

    render: function render() {
        var props = this.props;
        var index = props.index;
        var home = props.home;
        var node = index.node;

        var isPlaceHolder = this.isPlaceHolder(props);

        if (this.isMenuEntity(node)) {
            return React.createElement(
                'div',
                { className: 'menu_tit node' },
                React.createElement(MenuEntity, {
                    index: index,
                    getBaseUrl: props.getBaseUrl,
                    onCollapse: props.onCollapse
                }),
                this.renderChildren()
            );
        } else {
            return React.createElement(
                'div',
                { className: cx({
                        'node': true,
                        'item': true,
                        'copy': isPlaceHolder,
                        'off': node.activated !== 1
                    }) },
                React.createElement(MenuItem, {
                    index: index,
                    home: home,
                    getBaseUrl: props.getBaseUrl,
                    clickHome: props.clickHome,
                    mouseDown: this.handleMouseDown,

                    getSelectedNode: props.getSelectedNode,
                    setSelectedNode: props.setSelectedNode,

                    getSearchedNode: props.getSearchedNode,
                    setSearchedNode: props.setSearchedNode
                }),
                this.renderChildren()
            );
        }
    },

    handleMouseDown: function handleMouseDown(nodeId, dom, e) {
        if (this.props.onDragStart) {
            this.props.onDragStart(nodeId, dom, e);
        }
    },

    isMenuEntity: function isMenuEntity(node) {
        return node.entity && node.entity == 'menu';
    },

    isPlaceHolder: function isPlaceHolder(props) {
        var index = props.index;
        var dragging = props.dragging;
        return index.id === dragging || props.isPlaceHolder;
    }
});

module.exports = TreeNode;

}, {"./MenuEntity.jsx": 1, "./MenuItem.jsx": 2}], 7: [function (require, module, exports) {
'use strict';

var TreeNode = require('./TreeNode.jsx');

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

    getDefaultProps: function getDefaultProps() {
        return {
            paddingLeft: 48
        };
    },

    getInitialState: function getInitialState() {
        return this.init(this.props);
    },

    componentWillReceiveProps: function componentWillReceiveProps(nextProps) {
        if (!this._update) {
            this.setState(this.init(nextProps));
        } else {
            this._update = false;
        }
    },

    init: function init(props) {
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

    getDraggingDom: function getDraggingDom() {
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

            return React.createElement(
                'div',
                { className: 'm-draggable move', style: draggingStyles },
                React.createElement(TreeNode, {
                    getBaseUrl: this.props.getBaseUrl,
                    clickHome: this.props.clickHome,
                    getSelectedNode: this.props.getSelectedNode,
                    getSearchedNode: this.props.getSearchedNode,
                    getSelectedNode: this.props.getSelectedNode,
                    setSelectedNode: this.props.setSelectedNode,
                    tree: tree,
                    home: home,
                    index: draggingIndex,
                    key: dragging.id,
                    isDragging: true
                })
            );
        }

        return null;
    },

    render: function render() {
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
                isDragging: false
            });
        });
        return React.createElement(
            'div',
            { className: 'menu_cont', id: 'uitree' },
            draggingDom,
            treeItems
        );
    },

    dragStart: function dragStart(id, dom, e) {
        var tree = this.state.tree;
        console.log('drag start');
        console.log(tree);
        var node = tree.get(id);
        if (node.entity && node.entity == 'menu') return;
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

    drag: function drag(e) {
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

        if (index.depth == 2 && diffX < 0) diffX = 0;
        if (diffX < 0) {
            // left
            if (index.parent && !index.next) {
                newIndex = tree.move(index.id, index.parent, 'after');
            }
        } else if (diffX > paddingLeft) {
            // right
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
            // up
            var above = tree.getNodeByTop(index.top - 1);
            newIndex = tree.move(index.id, above.id, 'before');
        } else if (diffY > dragging.h) {
            // down
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

    dragStop: function dragStop(e) {

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

    dragEnd: function dragEnd() {
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
                if (targetNode.entity != 'menu') this.props.moveNode({
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

    rollbackTree: function rollbackTree() {

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

    toggleCollapse: function toggleCollapse(nodeId) {
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

module.exports = UITree;

}, {"./TreeNode.jsx": 6}]
}, {}, [5]);
