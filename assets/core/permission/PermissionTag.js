System.amdRequire(['react'], function(React) {
    var PermissionTag = React.createClass({
        displayName: 'PermissionTag',

        propTypes: {
            prefix: React.PropTypes.string,
            onDelete: React.PropTypes.func.isRequired,
            tag: React.PropTypes.object.isRequired
        },
        render: function() {
            var tag = this.props.tag;
            var label = tag.displayName || tag.name;
            label = this.props.prefix + label;
            return (
                React.createElement("span", {className: "ReactTags__tag"}, 
                label, 
                    React.createElement("a", {className: "ReactTags__remove", onClick: this.props.onDelete}, "x")
            )
            );


        }
    });
    
    return PermissionTag;
});