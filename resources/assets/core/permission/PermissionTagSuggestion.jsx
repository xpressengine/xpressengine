import React from 'react';
import createReactClass from 'create-react-class';
import PropTypes from 'prop-types';

/**@private*/
const MIN_QUERY_LENGTH = 2;

/**
 * PermissionTagSuggestion React Component
 * @namespace PermissionTagSuggestion
 * */
export default createReactClass({
  /**
   * @memberof PermissionTagSuggestion
   * @prop {string} displayName
   * */
  displayName: 'PermissionTagSuggestion',

  /**
   * @memberof PermissionTagSuggestion
   * */
  propTypes: {
    query: PropTypes.string.isRequired,
    selectedIndex: PropTypes.number.isRequired,
    suggestions: PropTypes.array.isRequired,
    handleClick: PropTypes.func.isRequired,
    handleHover: PropTypes.func.isRequired,
    searchingCnt: PropTypes.number,
  },
  /**
   * tag suggestion 마크업을 리턴한다.
   * @memberof PermissionTagSuggestion
   * @param {object} item
   * @param {string} query
   * @return {object}
   * */
  markIt: function (item, query) {

    var escapedRegex = query.trim().replace(/[-\\^$*+?.()|[\]{}]/g, '\\$&');
    var r = RegExp(escapedRegex, 'gi');
    var itemName = item.displayName || item.name;
    return {
      __html: itemName.replace(r, '<mark>$&</mark>'),
    };
  },
  /**
   * @memberof PermissionTagSuggestion
   * */
  render: function () {
    var props = this.props;
    var suggestionList;
    var searching;
    var suggestions;
    if (this.props.searchingCnt > 0) {
      searching = <ul>
				<li>Searching ... <span className="spinner" role="spinner"><span
         className="spinner-icon"></span></span></li>
			</ul>;
    } else {
      suggestions = props.suggestions.map((function (item, i) {
        return (

          <li
            key={i}
            onClick={props.handleClick.bind(null, i)}
            onMouseOver={props.handleHover.bind(null, i)}
            className={i == props.selectedIndex ? 'active' : '' }
          >
                <span
              dangerouslySetInnerHTML={this.markIt(item, props.query)}
            />
						</li>

        );
      }).bind(this));
    }

    suggestionList = <ul>{suggestions}</ul>;

    if ((suggestions && suggestions.length === 0) || props.query.length < MIN_QUERY_LENGTH) {
      return (
        <div className="ReactTags__suggestions"/>
      );
    }

    return (
      <div className="ReactTags__suggestions">
					{searching}
					{suggestionList}
				</div>
    );
  },
});
