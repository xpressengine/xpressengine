import React from 'react';
import ReactDOM from 'react-dom';
import createReactClass from 'create-react-class';
import PropTypes from 'prop-types';
import PermissionTagSuggestion from './PermissionTagSuggestion';
import PermissionTag from './PermissionTag';

const Keys = {
  ENTER: 13,
  TAB: 9,
  BACKSPACE: 8,
  UP_ARROW: 38,
  DOWN_ARROW: 40,
  ESCAPE: 27,
};

export default createReactClass({
  displayName: 'PermissionExclude',

  propTypes: {
    selectedMember: PropTypes.array,
    placeholder: PropTypes.string,
    suggestions: PropTypes.array,
    handleDelete: PropTypes.func.isRequired,
    handleAddition: PropTypes.func.isRequired,
  },
  getDefaultProps: function () {
    return {
      placeholder: XE.Lang.trans('xe::explainExcludeUser'),
      selectedMember: [],
      suggestions: [],
    };
  },

  componentDidMount: function () {
  },

  getInitialState: function () {
    return {
      suggestions: [],
      query: '',
      selectedIndex: -1,
      selectionMode: false,
      searchingCnt: 0,
    };
  },

  handleDelete: function (i, e) {
    this.props.handleDelete(i);
    this.setState({ query: '' });
  },

  handleChange: function (e) {
    var query = e.target.value.trim();

    this.setState({
      query: query,
    });

    var identifier = query.substr(0, 1);

    if (identifier == '@') {
      var keyword = query.substr(1, query.length);

      this.searchMember(keyword);

    } else {
      this.setState({
        suggestions: [],
        searchingCnt: 0,
      });
    }
  },

  searchMember: function (keyword) {

    var searchMemberUrl = this.props.searchMemberUrl;
    var _this = this;
    var searchingCnt = this.state.searchingCnt + 1;
    _this.setState({
      searchingCnt: searchingCnt,
    });

    $.ajax({
      url: searchMemberUrl + '/' + keyword,
      method: 'get',
      dataType: 'json',
      cache: false,
      success: function (data) {
        var searchingCnt = _this.state.searchingCnt;
        searchingCnt = searchingCnt - 1;
        _this.setState(
          {
          suggestions: data,
          searchingCnt: searchingCnt,
        }
        );
      }.bind(_this),
      error: function (xhr, status, err) {
        var searchingCnt = _this.state.searchingCnt;
        searchingCnt = searchingCnt - 1;
        _this.setState(
          {
          searchingCnt: searchingCnt,
        }
        );
        console.error(searchMemberUrl, status, err.toString());
      }.bind(_this),
    });

  },

  handleKeyDown: function (e) {
    var _state = this.state;
    var query = _state.query;
    var selectedIndex = _state.selectedIndex;
    var suggestions = _state.suggestions;

    // hide suggestions menu on escape
    if (e.keyCode === Keys.ESCAPE) {
      e.preventDefault();
      this.setState({
        selectedIndex: -1,
        selectionMode: false,
        suggestions: [],
      });
    }

    // when enter or tab is pressed add query to tags
    if ((e.keyCode === Keys.ENTER || e.keyCode === Keys.TAB) && query != '') {
      e.preventDefault();
      if (this.state.selectionMode) {
        this.addTag(this.state.suggestions[this.state.selectedIndex]);
      }
    }

    // when backspace key is pressed and query is blank, delete tag
    if (e.keyCode === Keys.BACKSPACE && query == '') {
      //
      this.handleDelete(this.props.selectedMember.length - 1);
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

  addTag: function (tag) {
    var input = ReactDOM.findDOMNode(this.refs.input);

    // call method to add
    this.props.handleAddition(tag);

    // reset the state
    this.setState({
      query: '',
      selectionMode: false,
      selectedIndex: -1,
    });

    // focus back on the input box
    input.value = '';
    input.focus();
  },

  handleSuggestionClick: function (i, e) {
    this.addTag(this.state.suggestions[i]);
  },

  handleSuggestionHover: function (i, e) {
    this.setState({
      selectedIndex: i,
      selectionMode: true,
    });
  },

  render: function () {

    var prefix = '@';
    var tagItems = this.props.selectedMember.map((function (tag, i) {
      return (<PermissionTag key={tag.id} tag={tag} prefix={prefix}
                  onDelete={this.handleDelete.bind(this, i)}
      />);
    }).bind(this));

    var query = this.state.query.trim();
    var selectedIndex = this.state.selectedIndex;
    var suggestions = this.state.suggestions;
    var placeholder = this.props.placeholder;

    return (<div className="ReactTags__tags">
					<div className="ReactTags__selected">
						{tagItems}
					</div>
					<div className="ReactTags__tagInput">
						<input type="text" ref="input" placeholder={placeholder}
            className="form-control" disabled={this.props.disabled}
            onChange={this.handleChange} onKeyDown={this.handleKeyDown}/>
						<PermissionTagSuggestion query={query}
                     suggestions={suggestions}
                     searchingCnt={this.state.searchingCnt}
                     selectedIndex={selectedIndex}
                     handleClick={this.handleSuggestionClick}
                     handleHover={this.handleSuggestionHover}/>
					</div>
				</div>
    );
  },
});
