import React from 'react';
import ReactDOM from 'react-dom';
import createReactClass from 'create-react-class';
import PropTypes from 'prop-types';
import MenuSearchSuggestion from './MenuSearchSuggestion';

export default createReactClass({
  displayName: 'MenuSearchBar',

  propTypes: {
    tree: PropTypes.object,
    placeholder: PropTypes.string,
    handleSearch: PropTypes.func,
    menuRoutes: PropTypes.object,
  },
  getDefaultProps: function () {
    return {
      placeholder: 'Search...',
      tree: new Tree({}),
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
      searchingCnt: 0,
    };
  },

  handleChange: function (e) {
    var query = e.target.value.trim();
    this.setState({
      query: query,
    });

    this.searchMenu(query);
    if (query.length == 0) {
      this.setState({
        suggestions: [],
        searchingCnt: 0,
      });
    }
  },

  searchMenu: function (keyword) {
    var _this = this;
    var searchingCnt = this.state.searchingCnt + 1;
    var suggestions;
    var tree = this.props.tree;

    this.setState({
      searchingCnt: searchingCnt,
    });

    suggestions = _.filter(tree.indexes, function (index) {

      if (index.id == 0) return false;

      var title = index.node.title;
      if (!_this.isMenuEntity(index.node)) {
        title = XE.Lang.trans(index.node.title);
      }

      return !!(title && title.indexOf(keyword) !== -1);
    });

    searchingCnt = this.state.searchingCnt;
    searchingCnt = searchingCnt - 1;
    _this.setState(
      {
      suggestions: suggestions,
      searchingCnt: searchingCnt,
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
      suggestions: [],
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
          selectionMode: true,
        });
      } else {
        this.setState({
          selectedIndex: selectedIndex - 1,
          selectionMode: true,
        });
      }
    }

    // down arrow
    if (e.keyCode === Keys.DOWN_ARROW) {
      e.preventDefault();
      this.setState({
        selectedIndex: (this.state.selectedIndex + 1) % suggestions.length,
        selectionMode: true,
      });
    }
  },

  selection: function (index) {
    var input = ReactDOM.findDOMNode(this.refs.input);

    this.props.handleSearch(index.node);

    this.setState({
      query: '',
      selectionMode: false,
      selectedIndex: -1,
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
      selectionMode: true,
    });
  },

  render: function render() {

    var query = this.state.query.trim();
    var selectedIndex = this.state.selectedIndex;
    var suggestions = this.state.suggestions;
    var placeholder = this.props.placeholder;
    var trans = {
      addMenu: XE.Lang.trans('xe::addMenu'),
    };

    return (
      <div className="panel-heading">
					<div className="pull-left">
						<div className={cx({
                  'input-group': true,
                  'search-group': true,
                  open: query.length > 0,
                })}>
							<input type="text" className="form-control"
             aria-label="Text input with dropdown button"
             placeholder={placeholder} ref="input" onChange={this.handleChange}
             onKeyDown={this.handleKeyDown}/>
							<button className="btn-link" onClick={this.resetSearch}>
								<i className="xi-search"></i><span className="sr-only">검색</span>
							</button>

							<MenuSearchSuggestion query={query}
                    suggestions={suggestions}
                    selectedIndex={selectedIndex}
                    handleClick={this.handleSuggestionClick}
                    handleHover={this.handleSuggestionHover}/>
						</div>
					</div>
					<div className="pull-right">
						<a href={this.props.menuRoutes.createMenu} className="btn btn-primary pull-right"><i
          className="xi-plus"></i> {trans.addMenu}</a>
					</div>
				</div>
    );
  },
});
