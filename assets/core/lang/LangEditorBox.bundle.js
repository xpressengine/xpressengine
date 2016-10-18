System.amdRequire(['vendor:/react', 'vendor:/react-dom'], function(React, ReactDOM) {
  var LangEditorBox = React.createClass({displayName: "LangEditorBox",
    getDefaultProps: function () {
      return {
        name: '',
        langKey: '',
        multiline: false,
        lines: [],
        autocomplete: false
      };
    },
    render: function () {
      LangEditor.seq++;
      return (
          React.createElement(LangEditor, {
              key: LangEditor.seq, 
              seq: LangEditor.seq, 
              name: this.props.name, 
              langKey: this.props.langKey, 
              multiline: this.props.multiline, 
              lines: this.props.lines, 
              autocomplete: this.props.autocomplete}
          )
      );
    }
  });

  var LangEditor = React.createClass({displayName: "LangEditor",
    statics: {seq: 0},
    getInitialState: function () {
      var lines = this.props.lines || [];
      return {lines: lines};
    },
    setLines: function (lines) {
      var self = this;
      self.setState({lines: lines});
      XE.Lang.locales.map(function (locale) {
        var selector = '#input-' + self.props.seq + '-' + locale,
            value = self.getValueFromLinesWithLocale(locale);
        $(selector).val(value);
      });
    },
    getValueFromLinesWithLocale: function (locale) {
      var lines = this.state.lines,
          i = lines.length,
          l = {};
      while (i--) {
        l = lines[i];
        if (l['locale'] == locale) {
          return l['value'];
        }
      }
      return "";
    },
    componentDidMount: function () {
      if (this.isMounted()) {
        var self = this;
        var el = ReactDOM.findDOMNode(this);

        if ( this.props.langKey ) {
          if ( this.state.lines.length == 0 ) {
            $.ajax({
              type: 'get',
              dataType: 'json',
              url: xeBaseURL + '/' + XE.options.managePrefix + '/lang/lines/' + this.props.langKey,
              success: function(result) {
                if (this.isMounted()) { self.setLines(result); }
              }.bind(this)
            });
          }
        }

        if (this.props.autocomplete) {
          $(el).find('input[type=text]:first,textarea:first').autocomplete({
            source: '/' + XE.options.managePrefix + '/lang/search/' + XE.Lang.locales[0],
            minLength: 1,
            focus: function(event, ui) { event.preventDefault(); },
            select: function(event, ui) { self.setLines(ui.item.lines); }
          });
        }
      }
    },
    // getFlagClass: function (locale) {
    //     var code = XE.Lang.getLangCode(locale),
    //         arr = code.split('-'),
    //         keyword = arr[1].toLowerCase();
    //
    //     return 'flag ' + keyword;
    // },
    getEditor: function (resource, locale, value) {
      var edit = null,
          id = ('input-' + this.props.seq + '-' + locale),
          name = (resource + '/locale/' + locale);

      if (!this.props.multiline) {
        edit = React.createElement("input", {type: "text", className: "form-control", id: id, name: name, defaultValue: value});
      } else {
        edit = React.createElement("textarea", {className: "form-control", id: id, name: name, defaultValue: value});
      }
      return edit;
    },
    render: function () {
      var self = this,
          locale = XE.Lang.locales[0],
          fallback = XE.Lang.locales.slice(1),
          resource = 'xe_lang_preprocessor://lang/seq/' + this.props.seq,
          value = this.getValueFromLinesWithLocale(locale),
          inputClass = this.props.multiline ? 'textarea' : 'text';

      var multiline = this.props.multiline
          ? React.createElement("input", {type: "hidden", name: resource + '/multiline', defaultValue: "true"})
          : null;

      return (
          React.createElement("div", {className: inputClass}, 
            React.createElement("input", {type: "hidden", name: "xe_use_request_preprocessor", value: "Y"}), 
            React.createElement("input", {type: "hidden", name: resource + '/name', defaultValue: this.props.name}), 
            React.createElement("input", {type: "hidden", name: resource + '/key', defaultValue: this.props.langKey}), 
            multiline, 
            React.createElement("input", {type: "hidden", name: this.props.name, defaultValue: this.props.langKey}), 
            React.createElement("div", {key: locale, className: "input-group"}, 
              self.getEditor(resource, locale, value), 
                React.createElement("span", {className: "input-group-addon"}, 
                React.createElement("span", {className: "flag-code"}, React.createElement("i", {className: locale + ' xe-flag'}), locale)
                )
            ), 
            React.createElement("div", {className: "sub"}, 
              fallback.map(function (locale, i) {
                var value = self.getValueFromLinesWithLocale(locale);
                return (
                    React.createElement("div", {key: locale, className: "input-group"}, 
                      self.getEditor(resource, locale, value), 
                    React.createElement("span", {className: "input-group-addon"}, 
                    React.createElement("span", {className: "flag-code"}, React.createElement("i", {className: locale + ' xe-flag'}), locale)
                    )
                    )
                );
              })
            )
          )
      );
    }
  });

  window.langEditorBoxRender = function ($o) {
    var name = $o.data('name'),
        langKey = $o.data('lang-key'),
        multiline = $o.data('multiline'),
        lines = $o.data('lines'),
        autocomplete = $o.data('autocomplete');

    ReactDOM.render(React.createElement(LangEditorBox, {name: name, langKey: langKey, multiline: multiline, lines: lines, 
                                   autocomplete: autocomplete}), $o[0]);
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

    System.import('xecore:/common/js/validator').then(function(validator) {
      validator.put("langrequired", function ($dst, parameters) {
        var $input = $dst.closest('.lang-editor-box').find("input[name^='xe_lang_preprocessor']:not(:hidden):first");

        return validator.validators.required($input, parameters);
      });
    });
  });
});
