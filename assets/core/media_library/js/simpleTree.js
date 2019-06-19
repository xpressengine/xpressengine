/* ============================================================================
    MIT LICENSE

    Copyright (c) 2019 eScience-Center, University of Tübingen

    Permission is hereby granted, free of charge, to any person obtaining a 
    copy of this software and associated documentation files (the "Software"), 
    to deal in the Software without restriction, including without limitation 
    the rights to use, copy, modify, merge, publish, distribute, sublicense, 
    and/or sell copies of the Software, and to permit persons to whom the 
    Software is furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in 
    all copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR 
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER 
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING 
    FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER 
    DEALINGS IN THE SOFTWARE.
============================================================================ */
;(function($){
$.fn.simpleTree = function(options, data) {
// ============================================================================
    if(this.length > 1) {
        this.each(function() { 
            $(this).simpleTree(options, data); 
        });
        return this;
    }

    // ========================================================================
    //
    // PUBLIC METHODS
    //
    // ========================================================================

    // ------------------------------------------------------------------------
    // set the selected node
    this.getSelectedNode = function(
    ) {
    // ------------------------------------------------------------------------
        return _selectedNode;
    }

    // ------------------------------------------------------------------------
    // sets the selected node
    this.setSelectedNode = function(
        node,
        fireEvent = true
    ) {
    // ------------------------------------------------------------------------
        if(node === _selectedNode)
            return;
        this.clearSelection(false);
        this.expandTo(node);
        node.domLabel.addClass(_options.css.selected);
        _selectedNode = node;
        if(fireEvent)
            this.trigger('simpleTree:change', [ _selectedNode ]);
        return this;
    }

    // ------------------------------------------------------------------------
    // clears the selected node, if any
    this.clearSelection = function(
        fireEvent = true
    ) {
    // ------------------------------------------------------------------------
        if(!_selectedNode)
            return this;
        _selectedNode.domLabel.removeClass(_options.css.selected);
        _selectedNode = undefined;
        if(fireEvent)
            this.trigger('simpleTree:change', [ _selectedNode ]);
        return this;
    }

    // ------------------------------------------------------------------------
    // get total node count
    this.getNodeCount = function(
    ) {
    // ------------------------------------------------------------------------
        return _nodeCount;
    }

    // ------------------------------------------------------------------------
    // expand all nodes
    this.expandAll = function(
    ) {
    // ------------------------------------------------------------------------
        return this.traverseTree((node) => {
            if(node.children.length > 0 && !node.expanded)
                this.toggleSubtree(node);
        });
    }

    // ------------------------------------------------------------------------
    // collapse all nodes
    this.collapseAll = function(
    ) {
    // ------------------------------------------------------------------------
        return this.traverseTree((node) => {
            if(node.children.length > 0 && node.expanded)
                this.toggleSubtree(node);
        });
    }

    // ------------------------------------------------------------------------
    // traverse all tree nodes
    this.traverseTree = function(
        callback,
        startNode = undefined
    ) {
    // ------------------------------------------------------------------------
        if(startNode === undefined)
            startNode = { children: _treeData };
        startNode.children.forEach(childNode => {
            callback(childNode);
            if(childNode.children.length > 0)
                this.traverseTree(callback, childNode);
        });
        return this;
    }

    // ------------------------------------------------------------------------
    // expands/collapses node with children
    this.toggleSubtree = function(
        node
    ) {
    // ------------------------------------------------------------------------
        if(node.children.length === 0) {
            console.warn('Invoked toggleSubtree on node with no children');
            return this;
        }
        if(node.expanded)
            node.domChildren.hide();
        else {
            // expand ancestor nodes if needed
            if(node.parent && !node.parent.expanded) 
                this.toggleSubtree(node.parent);
            if(node.domChildren.children().length > 0)
                node.domChildren.show();
            else
                node.children.forEach(child => _renderNode(child));
        }
        node.expanded = !node.expanded;
        node.domContainer
            .find('.' + _options.css.toggle)
            .first()
            .text(_options.symbols[node.expanded ? 'expanded' : 'collapsed']);
        return this;
    }

    // ------------------------------------------------------------------------
    // retrieves node object from node value
    this.getNodeFromValue = function(
        value
    ) {
    // ------------------------------------------------------------------------
        return _nodeValueMap[value];
    }

    // ------------------------------------------------------------------------
    // ensures node is visible; only works if node is shown - see expandTo()
    this.scrollTo = function(
        node
    ) {
    // ------------------------------------------------------------------------
        let nt = node.domContainer.offset().top,
            nh = node.domContainer.height(),
            dt = this.offset().top,
            dh = this.height();
        
        if(nt < dt || nt + nh > dt + dh) {
            this.animate({
                scrollTop: nt - dt - dh / 2 // scroll to middle of the tree
            });
        }
    }

    // ------------------------------------------------------------------------
    // expand the ancestry of the given node
    this.expandTo = function(
        node
    ) {
    // ------------------------------------------------------------------------
        if(node.parent && !node.parent.expanded)
            this.toggleSubtree(node.parent);
        return this;
    }

    // ------------------------------------------------------------------------
    // node is visible if the whole ancestry is visible and expanded and the 
    // node itself is not hidden
    this.isNodeVisible = function(
        node
    ) {
    // ------------------------------------------------------------------------
        // the DOM container must exist
        if(!node.domContainer)
            return false;

        // the container must not be hidden
        if(node.domContainer.hasClass('hidden'))
            return false;
        
        // if there's no parent, we're fine
        if(!node.parent)
            return true;

        if(!node.parent.expanded)
            return false;

        return this.isNodeVisible(node.parent);
    }

    // ------------------------------------------------------------------------
    // shows the node in the DOM
    this.showNode = function(
        node
    ) {
    // ------------------------------------------------------------------------
        if(node.domContainer)
            node.domContainer.removeClass('hidden');
        if(node.domChildren)
            node.domChildren.removeClass('hidden');
        return this;
    }

    // ------------------------------------------------------------------------
    // hides the node in the DOM
    this.hideNode = function(
        node
    ) {
    // ------------------------------------------------------------------------
        if(node.domContainer)
            node.domContainer.addClass('hidden');
        if(node.domChildren)
            node.domChildren.addClass('hidden');
        return this;
    }

    // ------------------------------------------------------------------------
    // toggles node visibility in the DOM
    this.toggleNodeVisibility = function(
        node
    ) {
    // ------------------------------------------------------------------------
        return this.isNodeVisible(node) 
            ? this.hideNode(node) 
            : this.showNode(node);
    }

    // ========================================================================
    //
    // PRIVATE VARIABLES
    //
    // ========================================================================

    var _self = this;
    var _selectedNode;
    var _lastSearchTerm;
    var _nodeValueMap;
    var _options;
    var _treeData;
    var _nodeCount;

    // Default options, can be overriden when initializing the jQuery object
    var _defaults = {
        // Optionally provide here the jQuery element that you use as the 
        // search box for filtering the tree. simplTree then takes control
        // over the provided box, handling user input
        searchBox: undefined,

        // Search starts after at least 3 characters are entered in the
        // search box
        searchMinInputLength: 3,

        // Number of pixels to indent each additional nesting level
        indentSize: 25,

        // Show child count badges?
        childCountShow: true,

        // Symbols for expanded and collapsed nodes that have child nodes
        symbols: {
            collapsed: '▶',
            expanded: '▼'
        },

        // these are the CSS class names used on various occasions. 
        // If you change these names, you also need to provide
        // the corresponding CSS class. See simpleTree.css
        css: {
            childrenContainer: 'simpleTree-childrenContainer',
            childCountBadge: 'simpleTree-childCountBadge badge badge-pill badge-secondary',
            highlight: 'simpleTree-highlight',
            indent: 'simpleTree-indent',
            label: 'simpleTree-label',
            mainContainer: 'simpleTree-mainContainer',
            nodeContainer: 'simpleTree-nodeContainer',
            selected: 'simpleTree-selected',
            toggle: 'simpleTree-toggle'
        }
    };

    // ========================================================================
    //
    // PRIVATE FUNCTIONS
    //
    // ========================================================================

    // ------------------------------------------------------------------------
    var _nodeClicked = function(
        node
    ) {
    // ------------------------------------------------------------------------
        if(node === _selectedNode)
            _self.clearSelection(true);
        else
            _self.setSelectedNode(node);
    }

    // ------------------------------------------------------------------------
    var _htmlEncode = function(
        text
    ) {
    // ------------------------------------------------------------------------
        return $('<textarea/>').text(text).html();
    }

    // ------------------------------------------------------------------------
    var _renderNodeLabelText = function(
        node
    ) {
    // ------------------------------------------------------------------------
        if(!node.domLabel)
            return;
        if(!_lastSearchTerm)
            node.domLabel.text(node.label);
        else {
            let remaining = node.label;
            let label = '';
            while(remaining !== '') {
                let pos = remaining.toUpperCase().indexOf(_lastSearchTerm);
                if(pos === -1) {
                    label += _htmlEncode(remaining);
                    break;
                }
                else {
                    label += (
                        _htmlEncode(remaining.substr(0, pos)) 
                        + "<span class='" + _options.css.highlight + "'>" 
                        + _htmlEncode(remaining.substr(pos, _lastSearchTerm.length)) 
                        + "</span>"
                    );
                    remaining = remaining.substr(pos + _lastSearchTerm.length);
                }
            }
            node.domLabel.html(label);
        }
    }
        
    // ------------------------------------------------------------------------
    var _renderNode = function(
        node
    ) {
    // ------------------------------------------------------------------------
        let div = $('<div/>').addClass(_options.css.nodeContainer);
        div.append($('<div/>').addClass(_options.css.indent).css({ 
            width: (node.children.length > 0 ? node.indent : (node.indent + 1)) * _options.indentSize 
        }));
        if(node.children.length > 0) {
            node.domToggle = $('<div/>')
                .css({ width: _options.indentSize })
                .addClass(_options.css.toggle)
                .text(node.expanded ? _options.symbols.expanded : _options.symbols.collapsed);
            node.domToggle.on('click', () => {
                if(!node.domToggle.hasClass('disabled'))
                    _self.toggleSubtree(node)
            });
            div.append(node.domToggle);
        }  
        node.domLabel = $('<div/>').addClass(_options.css.label)
            .on('click', () => _nodeClicked(node));
        _renderNodeLabelText(node);
        div.append(node.domLabel);
        if(node.children.length > 0 && _options.childCountShow) {
            div.append($('<span/>')
                .addClass(_options.css.childCountBadge)
                .text(node.children.length)
            );
        }
        div.data('node', node);
        if(node.parent) {
            if(!node.parent.domChildren)
                _renderNode(node.parent);
            node.parent.domChildren.append(div);
        }
        else
            _self.append(div);
        node.domContainer = div;
        if(node.children.length > 0)
            node.domChildren = $('<div/>').addClass(_options.css.childrenContainer).insertAfter(div);
        if(node.expanded)
            node.children.forEach(child => _renderNode(child));
    }

    // ------------------------------------------------------------------------
    var _setSearchInfo = function(
        node
    ) {
    // ------------------------------------------------------------------------
        if(!node.upperLabel)
            node.upperLabel = node.label.toUpperCase();
        if(node.searchInfo) {
            node.searchInfo.prevMatched = node.searchInfo.matches;
            node.searchInfo.matches = _lastSearchTerm === '' || node.upperLabel.includes(_lastSearchTerm);
        }
        else {
            node.searchInfo = {
                matches: _lastSearchTerm === '' || node.upperLabel.includes(_lastSearchTerm),
                expandedBefore: !!node.expanded
            };
        }
        node.searchInfo.anyChildMatches = false;
        node.children.forEach(child => {
            if(_setSearchInfo(child))
                node.searchInfo.anyChildMatches = true;
        });
        return node.searchInfo.matches || node.searchInfo.anyChildMatches;
    }

    // ------------------------------------------------------------------------
    var _setSearchVisibility = function(
        node
    ) {
    // ------------------------------------------------------------------------
        if((node.searchInfo.matches || node.searchInfo.anyChildMatches)
            && !_self.isNodeVisible(node)
        ) {
            _self.showNode(node);
        }
        if(node.searchInfo.anyChildMatches 
            && !node.expanded
        ) {
            _self.toggleSubtree(node);
        }
        if(!node.searchInfo.matches 
            && !node.searchInfo.anyChildMatches
            && _self.isNodeVisible(node)
        ) {
            _self.hideNode(node);
        }
        _renderNodeLabelText(node);
        node.children.forEach(child => _setSearchVisibility(child));
        if(node.children.length > 0 && node.domToggle) {
            if(!node.searchInfo.anyChildMatches)
                node.domToggle.addClass('disabled');
            else
                node.domToggle.removeClass('disabled');
        }
    }
    
    // ------------------------------------------------------------------------
    var _restoreNodeAfterSearch = function(
        node
    ) {
    // ------------------------------------------------------------------------
        if(node.searchInfo) {
            if(!_self.isNodeVisible(node))
            _self.showNode(node);
            if(node.children.length > 0) {
                node.domToggle && node.domToggle.removeClass('disabled');
                if((node.searchInfo.expandedBefore && !node.expanded)
                    || (!node.searchInfo.expandedBefore && node.expanded)
                ) {
                    _self.toggleSubtree(node);
                }
            }
            let hasMatched = node.searchInfo.matches;
            delete node.searchInfo;
            if(hasMatched)
                _renderNodeLabelText(node);
            node.children.forEach(child => _restoreNodeAfterSearch(child));
        }  
    }

    // ------------------------------------------------------------------------
    var _performSearch = function(
        searchTerm
    ) {
    // ------------------------------------------------------------------------
        if(_lastSearchTerm === searchTerm)
            return;
        _self.hide();
        _lastSearchTerm = searchTerm;
        if(_lastSearchTerm === '') {
            // restore previous
            _treeData.forEach(node => _restoreNodeAfterSearch(node));
            _self.removeClass('countHidden');
            // restore selection
            if(_selectedNode)
                _self.expandTo(_selectedNode).scrollTo(_selectedNode);
        }
        else {
            _treeData.forEach(node => {
                _setSearchInfo(node);
                _setSearchVisibility(node);
            });
            _self.addClass('countHidden');
        }
        _self.show();
    }

    // ------------------------------------------------------------------------
    var _installSearch = function(
    ) {
    // ------------------------------------------------------------------------
        let box = _options.searchBox;
        box && box.bind('keyup focus', function() {
            let v = String(box.val()).trim().toUpperCase();
            _performSearch(v.length >= _options.searchMinInputLength ? v : '');
        });
    }    

    // ------------------------------------------------------------------------
    var _initialize = function(
        options,
        data
    ) {
    // ------------------------------------------------------------------------
        _options = $.extend(true, _defaults, options);
        _nodeValueMap = {};
        _nodeCount = 0;
        // augment data object with essential info for processing
        (function traverseData(nodeArray, indent = 0, parent = undefined) {
            nodeArray.sort((a, b) => {
                return a.label.localeCompare(b.label);
            }).forEach((node, index) => {
                _nodeCount++;
                node.index = index;
                node.indent = indent;
                node.parent = parent;
                _nodeValueMap[node.value] = node;
                if(!$.isArray(node.children))
                    node.children = [];
                traverseData(node.children, indent + 1, node);
            });
        })(data);
        _treeData = data;
        _selectedNode = undefined;
        _lastSearchTerm = '';
        _self.data('simpleTree', _self);
        _self.empty();
        _treeData.forEach(node => _renderNode(node));
        _self.addClass(_options.css.mainContainer);
        _installSearch();
    }

    _initialize(options, data);
    return this;
// ============================================================================
}
})(jQuery);