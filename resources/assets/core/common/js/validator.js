import griper from 'griper';
import moment from 'moment';

(function (root, factory) {
  module.exports = factory();
}(this, function () {

  var Validator = {};
  Validator.rules = {};
  Validator.alertType = 'form';

  Validator.setRules = function (ruleName, rules) {
    if (this.rules[ruleName] != undefined) {
      this.rules[ruleName] = $.extend(rules, this.rules[ruleName]);
    } else {
      this.rules[ruleName] = rules;

      // init form check event listner
      this.init(ruleName);
    }
  };

  // validator 를 set 하면서 submit event listener 를 등록한다.
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

  Validator.getRuleName = function ($frm) {
    return $frm.data('rule');
  };

  Validator.check = function ($frm) {
    var ruleName = this.getRuleName($frm);
    var rules = this.rules[ruleName];
    var _this = this;
    var alertType = $frm.data('rule-alert-type');

    if (alertType == undefined) {
      alertType = 'form';
    }

    _this.alertType = alertType;

    $.each(rules, function (name, rule) {
      _this.validate($frm, name, rule);
    });

    this.checkRuleContainers($frm);
  };

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

  Validator.formValidate = function ($form) {
    var _this = this;

    Validator.alertType = $form.data('rule-alert-type') || 'toast';
    _this.errorClear($form);

    $form.find('[data-valid]').each(function () {
      var $this = $(this);
      var rule = $this.data('valid');
      var name = $this.attr('name');

      _this.validate($form, name, rule);
    });
  };

  Validator.validate = function ($frm, name, rule) {
    var parts = rule.split('|');
    var _this = this;

    $.each(parts, function (index, part) {
      var res = part.split(':');
      var command = res[0].toLowerCase();
      var parameters = res[1];

      if (typeof _this.validators[command] === 'function') {
        var $dst = $frm.find('[name="' + name + '"]');
        _this.errorClear($frm);
        if (_this.validators[command]($dst, parameters) === false) {
          throw Error('Validation error.');
        }
      }
    });
  };

  // validator 추가
  Validator.put = function (name, callback) {
    this.validators[name] = callback;
  };

  Validator.errorClear = function ($form) {
    griper.form.fn.clear($form);
  };

  Validator.error = function ($element, message) {
    if (this.alertType == 'form') {
      griper.form($element, message);

    } else if (this.alertType == 'toast') {
      var typeName = $element.attr('placeholder');
      if (typeName == undefined) {
        typeName = $element.attr('name');
      }

      message = '[' + typeName + '] ' + message;
      griper.toast($element, message);

    }

  };

  Validator.validators = {
    accepted: function ($dst, parameters) {
      var value = $dst.val();

      if (['yes', 'on', 1, true].indexOf(value) === -1) {
        Validator.error($dst, XE.Lang.trans('xe::validatorAccepted'));
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
      var value = $dst.val();
      if (value === '') {
        Validator.error($dst, XE.Lang.trans('xe::validatorRequired'));
        return false;
      }

      return true;
    },

    alpha: function ($dst, parameters) {
      var value = $dst.val();
      var pattern = /[a-zA-Z]/;

      if (!pattern.test(value)) {
        Validator.error($dst, XE.Lang.trans('xe::validatorAlpha')); //TODO 번역 넣어야함
        return false;
      }

      return true;
    },

    alphanum: function ($dst, parameters) {
      Validator.validators.alpha_num($dst, parameters);
    },

    alpha_num: function ($dst, parameters) {
      var value = $dst.val();
      var pattern = /[^a-zA-Z0-9]/;

      if (pattern.test(value) === true) {
        Validator.error($dst, XE.Lang.trans('xe::validatorAlphanum'));
        return false;
      }

      return true;
    },

    alpha_dash: function ($dst, parameters) {
      var value = $dst.val();
      var pattern = /[^a-zA-Z0-9\-\_]/;

      if (pattern.test(value)) {
        Validator.error($dst, XE.Lang.trans('xe::validatorAlphaDash'));
        return false;
      }

      return true;
    },

    array: function ($dst, parameters) {
      if (Array.isArray($dst.val())) {
        Validator.error($dst, XE.Lang.trans('xe::validatorArray'));
        return false;
      }

      return true;
    },

    boolean: function ($dst, parameters) {
      var value = $dst.val();

      if ([1, 0, '1', '0', true, false, 'true', 'false'].indexOf(value) === -1) {
        Validator.error($dst, XE.Lang.trans('xe::validatorBoolean'));
        return false;
      }

      return true;
    },

    date: function ($dst, parameters) {
      if (!Utils.strtotime($dst.val())) {
        Validator.error($dst, XE.Lang.trans('xe::validatorDate'));
        return false;
      }

      return true;
    },

    date_format: function ($dst, parameters) {
      //moment('2015-04-03', 'yyyy-mm-dd').isValid()
      if (!moment($dst.val(), parameters).isValid()) {
        Validator.error($dst, XE.Lang.trans('xe::validatorDateFormat'));
        return false;
      }

      return true;
    },

    digits: function ($dst, parameters) {
      var pattern = /[^0-9]/;
      var size = parseInt(parameters);

      if (pattern.test(value) || $dst.val().toString().length !== size) {
        Validator.error($dst, XE.Lang.trans('xe::validatorDigits'));
        return false;
      }

      return true;
    },

    digits_between: function ($dst, parameters) {
      var range = parameters.split(',');
      var size = $dst.val().toString().length;

      if (range[0] > size && size < range[1]) {
        Validator.error($dst, XE.Lang.trans('xe::validatorDigitsBetween'));
        return false;
      }

      return true;
    },

    filled: function ($dst, parameters) {
      if ($dst.val() === '') {
        Validator.error($dst, XE.Lang.trans('xe::validatorFilled'));
        return false;
      }

      return true;
    },

    integer: function ($dst) {
      var value = $dst.val();

      if (typeof value !== 'number' || isNaN(value) || Math.floor(value) !== value || !$.isNumeric(value)) {
        Validator.error($dst, XE.Lang.trans('xe::validatorInteger'));
        return false;
      }

      return true;
    },

    ip: function ($dst) {
      var value = $dst.val();
      var exp = /^(1|2)?\d?\d([.](1|2)?\d?\d){3}$/;

      if (!exp.test(value)) {
        Validator.error($dst, XE.Lang.trans('xe::validatorIp'));
        return false;
      }

      return true;
    },

    ipv4: function ($dst) {
      var value = $dst.val();
      var exp = /^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$|^(([a-zA-Z]|[a-zA-Z][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z]|[A-Za-z][A-Za-z0-9\-]*[A-Za-z0-9])$|^\s*((([0-9A-Fa-f]{1,4}:){7}([0-9A-Fa-f]{1,4}|:))|(([0-9A-Fa-f]{1,4}:){6}(:[0-9A-Fa-f]{1,4}|((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){5}(((:[0-9A-Fa-f]{1,4}){1,2})|:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){4}(((:[0-9A-Fa-f]{1,4}){1,3})|((:[0-9A-Fa-f]{1,4})?:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){3}(((:[0-9A-Fa-f]{1,4}){1,4})|((:[0-9A-Fa-f]{1,4}){0,2}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){2}(((:[0-9A-Fa-f]{1,4}){1,5})|((:[0-9A-Fa-f]{1,4}){0,3}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){1}(((:[0-9A-Fa-f]{1,4}){1,6})|((:[0-9A-Fa-f]{1,4}){0,4}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(:(((:[0-9A-Fa-f]{1,4}){1,7})|((:[0-9A-Fa-f]{1,4}){0,5}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:)))(%.+)?\s*$/;

      if (!exp.test(value)) {
        Validator.error($dst, XE.Lang.trans('xe::validatorIpv4'));
        return false;
      }

      return true;
    },

    ipv6: function ($dst) {
      var value = $dst.val();
      var exp = /^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$|^(([a-zA-Z]|[a-zA-Z][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z]|[A-Za-z][A-Za-z0-9\-]*[A-Za-z0-9])$|^\s*((([0-9A-Fa-f]{1,4}:){7}([0-9A-Fa-f]{1,4}|:))|(([0-9A-Fa-f]{1,4}:){6}(:[0-9A-Fa-f]{1,4}|((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){5}(((:[0-9A-Fa-f]{1,4}){1,2})|:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){4}(((:[0-9A-Fa-f]{1,4}){1,3})|((:[0-9A-Fa-f]{1,4})?:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){3}(((:[0-9A-Fa-f]{1,4}){1,4})|((:[0-9A-Fa-f]{1,4}){0,2}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){2}(((:[0-9A-Fa-f]{1,4}){1,5})|((:[0-9A-Fa-f]{1,4}){0,3}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){1}(((:[0-9A-Fa-f]{1,4}){1,6})|((:[0-9A-Fa-f]{1,4}){0,4}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(:(((:[0-9A-Fa-f]{1,4}){1,7})|((:[0-9A-Fa-f]{1,4}){0,5}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:)))(%.+)?\s*$/;

      if (!exp.test(value)) {
        Validator.error($dst, XE.Lang.trans('xe::validatorIpv4'));
        return false;
      }

      return true;
    },

    mimes: function ($dst, parameters) {
      var value = $dst.val();
      var exts = parameters.split(',');

      if (!value || exts.indexOf(value.split('.').pop()) === -1) {
        Validator.error($dst, XE.Lang.trans('xe::validatorMimes'));
        return false;
      }

      return true;
    },

    nullable: function ($dst) {
      var value = $dst.val();

      if (value != null) {
        Validator.error($dst, XE.Lang.trans('xe::validatorNullable'));
        return false;
      }

      return true;
    },

    regex: function ($dst, pattern) {

      if (!pattern.text($dst.val())) {
        Validator.error($dst, XE.Lang.trans('xe::validatorRegex'));
        return false;
      }

      return true;
    },

    json: function ($dst) {
      try {
        JSON.parse($dst.val());
        return true;

      }catch (e) {
        return false;
      }
    },

    string: function ($dst) {
      if (typeof $dst.val() !== 'string') {
        Validator.error($dst, XE.Lang.trans('xe::validatorString'));
        return false;
      }

      return true;
    },

    min: function ($dst, parameters) {
      var value = $dst.val();

      if (value.length <= parseInt(parameters)) {
        Validator.error($dst, XE.Lang.transChoice('xe::validatorMin', parameters, { charCount: parameters }));
        return false;
      }

      return true;
    },

    max: function ($dst, parameters) {
      var value = $dst.val();

      if (value.length >= parseInt(parameters)) {
        Validator.error($dst, XE.Lang.trans('xe::validatorMax')); //TODO 번역 넣어야함
        return false;
      }

      return true;
    },

    email: function ($dst, parameters) {
      var val = $dst.val();
      var re = /\w+@\w{2,}\.\w{2,}/;

      if (!val.match(re)) {
        Validator.error($dst, XE.Lang.trans('xe::validatorEmail')); //TODO 번역 넣어야함
        return false;
      }

      return true;
    },

    url: function ($dst, parameters) {
      var val = $dst.val();
      var re = /^https?:\/\/\S+/;

      if (!val.match(re)) {
        Validator.error($dst, XE.Lang.trans('xe::validatorUrl')); //TODO 번역 넣어야함
        return false;
      }

      return true;
    },

    numeric: function ($dst, parameters) {
      var val = $dst.val();
      var num = Number(val);

      if (typeof num === 'number' && !isNaN(num) && typeof val !== 'boolean') {
        return true;
      } else {
        Validator.error($dst, XE.Lang.trans('xe::validatorNumeric')); //TODO 번역 넣어야함
        return false;
      }
    },

    between: function ($dst, parameters) {
      var range = parameters.split(',');
      var value = $dst.val();

      // 등록된 내용이 없으면 체크 안함
      if (value.length == 0) {
        return true;
      }

      if (value.length <= parseInt(range[0]) || value.length >= parseInt(range[1])) {
        Validator.error($dst, XE.Lang.trans('xe::validatorBetween', { between: parameters }));
        return false;
      }
    },
  };

  return Validator;

}));
