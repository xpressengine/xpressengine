!function(e){function r(e,r,o){return 4===arguments.length?t.apply(this,arguments):void n(e,{declarative:!0,deps:r,declare:o})}function t(e,r,t,o){n(e,{declarative:!1,deps:r,executingRequire:t,execute:o})}function n(e,r){r.name=e,e in v||(v[e]=r),r.normalizedDeps=r.deps}function o(e,r){if(r[e.groupIndex]=r[e.groupIndex]||[],-1==g.call(r[e.groupIndex],e)){r[e.groupIndex].push(e);for(var t=0,n=e.normalizedDeps.length;n>t;t++){var a=e.normalizedDeps[t],u=v[a];if(u&&!u.evaluated){var d=e.groupIndex+(u.declarative!=e.declarative);if(void 0===u.groupIndex||u.groupIndex<d){if(void 0!==u.groupIndex&&(r[u.groupIndex].splice(g.call(r[u.groupIndex],u),1),0==r[u.groupIndex].length))throw new TypeError("Mixed dependency cycle detected");u.groupIndex=d}o(u,r)}}}}function a(e){var r=v[e];r.groupIndex=0;var t=[];o(r,t);for(var n=!!r.declarative==t.length%2,a=t.length-1;a>=0;a--){for(var u=t[a],i=0;i<u.length;i++){var s=u[i];n?d(s):l(s)}n=!n}}function u(e){return y[e]||(y[e]={name:e,dependencies:[],exports:{},importers:[]})}function d(r){if(!r.module){var t=r.module=u(r.name),n=r.module.exports,o=r.declare.call(e,function(e,r){if(t.locked=!0,"object"==typeof e)for(var o in e)n[o]=e[o];else n[e]=r;for(var a=0,u=t.importers.length;u>a;a++){var d=t.importers[a];if(!d.locked)for(var i=0;i<d.dependencies.length;++i)d.dependencies[i]===t&&d.setters[i](n)}return t.locked=!1,r},r.name);t.setters=o.setters,t.execute=o.execute;for(var a=0,i=r.normalizedDeps.length;i>a;a++){var l,s=r.normalizedDeps[a],c=v[s],f=y[s];f?l=f.exports:c&&!c.declarative?l=c.esModule:c?(d(c),f=c.module,l=f.exports):l=p(s),f&&f.importers?(f.importers.push(t),t.dependencies.push(f)):t.dependencies.push(null),t.setters[a]&&t.setters[a](l)}}}function i(e){var r,t=v[e];if(t)t.declarative?f(e,[]):t.evaluated||l(t),r=t.module.exports;else if(r=p(e),!r)throw new Error("Unable to load dependency "+e+".");return(!t||t.declarative)&&r&&r.__useDefault?r["default"]:r}function l(r){if(!r.module){var t={},n=r.module={exports:t,id:r.name};if(!r.executingRequire)for(var o=0,a=r.normalizedDeps.length;a>o;o++){var u=r.normalizedDeps[o],d=v[u];d&&l(d)}r.evaluated=!0;var c=r.execute.call(e,function(e){for(var t=0,n=r.deps.length;n>t;t++)if(r.deps[t]==e)return i(r.normalizedDeps[t]);throw new TypeError("Module "+e+" not declared as a dependency.")},t,n);c&&(n.exports=c),t=n.exports,t&&t.__esModule?r.esModule=t:r.esModule=s(t)}}function s(r){var t={};if(("object"==typeof r||"function"==typeof r)&&r!==e)if(m)for(var n in r)"default"!==n&&c(t,r,n);else{var o=r&&r.hasOwnProperty;for(var n in r)"default"===n||o&&!r.hasOwnProperty(n)||(t[n]=r[n])}return t["default"]=r,x(t,"__useDefault",{value:!0}),t}function c(e,r,t){try{var n;(n=Object.getOwnPropertyDescriptor(r,t))&&x(e,t,n)}catch(o){return e[t]=r[t],!1}}function f(r,t){var n=v[r];if(n&&!n.evaluated&&n.declarative){t.push(r);for(var o=0,a=n.normalizedDeps.length;a>o;o++){var u=n.normalizedDeps[o];-1==g.call(t,u)&&(v[u]?f(u,t):p(u))}n.evaluated||(n.evaluated=!0,n.module.execute.call(e))}}function p(e){if(I[e])return I[e];if("@node/"==e.substr(0,6))return D(e.substr(6));var r=v[e];if(!r)throw"Module "+e+" not present.";return a(e),f(e,[]),v[e]=void 0,r.declarative&&x(r.module.exports,"__esModule",{value:!0}),I[e]=r.declarative?r.module.exports:r.esModule}var v={},g=Array.prototype.indexOf||function(e){for(var r=0,t=this.length;t>r;r++)if(this[r]===e)return r;return-1},m=!0;try{Object.getOwnPropertyDescriptor({a:0},"a")}catch(h){m=!1}var x;!function(){try{Object.defineProperty({},"a",{})&&(x=Object.defineProperty)}catch(e){x=function(e,r,t){try{e[r]=t.value||t.get.call(e)}catch(n){}}}}();var y={},D="undefined"!=typeof System&&System._nodeRequire||"undefined"!=typeof require&&require.resolve&&"undefined"!=typeof process&&require,I={"@empty":{}};return function(e,n,o,a){return function(u){u(function(u){for(var d={_nodeRequire:D,register:r,registerDynamic:t,get:p,set:function(e,r){I[e]=r},newModule:function(e){return e}},i=0;i<n.length;i++)(function(e,r){r&&r.__esModule?I[e]=r:I[e]=s(r)})(n[i],arguments[i]);a(d);var l=p(e[0]);if(e.length>1)for(var i=1;i<e.length;i++)p(e[i]);return o?l["default"]:l})}}}("undefined"!=typeof self?self:global)

(["1"], [], true, function($__System) {
var require = this.require, exports = this.exports, module = this.module;
$__System.registerDynamic("1", [], true, function($__require, exports, module) {
  ;
  var define,
      global = this,
      GLOBAL = this;
  var LangEditorBox = React.createClass({
    displayName: "LangEditorBox",
    getDefaultProps() {
      return {
        name: '',
        langKey: '',
        multiline: false,
        lines: [],
        autocomplete: false
      };
    },
    render: function() {
      LangEditor.seq++;
      return (React.createElement(LangEditor, {
        key: LangEditor.seq,
        seq: LangEditor.seq,
        name: this.props.name,
        langKey: this.props.langKey,
        multiline: this.props.multiline,
        lines: this.props.lines,
        autocomplete: this.props.autocomplete
      }));
    }
  });
  var LangEditor = React.createClass({
    displayName: "LangEditor",
    statics: {seq: 0},
    getInitialState: function() {
      var lines = this.props.lines || [];
      return {lines: lines};
    },
    setLines: function(lines) {
      var self = this;
      self.setState({lines: lines});
      XE.Lang.locales.map(function(locale) {
        var selector = '#input-' + self.props.seq + '-' + locale,
            value = self.getValueFromLinesWithLocale(locale);
        $(selector).val(value);
      });
    },
    getValueFromLinesWithLocale: function(locale) {
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
    componentDidMount: function() {
      if (this.isMounted()) {
        var self = this;
        var el = this.getDOMNode();
        if (this.props.langKey) {
          if (this.state.lines.length == 0) {
            $.ajax({
              type: 'get',
              dataType: 'json',
              url: '/' + XE.options.managePrefix + '/lang/lines/' + this.props.langKey,
              success: function(result) {
                if (this.isMounted()) {
                  self.setLines(result);
                }
              }.bind(this)
            });
          }
        }
        if (this.props.autocomplete) {
          $(el).find('input[type=text]:first,textarea:first').autocomplete({
            source: '/' + XE.options.managePrefix + '/lang/search/' + XE.Lang.locales[0],
            minLength: 1,
            focus: function(event, ui) {
              event.preventDefault();
            },
            select: function(event, ui) {
              self.setLines(ui.item.lines);
            }
          });
        }
      }
    },
    getEditor: function(resource, locale, value) {
      var edit = null,
          id = ('input-' + this.props.seq + '-' + locale),
          name = (resource + '/locale/' + locale);
      if (!this.props.multiline) {
        edit = React.createElement("input", {
          type: "text",
          className: "form-control",
          id: id,
          name: name,
          defaultValue: value
        });
      } else {
        edit = React.createElement("textarea", {
          className: "form-control",
          id: id,
          name: name,
          defaultValue: value
        });
      }
      return edit;
    },
    render: function() {
      var self = this,
          locale = XE.Lang.locales[0],
          fallback = XE.Lang.locales.slice(1),
          resource = 'xe_lang_preprocessor://lang/seq/' + this.props.seq,
          value = this.getValueFromLinesWithLocale(locale),
          inputClass = this.props.multiline ? 'textarea' : 'text';
      var multiline = this.props.multiline ? React.createElement("input", {
        type: "hidden",
        name: resource + '/multiline',
        defaultValue: "true"
      }) : null;
      return (React.createElement("div", {className: inputClass}, React.createElement("input", {
        type: "hidden",
        name: "xe_use_request_preprocessor",
        value: "Y"
      }), React.createElement("input", {
        type: "hidden",
        name: resource + '/name',
        defaultValue: this.props.name
      }), React.createElement("input", {
        type: "hidden",
        name: resource + '/key',
        defaultValue: this.props.langKey
      }), multiline, React.createElement("input", {
        type: "hidden",
        name: this.props.name,
        defaultValue: this.props.langKey
      }), React.createElement("div", {
        key: locale,
        className: "input-group"
      }, self.getEditor(resource, locale, value), React.createElement("span", {className: "input-group-addon"}, React.createElement("span", {className: "flag-code"}, React.createElement("i", {className: locale + ' flag'}), locale))), React.createElement("div", {className: "sub"}, fallback.map(function(locale, i) {
        var value = self.getValueFromLinesWithLocale(locale);
        return (React.createElement("div", {
          key: locale,
          className: "input-group"
        }, self.getEditor(resource, locale, value), React.createElement("span", {className: "input-group-addon"}, React.createElement("span", {className: "flag-code"}, React.createElement("i", {className: locale + ' flag'}), locale))));
      }))));
    }
  });
  window.langEditorBoxRender = function($o) {
    var name = $o.data('name'),
        langKey = $o.data('lang-key'),
        multiline = $o.data('multiline'),
        lines = $o.data('lines'),
        autocomplete = $o.data('autocomplete');
    React.render(React.createElement(LangEditorBox, {
      name: name,
      langKey: langKey,
      multiline: multiline,
      lines: lines,
      autocomplete: autocomplete
    }), $o[0]);
  };
  $(function() {
    $('.lang-editor-box').each(function(i) {
      langEditorBoxRender($(this));
    });
    $(document).on('focus', '.lang-editor-box input, textarea', function() {
      var box = $(this).closest('.lang-editor-box');
      var el = box.find('.sub');
      if ($(el).is(':hidden')) {
        $(el).slideDown('fast');
      }
    });
    System.import('xecore:/common/js/modules/validator').then(function(validator) {
      validator.put("langrequired", function($dst, parameters) {
        var $input = $dst.closest('.lang-editor-box').find("input[name^='xe_lang_preprocessor']:not(:hidden):first");
        return validator.validators.required($input, parameters);
      });
    });
  });
  return module.exports;
});

})
(function(factory) {
  factory();
});