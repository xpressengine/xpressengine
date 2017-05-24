import React from 'react';
import createReactClass from 'create-react-class';
import PropTypes from 'prop-types';

const MIN_QUERY_LENGTH = 2;

export default createReactClass({
  displayName: 'MenuSearchSuggestion',

  propTypes: {
    query: PropTypes.string.isRequired,
    handleClick: PropTypes.func.isRequired,
    handleHover: PropTypes.func.isRequired,
    searchingCnt: PropTypes.number,
    suggestions: PropTypes.array,
    selectedIndex: PropTypes.number,
  },
  markIt: function (item, query) {

    var escapedRegex = query.trim().replace(/[-\\^$*+?.()|[\]{}]/g, '\\$&');
    var r = RegExp(escapedRegex, 'gi');
    var itemName = item.node.title;
    if (!this.isMenuEntity(item.node)) {
      itemName = XE.Lang.trans(item.node.title);
    }

    return {
      __html: itemName.replace(r, '<em>$&</em>'),
    };
  },

  isMenuEntity: function (node) {
    return (node.entity && (node.entity == 'menu'));
  },

  render: function () {

    var props = this.props;
    var suggestions = this.props.suggestions.map((function (item, i) {
      return (

        <li
          key={i}
          onClick={props.handleClick.bind(null, i)}
          onMouseOver={props.handleHover.bind(null, i)}
          className={cx({
                          on: i == props.selectedIndex,
                        })}
        >
						<a href="#"
           dangerouslySetInnerHTML={this.markIt(item, props.query)}
         />
					</li>
      );
    }).bind(this));

    if ((suggestions && suggestions.length === 0) || props.query.length < MIN_QUERY_LENGTH) {
      return (
        <div className="search-list"/>
      );
    }

    return (
      <div className="search-list">
					<ul>
						{suggestions}
					</ul>
				</div>
    );
  },
});
