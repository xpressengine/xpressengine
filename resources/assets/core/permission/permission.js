const Keys = {
	ENTER: 13,
	TAB: 9,
	BACKSPACE: 8,
	UP_ARROW: 38,
	DOWN_ARROW: 40,
	ESCAPE: 27,
};

class Permission {

	constructor({ $wrapper, key, memberSearchUrl, groupSearchUrl, permission, type, vgroupAll }) {
		this.$wrapper = $wrapper;
		this.key = key;
		this.memberSearchUrl = memberSearchUrl;
		this.groupSearchUrl = groupSearchUrl;
		this.permission = permission;
		this.type = type;
		this.vgroupAll = vgroupAll;
		this.query = '';
		this.suggestion = [];
		this.placeholder = XE.Lang.trans('xe::explainIncludeUserOrGroup');
		this.includeSearchCnt = 0;
		this.excludeSearchCnt = 0;
		this.searchCnt = 0;
		this.selectedIndex = '';
		this.includeSelectedIndex = -1;
		this.excludeSelectedIndex = -1;
		this.MIN_QUERY_LENGTH = 2;
	}

	bindEvents() {
		var _this = this;

		this.$wrapper.on('change', '.chkModeAble', function (e) {
			var $target = $(e.target);

			var checked = $target.is(':checked');

			if(checked) {
				_this.$wrapper.find('input:not(.chkModeAble)').prop('disabled', true);
			} else {
				_this.$wrapper.find('input:not(.chkModeAble)').prop('disabled', false);
			}
		});

		this.$wrapper.on('keydown', '.inputMemberGroup', function (e) {
			var query = e.target.value.trim();
			var $this = $(this);
			var keyCode = e.keyCode;
			var $ul = $this.parent().find('.ReactTags__suggestions ul');
			var dataInput = $this.data('input'); //include, exclude
			
			if (query.length >= _this.MIN_QUERY_LENGTH) {
				if($ul.length > 0) {
					var index = parseInt($this.data('index'), 10);
					var focusedIndex = 0;

					switch(keyCode) {
						case Keys.UP_ARROW :
							if(index == 0) {
								focusedIndex = $ul.find('li').length - 1;
							} else {
								focusedIndex = (index - 1);
							}

							$this.data('index', focusedIndex);
							$ul.find('li').eq(focusedIndex).addClass('active').siblings().removeClass('active');

							break;
						case Keys.DOWN_ARROW :
							if(index == $ul.find('li').length - 1) {
								focusedIndex = 0;
							} else {
								focusedIndex = index + 1;
							}

							$this.data('index', focusedIndex);
							$ul.find('li').eq(focusedIndex).addClass('active').siblings().removeClass('active');

							break;
						case Keys.ENTER :
						case Keys.TAB :
							e.preventDefault();

							if($ul.find('li.active').length > 0) {
								var tag = $ul.find('li.active').data('tag');
								var name = '';
								var pType = '';

								//member
								if($ul.data('target') == 'member') {
									//include
									if(dataInput == 'include') {
										name = _this.type + 'User';
										pType = 'user';
									//exclude
									} else {
										name = _this.type + 'Except';
										pType = 'except';
									}
								//group
								} else {
									name = _this.type + 'Group';
									pType = 'group';
								}

								var pTypes = _this.permission[pType];

								if(pTypes.length > 0) {
									pTypes.forEach(function (id, i) {
										if(id !== tag.id) {
											_this.permission[pType].push(tag.id);
										}
									});
								} else {
									_this.permission[pType].push(tag.id);
								}

								console.log('_this,permission[pType]', _this.permission[pType], 'name', name);

								$ul.closest('.ReactTags__tags').find('[name=' + name + ']').val(pTypes.join().trim());
								$ul.closest('.ReactTags__tags').find('.' + pType + 'Wrap')
									.append(`<span class="ReactTags__tag">${tag.display_name || tag.name}<a class="ReactTags__remove" data-id="${tag.id}">x</a></span>`);
								
								$ul.remove();
								$this.val('').data('index', -1).focus();

							}

							e.preventDefault();	//prevent tab

							break;
						case Keys.BACKSPACE :

							break;
						case Keys.ESCAPE :
							_this[dataInput + 'SelectedIndex'] = 0;
							$ul.parent().empty();
							break;

					}
				}
			}
		});

		this.$wrapper.find('.ReactTags__suggestions').on('mouseenter', 'li', function () {
			var $this = $(this);
			var $ul = $this.closest('ul');
			var size = $ul.find('li').length;
			
			$this.addClass('active').siblings().removeClass('active');
		});

		this.$wrapper.on('keyup', '.inputMemberGroup', function (e) {
			var query = e.target.value.trim();
			var $this = $(this);
			var keyCode = e.keyCode;

			if(query.length >= _this.MIN_QUERY_LENGTH) {

				if([Keys.ENTER, Keys.TAB, Keys.UP_ARROW, Keys.DOWN_ARROW, Keys.ESCAPE, 37, 39].indexOf(keyCode) == -1) {
					var temp = '';
					temp += 	`<ul>`;
					temp +=			`<li>Searching ... <span class="spinner" role="spinner"><span class="spinner-icon"></span></span></li>`;
					temp += 	`</ul>`;

					$this.parent().find('.ReactTags__suggestions').html(temp);

					var identifier = query.substr(0, 1);
					switch (identifier) {
						case '@':
							query = query.substr(1, query.length);
							_this.searchMember($this, query);
							break;

						case '%':
							query = query.substr(1, query.length);
							_this.searchGroup($this, query);
							break;

						default :
							break;
					}
				}
			} else {
				$this.parent().find('.ReactTags__suggestions').empty();
			}
		})

		this.$wrapper.on('keydownaa', '.inputInclude', function (e) {
			// var _state = this.state;
			var query = _this.query;
			var selectedIndex = _this.selectedIndex;
			var suggestions = _this.suggestions;

			// hide suggestions menu on escape
			if (e.keyCode === Keys.ESCAPE) {
				e.preventDefault();
				this.setState({
					selectedIndex: -1,
					selectionMode: false,
					suggestions: [],
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
				if (this.props.selectedMember.length > 0)
					this.handleMemberDelete(this.props.selectedMember.length - 1);
				else
					this.handleGroupDelete(this.props.selectedGroup.length - 1);
			}

			// up arrow
			if (e.keyCode === Keys.UP_ARROW) {
				e.preventDefault();

				// last item, cycle to the top
				if (selectedIndex <= 0) {
					this.setState({
						selectedIndex: this.state.suggestions.length - 1,
						selectionMode: true,
					});
				} else {
					this.setState({
						selectedIndex: selectedIndex - 1,
						selectionMode: true,
					});
				}
			}

			// down arrow
			if (e.keyCode === Keys.DOWN_ARROW) {
				e.preventDefault();
				this.setState({
					selectedIndex: (this.state.selectedIndex + 1) % suggestions.length,
					selectionMode: true,
				});
			}
		});
	}

	addTag() {

	}

	makeIt(item, query) {
		var escapedRegex = query.trim().replace(/[-\\^$*+?.()|[\]{}]/g, '\\$&');
		var r = RegExp(escapedRegex, 'gi');
		var itemName = item.display_name || item.name;

		return itemName.replace(r, '<mark>$&</mark>');
	}

	searchMember ($input, keyword) {
		var _this = this;
		var searchMemberUrl = _this.memberSearchUrl;

		// var searchingCnt = this.state.searchingCnt + 1;
		// _this.setState({
		// 	searchingCnt: searchingCnt,
		// });

		console.log(keyword);

		$.ajax({
			url: searchMemberUrl + '/' + keyword,
			method: 'get',
			dataType: 'json',
			cache: false,
			success: function (data) {

				if(data.length > 0) {
					var temp = '';
					temp += 	`<ul data-target="member">`;

					data.forEach(function (item, i) {
						/**
						 * TODO :: li event
						 * PermissionTagSuggestion handleClick click
						 * PermissionTagSuggestion handleHover mouseover
						 * */
						// temp += 		`<li class="${i == _this.selectedIndex ? 'active' : '' }">`;
						temp += 		`<li class="" data-tag='${JSON.stringify(item)}'>`;
						temp += 			`<span>${_this.makeIt(item, keyword)}</span>`;
						temp += 		`</li>`;
					});

					temp += 	`</ul>`;

					$input.parent().find('.ReactTags__suggestions').html(temp);

				} else {
					$input.parent().find('.ReactTags__suggestions').empty();

				}

				// var searchingCnt = _this.state.searchingCnt;
				// searchingCnt = searchingCnt - 1;
				// _this.setState(
				// 	{
				// 		suggestions: data,
				// 		searchingCnt: searchingCnt,
				// 	}
				// );
			},
			error: function (xhr, status, err) {
				// var searchingCnt = _this.state.searchingCnt;
				// searchingCnt = searchingCnt - 1;
				// _this.setState(
				// 	{
				// 		searchingCnt: searchingCnt,
				// 	}
				// );
				// console.error(searchMemberUrl, status, err.toString());
			},
		});

	}
	/**
	 * 그룹 suggestion을 AJAX요청하여 상태를 업데이트한다.
	 * @memberof PermissionInclude
	 * @param {string} keyword
	 * */
	searchGroup ($input, keyword) {
		var _this = this;
		var searchGroupUrl = _this.groupSearchUrl;
		// var _this = this;
		// var searchingCnt = this.state.searchingCnt + 1;
		// _this.setState({
		// 	searchingCnt: searchingCnt,
		// });

		$.ajax({
			url: searchGroupUrl + '/' + keyword,
			method: 'get',
			dataType: 'json',
			cache: false,
			success: function (data) {
				console.log(data);
				//TODO:: view renderin
				if(data.length > 0) {
					var temp = '';
					temp += 	`<ul data-target="group">`;

					data.forEach(function (item, i) {
						/**
						 * TODO :: li event
						 * PermissionTagSuggestion handleClick click
						 * PermissionTagSuggestion handleHover mouseover
						 * */
						// temp += 		`<li class="${i == _this.selectedIndex ? 'active' : '' }">`;
						temp += 		`<li data-tag='${JSON.stringify(item)}'>`;
						temp += 			`<span>${_this.makeIt(item, keyword)}</span>`;
						temp += 		`</li>`;
					});

					temp += 	`</ul>`;

					$input.parent().find('.ReactTags__suggestions').html(temp);

				} else {
					$input.parent().find('.ReactTags__suggestions').empty();

				}

				// var searchingCnt = _this.state.searchingCnt;
				// searchingCnt = searchingCnt - 1;
				// _this.setState(
				// 	{
				// 		suggestions: data,
				// 		searchingCnt: searchingCnt,
				// 	}
				// );
			},
			error: function (xhr, status, err) {
				// var searchingCnt = _this.state.searchingCnt;
				// searchingCnt = searchingCnt - 1;
				// _this.setState(
				// 	{
				// 		searchingCnt: searchingCnt,
				// 	}
				// );
				// console.error(searchGroupUrl, status, err.toString());
			},
		});

	}

	render() {

		var mode = this.permission.mode;
		var rating = this.permission.rating;
		var _this = this;
		var modeEnable = false;
		var permissionTypes = [
			{ value: 'super', name: XE.Lang.trans('xe::memberRatingAdministrator') },
			{ value: 'manager', name: XE.Lang.trans('xe::memberRatingManager') },
			{ value: 'member', name: XE.Lang.trans('xe::member') },
			{ value: 'guest', name: XE.Lang.trans('xe::guest') },
		];

		var disabled = false;

		if (mode === 'manual' || mode === 'inherit') {
			modeEnable = true;
			if (mode !== 'manual') {
				disabled = true;
			}
		}

		var includeGroups = this.permission.group.map(function (group) {
			return group.id;
		});

		var includeMembers = this.permission.user.map(function (member) {
			return member.id;
		});

		var excludeMembers = this.permission.except.map(function (member) {
			return member.id;
		});

		var temp = '';
		temp += `<div>`;

		if (modeEnable) {
			var checked = (mode === 'inherit')? 'checked="checked"' : '';

			temp += `<div class="form-group">`;
			temp += 	`<div class="checkbox">`;
			temp +=			`<label><input type="checkbox" name="${this.type + 'Mode'}" class="chkModeAble" value="inherit" ${checked} /> ${XE.Lang.trans('xe::inheritMode')}</label>`;
			temp += 	`</div>`;
			temp += `</div>`;
		}

		temp += 	`<div class="form-group">`;
		temp +=			`<label>회원 등급</label>`;
		temp += 		'<div class="radio">'
		permissionTypes.forEach(function (permissionType) {
			var checked = (permissionType.value == rating) ? 'checked' : '';

			temp += `<label><input type="radio" ${(disabled)? 'disabled="disabled"' : ''} name="${_this.type + 'Rating'}" value="${permissionType.value}" ${(checked)? 'checked="checked"' : ''} /> ${permissionType.name} &nbsp;</label>`;
		});
		temp +=			`</div>`;
		temp +=		`</div>`;
		temp += 	`<div class="form-group">`;
		temp +=			`<label>${XE.Lang.trans('xe::includeUserOrGroup')}</label>`;
		temp +=			`<div class="ReactTags__tags">`;

		temp += 			'<div class="ReactTags__selected groupWrap">';
		this.permission.group.forEach(function (g) {
			var tag = g;
			var label = '%' + (tag.displayName || tag.name);

			temp += 			`<span>${label}<a href="#" class="btnDeleteGroup">x</a></span>`;
		});
		temp +=				'</div>';

		temp +=				'<div class="ReactTags__selected userWrap">';
		this.permission.user.forEach(function (m) {
			var tag = m;
			var label = '@' + (tag.displayName || tag.name);

			temp += 			`<span>${label}<a href="#" class="btnDeleteMember">x</a></span>`;
		});
		temp +=				`</div>`;

		temp +=				`<div class="ReactTags__tagInput">`;
		temp += 				`<input type="text" placeholder="${this.placeholder}" class="form-control inputMemberGroup" data-input="include" ${(disabled)? 'disabled="disabled"' : ''} value="${this.query}" data-index="-1" />`;	//TODO:: PermissionInclude handleKeyDown
		temp += 				`<div class="ReactTags__suggestions" data-input="include"></div>`;



		temp +=				`</div>`; //ReactTags__tagInput
		temp += 			`<input type="hidden" name="${this.type + 'Group'}" class="form-control includeGroups" value="${includeGroups}" />`;
		temp +=				`<input type="hidden" name="${this.type + 'User'}" class="form-control includeMembers" value="${includeMembers}" />`;
		temp +=			`</div>`;	//ReactTags__tags
		temp +=		`</div>`;//form-group

		if(this.vgroupAll.length >= 1) {
			temp += `<div class="form-group">`;
			temp += 	`<label>${XE.Lang.trans('xe::includeVGroup')}</label>`;

			temp += _this.vgroupAll.map(function (data) {

				var checked = false;

				var inArray = function (val, arr) {
					for (var i = 0; i < arr.length; i++) {
						if (arr[i] == val) {
							return i;
						}
					}

					return -1;
				};

				if (inArray(data.id, this.permission.vgroup) != -1) {
					checked = true;
				}

				return `<label><input type="checkbox" ${(disabled)? 'disabled="disabled"' : ''} name="${_this.type + 'VGroup[]'}" value="${data.id}" ${(checked)? 'checked="checked"' : ''} /> ${data.title} &nbsp;</label>`;
			});

			temp += '</div>';
		}

		temp += `<div class="form-group">`;
		temp += 	`<label>${XE.Lang.trans('xe::excludeUser')}</label>`;
		temp +=		`<div class="ReactTags__tags">`;
		temp +=			`<div class="ReactTags__selected exceptWrap">`;

		this.permission.except.forEach(function (tag, i) {
			var label = tag.displayName || tag.name;
			label = '@' + label;

			temp += `<span>${label}<a href="#" class="btnDeleteExcept">x</a></span>`;
		});

		temp +=			`</div>`;
		temp += 		`<div class="ReactTags__tagInput">`;
		temp +=				`<input type="text" placeholder="${XE.Lang.trans('xe::explainExcludeUser')}" class="form-control inputMemberGroup" data-input="exclude" ${(disabled)? 'disabled="disabled"' : ''} data-index="-1" />`; 	//TODO:: PermissionExclude handleKeyDown
		temp += 			`<div class="ReactTags__suggestions" data-input="exclude"></div>`;
		temp += 		`</div>`; //ReactTags__tagInput
		temp +=		`</div>`; //ReactTags__tags
		temp +=		`<input type="hidden" name="${this.type + 'Except'}" class="form-control excludeMembers" value="${excludeMembers}" />`;
		temp += `</div>`;//form-group

		temp += `</div>`;

		this.$wrapper.html(temp);
	}
}

$('.__xe__uiobject_permission').each(function (i) {
  var $this = $(this);
  var permission = $this.data('data');

  var key = $this.data('key');
  var type = $this.data('type');
  var memberSearchUrl = $this.data('memberUrl');
  var groupSearchUrl = $this.data('groupUrl');
  var vgroupAll = $this.data('vgroupAll');

  var p = new Permission({ $wrapper: $this, key, memberSearchUrl, groupSearchUrl, permission, type, vgroupAll });
	p.render();
  p.bindEvents();

});


