import React from 'react';

export default React.createClass({
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
    data: React.PropTypes.object,
    onChangeRadio: React.PropTypes.function,
    isChecked: React.PropTypes.boolean,
    controlDisabled: React.PropTypes.boolean,
    name: React.PropTypes.string,
  },
});
