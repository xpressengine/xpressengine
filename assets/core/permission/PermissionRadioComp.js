System.amdDefine(['vendor:/react'], function(React) {
    var PermissionRadioComp = React.createClass({displayName: "PermissionRadioComp",
        componentDidMount: function() {},
        render: function() {
            return (
                React.createElement("label", null, React.createElement("input", {type: "radio", 
                              disabled: this.props.controlDisabled, 
                              name: this.props.name, 
                              value: this.props.data.value, 
                              checked: this.props.isChecked, 
                              onChange: this.inputChange}), " ", this.props.data.name, "  ")
            )
        },
        changeHandler: function(e) {
            this.props.onChangeRadio('radio', e);
        },
        prodTypes: {
            data: React.PropTypes.object,
            onChangeRadio: React.PropTypes.function,
            isChecked: React.PropTypes.boolean,
            controlDisabled: React.PropTypes.boolean,
            name: React.PropTypes.string
        }
    });

    return PermissionRadioComp;
});
