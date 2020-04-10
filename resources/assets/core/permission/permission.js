import $ from 'jquery'
import XE from 'xe'

// TODO:: mouseover,

const Keys = {
  ENTER: 13,
  TAB: 9,
  BACKSPACE: 8,
  UP_ARROW: 38,
  DOWN_ARROW: 40,
  ESCAPE: 27
}

class Permission {
  constructor ({ $wrapper, key, userSearchUrl, groupSearchUrl, permission, type, vgroupAll }) {
    this.$wrapper = $wrapper
    this.key = key
    this.userSearchUrl = userSearchUrl
    this.groupSearchUrl = groupSearchUrl
    this.permission = permission
    this.type = type
    this.vgroupAll = vgroupAll
    this.query = ''
    this.suggestion = []
    this.placeholder = XE.Lang.trans('xe::explainIncludeUserOrGroup')
    this.selectedIndex = ''
    this.includeSelectedIndex = -1
    this.excludeSelectedIndex = -1
    this.MIN_QUERY_LENGTH = 2
  }

  bindEvents () {
    var _this = this

    this.$wrapper.on('change', '.chkModeAble', function (e) {
      var $target = $(e.target)
      var checked = $target.is(':checked')

      if (checked) {
        _this.$wrapper.find('input:not(.chkModeAble)').prop('disabled', true)
      } else {
        _this.$wrapper.find('input:not(.chkModeAble)').prop('disabled', false)
      }
    })

    this.$wrapper.on('keydown', '.inputUserGroup', function (e) {
      var query = e.target.value.trim()
      var $this = $(this)
      var keyCode = e.keyCode
      var $ul = $this.parent().find('.ReactTags__suggestions ul')
      var dataInput = $this.data('input') // include, exclude

      if (query.length >= _this.MIN_QUERY_LENGTH) {
        if ($ul.length > 0) {
          var index = parseInt($this.data('index'), 10)
          var focusedIndex = 0

          switch (keyCode) {
            case Keys.UP_ARROW :
              if (index == 0) {
                focusedIndex = $ul.find('li').length - 1
              } else {
                focusedIndex = (index - 1)
              }

              $this.data('index', focusedIndex)
              $ul.find('li').eq(focusedIndex).addClass('active').siblings().removeClass('active')

              break
            case Keys.DOWN_ARROW :
              if (index == $ul.find('li').length - 1) {
                focusedIndex = 0
              } else {
                focusedIndex = index + 1
              }

              $this.data('index', focusedIndex)
              $ul.find('li').eq(focusedIndex).addClass('active').siblings().removeClass('active')

              break
            case Keys.ENTER :
            case Keys.TAB :
              e.preventDefault()

              if ($ul.find('li.active').length > 0) {
                var tag = $ul.find('li.active').data('tag')
                var name = ''
                var pType = ''
                var prefix = ''

                // user
                if ($ul.data('target') === 'user') {
                  // include
                  if (dataInput === 'include') {
                    name = _this.type + 'User'
                    pType = 'user'
                    prefix = '@'
                    // exclude
                  } else {
                    name = _this.type + 'Except'
                    pType = 'except'
                    prefix = '@'
                  }
                  // group
                } else {
                  name = _this.type + 'Group'
                  pType = 'group'
                  prefix = '%'
                }

                var pTypes = _this.permission[pType]
                var bSameWord = false

                if (pTypes.length > 0) {
                  pTypes.forEach(function (type, i) {
                    if (type.id === tag.id) {
                      bSameWord = true
                    }
                  })

                  if (!bSameWord) {
                    _this.permission[pType].push(tag)
                  }
                } else {
                  _this.permission[pType].push(tag)
                }

                var ids = _this.permission[pType].map(function (tag) {
                  return tag.id
                })

                if (!bSameWord) {
                  $ul.closest('.ReactTags__tags').find('[name=' + name + ']').val(ids.join().trim())
                  $ul.closest('.ReactTags__tags').find('.' + pType + 'Wrap')
                    .append(`<span class="ReactTags__tag">${prefix + (tag.display_name || tag.name)}<a class="ReactTags__remove btnRemoveTag" data-id="${tag.id}">x</a></span>`)
                }

                $ul.remove()
                $this.val('').data('index', -1).focus()
              }

              e.preventDefault() // prevent tab

              break
            case Keys.ESCAPE :
              _this[dataInput + 'SelectedIndex'] = 0
              $ul.parent().empty()
              $this.focus()
              break
          }
        }
      } else {
        if (Keys.BACKSPACE === keyCode) {
          var $tag = $this.closest('.ReactTags__tags').find('.ReactTags__selected span')
          if (!query && $tag.length > 0) {
            _this.removeTag($tag.eq($tag.length - 1))
          }
        }
      }
    })

    this.$wrapper.find('.ReactTags__suggestions').on('mouseenter', 'li', function () {
      var $this = $(this)

      $this.addClass('active').siblings().removeClass('active')
    })

    this.$wrapper.find('.ReactTags__suggestions').on('click', 'li', function () {
      var $this = $(this)
      var tag = $this.data('tag')
      var $ul = $this.closest('ul')
      var $input = $this.closest('.ReactTags__tagInput').find('input:text')
      var dataInput = $input.data('input')
      var name = ''
      var pType = ''
      var prefix = ''

      if ($ul.data('target') === 'user') {
        // include
        if (dataInput === 'include') {
          name = _this.type + 'User'
          pType = 'user'
          prefix = '@'
          // exclude
        } else {
          name = _this.type + 'Except'
          pType = 'except'
          prefix = '@'
        }
        // group
      } else {
        name = _this.type + 'Group'
        pType = 'group'
        prefix = '%'
      }

      var pTypes = _this.permission[pType]
      var bSameWord = false

      if (pTypes.length > 0) {
        pTypes.forEach(function (type, i) {
          if (type.id === tag.id) {
            bSameWord = true
          }
        })

        if (!bSameWord) {
          _this.permission[pType].push(tag)
        }
      } else {
        _this.permission[pType].push(tag)
      }

      var ids = _this.permission[pType].map(function (tag) {
        return tag.id
      })

      if (!bSameWord) {
        $ul.closest('.ReactTags__tags').find('[name=' + name + ']').val(ids.join().trim())
        $ul.closest('.ReactTags__tags').find('.' + pType + 'Wrap')
          .append(`<span class="ReactTags__tag">${prefix + (tag.display_name || tag.name)}<a class="ReactTags__remove btnRemoveTag" data-id="${tag.id}">x</a></span>`)
      }

      $ul.remove()
      $input.val('').data('index', -1).focus()
    })

    this.$wrapper.on('keyup', '.inputUserGroup', function (e) {
      var query = e.target.value.trim()
      var $this = $(this)
      var keyCode = e.keyCode

      if (query.length >= _this.MIN_QUERY_LENGTH) {
        if ([Keys.ENTER, Keys.TAB, Keys.UP_ARROW, Keys.DOWN_ARROW, Keys.ESCAPE, 37, 39].indexOf(keyCode) == -1) {
          var temp = ''
          temp += `<ul>`
          temp += `<li>Searching ... <span class="spinner" role="spinner"><span class="spinner-icon"></span></span></li>`
          temp += `</ul>`

          $this.parent().find('.ReactTags__suggestions').html(temp)

          var identifier = query.substr(0, 1)
          switch (identifier) {
            case '@':
              query = query.substr(1, query.length)
              _this.searchUser($this, query)
              break

            case '%':
              query = query.substr(1, query.length)
              _this.searchGroup($this, query)
              break

            default :
              break
          }
        }
      } else {
        $this.parent().find('.ReactTags__suggestions').empty()
      }
    })

    this.$wrapper.on('click', '.btnRemoveTag', function (e) {
      e.preventDefault()

      _this.removeTag($(this).closest('span'))
    })
  }

  makeIt (item, query) {
    var escapedRegex = query.trim().replace(/[-\\^$*+?.()|[\]{}]/g, '\\$&')
    var r = RegExp(escapedRegex, 'gi')
    var itemName = item.display_name || item.name

    return itemName.replace(r, '<mark>$&</mark>')
  }

  removeTag ($target) {
    var _this = this
    var pType = $target.closest('.ReactTags__selected').data('ptype')
    var id = $target.data('id')
    var name = ''

    switch (pType) {
      case 'user' :
        name = _this.type + 'User'
        break
      case 'except' :
        name = _this.type + 'Except'
        break
      case 'group' :
        name = _this.type + 'Group'
        break
    }

    var pTypes = _this.permission[pType]

    pTypes.forEach(function (type, i) {
      if (type.id !== id) {
        _this.permission[pType].splice(i, 1)// .push(tag);
      }
    })

    var ids = _this.permission[pType].map(function (tag) {
      return tag.id
    })

    $target.closest('.ReactTags__tags').find('[name=' + name + ']').val(ids.join().trim())
    $target.remove()
  }

  searchUser ($input, keyword) {
    var _this = this
    var searchUserUrl = _this.userSearchUrl

    XE.ajax({
      url: searchUserUrl + '/' + keyword,
      method: 'get',
      dataType: 'json',
      cache: false,
      success: function (data) {
        if (data.length > 0) {
          var temp = ''
          temp += `<ul data-target="user">`

          data.forEach(function (item, i) {
            temp += `<li class="" data-tag='${JSON.stringify(item)}'>`
            temp += `<span>${_this.makeIt(item, keyword)}</span>`
            temp += `</li>`
          })

          temp += `</ul>`

          $input.parent().find('.ReactTags__suggestions').html(temp)
        } else {
          $input.parent().find('.ReactTags__suggestions').empty()
        }
      },
      error: function (xhr, status, err) {

      }
    })
  }

  searchGroup ($input, keyword) {
    var _this = this
    var searchGroupUrl = _this.groupSearchUrl

    XE.ajax({
      url: searchGroupUrl + '/' + keyword,
      method: 'get',
      dataType: 'json',
      cache: false,
      success: function (data) {
        // TODO:: view renderin
        if (data.length > 0) {
          var temp = ''
          temp += `<ul data-target="group">`

          data.forEach(function (item, i) {
            temp += `<li data-tag='${JSON.stringify(item)}'>`
            temp += `<span>${_this.makeIt(item, keyword)}</span>`
            temp += `</li>`
          })

          temp += `</ul>`

          $input.parent().find('.ReactTags__suggestions').html(temp)
        } else {
          $input.parent().find('.ReactTags__suggestions').empty()
        }
      },
      error: function (xhr, status, err) {}
    })
  }

  render () {
    var _this = this
    var mode = this.permission.mode
    var rating = this.permission.rating
    var modeEnable = false
    var permissionTypes = [
      { value: 'super', name: XE.Lang.trans('xe::userRatingAdministrator') },
      { value: 'manager', name: XE.Lang.trans('xe::userRatingManager') },
      { value: 'user', name: XE.Lang.trans('xe::user') },
      { value: 'guest', name: XE.Lang.trans('xe::guest') }
    ]

    var disabled = false

    if (mode === 'manual' || mode === 'inherit') {
      modeEnable = true
      if (mode !== 'manual') {
        disabled = true
      }
    }

    var includeGroups = this.permission.group.map(function (group) {
      return group.id
    })

    var includeUsers = this.permission.user.map(function (user) {
      return user.id
    })

    var excludeUsers = this.permission.except.map(function (user) {
      return user.id
    })

    var temp = ''
    temp += `<div>`

    if (modeEnable) {
      var checked = (mode === 'inherit') ? 'checked="checked"' : ''

      temp += `<div class="form-group">`
      temp += `<div class="checkbox">`
      temp += `<label><input type="checkbox" name="${this.type + 'Mode'}" class="chkModeAble" value="inherit" ${checked} /> ${XE.Lang.trans('xe::inheritMode')}</label>`
      temp += `</div>`
      temp += `</div>`
    }

    temp += `<div class="form-group">`
    temp += `<label>회원 등급</label>`
    temp += '<div class="radio">'
    permissionTypes.forEach(function (permissionType) {
      var checked = (permissionType.value == rating) ? 'checked' : ''

      temp += `<label><input type="radio" ${(disabled) ? 'disabled="disabled"' : ''} name="${_this.type + 'Rating'}" value="${permissionType.value}" ${(checked) ? 'checked="checked"' : ''} /> ${permissionType.name} &nbsp;</label>`
    })
    temp += `</div>`
    temp += `</div>`
    temp += `<div class="form-group">`
    temp += `<label>${XE.Lang.trans('xe::includeUserOrGroup')}</label>`
    temp += `<div class="ReactTags__tags">`

    temp += `<div class="ReactTags__selected groupWrap" data-ptype="group">`
    this.permission.group.forEach(function (g) {
      var tag = g
      var label = '%' + (tag.display_name || tag.name)

      temp += `<span class="ReactTags__tag">${label}<a href="#" class="ReactTags__remove btnRemoveTag" data-id="${tag.id}">x</a></span>`
    })
    temp += '</div>'

    temp += '<div class="ReactTags__selected userWrap" data-ptype="user">'
    this.permission.user.forEach(function (tag) {
      var label = '@' + (tag.display_name || tag.name)

      temp += `<span class="ReactTags__tag">${label}<a href="#" class="ReactTags__remove btnRemoveTag" data-id="${tag.id}|">x</a></span>`
    })
    temp += `</div>`

    temp += `<div class="ReactTags__tagInput">`
    temp += `<input type="text" placeholder="${this.placeholder}" class="form-control inputUserGroup" data-input="include" ${(disabled) ? 'disabled="disabled"' : ''} value="${this.query}" data-index="-1" />` // TODO:: PermissionInclude handleKeyDown
    temp += `<div class="ReactTags__suggestions" data-input="include"></div>`
    temp += `</div>` // ReactTags__tagInput
    temp += `<input type="hidden" name="${this.type + 'Group'}" class="form-control includeGroups" value="${includeGroups.join().trim()}" />`
    temp += `<input type="hidden" name="${this.type + 'User'}" class="form-control includeUsers" value="${includeUsers.join().trim()}" />`
    temp += `</div>` // ReactTags__tags
    temp += `</div>`// form-group

    if (this.vgroupAll.length >= 1) {
      temp += `<div class="form-group">`
      temp += `<label>${XE.Lang.trans('xe::includeVGroup')}</label>`

      temp += _this.vgroupAll.map(function (data) {
        var checked = false

        var inArray = function (val, arr) {
          for (var i = 0; i < arr.length; i++) {
            if (arr[i] == val) {
              return i
            }
          }

          return -1
        }

        if (inArray(data.id, this.permission.vgroup) != -1) {
          checked = true
        }

        return `<label><input type="checkbox" ${(disabled) ? 'disabled="disabled"' : ''} name="${_this.type + 'VGroup[]'}" value="${data.id}" ${(checked) ? 'checked="checked"' : ''} /> ${data.title} &nbsp;</label>`
      })

      temp += '</div>'
    }

    temp += `<div class="form-group">`
    temp += `<label>${XE.Lang.trans('xe::excludeUser')}</label>`
    temp += `<div class="ReactTags__tags">`
    temp += `<div class="ReactTags__selected exceptWrap" data-ptype="except">`

    this.permission.except.forEach(function (tag) {
      var label = tag.display_name || tag.name
      label = '@' + label

      temp += `<span class="ReactTags__tag">${label}<a href="#" class="ReactTags__remove btnRemoveTag" data-id="${tag.id}">x</a></span>`
    })

    temp += `</div>`
    temp += `<div class="ReactTags__tagInput">`
    temp += `<input type="text" placeholder="${XE.Lang.trans('xe::explainExcludeUser')}" class="form-control inputUserGroup" data-input="exclude" ${(disabled) ? 'disabled="disabled"' : ''} data-index="-1" />` // TODO:: PermissionExclude handleKeyDown
    temp += `<div class="ReactTags__suggestions" data-input="exclude"></div>`
    temp += `</div>` // ReactTags__tagInput
    temp += `<input type="hidden" name="${this.type + 'Except'}" class="form-control excludeUsers" value="${excludeUsers}" />`
    temp += `</div>` // ReactTags__tags
    temp += `</div>`// form-group

    temp += `</div>`

    this.$wrapper.html(temp)
  }
}

$('.__xe__uiobject_permission').each(function (i) {
  var $this = $(this)
  var permission = $this.data('data')

  var key = $this.data('key')
  var type = $this.data('type')
  var userSearchUrl = $this.data('userUrl')
  var groupSearchUrl = $this.data('groupUrl')
  var vgroupAll = $this.data('vgroupAll')

  var p = new Permission({ $wrapper: $this, key, userSearchUrl, groupSearchUrl, permission, type, vgroupAll })
  p.render()
  p.bindEvents()
})
