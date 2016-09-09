System.amdRequire(['react'], function(React) {
    var MIN_QUERY_LENGTH = 2;
    var PermissionTagSuggestion = React.createClass({
        displayName: "PermissionTagSuggestion",

        propTypes: {
            query: React.PropTypes.string.isRequired,
            selectedIndex: React.PropTypes.number.isRequired,
            suggestions: React.PropTypes.array.isRequired,
            handleClick: React.PropTypes.func.isRequired,
            handleHover: React.PropTypes.func.isRequired,
            searchingCnt: React.PropTypes.number
        },
        markIt: function (item, query) {

            var escapedRegex = query.trim().replace(/[-\\^$*+?.()|[\]{}]/g, "\\$&");
            var r = RegExp(escapedRegex, "gi");
            var itemName = item.displayName || item.name;
            return {
                __html: itemName.replace(r, "<mark>$&</mark>")
            };
        },
        render: function () {
            var props = this.props;
            var suggestionList;
            var searching;
            var suggestions;
            if(this.props.searchingCnt > 0) {
                searching = React.createElement("ul", null, React.createElement("li", null, "Searching ... ", React.createElement("span", {className: "spinner", role: "spinner"}, React.createElement("span", {className: "spinner-icon"}))));
            }else{
                suggestions = props.suggestions.map((function (item, i) {
                    return (

                        React.createElement("li", {
                            key: i, 
                            onClick: props.handleClick.bind(null, i), 
                            onMouseOver: props.handleHover.bind(null, i), 
                            className: i == props.selectedIndex ? "active" : ""
                        }, 
                    React.createElement("span", {
                        dangerouslySetInnerHTML: this.markIt(item, props.query)}
                    )
                        )

                    );
                }).bind(this));
            }

            suggestionList = React.createElement("ul", null, suggestions);

            if ((suggestions && suggestions.length === 0) || props.query.length < MIN_QUERY_LENGTH) {
                return (
                    React.createElement("div", {className: "ReactTags__suggestions"})
                );
            }

            return (
                React.createElement("div", {className: "ReactTags__suggestions"}, 
                    searching, 
                    suggestionList
                )
            );
        }
    });
    
    return PermissionTagSuggestion;
});


