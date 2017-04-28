import React from 'react';
import ReactDOM from 'react-dom';

import validator from 'validator';

var LangEditorBox = React.createClass({
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

var LangEditor = React.createClass({
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
    if (this.isMounted()) {
      var _this = this;
      var el = ReactDOM.findDOMNode(this);

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
    }
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

window.langEditorBoxRender = function ({ name, langKey, multiline, lines, autocomplete, target }) {
  ReactDOM.render(<LangEditorBox name={name} langKey={langKey} multiline={multiline} lines={lines} autocomplete={autocomplete}/>, target);
};

$(function () {

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
            langEditorBoxRender(this);
          });
        },
      });
    } else {
      $.each(langs, function () {
        langEditorBoxRender(this);
      });
    }
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

  validator.put('langrequired', function ($dst, parameters) {
    var $input = $dst.closest('.lang-editor-box').find("input[name^='xe_lang_preprocessor']:not(:hidden):first");

    return validator.validators.required($input, parameters);
  });
});

