import React from 'react';
import createReactClass from 'create-react-class';
import PropTypes from 'prop-types';
import PermissionRadioComp from './PermissionRadioComp';
import PermissionInclude from './PermissionInclude';
import PermissionExclude from './PermissionExclude';

/**
 * Permission React Component
 * @namespace Permission
 * */
export default createReactClass({
  /**
   * @memberof Permission
   * @prop {string} displayName
   * */
  displayName: 'Permission',
  /**
   * @memberof Permission
   * @prop {object} propTypes
   * @prop {object} propTypes.permission
   * @prop {string} propTypes.type
   * */
  propTypes: {
    permission: PropTypes.object,
    type: PropTypes.string,
  },
  /**
   * default props를 리턴한다.
   * @memberof Permission
   * @return {object}
   * */
  getDefaultProps: function () {
    return {
      modeEnable: false,
    };
  },
  /**
   * @memberof Permission
   * */
  getInitialState: function () {
    return this.init(this.props);
  },
  /**
   * Permission을 초기화한다.
   * @memberof Permission
   * @param {object} props
   * @return {object}
   * */
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

  /**
   * @memberof Permission
   * */
  componentDidUpdate: function (prevProps) {
    var permission = this.props.permission;
    if (permission !== prevProps.permission) {
      this.setState(this.init(this.props));
    }

  },
  /**
   * 상위설정 mode 변경
   * @memberof Permission
   * */
  modeChange: function () {
    var formData = this.state.formData;

    formData.mode = formData.mode === 'inherit' ? 'manual' : 'inherit';

    this.setState({
      formData: formData,
    });
  },
  /**
   * key에 해당하는 state를 value값으로 업데이트 한다.
   * @memberof Permission
   * @param {string} key
   * @param {string} value
   * */
  inputChange: function (key, value) {
    var formData = this.state.formData;

    formData[key] = value;

    this.setState({
      formData: formData,
    });
  },
  /**
   * 포함할 그룹을 삭제한다.
   * @memberof Permission
   * @param {number} i
   * */
  handleIncludeGroupDelete: function (i) {
    var tags = this.state.includeGroups;
    tags.splice(i, 1);
    this.setState({ includeGroups: tags });
  },
  /**
   * 포함할 멤버를 삭제한다.
   * @memberof Permission
   * @param {number} i
   * */
  handleIncludeMemberDelete: function (i) {
    var tags = this.state.includeMembers;
    tags.splice(i, 1);
    this.setState({ includeMembers: tags });
  },
  /**
   * 제외할 사용자를 삭제한다.
   * @memberof Permission
   * @param {number} i
   * */
  handleExcludeMemberDelete: function (i) {
    var tags = this.state.excludeMembers;
    tags.splice(i, 1);
    this.setState({ excludeMembers: tags });
  },
  /**
    * 포함할 사용자, 그룹을 추가한다.
    * @memberof Permission
    * @param {object} tag
    * */
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
  /**
   * 제외할 사용자를 추가한다.
   * @memberof Permission
   * @param {object} tag
   * */
  handleExcludeAddition: function (tag) {
    var tags = this.state.excludeMembers;
    var finded = _.find(tags, { id: tag.id });

    if (!finded) {
      tags.push(tag);
      this.setState({ excludeMembers: tags });
    }
  },
  /**
   * @memberof Permission
   * */
  render: function () {
    var _this = this;

    var modeEnable = this.props.modeEnable;
    var modeTitle = this.props.type + 'Mode';
    var ratingTitle = this.props.type + 'Rating';
    var includeGroupTitle = this.props.type + 'Group';
    var includeMemberTitle = this.props.type + 'User';
    var excludeMemberTitle = this.props.type + 'Except';
    var includeVGroupTitle = this.props.type + 'VGroup[]';

    var modeValue = this.state.formData.mode;
    var ratingValue = this.state.formData.rating;

    var controlDisabled = false;

    if (modeValue === 'manual' || modeValue === 'inherit') {
      modeEnable = true;
      if (modeValue !== 'manual') {
        controlDisabled = true;
      }
    }

    var ratingOption = [
     { value: 'super', name: XE.Lang.trans('xe::memberRatingAdministrator') },
     { value: 'manager', name: XE.Lang.trans('xe::memberRatingManager') },
     { value: 'member', name: XE.Lang.trans('xe::member') },
     { value: 'guest', name: XE.Lang.trans('xe::guest') },
    ];

    var RatingUI =
      ratingOption.map(function (data, i) {
        if (data.value == ratingValue)
         return <PermissionRadioComp data={data}
                       name={ratingTitle}
                       isChecked={true}
                       controlDisabled={controlDisabled}
                       key={i}
                       onChangeRadio={_this.inputChange.bind(null, 'rating')}
         />;
        else
         return <PermissionRadioComp data={data}
                       name={ratingTitle}
                       isChecked={false}
                       controlDisabled={controlDisabled}
                       key={i}
                       onChangeRadio={_this.inputChange.bind(null, 'rating')}
         />;
      });

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

    var modeUI;

    if (modeEnable)
     modeUI = <div className="form-group">
				<div className="checkbox">
					<label>
						<input type="checkbox" name={modeTitle} value="inherit" onChange={this.modeChange}
            checked={(modeValue === 'inherit')}/> {XE.Lang.trans('xe::inheritMode')}
					</label>
				</div>
			</div>;

    return (
      <div>
        {modeUI}
        <div className="form-group">
          <label>{XE.Lang.trans('xe::memberRating')}</label>
          <div className="radio">
            {RatingUI}
          </div>
        </div>
        <div className="form-group">
          <label>{XE.Lang.trans('xe::includeUserOrGroup')}</label>
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
                <div className="form-group">
                  <label>{XE.Lang.trans('xe::includeVGroup')}</label>
                  {VGroupUI}
                </div>
              );
            }
          }.call(this))
        }
					<div className="form-group">
						<label>{XE.Lang.trans('xe::excludeUser')}</label>
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

