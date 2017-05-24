import React from 'react';
import createReactClass from 'create-react-class';
import PropTypes from 'prop-types';

export default createReactClass({
  displayName: 'PermissionTag',

  propTypes: {
    prefix: PropTypes.string,
    onDelete: PropTypes.func.isRequired,
    tag: PropTypes.object.isRequired,
  },
  render: function () {
    var tag = this.props.tag;
    var label = tag.displayName || tag.name;
    label = this.props.prefix + label;
    return (
      <span className="ReactTags__tag">
            {label}
					<a className="ReactTags__remove" onClick={this.props.onDelete}>x</a>
        </span>
    );

  },
});
