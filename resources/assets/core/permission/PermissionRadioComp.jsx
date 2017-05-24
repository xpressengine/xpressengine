import React from 'react';
import createReactClass from 'create-react-class';
import PropTypes from 'prop-types';

export default createReactClass({
  render: function () {
    return (
      <label><input type="radio"
             disabled={this.props.controlDisabled}
             name={this.props.name}
             value={this.props.data.value}
             checked={this.props.isChecked}
             onChange={this.inputChange}/> {this.props.data.name} &nbsp;</label>
    );
  },

  inputChange: function (e) {
    this.props.onChangeRadio(e.target.value);
  },

  prodTypes: {
    data: PropTypes.object,
    onChangeRadio: PropTypes.function,
    isChecked: PropTypes.boolean,
    controlDisabled: PropTypes.boolean,
    name: PropTypes.string,
  },
});
