import $ from 'jquery'
import config from 'xe/config'
import _ from 'lodash'

/**
 * @private
 * @FIXME
 * @description
 * <pre>
 * 다국어 입력 컴포넌트를 만드는 방식 2가지
 * 1)DOM data속성을 사용하여 document ready상태일 경우 ajax로 한번에 다국어를 요청하여 컴포넌트를 만든다.
 * - ajax이후 langEditorBoxRender 사용시 type이 'obj'로 들어감.
 *
 * 2)langEditorBoxRender:fn 외부에서 직접호출하여 컴포넌트를 만든다
 * - 컴포넌트 state에 다국어 정보가 없으면 하나의 컴포넌트에 대한 다국어 정보를 ajax로 요청하여 상태를 갱신한다.
 * </pre>
 * */
class LangEditorBox {
  constructor ({ $wrapper, seq, name, langKey, multiline, lines, autocomplete, placeholder, required }) {
    this.$wrapper = $wrapper
    this.seq = seq
    this.name = name
    this.langKey = langKey
    this.multiline = multiline
    this.lines = lines || []
    this.autocomplete = autocomplete
    this.placeholder = placeholder
    this.required = required

    var that = this
    window.XE.app('Lang').then((appLang) => {
      $(function () {
        that.init()
      })
    })
  }

  init () {



    if (this.langKey && this.lines.length === 0) {
      window.XE.ajax({
        type: 'get',
        dataType: 'json',
        url: config.getters['router/origin'] + '/lang/lines/' + this.langKey,
        success: function (result) {
          this.setLines(result)
          this.render()
          this.bindEvents()
        }.bind(this)
      })
    } else {
      this.render()
      this.bindEvents()
    }
  }

  bindEvents () {
    if (this.autocomplete) {
      this.$wrapper.find('input[type=text]:first,textarea:first').autocomplete({
        source: '/lang/search/' + config.getters['lang/current'].code,
        minLength: 1,
        focus: function (event, ui) {
          event.preventDefault()
        },

        select: function (event, ui) {
          this.setLines(ui.item.lines)
        }
      })
    }
  }

  render () {
    var _this = this
    var locale = config.getters['lang/default']
    var fallback = config.getters['lang/fallback']
    var resource = 'xe_lang_preprocessor://lang/seq/' + this.seq
    var value = this.getValueFromLinesWithLocale(locale.code) || ''
    var inputClass = this.multiline ? 'textarea' : 'text'
    var multiline = this.multiline
      ? `<input type="hidden" name="${resource + '/multiline'}" value="true" />`
      : ''

    var editor = this.getEditor(resource, locale.code, value)
    var subTemplate = ''

    fallback.forEach(function (locale, i) {
      var value = _this.getValueFromLinesWithLocale(locale.code) || ''
      var editor = _this.getEditor(resource, locale.code, value)

      subTemplate += [
        `<div key="${locale.code}" class="input-group">`,
        `${editor}`,
        `<span class="input-group-addon">`,
        `<span class="flag-code"><i class="${locale.code + ' xe-flag'}"></i>${locale.nativeName}</span>`,
        `</span>`,
        `</div>`
      ].join('\n')
    })

    var template = [
      `<div class="${inputClass}">`,
      `<input type="hidden" name="xe_use_request_preprocessor" value="Y"/>`,
      `<input type="hidden" name="${resource + '/name'}" value="${this.name}" />`,
      `<input type="hidden" name="${resource + '/key'}" value="${this.langKey || ''}" />`,
      `${multiline}`,
      `<input type="hidden" name="${this.name}" value="${this.langKey || ''}" />`,
      `<div key="${locale.code}" class="input-group">`,
      `${editor}`,
      `<span class="input-group-addon">`,
      `<span class="flag-code"><i class="${locale.code + ' xe-flag'}"></i>${locale.nativeName}</span>`,
      `</span>`,
      `</div>`,
      `<div class="sub">${subTemplate}</div>`,
      `</div>`
    ].join('\n')

    this.$wrapper.html(template)
  }

  setLines (lines) {
    var _this = this
    this.lines = lines

    window.XE.Lang.locales.map(function (locale) {
      var selector = '#input-' + _this.seq + '-' + locale.code
      var value = _this.getValueFromLinesWithLocale(locale.code)
      $(selector).val(value)
    })
  }

  getValueFromLinesWithLocale (locale) {
    var lines = this.lines
    var i = lines.length
    var l = {}

    while (i--) {
      l = lines[i]
      if (l.locale == locale) {
        return l.value
      }
    }
  }

  getEditor (resource, locale, value) {
    var edit = null
    var id = ('input-' + this.seq + '-' + locale)
    var name = (resource + '/locale/' + locale)
    var placeholder = this.placeholder;
    var required = '';

    if(_.isArray(placeholder)) {
      placeholder = _.find(placeholder, (o) => { return o.locale === locale }).value;
    }
    if(this.required === 'required' || this.required === 'true' || this.required === true || this.required === 1) {
      required = 'required'
    }

    if (!this.multiline) {
      edit = $(`<input type="text" class="form-control" id="${id}" name="${name}" placeholder="${placeholder}" ${required} />`).attr('value', value).attr('data-origin-value', value)
    } else {
      edit = $(`<textarea class="form-control" id="${id}" name="${name}"></textarea>`).text(value).attr('data-origin-value', value)
    }

    return edit.prop('outerHTML')
  }
}

var seq = 0
/**
 * target element에 LangEditorBox를 랜더링함.
 * @FIXME
 * @global
 * @function langEditorBoxRender
 * */
window.langEditorBoxRender = function ($data, type) {
  if (type === 'obj') {
    // { name, langKey, multiline, lines, autocomplete, target }
    let name = $data.name
    let langKey = $data.langKey
    let multiline = $data.multiline
    let lines = $data.lines
    let autocomplete = $data.autocomplete
    let target = $data.target
    let placeholder = $data.placeholder
    let required = $data.required
    new LangEditorBox({ $wrapper: $($data.target), seq, name, langKey, multiline, lines, autocomplete, placeholder, required })
  } else {
    var name = $data.data('name')
    var langKey = $data.data('lang-key')
    var multiline = $data.data('multiline')
    var lines = $data.data('lines')
    var autocomplete = $data.data('autocomplete')

    new LangEditorBox({ $wrapper: $data, seq, name, langKey, multiline, lines, autocomplete })
  }

  seq++
}

// @FIXME
$(function () {
  renderLangEditorBox()
})

// @FIXME
function renderLangEditorBox () {
  let langKeys = []
  let langObj = {}
  let langs = []
  let idx = 0

  if ($('.lang-editor-box').length > 0) {
    $('.lang-editor-box').each(function (key, i) {
      let $this = $(this)

      let name = $this.data('name')
      let langKey = $this.data('lang-key')
      let multiline = $this.data('multiline')
      let lines = $this.data('lines')
      let autocomplete = $this.data('autocomplete')
      let placeholder = $this.data('placeholder')
      let required = $this.data('required')

      if (langKey) {
        langKeys.push(langKey)
      }

      if (placeholder) {
        langKeys.push(placeholder)
      }

      langs.push({
        name,
        langKey,
        multiline,
        lines,
        autocomplete,
        placeholder,
        required,
        target: $this[0]
      })

      idx++

    })

    if (langKeys.length > 0) {
      window.XE.ajax({
        type: 'post',
        dataType: 'json',
        url: config.getters['router/origin'] + '/lang/lines/many',
        data: {
          keys: langKeys
        },
        success: function (result) {
          $.each(result, (key, arr) => {
            $.each(langs, function () {
              if (key === this.langKey) {
                this.lines = arr
              }
            })
          })
          $.each(langs, function () {
            if(_.hasIn(result, this.placeholder) && !_.isEmpty(result[this.placeholder])) {
              this.placeholder = result[this.placeholder];
            }
            window.langEditorBoxRender(this, 'obj') // @FIXME
          })
        }
      })
    } else {
      $.each(langs, function () {
        window.langEditorBoxRender(this, 'obj') // @FIXME
      })
    }
  }

  window.XE.Validator.put('langrequired', function ($dst, parameters) {
    var $input = $dst.closest('.lang-editor-box').find("input[name^='xe_lang_preprocessor']:not(:hidden):first")
    var value = $input.val()
    var name = $dst.closest('.lang-editor-box').data('valid-name') || $dst.closest('.lang-editor-box').data('name')

    if (value === '') {
      window.XE.Validator.error($input, window.XE.Lang.trans('validation.required', { attribute: name }))
      return false
    }

    return true
  })
}

// @FIXME
$(document).on('focus', '.lang-editor-box input, textarea', function () {
  var box = $(this).closest('.lang-editor-box')
  var el = box.find('.sub')
  if ($(el).is(':hidden')) {
    $(el).slideDown('fast')
  }
})
