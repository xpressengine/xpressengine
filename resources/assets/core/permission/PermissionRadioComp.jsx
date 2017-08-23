import React from 'react';
import createReactClass from 'create-react-class';
import PropTypes from 'prop-types';

/**
 * PermissionRadioComp React Component
 * @namespace PermissionRadioComp
 * */
export default createReactClass({
  /**
   * @memberof PermissionRadioComp
   * */
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
  /**
   * component input 상태가 변경시 상위 컴포넌트의 onChangeRadio를 호출한다.
   * @memberof PermissionRadioComp
   * @param {event} e
   * */
  inputChange: function (e) {
    this.props.onChangeRadio(e.target.value);
  },
  /**
   * @memberof PermissionRadioComp
   * @prop {object} propTypes
   * @prop {object} propTypes.data
   * @prop {function} propTypes.onChangeRadio
   * @prop {boolean} propTypes.isChecked
   * @prop {boolean} propTypes.controlDisabled
   * @prop {string} propTypes.name
   * */
  prodTypes: {
    data: PropTypes.object,
    onChangeRadio: PropTypes.function,
    isChecked: PropTypes.boolean,
    controlDisabled: PropTypes.boolean,
    name: PropTypes.string,
  },
});
