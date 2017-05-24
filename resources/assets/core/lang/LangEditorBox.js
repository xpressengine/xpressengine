import React from 'react';
import ReactDOM from 'react-dom';
import createReactClass from 'create-react-class';
import validator from 'validator';

/**
 * 다국어 입력 컴포넌트를 만드는 방식 2가지
 * 1)DOM data속성을 사용하여 document ready상태일 경우 ajax로 한번에 다국어를 요청하여 컴포넌트를 만든다.
 * - ajax이후 langEditorBoxRender 사용시 type이 'obj'로 들어감.
 *
 * 2)langEditorBoxRender:fn 외부에서 직접호출하여 컴포넌트를 만든다
 * - 컴포넌트 state에 다국어 정보가 없으면 하나의 컴포넌트에 대한 다국어 정보를 ajax로 요청하여 상태를 갱신한다.
 * */

var LangEditorBox = createReactClass({
  getDefaultProps: function () {
    return {
      name: '',
      langKey: '',
      multiline: false,
      lines: [],
      autocomplete: false,
    };
  },

  render: function () {
    LangEditor.seq++;
    return (
      <LangEditor
        key={LangEditor.seq}
        seq={LangEditor.seq}
        name={this.props.name}
        langKey={this.props.langKey}
        multiline={this.props.multiline}
        lines={this.props.lines}
        autocomplete={this.props.autocomplete}
      />
    );
  },
});

var LangEditor = createReactClass({
  statics: { seq: 0 },
  getInitialState: function () {
    var lines = this.props.lines || [];
    return { lines: lines };
  },

  setLines: function (lines) {
    var _this = this;
    _this.setState({ lines: lines });
    XE.Lang.locales.map(function (locale) {
      var selector = '#input-' + _this.props.seq + '-' + locale;
      var value = _this.getValueFromLinesWithLocale(locale);
      $(selector).val(value);
    });
  },

  getValueFromLinesWithLocale: function (locale) {
    var lines = this.state.lines;
    var i = lines.length;
    var l = {};

    while (i--) {
      l = lines[i];
      if (l.locale == locale) {
        return l.value;
      }
    }

    return '';
  },

  componentDidMount: function () {
    // if (this.isMounted()) {
    var _this = this;
    var el = ReactDOM.findDOMNode(this);

    if (this.props.langKey) {
      if (this.state.lines.length == 0) {
        $.ajax({
          type: 'get',
          dataType: 'json',
          url: xeBaseURL + '/' + XE.options.managePrefix + '/lang/lines/' + this.props.langKey,
          success: function (result) {
            // if (this.isMounted()) {
            _this.setLines(result);

            // }
          }.bind(this),
        });
      }
    }

    if (this.props.autocomplete) {
      $(el).find('input[type=text]:first,textarea:first').autocomplete({
        source: '/' + XE.options.managePrefix + '/lang/search/' + XE.Lang.locales[0],
        minLength: 1,
        focus: function (event, ui) {
          event.preventDefault();
        },

        select: function (event, ui) {
          _this.setLines(ui.item.lines);
        },
      });
    }
    // }
  },

  getEditor: function (resource, locale, value) {
    var edit = null;
    var id = ('input-' + this.props.seq + '-' + locale);
    var name = (resource + '/locale/' + locale);

    if (!this.props.multiline) {
      edit = <input type="text" className="form-control" id={id} name={name} defaultValue={value}/>;
    } else {
      edit = <textarea className="form-control" id={id} name={name} defaultValue={value}/>;
    }

    return edit;
  },

  render: function () {
    var _this = this;
    var locale = XE.Lang.locales[0];
    var fallback = XE.Lang.locales.slice(1);
    var resource = 'xe_lang_preprocessor://lang/seq/' + this.props.seq;
    var value = this.getValueFromLinesWithLocale(locale);
    var inputClass = this.props.multiline ? 'textarea' : 'text';

    var multiline = this.props.multiline
      ? <input type="hidden" name={resource + '/multiline'} defaultValue='true'/>
      : null;

    return (
      <div className={inputClass}>
        <input type="hidden" name="xe_use_request_preprocessor" value="Y"/>
        <input type="hidden" name={resource + '/name'} defaultValue={this.props.name}/>
        <input type="hidden" name={resource + '/key'} defaultValue={this.props.langKey}/>
        {multiline}
        <input type="hidden" name={this.props.name} defaultValue={this.props.langKey}/>
        <div key={locale} className="input-group">
          {_this.getEditor(resource, locale, value)}
            <span className="input-group-addon">
            <span className="flag-code"><i className={locale + ' xe-flag'}></i>{locale}</span>
            </span>
        </div>
        <div className="sub">
          {
            fallback.map(function (locale, i) {
              var value = _this.getValueFromLinesWithLocale(locale);
              return (
                <div key={locale} className="input-group">
                  {_this.getEditor(resource, locale, value)}
                      <span className="input-group-addon">
                      <span className="flag-code"><i className={locale + ' xe-flag'}></i>{locale}</span>
                      </span>
                </div>
              );
            })
          }
        </div>
      </div>
    );
  },
});

window.langEditorBoxRender = function ($data, type) {
  if (type === 'obj') {
    //{ name, langKey, multiline, lines, autocomplete, target }
    let name = $data.name;
    let langKey = $data.langKey;
    let multiline = $data.multiline;
    let lines = $data.lines;
    let autocomplete = $data.autocomplete;
    let target = $data.target;

    ReactDOM.render(<LangEditorBox name={name} langKey={langKey} multiline={multiline} lines={lines} autocomplete={autocomplete}/>, target);

  } else {
    var name = $data.data('name');
    var langKey = $data.data('lang-key');
    var multiline = $data.data('multiline');
    var lines = $data.data('lines');
    var autocomplete = $data.data('autocomplete');

    ReactDOM.render(<LangEditorBox name={name} langKey={langKey} multiline={multiline} lines={lines} autocomplete={autocomplete}/>, $data[0]);
  }

};

$(function () {
  renderLangEditorBox();
});

function renderLangEditorBox() {

  let langKeys = [];
  let langObj = {};
  let langs = [];
  let idx = 0;

  if ($('.lang-editor-box').length > 0) {

    $('.lang-editor-box').each(function (key, i) {
      let $this = $(this);

      let name = $this.data('name');
      let langKey = $this.data('lang-key');
      let multiline = $this.data('multiline');
      let lines = $this.data('lines');
      let autocomplete = $this.data('autocomplete');

      // langObj[langKey] = {
      //   name,
      //   langKey,
      //   multiline,
      //   lines,
      //   autocomplete,
      //   target: $this[0],
      // };
      //

      if (langKey) {
        langKeys.push(langKey);
      }

      langs.push({
        name,
        langKey,
        multiline,
        lines,
        autocomplete,
        target: $this[0],
      });

      idx++;
    });

    if (langKeys.length > 0) {
      XE.ajax({
        type: 'get',
        dataType: 'json',
        url: xeBaseURL + '/' + XE.options.managePrefix + '/lang/lines/many',
        data: {
          keys: langKeys,
        },
        success: function (result) {
          $.each(result, (key, arr) => {
            $.each(langs, function () {
              if (key === this.langKey) {
                this.lines = arr;
              }
            });
          });

          $.each(langs, function () {
            langEditorBoxRender(this, 'obj');
          });
        },
      });
    } else {
      $.each(langs, function () {
        langEditorBoxRender(this, 'obj');
      });
    }
  }

  validator.put('langrequired', function ($dst, parameters) {
    var $input = $dst.closest('.lang-editor-box').find("input[name^='xe_lang_preprocessor']:not(:hidden):first");

    return validator.validators.required($input, parameters);
  });
}

$(document).on('focus', '.lang-editor-box input, textarea', function () {
  var box = $(this).closest('.lang-editor-box');
  var el = box.find('.sub');
  if ($(el).is(':hidden')) {
    $(el).slideDown('fast');

    // todo: 기능 점검
    // $(box).find('textarea').expanding();
  }
});

