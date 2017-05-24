import React from 'react';
import createReactClass from 'create-react-class';
import PropTypes from 'prop-types';
import PermissionInclude from './PermissionInclude';
import PermissionExclude from './PermissionExclude';
import PermissionRadioComp from './PermissionRadioComp';

export default createReactClass({
  displayName: 'Permission',

  propTypes: {
    permission: PropTypes.object,
    type: PropTypes.string,
  },

  getDefaultProps: function () {
    return {
      modeEnable: false,
    };
  },

  getInitialState: function () {
    return this.init(this.props);
  },

  init: function (props) {
    var permission = props.permission;

    var mode;
    var rating;

    var includeGroups = [];
    var includeMembers = [];
    var excludeMembers = [];

    if (permission) {
      mode = permission.mode;
      rating = permission.rating;
      includeGroups = permission.group;
      includeMembers = permission.user;
      excludeMembers = permission.except;
    }

    return {
      permission: permission,
      modeEnable: this.props.modeEnable,
      formData: {
        mode: mode,
        rating: rating,
      },
      includeGroups: includeGroups,
      includeMembers: includeMembers,
      excludeMembers: excludeMembers,
    };
  },

  componentDidMount: function () {
  },

  componentDidUpdate: function (prevProps) {
    var permission = this.props.permission;
    if (permission !== prevProps.permission) {
      this.setState(this.init(this.props));
    }

  },

  inputChange: function (key, event) {
    var value = event.target.value;
    var formData = this.state.formData;

    formData[key] = value;

    this.setState({
      formData: formData,
    });
  },

  handleIncludeGroupDelete: function (i) {
    var tags = this.state.includeGroups;
    tags.splice(i, 1);
    this.setState({ includeGroups: tags });
  },

  handleIncludeMemberDelete: function (i) {
    var tags = this.state.includeMembers;
    tags.splice(i, 1);
    this.setState({ includeMembers: tags });
  },

  handleExcludeMemberDelete: function (i) {
    var tags = this.state.excludeMembers;
    tags.splice(i, 1);
    this.setState({ excludeMembers: tags });
  },

  handleIncludeAddition: function (tag) {
    var includeGroups = this.state.includeGroups;
    var includeMembers = this.state.includeMembers;

    var finded;

    if (tag.hasOwnProperty('displayName')) {
      finded = _.find(includeMembers, { id: tag.id });

      if (!finded) {
        includeMembers.push(tag);
        this.setState({ includeMembers: includeMembers });
      }
    } else {
      finded = _.find(includeGroups, { id: tag.id });

      if (!finded) {
        includeGroups.push(tag);
        this.setState({ includeGroups: includeGroups });
      }
    }
  },

  handleExcludeAddition: function (tag) {
    var tags = this.state.excludeMembers;
    var finded = _.find(tags, { id: tag.id });

    if (!finded) {
      tags.push(tag);
      this.setState({ excludeMembers: tags });
    }
  },

  render: function () {
    var _this = this;
    var ratingTitle = this.props.type + 'Rating';
    var includeGroupTitle = this.props.type + 'Group';
    var includeMemberTitle = this.props.type + 'User';
    var excludeMemberTitle = this.props.type + 'Except';
    var includeVGroupTitle = this.props.type + 'VGroup[]';

    var modeValue = this.state.formData.mode;
    var ratingValue = this.state.formData.rating;

    var controlDisabled = false;

    if (modeValue === 'manual' || modeValue === 'inherit') {
      if (modeValue !== 'manual') {
        controlDisabled = true;
      }
    }

    var ratingOption = [
     { value: 'super', name: 'Super' }, { value: 'manager', name: 'Manager' }, {
      value: 'member',
      name: 'Member',
    }, { value: 'guest', name: 'Guest' },
    ];

    var VGroupUI = this.props.vgroupAll.length < 1 ? null : this.props.vgroupAll.map(function (data) {
      var inputProps = {
        type: 'checkbox',
        disabled: controlDisabled,
        name: includeVGroupTitle,
        value: data.id,
        key: data.id,
      };
      var inArray = function (val, arr) {
        for (var i = 0; i < arr.length; i++) {
          if (arr[i] == val) {
            return i;
          }
        }

        return -1;
      };

      if (inArray(data.id, this.props.permission.vgroup) != -1) {
        inputProps.defaultChecked = true;
      }

      return (
        <label>
						<input {...inputProps} /> {data.title} &nbsp;
					</label>
      );
    }.bind(this));

    var includeGroups = this.state.includeGroups.map(function (group) {
      return group.id;
    });

    var includeMembers = this.state.includeMembers.map(function (member) {
      return member.id;
    });

    var excludeMembers = this.state.excludeMembers.map(function (member) {
      return member.id;
    });

    return (
      <div>
					<div>
						<label>
							Rating &nbsp;
							<i className="fa fa-info-circle" data-toggle="popover"
           data-content="권한의 등급을 설정합니다."></i>
						</label>
						<br/>
						{
         ratingOption.map(function (data, i) {
          var checked = (data.value === ratingValue) ? true : false;

          return (
            <PermissionRadioComp data={data}
                       name={ratingTitle}
                       isChekced={checked}
                       controlDisabled={controlDisabled}
                       key={i}
                       onChangeRadio={_this.inputChange}
            />
          );
        })
        }
					</div>
					<div>
						<label>
							Include Group and User&nbsp;
							<i className="fa fa-info-circle" data-toggle="popover"
           data-content="포함하고자 하는 대상을 지정합니다."
           data-original-title=""></i>
						</label><br/>
						<PermissionInclude
          selectedGroup={this.state.includeGroups}
          selectedMember={this.state.includeMembers}
          searchMemberUrl={this.props.memberSearchUrl}
          searchGroupUrl={this.props.groupSearchUrl}
          disabled={controlDisabled}
          handleGroupDelete={this.handleIncludeGroupDelete}
          handleMemberDelete={this.handleIncludeMemberDelete}
          handleAddition={this.handleIncludeAddition}
        />
						<input type="hidden" name={includeGroupTitle} className="form-control"
            value={includeGroups}/>
						<input type="hidden" name={includeMemberTitle} className="form-control"
            value={includeMembers}/>

					</div>
					{
            (function () {
              if (VGroupUI) {
                return (
                  <p>
                    <label>Include Virtual Group&nbsp;<i className="fa fa-info-circle" data-toggle="popover" data-content="포함하고자 하는 대상을 지정합니다." data-original-title=""></i></label><br/>
                    {VGroupUI}
                  </p>
                );
              }
            }.call(this))
          }
					<div>
						<label>
							Exclude User &nbsp;
							<i className="fa fa-info-circle" data-toggle="popover"
           data-content="제외하고자 하는 대상을 지정합니다."
           data-original-title=""></i>
						</label><br/>
						<PermissionExclude
          selectedMember={this.state.excludeMembers}
          searchMemberUrl={this.props.memberSearchUrl}
          disabled={controlDisabled}
          handleDelete={this.handleExcludeMemberDelete}
          handleAddition={this.handleExcludeAddition}
        />
						<input type="hidden" name={excludeMemberTitle} className="form-control"
            value={excludeMembers}/>
					</div>
				</div>
    );
  },
});
