import griper from 'griper';
import moment from 'moment';

(function (root, factory) {
  module.exports = factory();
}(this, function () {

  /**
   * @module validator
   * */
  var Validator = {};
  Validator.rules = {};
  Validator.alertTypes = {};

  /**
   * 룰을 세팅한다.
   * @memberof module:validator
   * @param {string} ruleName
   * @param {object} rules
   * */
  Validator.setRules = function (ruleName, rules) {

    var lang = [];
    var langMap = {};
    $.each(rules, function (k, v) {
      var ruleList = v.split('|');

      $.each(ruleList, function (idx, val) {
        var langKey = val.split(':')[0].toLowerCase();

        if (langKey === 'langrequired') {
          langKey = 'required';
        }

        if (!Translator.hasMessage('validation.' + langKey) && !langMap.hasOwnProperty(langKey)) {
          langMap[langKey] = '';

          if (['min', 'max', 'between'].indexOf(langKey) != -1) {
            lang.push('validation.' + langKey + '.numeric');
            lang.push('validation.' + langKey + '.string');
            lang.push('validation.' + langKey + '.file');
          } else {
            lang.push('validation.' + langKey);
          }

        }
      });
    });

    if (lang.length > 0) {
      XE.Lang.requestTransAll(lang);
    }

    if (this.rules[ruleName] != undefined) {
      this.rules[ruleName] = $.extend(rules, this.rules[ruleName]);
    } else {
      this.rules[ruleName] = rules;

      // init form check event listner
      this.init(ruleName);
    }
  };

  /**
   * validator 를 set 하면서 submit event listener 를 등록한다.
   * @memberof module:validator
   * @param {string} ruleName
   * */
  Validator.init = function (ruleName) {
    $('[data-rule="' + ruleName + '"]').on('submit', function (event) {
      try {
        Validator.check($(this));
      } catch (e) {
        // validation 체크하면서 에러가 발생한 경우 다른 이벤트는 처리하지 않음
        event.preventDefault();
      }
    });
  };

  /**
   * 폼요소의 룰명을 리턴한다.
   * @memberof module:validator
   * @param {jQuery} $frm jQuery form element
   * @return {string}
   * */
  Validator.getRuleName = function ($frm) {
    return $frm.data('rule');
  };

  /**
   * 폼에 정의 된 룰을 실행한다.
   * @memberof module:validator
   * @param {jQuery} $frm jQuery form element
   * */
  Validator.check = function ($frm) {
    var ruleName = this.getRuleName($frm);
    var rules = this.rules[ruleName];
    var _this = this;

    $.each(rules, function (name, rule) {
      _this.validate($frm, name, rule);
    });

    this.checkRuleContainers($frm);
  };

  /**
   * 폼에 정의 된 룰을 실행한다.
   * @memberof module:validator
   * @param {jQuery} $frm jQuery form element
   * */
  Validator.checkRuleContainers = function ($frm) {
    var _this = this;
    var containers = $frm.find('[data-rule]');

    $.each(containers, function (index, container) {
      var ruleName = $(container).data('rule');
      var rules = _this.rules[ruleName];

      $.each(rules, function (name, rule) {
        _this.validate($frm, name, rule);
      });
    });
  };

  /**
   * 폼안의 요소에 정의된 룰을 실행한다.
   * @memberof module:validator
   * @param {jQuery} $frm jQuery form element
   * */
  Validator.formValidate = function ($form) {
    var _this = this;

    _this.errorClear($form);

    $form.find('[data-valid]').each(function () {
      var $this = $(this);
      var rule = $this.data('valid');
      var name = $this.attr('name');

      _this.validate($form, name, rule);
    });
  };

  /**
   * 폼 내의 name요소에 대한 rule을 실행한다.
   * @memberof module:validator
   * @param {jQuery} $frm jQuery form element
   * @param {string} name
   * @param {string} rule
   * @throws {Error} validation 실패시
   * */
  Validator.validate = function ($frm, name, rule) {
    var parts = rule.split('|');
    var _this = this;

    $frm.data('valid-result', true);

    $.each(parts, function (index, part) {
      var res = part.split(':');
      var command = res[0].toLowerCase();
      var parameters = res[1];

      if (typeof _this.validators[command] === 'function') {
        var $dst = $frm.find('[name="' + name + '"]');

        _this.errorClear($frm);
        if (_this.validators[command]($dst, parameters) === false) {
          $frm.data('valid-result', false);
          throw Error('Validation error.');

        }
      }
    });
  };

  Validator.extendAlertType = function (type, callback) {
    this.alertTypes[type] = callback;
  };

  /**
   * validator 추가
   * @memberof module:validator
   * @param {string} name validatior name
   * @param {function} callback validation 실패시 호출
   * */
  Validator.put = function (name, callback) {
    this.validators[name] = callback;
  };

  /**
   * validation 메시지 제거
   * @memberof module:validator
   * @param {jQuery} $form jQuery form element
   * */
  Validator.errorClear = function ($form) {
    griper.form.fn.clear($form);
  };

  /**
   * validation 실패 메시지를 노출한다.
   * @memberof module:validator
   * @param {jQuery} $element
   * @param {string} message
   * @param {object} replaceStrMap
   * */
  Validator.error = function ($element, message, replaceStrMap) {

    if (replaceStrMap && Object.keys(replaceStrMap).length > 0) {
      $.each(replaceStrMap, function (key, val) {
        message = message.replace(':' + key, val);
      });
    }

    var alertType = $element.closest('form').data('rule-alert-type') || 'form';

    if (typeof this.alertTypes[alertType] === 'function') {
      this.alertTypes[alertType]($element, message);
    } else if (alertType === 'form') {
      griper.form($element, message);
    } else if (alertType === 'toast') {
      griper.toast($element, message);
    }

  };

  /**
   * validation 엘리먼트 요소의 value를 리턴한다.
   * @memberof module:validator
   * @param {jQuery} $ele
   * @return {string}
   * */
  Validator.getValue = function ($ele) {
    var value = '';

    if ($ele[0].tagName === 'SELECT') {
      value = $ele.find('option:selected').val();

    } else if ($ele.is('input[type=checkbox]')) {
      if ($ele.is(':checked')) {
        value = $ele.val();
      }

    } else {
      value = $ele.val();
    }

    return value;
  };

  /**
   * validation 실패 메시지를 노출한다.
   * @memberof module:validator
   * @property {object} validator
   * @property {function} validator.accepted
   * @property {function} validator.checked
   * @property {function} validator.required
   * @property {function} validator.alpha
   * @property {function} validator.alphanum
   * @property {function} validator.alpha_num
   * @property {function} validator.alpha_dash
   * @property {function} validator.array
   * @property {function} validator.boolean
   * @property {function} validator.date
   * @property {function} validator.date_format
   * @property {function} validator.digits
   * @property {function} validator.digits_between
   * @property {function} validator.filled
   * @property {function} validator.integer
   * @property {function} validator.ip
   * @property {function} validator.mimes
   * @property {function} validator.regex
   * @property {function} validator.json
   * @property {function} validator.string
   * @property {function} validator.min
   * @property {function} validator.max
   * @property {function} validator.email
   * @property {function} validator.url
   * @property {function} validator.numeric
   * @property {function} validator.between
   * */
  Validator.validators = {
    accepted: function ($dst, parameters) {
      var value = Validator.getValue($dst);

      if (['yes', 'on', 1, true].indexOf(value) === -1) {
        Validator.error($dst, XE.Lang.trans('validation.accepted', { attribute: $dst.data('valid-name') || $dst.attr('name') }));
        return false;
      }

      return true;
    },

    checked: function ($dst, parameters) {
      var name = $dst.attr('name');
      var min = parameters.split('-')[0];
      var max = parameters.split('-')[1];

      var checkedLenth = $dst.clone().wrap('<div />').parent().find(':checked').length;

      if (checkedLenth < parseInt(min, 10) || checkedLenth > parseInt(max, 10)) {

        var messageType = 'xe::validatorChecked';

        if (!max) {
          messageType = 'xe::validatorCheckedMin';
        } else if (min == 0) {
          messageType = 'xe::validatorCheckedMax';
        }

        Validator.error($dst, XE.Lang.trans(messageType));
        return false;
      }

      return true;
    },

    required: function ($dst, parameters) {
      var value = Validator.getValue($dst);

      if (value === '') {
        Validator.error($dst, XE.Lang.trans('validation.required', { attribute: $dst.data('valid-name') || $dst.attr('name') }));
        return false;
      }

      return true;
    },

    alpha: function ($dst, parameters) {
      var value = Validator.getValue($dst);
      var pattern = /[a-zA-Z]/;

      if (!pattern.test(value)) {
        Validator.error($dst, XE.Lang.trans('validation.alpha', { attribute: $dst.data('valid-name') || $dst.attr('name') }));
        return false;
      }

      return true;
    },

    alphanum: function ($dst, parameters) {
      return Validator.validators.alpha_num($dst, parameters, true);
    },

    alpha_num: function ($dst, parameters, trigger) {
      var value = Validator.getValue($dst);
      var pattern = /[^a-zA-Z0-9]/;

      if (pattern.test(value) === true) {
        var langKey = '';

        if (trigger) {
          langKey = 'validation.alphanum';
        } else {
          langKey = 'validation.alpha_num';
        }

        Validator.error($dst, XE.Lang.trans(langKey, { attribute: $dst.data('valid-name') || $dst.attr('name') }));

        return false;
      }

      return true;
    },

    alpha_dash: function ($dst, parameters) {
      var value = Validator.getValue($dst);
      var pattern = /[^a-zA-Z0-9\-\_]/;

      if (pattern.test(value)) {
        Validator.error($dst, XE.Lang.trans('validation.alpha_dash', { attribute: $dst.data('valid-name') || $dst.attr('name') }));
        return false;
      }

      return true;
    },

    array: function ($dst, parameters) {
      if (Array.isArray(Validator.getValue($dst))) {
        Validator.error($dst, XE.Lang.trans('validation.array', { attribute: $dst.data('valid-name') || $dst.attr('name') }));
        return false;
      }

      return true;
    },

    boolean: function ($dst, parameters) {
      var value = Validator.getValue($dst);

      if ([1, 0, '1', '0', true, false, 'true', 'false'].indexOf(value) === -1) {
        Validator.error($dst, XE.Lang.trans('validation.boolean', { attribute: $dst.data('valid-name') || $dst.attr('name') }));
        return false;
      }

      return true;
    },

    date: function ($dst, parameters) {
      if (!Utils.strtotime(Validator.getValue($dst))) {
        Validator.error($dst, XE.Lang.trans('validation.date', { attribute: $dst.data('valid-name') || $dst.attr('name') }));
        return false;
      }

      return true;
    },

    date_format: function ($dst, parameters) {
      //moment('2015-04-03', 'yyyy-mm-dd').isValid()
      if (!moment(Validator.getValue($dst), parameters).isValid()) {
        Validator.error($dst, XE.Lang.trans('validation.date_format', {
          attribute: $dst.data('valid-name') || $dst.attr('name'),
          format: parameters,
        }));
        return false;
      }

      return true;
    },

    digits: function ($dst, parameters) {
      var value = Validator.getValue($dst);
      var pattern = /[^0-9]/;
      var size = parseInt(parameters);

      if (pattern.test(value) || $dst.val().toString().length !== size) {
        Validator.error($dst, XE.Lang.trans('validation.digits', {
          attribute: $dst.data('valid-name') || $dst.attr('name'),
          digits: Utils.addCommas(size),
        }));
        return false;
      }

      return true;
    },

    digits_between: function ($dst, parameters) {
      var value = Validator.getValue($dst);
      var range = parameters.split(',');
      var size = value.toString().length;

      if (range[0] > size && size < range[1]) {
        Validator.error($dst, XE.Lang.trans('validation.digits_between', {
          attribute: $dst.data('valid-name') || $dst.attr('name'),
          min: Utils.addCommas(range[0]),
          max: Utils.addCommas(range[1]),
        }));

        return false;
      }

      return true;
    },

    filled: function ($dst, parameters) {
      if (Validator.getValue($dst) === '') {
        Validator.error($dst, XE.Lang.trans('validation.filled', { attribute: $dst.attr('name') }));
        return false;
      }

      return true;
    },

    integer: function ($dst) {
      var value = Validator.getValue($dst);

      if (typeof value !== 'number' || isNaN(value) || Math.floor(value) !== value || !$.isNumeric(value)) {
        Validator.error($dst, XE.Lang.trans('validation.integer', { attribute: $dst.data('valid-name') || $dst.attr('name') }));
        return false;
      }

      return true;
    },

    ip: function ($dst) {
      var value = Validator.getValue($dst);
      var exp = /^(1|2)?\d?\d([.](1|2)?\d?\d){3}$/;

      if (!exp.test(value)) {
        Validator.error($dst, XE.Lang.trans('validation.ip', { attribute: $dst.data('valid-name') || $dst.attr('name') }));
        return false;
      }

      return true;
    },

    // ipv4: function ($dst) {
    //   var value = $dst.val();
    //   var exp = /^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$|^(([a-zA-Z]|[a-zA-Z][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z]|[A-Za-z][A-Za-z0-9\-]*[A-Za-z0-9])$|^\s*((([0-9A-Fa-f]{1,4}:){7}([0-9A-Fa-f]{1,4}|:))|(([0-9A-Fa-f]{1,4}:){6}(:[0-9A-Fa-f]{1,4}|((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){5}(((:[0-9A-Fa-f]{1,4}){1,2})|:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){4}(((:[0-9A-Fa-f]{1,4}){1,3})|((:[0-9A-Fa-f]{1,4})?:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){3}(((:[0-9A-Fa-f]{1,4}){1,4})|((:[0-9A-Fa-f]{1,4}){0,2}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){2}(((:[0-9A-Fa-f]{1,4}){1,5})|((:[0-9A-Fa-f]{1,4}){0,3}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){1}(((:[0-9A-Fa-f]{1,4}){1,6})|((:[0-9A-Fa-f]{1,4}){0,4}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(:(((:[0-9A-Fa-f]{1,4}){1,7})|((:[0-9A-Fa-f]{1,4}){0,5}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:)))(%.+)?\s*$/;
    //
    //   if (!exp.test(value)) {
    //     Validator.error($dst, XE.Lang.trans('validation.ipv4'));
    //     return false;
    //   }
    //
    //   return true;
    // },
    //
    // ipv6: function ($dst) {
    //   var value = $dst.val();
    //   var exp = /^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$|^(([a-zA-Z]|[a-zA-Z][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z]|[A-Za-z][A-Za-z0-9\-]*[A-Za-z0-9])$|^\s*((([0-9A-Fa-f]{1,4}:){7}([0-9A-Fa-f]{1,4}|:))|(([0-9A-Fa-f]{1,4}:){6}(:[0-9A-Fa-f]{1,4}|((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){5}(((:[0-9A-Fa-f]{1,4}){1,2})|:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){4}(((:[0-9A-Fa-f]{1,4}){1,3})|((:[0-9A-Fa-f]{1,4})?:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){3}(((:[0-9A-Fa-f]{1,4}){1,4})|((:[0-9A-Fa-f]{1,4}){0,2}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){2}(((:[0-9A-Fa-f]{1,4}){1,5})|((:[0-9A-Fa-f]{1,4}){0,3}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){1}(((:[0-9A-Fa-f]{1,4}){1,6})|((:[0-9A-Fa-f]{1,4}){0,4}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(:(((:[0-9A-Fa-f]{1,4}){1,7})|((:[0-9A-Fa-f]{1,4}){0,5}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:)))(%.+)?\s*$/;
    //
    //   if (!exp.test(value)) {
    //     Validator.error($dst, XE.Lang.trans('validation.ipv6'));
    //     return false;
    //   }
    //
    //   return true;
    // },

    mimes: function ($dst, parameters) {
      var value = Validator.getValue($dst);
      var exts = parameters.split(',');

      if (value === '' || exts.indexOf(value.split('.').pop()) === -1) {
        Validator.error($dst, XE.Lang.trans('validation.mimes', {
          attribute: $dst.data('valid-name') || $dst.attr('name'),
          values: '[' + parameters + ']',
        }));
        return false;
      }

      return true;
    },

    // nullable: function ($dst) {
    //   var value = $dst.val();
    //
    //   if (value != null) {
    //     Validator.error($dst, XE.Lang.trans('validation.nullable'));
    //     return false;
    //   }
    //
    //   return true;
    // },

    regex: function ($dst, pattern) {

      if (!pattern.text(Validator.getValue($dst))) {
        Validator.error($dst, XE.Lang.trans('validation.regex', { attribute: $dst.data('valid-name') || $dst.attr('name') }));
        return false;
      }

      return true;
    },

    json: function ($dst) {
      try {
        JSON.parse(Validator.getValue($dst));
        return true;

      }catch (e) {
        Validator.error($dst, XE.Lang.trans('validation.json', { attribute: $dst.data('valid-name') || $dst.attr('name') }));
        return false;
      }
    },

    string: function ($dst) {
      if (typeof Validator.getValue($dst) !== 'string') {
        Validator.error($dst, XE.Lang.trans('validation.string', { attribute: $dst.data('valid-name') || $dst.attr('name') }));
        return false;
      }

      return true;
    },

    min: function ($dst, parameters) {
      var value = Validator.getValue($dst);
      var type = $dst.data('valid-type');

      switch (type) {
        case 'numeric':
          if (parseInt(value) <= parseInt(parameters)) {
            Validator.error($dst, XE.Lang.trans('validation.min.numeric', {
              attribute: $dst.data('valid-name') || $dst.attr('name'),
              min: Utils.addCommas(parameters),
            }));

            return false;
          }

          break;

        case 'file':
          if ($dst[0].files[0] && ($dst[0].files[0].size / 1024) <= parseInt(parameters)) {
            Validator.error($dst, XE.Lang.trans('validation.min.file', {
              attribute: $dst.data('valid-name') || $dst.attr('name'),
              min: Utils.addCommas(parameters),
            }));

            return false;
          }

          break;

        case 'string':
          if (value.length <= parseInt(parameters)) {
            Validator.error($dst, XE.Lang.trans('validation.min.string', {
              attribute: $dst.data('valid-name') || $dst.attr('name'),
              min: Utils.addCommas(parameters),
            }));

            return false;
          }

          break;

        default:
          if (value.length <= parseInt(parameters)) {
            Validator.error($dst, XE.Lang.transChoice('xe::validatorMin', parameters, { charCount: Utils.addCommas(parameters) }));
            return false;
          }
      }

      return true;
    },

    max: function ($dst, parameters) {
      var value = Validator.getValue($dst);
      var type = $dst.data('valid-type');

      switch (type) {
        case 'numeric':
          if (parseInt(value) >= parseInt(parameters)) {
            Validator.error($dst, XE.Lang.trans('validation.max.numeric', {
              attribute: $dst.data('valid-name') || $dst.attr('name'),
              max: Utils.addCommas(parameters),
            }));

            return false;
          }

          break;

        case 'file':
          if ($dst[0].files[0] && ($dst[0].files[0].size / 1024) >= parseInt(parameters)) {
            Validator.error($dst, XE.Lang.trans('validation.max.file', {
              attribute: $dst.data('valid-name') || $dst.attr('name'),
              max: Utils.addCommas(parameters),
            }));

            return false;
          }

          break;

        case 'string':
          if (value.length >= parseInt(parameters)) {
            Validator.error($dst, XE.Lang.trans('validation.max.string', {
              attribute: $dst.data('valid-name') || $dst.attr('name'),
              max: Utils.addCommas(parameters),
            }));

            return false;
          }

          break;

      }

      return true;
    },

    email: function ($dst, parameters) {
      var val = Validator.getValue($dst);
      var re = /\w+@\w{2,}\.\w{2,}/;

      if (!val.match(re)) {
        Validator.error($dst, XE.Lang.trans('validation.email', { attribute: $dst.data('valid-name') || $dst.attr('name') }));
        return false;
      }

      return true;
    },

    url: function ($dst, parameters) {
      var val = Validator.getValue($dst);
      var re = /^https?:\/\/\S+/;

      if (!val.match(re)) {
        Validator.error($dst, XE.Lang.trans('validation.url', { attribute: $dst.data('valid-name') || $dst.attr('name') }));
        return false;
      }

      return true;
    },

    numeric: function ($dst, parameters) {
      var val = Validator.getValue($dst);
      var num = Number(val);

      if (typeof num === 'number' && !isNaN(num) && typeof val !== 'boolean') {
        return true;
      } else {
        Validator.error($dst, XE.Lang.trans('validation.numeric', { attribute: $dst.data('valid-name') || $dst.attr('name') }));
        return false;
      }
    },

    between: function ($dst, parameters) {
      var range = parameters.split(',');
      var value = Validator.getValue($dst);
      var type = $dst.data('valid-type');

      switch (type) {
        case 'numeric':
          if (!$.isNumeric(value) || parseInt(value) < parseInt(range[0]) || parseInt(value) > parseInt(range[1])) {
            Validator.error($dst, XE.Lang.trans('validation.between.numeric', {
              attribute: $dst.data('valid-name') || $dst.attr('name'),
              min: Utils.addCommas(range[0]),
              max: Utils.addCommas(range[1]),
            }));

            return false;
          }

          break;

        case 'file':
          if ($dst[0].files[0] && ((($dst[0].files[0].size / 1024) < range[0]) || (($dst[0].files[0].size / 1024) > range[1]))) {
            Validator.error($dst, XE.Lang.trans('validation.between.file', {
              attribute: $dst.data('valid-name') || $dst.attr('name'),
              min: Utils.addCommas(range[0]),
              max: Utils.addCommas(range[1]),
            }));

            return false;
          }

          break;

        case 'string':
          if (value.length < range[0] || value.length > range[1]) {
            Validator.error($dst, XE.Lang.trans('validation.between.string', {
              attribute: $dst.data('valid-name') || $dst.attr('name'),
              min: Utils.addCommas(range[0]),
              max: Utils.addCommas(range[1]),
            }));

            return false;
          }

          break;

        default:
          if (value.length <= parseInt(range[0]) || value.length >= parseInt(range[1])) {
            Validator.error($dst, XE.Lang.trans('xe::validatorBetween', { between: parameters }));
            return false;
          }
      }
    },
  };

  $(function () {
    $('form[data-rule]').each(function () {
      if (window.hasOwnProperty('ruleSet')) {
        Validator.setRules(ruleSet.ruleName, ruleSet.rules);
      }
    });
  });

  return Validator;

}));

