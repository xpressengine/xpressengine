System.amdDefine(['vendor:/react', 'vendor:/react-dom', 'jquery', 'PermissionTagSuggestion', 'PermissionTag'], function(React, ReactDOM, $, PermissionTagSuggestion, PermissionTag) {

    var Keys = {
        ENTER: 13,
        TAB: 9,
        BACKSPACE: 8,
        UP_ARROW: 38,
        DOWN_ARROW: 40,
        ESCAPE: 27
    };

    var PermissionExclude = React.createClass({
        displayName: 'PermissionExclude',

        propTypes: {
            selectedMember: React.PropTypes.array,
            placeholder: React.PropTypes.string,
            suggestions: React.PropTypes.array,
            handleDelete: React.PropTypes.func.isRequired,
            handleAddition: React.PropTypes.func.isRequired
        },
        getDefaultProps: function () {
            return {
                placeholder: XE.Lang.trans('xe::explainExcludeUser'),
                selectedMember: [],
                suggestions: []
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
                searchingCnt: 0
            };
        },
        handleDelete: function (i, e) {
            this.props.handleDelete(i);
            this.setState({query: ''});
        },
        handleChange: function (e)
        {
            var query = e.target.value.trim();

            this.setState({
                query: query
            });

            var identifier = query.substr(0, 1);

            if (identifier == "@") {
                var keyword = query.substr(1, query.length);

                this.searchMember(keyword);

            } else {
                this.setState({
                    suggestions: [],
                    searchingCnt: 0
                });
            }
        },

        searchMember: function (keyword) {

            var searchMemberUrl = this.props.searchMemberUrl;
            var self = this;
            var searchingCnt = this.state.searchingCnt + 1;
            self.setState({
                searchingCnt: searchingCnt
            });

            $.ajax({
                url: searchMemberUrl + '/' + keyword,
                method: 'get',
                dataType: 'json',
                cache: false,
                success: function (data) {
                    var searchingCnt = self.state.searchingCnt;
                    searchingCnt = searchingCnt - 1;
                    self.setState(
                        {
                            suggestions: data,
                            searchingCnt: searchingCnt
                        }
                    );
                }.bind(self),
                error: function (xhr, status, err) {
                    var searchingCnt = self.state.searchingCnt;
                    searchingCnt = searchingCnt - 1;
                    self.setState(
                        {
                            searchingCnt: searchingCnt
                        }
                    );
                    console.error(searchMemberUrl, status, err.toString());
                }.bind(self)
            });

        },

        handleKeyDown: function(e) {
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
                    suggestions: []
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
        addTag: function (tag) {
            var input = ReactDOM.findDOMNode(this.refs.input);

            // call method to add
            this.props.handleAddition(tag);

            // reset the state
            this.setState({
                query: '',
                selectionMode: false,
                selectedIndex: -1
            });

            // focus back on the input box
            input.value = '';
            input.focus();
        },
        handleSuggestionClick: function(i, e) {
            this.addTag(this.state.suggestions[i]);
        },
        handleSuggestionHover: function(i, e) {
            this.setState({
                selectedIndex: i,
                selectionMode: true
            });
        },

        render: function() {

            var prefix = '@';
            var tagItems = this.props.selectedMember.map((function (tag, i) {
                return (React.createElement(PermissionTag, {key: tag.id, tag: tag, prefix: prefix, onDelete: this.handleDelete.bind(this, i)}
                ));
            }).bind(this));

            var query = this.state.query.trim(),
                selectedIndex = this.state.selectedIndex,
                suggestions = this.state.suggestions,
                placeholder = this.props.placeholder;
            return ( React.createElement("div", {className: "ReactTags__tags"}, 
                    React.createElement("div", {className: "ReactTags__selected"}, 
                        tagItems
                    ), 
                    React.createElement("div", {className: "ReactTags__tagInput"}, 
                        React.createElement("input", {type: "text", ref: "input", placeholder: placeholder, 
                               className: "form-control", disabled: this.props.disabled, 
                               onChange: this.handleChange, onKeyDown: this.handleKeyDown}), 
                        React.createElement(PermissionTagSuggestion, {query: query, 
                                                 suggestions: suggestions, 
                                                 searchingCnt: this.state.searchingCnt, 
                                                 selectedIndex: selectedIndex, 
                                                 handleClick: this.handleSuggestionClick, 
                                                 handleHover: this.handleSuggestionHover})
                    )
                )
            );
        }
    });

    return PermissionExclude;
});

