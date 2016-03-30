(function (root, factory) {
  if (typeof define === 'function' && define.amd) {
    define(['exports'], function (exports) {
        factory(exports);
      });
  } else if (typeof exports === 'object' && typeof exports.nodeName !== 'string') {
    factory(exports);
  } else {
    factory({});
  }
}(this, function (exports) {
  'use strict';

  var Validator = {};

  Validator.rules = {};

  Validator.alertType = 'form';

  Validator.setRules = function(ruleName, rules) {
    if (this.rules[ruleName] != undefined) {
      this.rules[ruleName] = $.extend(rules, this.rules[ruleName]);
    } else {
      this.rules[ruleName] = rules;

      // init form check event listner
      this.init(ruleName);
    }
  };

  // validator 를 set 하면서 submit event listener 를 등록한다.
  Validator.init = function(ruleName) {
    $('[data-rule="'+ruleName+'"]').on('submit', function(event) {
      try {
        Validator.check($(this));
      } catch(e) {
        // validation 체크하면서 에러가 발생한 경우 다른 이벤트는 처리하지 않음
        event.preventDefault();
      }
    });
  };

  Validator.getRuleName = function($frm) {
    return $frm.data('rule');
  };

  Validator.check = function($frm) {
    var ruleName = this.getRuleName($frm),
    rules = this.rules[ruleName],
    self = this,
    alertType = $frm.data('rule-alert-type');


    if (alertType == undefined) {
      alertType = 'form';
    }
    self.alertType = alertType;

    $.each(rules, function(name, rule) {
      self.validate($frm, name, rule);
    });

    this.checkRuleContainers($frm);
  };

  Validator.checkRuleContainers = function($frm) {
    var self = this,
    containers = $frm.find('[data-rule]');

    $.each(containers, function(index, container) {
      var ruleName = $(container).data('rule'),
      rules = self.rules[ruleName];

      $.each(rules, function(name, rule) {
        self.validate($frm, name, rule);
      });
    });
  };

  Validator.validate = function($frm, name, rule) {
    var parts = rule.split('|'),
    self = this;


    $.each(parts, function(index, part) {
      var res = part.split(':'),
      command = res[0].toLowerCase(),
      parameters = res[1];

      if (typeof self.validators[command] === 'function') {
        var $dst = $frm.find('[name="'+name+'"]');

        self.errorClear($frm);

        if (self.validators[command]($dst, parameters) === false) {
          throw Error('Validation error.');
        }
      }
    });
  };

  // validator 추가
  Validator.put = function(name, callback) {
    $.extend(this.validators, {name:callback});
  };

  Validator.errorClear = function($form) {
    require(['griper'], function(griper) {
      griper.form.fn.clear($form);
    });
  };

  Validator.error = function($element, message) {
    if (this.alertType == 'form') {
      require(['griper'], function(griper) {
        griper.form($element, message);
      });
    } else if (this.alertType == 'toast') {
      require(['griper'], function(griper) {
        var typeName = $element.attr('placeholder');
        if (typeName == undefined) {
          typeName = $element.attr('name');
        }
        message = '[' + typeName + '] ' + message;
        griper.toast($element, message);
      });
    }

  };

  Validator.validators = {
    required: function($dst, parameters) {
      var value = $dst.val();

      if (value === '') {
        Validator.error($dst, XE.Lang.trans('xe::ValidatorRequired'));
        return false;
      }
      return true;
    },
    alphanum: function($dst, parameters) {
      var value = $dst.val(),
      pattern = /[^a-zA-Z0-9]/;
      if (pattern.test(value) === true) {
        Validator.error($dst, XE.Lang.trans('xe::ValidatorAlphanum'));
        return false;
      }
      return true;
    },
    min: function($dst, parameters) {
      var value = $dst.val();

      if (value.length <= parseInt(parameters)) {
        Validator.error($dst, XE.Lang.transChoice('xe::ValidatorMin', parameters, {charCount:parameters}));
        return false;
      }
      return true;
    },
    between: function($dst, parameters) {
      var range = parameters.split(','),
      value = $dst.val();

      // 등록된 내용이 없으면 체크 안함
      if (value.length == 0) {
        return true;
      }

      if (value.length <= parseInt(range[0]) || value.length >= parseInt(range[1])) {
        Validator.error($dst, XE.Lang.trans('xe::ValidatorBetween', {between:parameters}));
        return false;
      }
    },
    langrequired: function ($dst, parameters) {
      return true;
    }
  };

  $.extends(exports, new Validator());
});
