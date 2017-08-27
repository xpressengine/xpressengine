import React from 'react';
import ReactDOM from 'react-dom';
import createReactClass from 'create-react-class';
import PropTypes from 'prop-types';
import PermissionTagSuggestion from './PermissionTagSuggestion';
import PermissionTag from './PermissionTag';

/**@private*/
const Keys = {
  ENTER: 13,
  TAB: 9,
  BACKSPACE: 8,
  UP_ARROW: 38,
  DOWN_ARROW: 40,
  ESCAPE: 27,
};

/**
 * PermissionInclude React Component
 * @namespace PermissionInclude
 * */
export default createReactClass({
  /**
   * @memberof PermissionInclude
   * @prop {string} displayName
   * */
  displayName: 'PermissionInclude',
  /**
   * @memberof PermissionInclude
   * @prop {object} propTypes
   * @prop {array} propTypes.selectedGroup
   * @prop {array} propTypes.selectedMember
   * @prop {string} propTypes.placeholder
   * @prop {array} propTypes.suggestions
   * @prop {array} propTypes.groups
   * @prop {boolean} propTypes.handleGroupDelete
   * @prop {boolean} propTypes.handleDelete
   * @prop {boolean} propTypes.handleAddition
   * */
  propTypes: {
    selectedGroup: PropTypes.array,
    selectedMember: PropTypes.array,
    placeholder: PropTypes.string,
    suggestion: PropTypes.array,

    groups: PropTypes.array,
    handleGroupDelete: PropTypes.func.isRequired,
    handleMemberDelete: PropTypes.func.isRequired,
    handleAddition: PropTypes.func.isRequired,
  },
  /**
   * @memberof PermissionInclude
   * @return {object}
   * */
  getDefaultProps: function () {
    return {
      placeholder: XE.Lang.trans('xe::explainIncludeUserOrGroup'),
      selectedGroup: [],
      selectedMember: [],
      groupSuggestions: [],
      memberSuggestions: [],
    };
  },
  /**
   * @memberof PermissionInclude
   * @return {object}
   * */
  getInitialState: function () {
    return {
      suggestions: [],
      groupSuggestions: [],
      memberSuggestions: [],
      query: '',
      selectedIndex: -1,
      selectionMode: false,
      searchingCnt: 0,
    };
  },
  /**
   * 상위 컴포넌트의 handleGroupDelete를 호출한다.
   * @memberof PermissionInclude
   * @param {number} i
   * */
  handleGroupDelete: function (i, e) {
    this.props.handleGroupDelete(i);
    this.setState({ query: '' });
  },
  /**
   * 상위 컴포넌트의 handleMemberDelete를 호출한다.
   * @memberof PermissionInclude
   * */
  handleMemberDelete: function (i, e) {
    this.props.handleMemberDelete(i);
    this.setState({ query: '' });
  },
  /**
   * input상태를 업데이트한다.
   * @memberof PermissionInclude
   * @param {event} e
   * */
  handleChange: function (e) {
    var query = e.target.value.trim();

    this.setState({
      query: query,
    });

    if (query.length > 0) {
      var identifier = query.substr(0, 1);
      switch (identifier) {
      case '@':
        query = query.substr(1, query.length);
        this.searchMember(query);
      break;
      case '%':
        query = query.substr(1, query.length);
        this.searchGroup(query);
      break;
      default :
      break;
    }
    } else {
      this.setState({
        query: '',
        suggestions: [],
        searchingCnt: 0,
      });
    }
  },
  /**
   * 멤버 suggestion을 AJAX요청하여 상태를 업데이트한다.
   * @memberof PermissionInclude
   * @param {string} keyword
   * */
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
  /**
   * 그룹 suggestion을 AJAX요청하여 상태를 업데이트한다.
   * @memberof PermissionInclude
   * @param {string} keyword
   * */
  searchGroup: function (keyword) {

    var searchGroupUrl = this.props.searchGroupUrl;
    var _this = this;
    var searchingCnt = this.state.searchingCnt + 1;
    _this.setState({
      searchingCnt: searchingCnt,
    });

    $.ajax({
      url: searchGroupUrl + '/' + keyword,
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
        console.error(searchGroupUrl, status, err.toString());
      }.bind(_this),
    });

  },
  /**
   * component keydown handler
   * @memberof PermissionInclude
   * @param {event} e
   * */
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
      if (this.props.selectedMember.length > 0)
       this.handleMemberDelete(this.props.selectedMember.length - 1);
      else
       this.handleGroupDelete(this.props.selectedGroup.length - 1);
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
  /**
   * 태그를 추가한다.
   * @memberof PermissionInclude
   * @param {object} tag
   * */
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
  /**
   * suggestion click시 태그를 추가한다.
   * @memberof PermissionInclude
   * @param {object} tag
   * */
  handleSuggestionClick: function (i, e) {
    this.addTag(this.state.suggestions[i]);
  },
  /**
   * suggestion hover시 selected상태를 변경한다.
   * @memberof PermissionInclude
   * @param {number} i
   * */
  handleSuggestionHover: function (i, e) {
    this.setState({
      selectedIndex: i,
      selectionMode: true,
    });
  },
  /**
   * @memberof PermissionInclude
   * */
  render: function () {
    var groupPrefix = '%';
    var memberPrefix = '@';

    var groupTagItems = this.props.selectedGroup.map((function (tag, i) {
      return (
        <PermissionTag key={tag.id}
                tag={tag}
                prefix={groupPrefix}
                onDelete={this.handleGroupDelete.bind(this, i)}/>
      );
    }).bind(this));

    var memberTagItems = this.props.selectedMember.map((function (tag, i) {
      return (
        <PermissionTag key={tag.id}
                tag={tag}
                prefix={memberPrefix}
                onDelete={this.handleMemberDelete.bind(this, i)}/>
      );
    }).bind(this));

    var query = this.state.query.trim();
    var selectedIndex = this.state.selectedIndex;

    var suggestions = this.state.suggestions;
    var placeholder = this.props.placeholder;

    return (
      <div className="ReactTags__tags">
					<div className="ReactTags__selected">
						{groupTagItems}
					</div>
					<div className="ReactTags__selected">
						{memberTagItems}
					</div>
					<div className="ReactTags__tagInput">
						<input type="text" ref="input" placeholder={placeholder}
            className="form-control" disabled={this.props.disabled}
            value={this.state.query}
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
