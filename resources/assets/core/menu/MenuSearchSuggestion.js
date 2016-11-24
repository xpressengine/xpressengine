import React from 'react';

const MIN_QUERY_LENGTH = 2;

export default React.createClass({
  displayName: 'MenuSearchSuggestion',

  propTypes: {
    query: React.PropTypes.string.isRequired,
    handleClick: React.PropTypes.func.isRequired,
    handleHover: React.PropTypes.func.isRequired,
    searchingCnt: React.PropTypes.number,
    suggestions: React.PropTypes.array,
    selectedIndex: React.PropTypes.number,
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
