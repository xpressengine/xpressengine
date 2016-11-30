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

      if (this.props.langKey) {
        if (this.state.lines.length == 0) {
          $.ajax({
            type: 'get',
            dataType: 'json',
            url: xeBaseURL + '/' + XE.options.managePrefix + '/lang/lines/' + this.props.langKey,
            success: function (result) {
              if (this.isMounted()) {
                _this.setLines(result);
              }
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

window.langEditorBoxRender = function ($o) {
  var name = $o.data('name');
  var langKey = $o.data('lang-key');
  var multiline = $o.data('multiline');
  var lines = $o.data('lines');
  var autocomplete = $o.data('autocomplete');

  ReactDOM.render(<LangEditorBox name={name} langKey={langKey} multiline={multiline} lines={lines} autocomplete={autocomplete}/>, $o[0]);
};

$(function () {
  $('.lang-editor-box').each(function (i) {
    langEditorBoxRender($(this));
  });

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

