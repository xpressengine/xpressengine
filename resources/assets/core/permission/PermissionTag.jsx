import React from 'react';
import createReactClass from 'create-react-class';
import PropTypes from 'prop-types';

/**
 * PermissionTag React Component
 * @namespace PermissionTag
 * */
export default createReactClass({
  /**
   * @memberof PermissionTag
   * @prop {string} displayName
   * */
  displayName: 'PermissionTag',
  /**
   * @memberof PermissionTag
   * @prop {object} propTypes
   * @prop {string} propTypes.prefix
   * @prop {function} propTypes.onDelete
   * @prop {array} propTypes.tag
   * */
  propTypes: {
    prefix: PropTypes.string,
    onDelete: PropTypes.func.isRequired,
    tag: PropTypes.object.isRequired,
  },
  /**
   * @memberof PermissionTag
   * */
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
