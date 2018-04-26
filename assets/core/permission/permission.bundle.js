/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 31);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(2))(397);

/***/ }),
/* 1 */
/***/ (function(module, exports) {

module.exports = _xe_bundle_common;

/***/ }),
/* 2 */
/***/ (function(module, exports) {

module.exports = _xe_bundle_vendor;

/***/ }),
/* 3 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(1))(521);

/***/ }),
/* 4 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(1))(159);

/***/ }),
/* 5 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _jquery = __webpack_require__(0);

var _jquery2 = _interopRequireDefault(_jquery);

var _dynamicLoadManager = __webpack_require__(3);

var _dynamicLoadManager2 = _interopRequireDefault(_dynamicLoadManager);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

/**
 * @module Progress
 **/

/** @private */
var instances = [];
/** @private */
var cssLoaded = false;

var Progress = {

  /**
   * css를 로드한다.
   * @memberof module:Progress
   * @DEPRECATED
   * @FIXME
   **/
  cssLoad: function cssLoad() {
    if (cssLoaded === false) {
      cssLoaded = true;
      _dynamicLoadManager2.default.cssLoad('/assets/core/common/css/progress.css'); // @FIXME
    }
  },

  /**
   * progress를 그린다.
   * @memberof module:Progress
   * @param {Element} context
   **/
  start: function start(context) {
    if ((0, _jquery2.default)('link[href*="assets/core/common/css/progress.css"]').length == 0) {
      _dynamicLoadManager2.default.cssLoad('/assets/core/common/css/progress.css'); // @FIXME
    }

    var $context = (0, _jquery2.default)(context);
    if ($context.context === undefined) {
      $context = (0, _jquery2.default)('body');
    }

    setInstance($context);

    $context.trigger('progressStart');
  },

  /**
   * progress를 종료한다.
   * @memberof module:Progress
   * @param {Element} context
   **/
  done: function done(context) {
    var $context = (0, _jquery2.default)(context);
    if ($context.context === undefined) {
      $context = (0, _jquery2.default)('body');
    }

    $context.trigger('progressDone');
  }

  /** @private */
};function getInstance($context) {
  var instanceId = $context.attr('data-progress-instance');

  var instance = null;
  if (instanceId != undefined) {
    instance = instances[instanceId];
  }

  return instance;
}

/** @private */
function getCount($context) {
  var count = $context.attr('data-progress-count');

  if (count != undefined) {
    count = parseInt(count);
  }

  return count;
}

/** @private */
function setCount($context, count) {
  if (parseInt(count) < 0) {
    count = 0;
  }

  $context.attr('data-progress-count', count);
}

/** @private */
function setInstance($context, instance) {
  if (getInstance($context) === null) {
    var progress = new XeProgress();
    var parent = 'body';
    var type = $context.data('progress-type') === undefined ? 'default' : $context.data('progress-type');
    var bgcolor = $context.data('progress-bgcolor');
    var showSpinner = type !== 'nospin';

    if ($context.attr('id') !== undefined) {
      parent = '#' + $context.attr('id');
    } else if ($context.selector) {
      parent = $context.selector;
    } else {
      var cnt = getCount($context) || 0;

      $context.attr('data-progress-idx', cnt);
      parent = '[data-progress-idx=' + cnt + ']';
    }

    progress.configure({
      parent: parent,
      type: type,
      showSpinner: showSpinner,
      bgcolor: bgcolor
    });
    instances.push(progress);
    var instanceId = instances.length - 1;
    $context.attr('data-progress-instance', instanceId);

    progress.setInstanceId(instanceId);

    setCount($context, 0);
    attachInstance($context);
  }
}

/** @private */
function attachInstance($context) {
  $context.bind('progressStart', function (e) {
    e.stopPropagation();
    var count = getCount($context) + 1;
    setCount($context, count);
    if (count === 1) {
      getInstance($context).start();
    }
  });

  $context.bind('progressDone', function (e) {
    e.stopPropagation();

    var count = getCount((0, _jquery2.default)(this)) - 1;
    setCount((0, _jquery2.default)(this), count);
    if (getCount((0, _jquery2.default)(this)) === 0) {
      var instance = getInstance($context);
      instance.done(instance.getTime());
    }
  });
}

/**
 * NProgress, (c) 2013, 2014 Rico Sta. Cruz - http://ricostacruz.com/nprogress
 * @license MIT
 *
 * NProgress 모듈을 instance 화 할 수 있도록 하기위해 수정함
 * @private
 **/
function XeProgress() {
  this.settings = {
    type: 'default', // defautl, cover, nospin
    minimum: 0.08,
    easing: 'ease',
    positionUsing: '',
    speed: 200,
    trickle: true,
    trickleRate: 0.02,
    trickleSpeed: 800,
    showSpinner: true,
    barSelector: '[role="bar"]',
    spinnerSelector: '[role="spinner"]',
    bgcolor: '',
    parent: 'body',
    template: {
      default: '<div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div>',
      cover: '<div class="cover" role="bar"><div class="peg"></div></div><div class="spinner spinner-center" role="spinner"><div class="spinner-icon"></div></div>'
    }
  };

  this.$progress = null;
  this.$bar = null;
  this.status = null;
  this.initial = 0;
  this.current = 0;
  this.instanceId = null;
  this.time = null;

  this.setInstanceId = function (instanceId) {
    this.instanceId = instanceId;
  };

  this.configure = function (options) {
    _jquery2.default.extend(this.settings, options);
  };

  this.getTime = function () {
    return this.time;
  };

  this.start = function () {
    if (!this.status) {
      this.time = new Date().getTime();
      this.set(0);
    }

    var _this = this;

    var work = function work() {
      setTimeout(function () {
        if (!_this.status) return;
        _this.trickle();
        work();
      }, _this.settings.trickleSpeed);
    };

    if (this.settings.trickle) work();

    return this;
  };

  this.done = function (time, force) {
    if (this.time != time) {
      return this;
    }

    if (!force && !this.status) return this;

    return this.inc(0.3 + 0.5 * Math.random()).set(1);
  };

  this.inc = function (amount) {
    var n = this.status;

    if (!n) {
      return this.start();
    } else {
      if (typeof amount !== 'number') {
        amount = (1 - n) * clamp(Math.random() * n, 0.1, 0.95);
      }

      n = clamp(n + amount, 0, 0.994);
      return this.set(n);
    }
  };

  this.set = function (n) {
    var started = this.isStarted();

    n = clamp(n, this.settings.minimum, 1);
    this.status = n === 1 ? null : n;

    var $progress = this.render(!started);
    var $bar = this.$bar;
    var speed = this.settings.speed;
    var ease = this.settings.easing;

    // $progress.offsetWidth; /* Repaint */
    var _this = this;
    var time = this.getTime();

    Progress.queue(function (next) {
      // Set positionUsing if it hasn't already been set
      if (_this.settings.positionUsing === '') _this.settings.positionUsing = _this.getPositioningCSS();

      // Add transition
      Progress.css(_this.$bar, barPositionCSS(n, speed, ease, _this.settings));

      if (n === 1) {
        // Fade out
        Progress.css(_this.$progress, {
          transition: 'none',
          opacity: 1
        });

        setTimeout(function () {
          Progress.css(_this.$progress, {
            transition: 'all ' + speed + 'ms linear',
            opacity: 0
          });
          setTimeout(function () {
            _this.remove(time);
            next();
          }, speed);
        }, speed);
      } else {
        setTimeout(next, speed);
      }
    });

    return this;
  };

  this.isStarted = function () {
    return typeof this.status === 'number';
  };

  this.promise = function ($promise) {
    if (!$promise || $promise.state() === 'resolved') {
      return this;
    }

    if (this.current === 0) {
      this.start();
    }

    this.initial++;
    this.current++;

    var _this = this;
    $promise.always(function () {
      _this.current--;
      if (_this.current === 0) {
        _this.initial = 0;
        _this.done(this.time);
      } else {
        _this.set((_this.initial - _this.current) / _this.initial);
      }
    });

    return this;
  };

  this.trickle = function () {
    return this.inc(Math.random() * this.settings.trickleRate);
  };

  this.render = function (fromStart) {
    // if (this.isRendered()) {
    //    return $(this.settings.parent).children('.xe-progress');
    // }

    if (this.isRendered()) {
      return this.$progress;
    }

    var $progress = (0, _jquery2.default)('<div>');
    $progress.addClass('xe-progress');
    if (this.settings.template[this.settings.type] === undefined) {
      this.settings.type = 'default';
    }

    var $template = (0, _jquery2.default)(this.settings.template[this.settings.type]);

    if (this.settings.bgcolor) {
      $template.eq(0).css('background', this.settings.bgcolor);
    }

    $progress.html($template);

    var $bar = $progress.find(this.settings.barSelector);
    var perc = fromStart ? '-100' : toBarPerc(this.status || 0);
    var $parent = (0, _jquery2.default)(this.settings.parent);
    var $spinner;

    $bar.attr('title-name', this.instanceId);
    this.$bar = $bar;

    Progress.css($bar, {
      transition: 'all 0 linear',
      transform: 'translate3d(' + perc + '%,0,0)'
    });

    if (!this.settings.showSpinner) {
      $spinner = $progress.find(this.settings.spinnerSelector);
      $spinner && $spinner.remove();
    }

    $parent.addClass('xe-progress-' + this.settings.type);
    if ($parent.is('body') === false) {
      $parent.addClass('xe-progress-custom-parent');
    }

    this.$progress = $progress;

    $parent.append($progress);
    return $progress;
  };

  /**
   * Removes the element. Opposite of render().
   */
  this.remove = function (time) {
    this.done(time);

    (0, _jquery2.default)(this.settings.parent).removeClass('xe-progress-custom-parent xe-progress-' + this.settings.type);

    if (this.$progress != null) {
      this.$progress.remove();
    }

    this.$progress = null;
    this.$bar = null;
  };

  /**
   * Checks if the progress bar is rendered.
   */
  this.isRendered = function () {
    // return !!$(this.settings.parent).children('.xe-progress').length;
    return this.$progress !== null;
  };

  /**
   * Determine which positioning CSS rule to use.
   */
  this.getPositioningCSS = function () {
    var bodyStyle = document.body.style;

    // Sniff prefixes
    var vendorPrefix = 'WebkitTransform' in bodyStyle ? 'Webkit' : 'MozTransform' in bodyStyle ? 'Moz' : 'msTransform' in bodyStyle ? 'ms' : 'OTransform' in bodyStyle ? 'O' : '';

    if (vendorPrefix + 'Perspective' in bodyStyle) {
      // Modern browsers with 3D support, e.g. Webkit, IE10
      return 'translate3d';
    } else if (vendorPrefix + 'Transform' in bodyStyle) {
      // Browsers without 3D support, e.g. IE9
      return 'translate';
    } else {
      // Browsers without translate() support, e.g. IE7-8
      return 'margin';
    }
  };
};

/**
 * Helpers
 * @private
 */
function clamp(n, min, max) {
  if (n < min) return min;
  if (n > max) return max;
  return n;
}

/** @private */
function toBarPerc(n) {
  return (-1 + n) * 100;
}

/** @private */
function barPositionCSS(n, speed, ease, Settings) {
  var barCSS;

  if (Settings.positionUsing === 'translate3d') {
    barCSS = { transform: 'translate3d(' + toBarPerc(n) + '%,0,0)' };
  } else if (Settings.positionUsing === 'translate') {
    barCSS = { transform: 'translate(' + toBarPerc(n) + '%,0)' };
  } else {
    barCSS = { 'margin-left': toBarPerc(n) + '%' };
  }

  barCSS.transition = 'all ' + speed + 'ms ' + ease;

  return barCSS;
}

/** @private */
var pending = [];

/** @private */
function next() {
  var fn = pending.shift();
  if (fn) {
    fn(next);
  }
}

/**
 * callback을 queue에 담는다.
 * @memberof module:Progress
 * @param {function} fn
 **/
Progress.queue = function (fn) {
  pending.push(fn);
  if (pending.length == 1) next();
};

/** @private */
var cssPrefixes = ['Webkit', 'O', 'Moz', 'ms'];
/** @private */
var cssProps = {};

/** @private */
function camelCase(string) {
  return string.replace(/^-ms-/, 'ms-').replace(/-([\da-z])/gi, function (match, letter) {
    return letter.toUpperCase();
  });
}

/** @private */
function getVendorProp(name) {
  var style = document.body.style;
  if (name in style) return name;

  var i = cssPrefixes.length;
  var capName = name.charAt(0).toUpperCase() + name.slice(1);
  var vendorName;

  while (i--) {
    vendorName = cssPrefixes[i] + capName;
    if (vendorName in style) return vendorName;
  }

  return name;
}

/** @private */
function getStyleProp(name) {
  name = camelCase(name);
  return cssProps[name] || (cssProps[name] = getVendorProp(name));
}

/** @private */
function applyCss(element, prop, value) {
  prop = getStyleProp(prop);
  if (element) {
    element[0].style[prop] = value;
  }
}

/**
 * element에 properties 스타일을 추가한다.
 * @memberof module:Progress
 * @param {Element} element
 * @param {object} properties
 **/
Progress.css = function () {
  return function (element, properties) {
    var args = arguments;
    var prop;
    var value;

    if (args.length == 2) {
      for (prop in properties) {
        value = properties[prop];
        if (value !== undefined && properties.hasOwnProperty(prop)) applyCss(element, prop, value);
      }
    } else {
      applyCss(element, args[1], args[2]);
    }
  };
};

exports.default = Progress;

/***/ }),
/* 6 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }(); // external libraries


// internal libraries


var _jquery = __webpack_require__(0);

var _jquery2 = _interopRequireDefault(_jquery);

var _blankshield = __webpack_require__(13);

var _blankshield2 = _interopRequireDefault(_blankshield);

var _moment = __webpack_require__(7);

var _moment2 = _interopRequireDefault(_moment);

var _urijs = __webpack_require__(14);

var _urijs2 = _interopRequireDefault(_urijs);

var _component = __webpack_require__(11);

var _component2 = _interopRequireDefault(_component);

var _dynamicLoadManager = __webpack_require__(3);

var _dynamicLoadManager2 = _interopRequireDefault(_dynamicLoadManager);

var _griper = __webpack_require__(4);

var _griper2 = _interopRequireDefault(_griper);

var _lang = __webpack_require__(9);

var _lang2 = _interopRequireDefault(_lang);

var _progress = __webpack_require__(5);

var _progress2 = _interopRequireDefault(_progress);

var _request = __webpack_require__(12);

var _request2 = _interopRequireDefault(_request);

var _utils = __webpack_require__(8);

var Utils = _interopRequireWildcard(_utils);

var _translator = __webpack_require__(19);

var _translator2 = _interopRequireDefault(_translator);

var _validator = __webpack_require__(10);

var _validator2 = _interopRequireDefault(_validator);

function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

/**
 * @class XE
 * @global
 * @namespace XE
 * @type {object}
 **/
var XE = function () {
  function XE() {
    _classCallCheck(this, XE);

    var that = this;

    Utils.eventify(this);

    this.options = {};

    // internal libraries
    // this.util = Utils // @DEPRECATED
    this.Utils = Utils;
    // this.validator = Validator // @DEPRECATED
    this.Validator = _validator2.default;
    this.Lang = _lang2.default;
    this.Progress = _progress2.default;
    this.Request = _request2.default;
    this.Component = _component2.default;

    // external libraries
    this.moment = _moment2.default;
    this.Translator = _translator2.default;

    // window.Utils = Utils // @DEPRECATED
    // window.DynamicLoadManager = DynamicLoadManager // @DEPRECATED
    // window.Translator = Translator // @DEPRECATED
    // window.blankshield = blankshield // @DEPRECATED

    (0, _jquery2.default)(function () {
      (0, _jquery2.default)('body').on('click', 'a[target]', function (e) {
        var $this = (0, _jquery2.default)(this);
        var href = $this.attr('href').trim();
        var target = $this.attr('target');

        if (!href) return;
        if (target === '_top' || target === '_self' || target === '_parent') return;
        if (!href.match(/^(https?:\/\/)/)) return;
        if (that.isSameHost(href)) return;

        var rel = $this.attr('rel');

        if (typeof rel === 'string') {
          $this.attr('rel', rel + ' noopener');
        } else {
          $this.attr('rel', 'noopener');
        }

        _blankshield2.default.open(href);
        e.preventDefault();
      });
    });
  }

  /**
   * XE 기본설정을 세팅한다.
   * @param {object} options
   * <pre>
   *   - loginUserId
   *   - X-CSRF-TOKEN : CSRF Token 값 세팅
   *   - useXESpinner : ajax요청시 UI상에 spinner 사용여부
   * </pre>
   **/


  _createClass(XE, [{
    key: 'setup',
    value: function setup(options) {
      this.options.loginUserId = options.loginUserId;
      this.Request.setup({
        headers: {
          'X-CSRF-TOKEN': options['X-CSRF-TOKEN']
        },
        useXeSpinner: options.useXeSpinner
      });
    }
  }, {
    key: 'configure',
    value: function configure(options) {
      _jquery2.default.extend(this.options, options);
    }

    /**
     * css 파일을 로드한다.
     * @param {url} url css file path
     * @DEPRECATED
     **/

  }, {
    key: 'cssLoad',
    value: function cssLoad(url) {
      _dynamicLoadManager2.default.cssLoad(url);
    }

    /**
     * js 파일을 로드한다.
     * @param {string} url js file path
     * @DEPRECATED
     **/

  }, {
    key: 'jsLoad',
    value: function jsLoad(url) {
      _dynamicLoadManager2.default.jsLoad(url);
    }

    /**
     * Ajax를 요청한다.
     * @param {string|object} url request url
     * @param {object} options jQuery ajax options
     **/

  }, {
    key: 'ajax',
    value: function ajax(url, options) {
      if ((typeof url === 'undefined' ? 'undefined' : _typeof(url)) === 'object') {
        options = _jquery2.default.extend({}, this.Request.options, url);
        url = undefined;
      } else {
        options = _jquery2.default.extend({}, options, this.Request.options, { url: url });
        url = undefined;
      }

      return _jquery2.default.ajax(url, options);
    }

    /**
     * 주어진 URL이 현재 호스트와 동일 호스트인지 확인
     * @param {string|object} url request url
     * @param {object} options jQuery ajax options
     * @return {boolean}
     **/

  }, {
    key: 'isSameHost',
    value: function isSameHost(url) {
      if (typeof url !== 'string') return false;
      var baseUrl = void 0;
      var targetUrl = (0, _urijs2.default)(url).normalizePathname();
      var baseURL = (0, _urijs2.default)(window.xeBaseURL).normalizePathname();

      if (targetUrl.is('urn')) return false;

      if (!targetUrl.hostname()) {
        targetUrl = targetUrl.absoluteTo(window.xeBaseURL);
      }

      var port = Number(baseURL.port());
      var targetPort = Number(targetUrl.port());
      if (!port) {
        port = baseURL.protocol() === 'http' ? 80 : 443;
      }
      if (!targetPort) {
        targetPort = targetUrl.protocol() === 'http' ? 80 : 443;
      }

      if (targetPort !== port) {
        return false;
      }

      if (!baseUrl) {
        baseUrl = (0, _urijs2.default)(window.xeBaseURL).normalizePathname();
        baseUrl = baseUrl.hostname() + baseUrl.directory();
      }
      targetUrl = targetUrl.hostname() + targetUrl.directory();

      return targetUrl.indexOf(baseUrl) === 0;
    }

    /**
     * type에 따른 토스트 팝업을 출력한다.
     * @param {string} type
     * <pre>
     *   - danger
     *   - positive
     *   - warning
     *   - success
     *   - info
     *   - fail
     *   - error
     * </pre>
     * @param {string} message 토스트 팝업에 노출할 메시지
     * @param {string} pos default 'bottom'
     * <pre>
     *   - top
     *   - topLeft
     *   - topRight
     *   - bottom
     *   - bottomLeft
     *   - bottomRight
     * </pre>
     **/

  }, {
    key: 'toast',
    value: function toast() {
      var type = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 'danger';
      var message = arguments[1];
      var pos = arguments[2];

      _griper2.default.toast(type, message, pos);
    }

    /**
     * status에 따른 토스트 팝업을 출력한다.
     * @param {number}
     * <pre>
     *   - 500 : danger
     *   - 401 : warning
     * </pre>
     * @param {string} 팝업에 출력될 메시지
     **/

  }, {
    key: 'toastByStatus',
    value: function toastByStatus(status, message) {
      return _griper2.default.toast(_griper2.default.toast.fn.statusToType(status), message);
    }

    /**
     * 폼 요소 엘리먼트에 메시지를 출력한다.
     * @param {object} form element object
     * @param {string} message 엘리먼트에 출력될 메시지
     **/

  }, {
    key: 'formError',
    value: function formError($element, message) {
      return _griper2.default.form($element, message);
    }

    /**
     * 폼 요소의 메시지를 모두 제거한다.
     * @param {object} jquery form object
     **/

  }, {
    key: 'formErrorClear',
    value: function formErrorClear($form) {
      return _griper2.default.form.fn.clear($form);
    }

    /**
     * 설정된 폼의 유효성 체크를 한다.
     * @param {object} jquery form object
     **/

  }, {
    key: 'formValidate',
    value: function formValidate($form) {
      _validator2.default.formValidate($form);
    }

    /**
     * locale 정보를 반환
     * @return {string} locale
     **/

  }, {
    key: 'getLocale',


    /**
     * @DEPRECATED
     **/
    value: function getLocale() {
      return this.locale;
    }

    /**
     * default locale 정보를 반환한다.
     * @return {string} defaultLocale
     **/

  }, {
    key: 'getDefaultLocale',


    /**
     * @DEPRECATED
     **/
    value: function getDefaultLocale() {
      return this.defaultLocale;
    }
  }, {
    key: 'locale',
    get: function get() {
      return this.options.locale;
    }

    /**
     * locale 지정
     * @param {string} 변경할 locale
     **/
    ,
    set: function set(locale) {
      this.options.locale = locale;
    }
  }, {
    key: 'defaultLocale',
    get: function get() {
      return this.options.defaultLocale;
    }
  }]);

  return XE;
}();

window.XE = new XE();

exports.default = window.XE;

/***/ }),
/* 7 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(2))(107);

/***/ }),
/* 8 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(1))(109);

/***/ }),
/* 9 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(1))(520);

/***/ }),
/* 10 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(1))(404);

/***/ }),
/* 11 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _xe = __webpack_require__(6);

var _xe2 = _interopRequireDefault(_xe);

__webpack_require__(4);

var _moment = __webpack_require__(7);

var _moment2 = _interopRequireDefault(_moment);

__webpack_require__(15);

__webpack_require__(16);

__webpack_require__(17);

__webpack_require__(18);

var _xeDynamicLoadManager = __webpack_require__(3);

var _xeDynamicLoadManager2 = _interopRequireDefault(_xeDynamicLoadManager);

var _jquery = __webpack_require__(0);

var _jquery2 = _interopRequireDefault(_jquery);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

/**
 * @module Component
 * */
var Component = function (exports) {
  return {
    /**
     * 시간 설정을 바인딩한다.
     * @memberof module:Component
     * */
    timeago: function timeago() {
      (0, _jquery2.default)('[data-xe-timeago]').trigger('boot.xe.timeago');
    },
    /**
     * DOM에 지정된 selector가 있을 경우 컴포넌트를 바인딩한다.
     * @memberof module:Component
     * */
    boot: function boot() {
      this.timeago();
      (0, _jquery2.default)('[data-toggle=xe-dropdown]').trigger('boot.xe.dropdown');
      (0, _jquery2.default)('[data-toggle=xe-modal]').trigger('boot.xe.modal');
      (0, _jquery2.default)('[data-toggle=xe-tooltip]').trigger('boot.xe.tooltip');
      (0, _jquery2.default)('[data-toggle=dropdown]').trigger('boot.dropdown');
    }
  };
}(window);

_xeDynamicLoadManager2.default.cssLoad('/assets/core/xe-ui-component/xe-ui-component.css');

(0, _jquery2.default)(function () {
  /*
   * @Component Timeago
   *
   * <span data-xe-timeago="{timestmap|ISO8601}">2016-04-04 07:05:44</span>
   * <span data-xe-timeago="{timestmap|ISO8601}" title="2016-04-04 07:05:44" />3 Hours ago</span>
   */

  _moment2.default.locale(_xe2.default.getLocale());

  (0, _jquery2.default)(document).on('boot.xe.timeago', '[data-xe-timeago]', function () {
    var $this = (0, _jquery2.default)(this);
    if ($this.data().xeTimeagoCalled === true) return false;

    var dataDate = $this.data('xe-timeago');
    var isTimestamp = parseInt(dataDate) == dataDate;

    if (isTimestamp) {
      dataDate = _moment2.default.unix(dataDate);
    } else {
      dataDate = (0, _moment2.default)(dataDate);
    }

    $this.text(dataDate.fromNow());
    $this.data().xeTimeagoCalled = true;
  });

  (0, _jquery2.default)(document).on('boot.xe.dropdown', '[data-toggle=xe-dropdown]', function () {
    (0, _jquery2.default)(this).xeDropdown();
  });

  (0, _jquery2.default)(document).on('boot.xe.modal', '[data-toggle=xe-modal]', function () {});

  (0, _jquery2.default)(document).on('boot.xe.tooltip', '[data-toggle=xe-tooltip]', function () {
    (0, _jquery2.default)(this).xeTooltip();
  });

  Component.boot();
});

// // xeModal =========================================================
// $.fn.xeModal = function (options) {
//   var _this = this;
//
//   _this.xeModal(options);
//   DynamicLoadManager.cssLoad('/assets/core/xe-ui-component/xe-ui-component.css');
// };
//
// // xeDropdown ======================================================
// $.fn.xeDropdown = function (options) {
//   var _this = this;
//
//   _this.xeDropdown(options);
//   DynamicLoadManager.cssLoad('/assets/core/xe-ui-component/xe-ui-component.css');
// };
//
// // xeTooltip =======================================================
// $.fn.xeTooltip = function (options) {
//   var _this = this;
//
//   _this.xeTooltip(options);
//   DynamicLoadManager.cssLoad('/assets/core/xe-ui-component/xe-ui-component.css');
// };

exports.default = Component;

/***/ }),
/* 12 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _jquery = __webpack_require__(0);

var _jquery2 = _interopRequireDefault(_jquery);

var _progress = __webpack_require__(5);

var _progress2 = _interopRequireDefault(_progress);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

/**
 * @module Request
 **/
exports.default = function () {
  /** @private */
  var that;

  /** @private */
  var _options = {
    headers: {
      'X-CSRF-TOKEN': null
    }

    // @FIXME
  };(0, _jquery2.default)(document).ajaxSend(function (event, jqxhr, settings) {
    if (settings.useXeSpinner) {
      _progress2.default.start(settings.context == undefined ? (0, _jquery2.default)('body') : settings.context);
    }
  }).ajaxComplete(function (event, jqxhr, settings) {
    if (settings.useXeSpinner) {
      _progress2.default.done(settings.context == undefined ? (0, _jquery2.default)('body') : settings.context);
    }
  }).ajaxError(function (event, jqxhr, settings, thrownError) {
    if (settings.useXeSpinner) {
      _progress2.default.done();
    }

    if (!settings.hasOwnProperty('error')) {
      that.error(jqxhr, settings, thrownError);
    }
  });

  return {
    /**
     * Request module 초기화한다.
     * @method
     * @return this
     **/
    init: function init() {
      that = this;
      return this;
    },

    /**
     * @public
     **/
    options: _options,
    /**
     * ajax 옵션을 세팅한다.
     * @param {object} options jQuery ajax options
     **/
    setup: function setup(options) {
      _jquery2.default.extend(_options, options);
      _jquery2.default.ajaxSetup(_options);
    },

    /**
     * ajax를 method get 방식으로 호출한다.
     * @param {string} url
     * @param {object} data
     * @param {function} callback
     * @param {string} type
     **/
    get: function get(url, data, callback, type) {
      return _jquery2.default.get(url, data, callback, type);
    },

    /**
     * ajax를 method post 방식으로 호출한다.
     * @param {string} url
     * @param {object} data
     * @param {function} callback
     * @param {string} type
     **/
    post: function post(url, data, callback, type) {
      return _jquery2.default.post(url, data, callback, type);
    },

    /**
     * ajax 오류 메시지를 노출한다.
     * @param {object} jqxhr
     * @param {object} settings
     * @params {object} thrownError
     **/
    error: function error(jqxhr, settings, thrownError) {
      var status = jqxhr.status;
      var errorMessage = 'Not defined error message (' + status + ')';

      // @TODO dataType 에 따라 메시지 획득 방식을 추가 해야함.
      if (jqxhr.status == 422) {
        var list = _jquery2.default.parseJSON(jqxhr.responseText).errors || {};

        errorMessage = '';
        errorMessage += '<ul>';
        for (var i in list) {
          errorMessage += '<li>' + list[i] + '</li>';
        }

        errorMessage += '</ul>';
      } else if (settings.dataType == 'json') {
        errorMessage = _jquery2.default.parseJSON(jqxhr.responseText).message;
      } else {
        errorMessage = jqxhr.statusText;
      }

      // @FIXME 의존성
      window.XE.toastByStatus(status, errorMessage);
    }
  }.init();
}();

/***/ }),
/* 13 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(2))(399);

/***/ }),
/* 14 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(2))(401);

/***/ }),
/* 15 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


(function ($) {
  /* ========================================================================
   * Bootstrap: transition.js v3.3.6
   * http://getbootstrap.com/javascript/#transitions
   * ========================================================================
   * Copyright 2011-2015 Twitter, Inc.
   * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
   * ======================================================================== */

  'use strict';

  // CSS TRANSITION SUPPORT (Shoutout: http://www.modernizr.com/)
  // ============================================================

  function transitionEnd() {
    var el = document.createElement('xpressengineBootstrap');

    var transEndEventNames = {
      WebkitTransition: 'webkitTransitionEnd',
      MozTransition: 'transitionend',
      OTransition: 'oTransitionEnd otransitionend',
      transition: 'transitionend'
    };

    for (var name in transEndEventNames) {
      if (el.style[name] !== undefined) {
        return { end: transEndEventNames[name] };
      }
    }

    return false; // explicit for ie8 (  ._.)
  }

  // http://blog.alexmaccaw.com/css-transitions
  $.fn.emulateTransitionEnd = function (duration) {
    var called = false;
    var _this = this;
    $(this).one('xeTransitionEnd', function () {
      called = true;
    });

    var callback = function callback() {
      if (!called) $(_this).trigger($.support.transition.end);
    };

    setTimeout(callback, duration);
    return this;
  };

  $(function () {
    $.support.transition = transitionEnd();

    if (!$.support.transition) return;

    $.event.special.xeTransitionEnd = {
      bindType: $.support.transition.end,
      delegateType: $.support.transition.end,
      handle: function handle(e) {
        if ($(e.target).is(this)) return e.handleObj.handler.apply(this, arguments);
      }
    };
  });
})(window.jQuery);

/***/ }),
/* 16 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

/**
 * @name		jQuery xeModal plugin
 * */
;(function ($) {
  // MODAL CLASS DEFINITION
  // ======================

  var Modal = function Modal(element, options) {
    this.options = options;
    this.$body = $(document.body);
    this.$element = $(element);
    this.$dialog = this.$element.find('.xe-modal-dialog');
    this.$backdrop = null;
    this.isShown = null;
    this.originalBodyPad = null;
    this.scrollbarWidth = 0;
    this.ignoreBackdropClick = false;

    if (this.options.remote) {
      this.$element.find('.xe-modal-content').load(this.options.remote, $.proxy(function () {
        this.$element.trigger('loaded.xe.modal');
      }, this));
    }
  };

  Modal.VERSION = '3.3.6';

  Modal.TRANSITION_DURATION = 300;
  Modal.BACKDROP_TRANSITION_DURATION = 150;

  Modal.DEFAULTS = {
    backdrop: true,
    keyboard: true,
    show: true
  };

  Modal.prototype.toggle = function (_relatedTarget) {
    return this.isShown ? this.hide() : this.show(_relatedTarget);
  };

  Modal.prototype.show = function (_relatedTarget) {
    var _this = this;
    var e = $.Event('show.xe.modal', { relatedTarget: _relatedTarget });

    this.$element.trigger(e);

    if (this.isShown || e.isDefaultPrevented()) return;

    this.isShown = true;

    this.checkScrollbar();
    this.setScrollbar();
    this.$body.addClass('xe-modal-open');

    this.escape();
    this.resize();

    this.$element.on('click.dismiss.xe.modal', '[data-dismiss="xe-modal"]', $.proxy(this.hide, this));

    this.$dialog.on('mousedown.dismiss.xe.modal', function () {
      _this.$element.one('mouseup.dismiss.xe.modal', function (e) {
        if ($(e.target).is(_this.$element)) _this.ignoreBackdropClick = true;
      });
    });

    this.backdrop(function () {
      var transition = $.support.transition && _this.$element.hasClass('fade');

      if (!_this.$element.parent().length) {
        _this.$element.appendTo(_this.$body); // don't move modals dom position
      }

      _this.$element.show().scrollTop(0);

      _this.adjustDialog();

      if (transition) {
        _this.$element[0].offsetWidth; // force reflow
      }

      _this.$element.addClass('in');

      _this.enforceFocus();

      var e = $.Event('shown.xe.modal', { relatedTarget: _relatedTarget });

      transition ? _this.$dialog // wait for modal to slide in
      .one('xeTransitionEnd', function () {
        _this.$element.trigger('focus').trigger(e);
      }).emulateTransitionEnd(Modal.TRANSITION_DURATION) : _this.$element.trigger('focus').trigger(e);
    });
  };

  Modal.prototype.hide = function (e) {
    if (e) e.preventDefault();

    e = $.Event('hide.xe.modal');

    this.$element.trigger(e);

    if (!this.isShown || e.isDefaultPrevented()) return;

    this.isShown = false;

    this.escape();
    this.resize();

    $(document).off('focusin.xe.modal');

    this.$element.removeClass('in').off('click.dismiss.xe.modal').off('mouseup.dismiss.xe.modal');

    this.$dialog.off('mousedown.dismiss.xe.modal');

    $.support.transition && this.$element.hasClass('fade') ? this.$element.one('xeTransitionEnd', $.proxy(this.hideModal, this)).emulateTransitionEnd(Modal.TRANSITION_DURATION) : this.hideModal();
  };

  Modal.prototype.enforceFocus = function () {
    $(document).off('focusin.xe.modal') // guard against infinite focus loop
    .on('focusin.xe.modal', $.proxy(function (e) {
      if (this.$element[0] !== e.target && !this.$element.has(e.target).length) {
        this.$element.trigger('focus');
      }
    }, this));
  };

  Modal.prototype.escape = function () {
    if (this.isShown && this.options.keyboard) {
      this.$element.on('keydown.dismiss.xe.modal', $.proxy(function (e) {
        e.which == 27 && this.hide();
      }, this));
    } else if (!this.isShown) {
      this.$element.off('keydown.dismiss.xe.modal');
    }
  };

  Modal.prototype.resize = function () {
    if (this.isShown) {
      $(window).on('resize.xe.modal', $.proxy(this.handleUpdate, this));
    } else {
      $(window).off('resize.xe.modal');
    }
  };

  Modal.prototype.hideModal = function () {
    var _this = this;
    this.$element.hide();
    this.backdrop(function () {
      _this.$body.removeClass('xe-modal-open');
      _this.resetAdjustments();
      _this.resetScrollbar();
      _this.$element.trigger('hidden.xe.modal');
    });
  };

  Modal.prototype.removeBackdrop = function () {
    this.$backdrop && this.$backdrop.remove();
    this.$backdrop = null;
  };

  Modal.prototype.backdrop = function (callback) {
    var _this = this;
    var animate = this.$element.hasClass('fade') ? 'fade' : '';

    if (this.isShown && this.options.backdrop) {
      var doAnimate = $.support.transition && animate;

      this.$backdrop = $(document.createElement('div')).addClass('xe-modal-backdrop ' + animate).appendTo(this.$body);

      this.$element.on('click.dismiss.xe.modal', $.proxy(function (e) {
        if (this.ignoreBackdropClick) {
          this.ignoreBackdropClick = false;
          return;
        }

        if (e.target !== e.currentTarget) return;
        this.options.backdrop == 'static' ? this.$element[0].focus() : this.hide();
      }, this));

      if (doAnimate) this.$backdrop[0].offsetWidth; // force reflow

      this.$backdrop.addClass('in');

      if (!callback) return;

      doAnimate ? this.$backdrop.one('xeTransitionEnd', callback).emulateTransitionEnd(Modal.BACKDROP_TRANSITION_DURATION) : callback();
    } else if (!this.isShown && this.$backdrop) {
      this.$backdrop.removeClass('in');

      var callbackRemove = function callbackRemove() {
        _this.removeBackdrop();
        callback && callback();
      };

      $.support.transition && this.$element.hasClass('fade') ? this.$backdrop.one('xeTransitionEnd', callbackRemove).emulateTransitionEnd(Modal.BACKDROP_TRANSITION_DURATION) : callbackRemove();
    } else if (callback) {
      callback();
    }
  };

  // these following methods are used to handle overflowing modals

  Modal.prototype.handleUpdate = function () {
    this.adjustDialog();
  };

  Modal.prototype.adjustDialog = function () {
    var modalIsOverflowing = this.$element[0].scrollHeight > document.documentElement.clientHeight;

    this.$element.css({
      paddingLeft: !this.bodyIsOverflowing && modalIsOverflowing ? this.scrollbarWidth : '',
      paddingRight: this.bodyIsOverflowing && !modalIsOverflowing ? this.scrollbarWidth : ''
    });
  };

  Modal.prototype.resetAdjustments = function () {
    this.$element.css({
      paddingLeft: '',
      paddingRight: ''
    });
  };

  Modal.prototype.checkScrollbar = function () {
    var fullWindowWidth = window.innerWidth;
    if (!fullWindowWidth) {
      // workaround for missing window.innerWidth in IE8
      var documentElementRect = document.documentElement.getBoundingClientRect();
      fullWindowWidth = documentElementRect.right - Math.abs(documentElementRect.left);
    }

    this.bodyIsOverflowing = document.body.clientWidth < fullWindowWidth;
    this.scrollbarWidth = this.measureScrollbar();
  };

  Modal.prototype.setScrollbar = function () {
    var bodyPad = parseInt(this.$body.css('padding-right') || 0, 10);
    this.originalBodyPad = document.body.style.paddingRight || '';
    if (this.bodyIsOverflowing) this.$body.css('padding-right', bodyPad + this.scrollbarWidth);
  };

  Modal.prototype.resetScrollbar = function () {
    this.$body.css('padding-right', this.originalBodyPad);
  };

  Modal.prototype.measureScrollbar = function () {
    // thx walsh
    var scrollDiv = document.createElement('div');
    scrollDiv.className = 'xe-modal-scrollbar-measure';
    this.$body.append(scrollDiv);
    var scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth;
    this.$body[0].removeChild(scrollDiv);

    return scrollbarWidth;
  };

  // MODAL PLUGIN DEFINITION
  // =======================

  function Plugin(option, _relatedTarget) {
    return this.each(function () {
      var $this = $(this);
      var data = $this.data('xe.modal');
      var options = $.extend({}, Modal.DEFAULTS, $this.data(), (typeof option === 'undefined' ? 'undefined' : _typeof(option)) === 'object' && option);

      if (!data) $this.data('xe.modal', data = new Modal(this, options));
      if (typeof option === 'string') data[option](_relatedTarget);else if (options.show) data.show(_relatedTarget);
    });
  }

  var old = $.fn.modal;

  $.fn.xeModal = Plugin;
  $.fn.xeModal.Constructor = Modal;

  // MODAL NO CONFLICT
  // =================

  $.fn.xeModal.noConflict = function () {
    $.fn.modal = old;
    return this;
  };

  // MODAL DATA-API
  // ==============

  $(document).on('click.xe.modal.data-api', '[data-toggle="xe-modal"]', function (e) {
    var $this = $(this);
    var href = $this.attr('href');
    var $target = $($this.attr('data-target') || href && href.replace(/.*(?=#[^\s]+$)/, '')); // strip for ie7
    var option = $target.data('xe.modal') ? 'toggle' : $.extend({ remote: !/#/.test(href) && href }, $target.data(), $this.data());

    if ($this.is('a')) e.preventDefault();

    $target.one('show.xe.modal', function (showEvent) {
      if (showEvent.isDefaultPrevented()) return; // only register focus restorer if modal will actually get shown
      $target.one('hidden.xe.modal', function () {
        $this.is(':visible') && $this.trigger('focus');
      });
    });

    Plugin.call($target, option, this);
  });
})(window.jQuery);

/***/ }),
/* 17 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * @name		jQuery xeDropdown plugin
 */
(function ($) {
  // DROPDOWN CLASS DEFINITION
  // =========================

  var backdrop = '.xe-dropdown-backdrop';
  var toggle = '[data-toggle="xe-dropdown"]';
  var Dropdown = function Dropdown(element) {
    $(element).on('click.xe.dropdown', this.toggle);
  };

  Dropdown.VERSION = '3.3.6';

  function getParent($this) {
    var selector = $this.attr('data-target');

    if (!selector) {
      selector = $this.attr('href');
      selector = selector && /#[A-Za-z]/.test(selector) && selector.replace(/.*(?=#[^\s]*$)/, ''); // strip for ie7
    }

    var $parent = selector && $(selector);

    return $parent && $parent.length ? $parent : $this.parent();
  }

  function clearMenus(e) {
    if (e && e.which === 3) return;
    $(backdrop).remove();
    toggle += ',[data-toggle="xe-page-toggle-menu"]';
    $(toggle).each(function () {
      var $this = $(this);
      var $parent = getParent($this);
      var relatedTarget = { relatedTarget: this };

      if (!$parent.hasClass('open')) return;

      if (e && e.type == 'click' && /input|textarea/i.test(e.target.tagName) && $.contains($parent[0], e.target)) return;

      $parent.trigger(e = $.Event('hide.xe.dropdown', relatedTarget));

      if (e.isDefaultPrevented()) return;

      $this.attr('aria-expanded', 'false');
      $parent.removeClass('open').trigger($.Event('hidden.xe.dropdown', relatedTarget));
    });
  }

  Dropdown.prototype.toggle = function (e) {
    var $this = $(this);

    if ($this.is('.disabled, :disabled')) return;

    var $parent = getParent($this);
    var isActive = $parent.hasClass('open');

    clearMenus();

    if (!isActive) {
      if ('ontouchstart' in document.documentElement && !$parent.closest('.navbar-nav').length) {
        // if mobile we use a backdrop because click events don't delegate
        $(document.createElement('div')).addClass('xe-dropdown-backdrop').insertAfter($(this)).on('click', clearMenus);
      }

      var relatedTarget = { relatedTarget: this };
      $parent.trigger(e = $.Event('show.xe.dropdown', relatedTarget));

      if (e.isDefaultPrevented()) return;

      $this.trigger('focus').attr('aria-expanded', 'true');

      $parent.toggleClass('open').trigger($.Event('shown.xe.dropdown', relatedTarget));
    }

    return false;
  };

  Dropdown.prototype.keydown = function (e) {
    if (!/(38|40|27|32)/.test(e.which) || /input|textarea/i.test(e.target.tagName)) return;

    var $this = $(this);

    e.preventDefault();
    e.stopPropagation();

    if ($this.is('.disabled, :disabled')) return;

    var $parent = getParent($this);
    var isActive = $parent.hasClass('open');

    if (!isActive && e.which != 27 || isActive && e.which == 27) {
      if (e.which == 27) $parent.find(toggle).trigger('focus');
      return $this.trigger('click');
    }

    var desc = ' li:not(.disabled):visible a';
    var $items = $parent.find('.xe-dropdown-menu' + desc);

    if (!$items.length) return;

    var index = $items.index(e.target);

    if (e.which == 38 && index > 0) index--; // up
    if (e.which == 40 && index < $items.length - 1) index++; // down
    if (!~index) index = 0;

    $items.eq(index).trigger('focus');
  };

  // DROPDOWN PLUGIN DEFINITION
  // ==========================

  function Plugin(option) {
    return this.each(function () {
      var $this = $(this);
      var data = $this.data('xe.dropdown');

      if (!data) $this.data('xe.dropdown', data = new Dropdown(this));
      if (typeof option === 'string') data[option].call($this);
    });
  }

  var old = $.fn.dropdown;

  $.fn.xeDropdown = Plugin;
  $.fn.xeDropdown.Constructor = Dropdown;

  // DROPDOWN NO CONFLICT
  // ====================

  $.fn.xeDropdown.noConflict = function () {
    $.fn.dropdown = old;
    return this;
  };

  // APPLY TO STANDARD DROPDOWN ELEMENTS
  // ===================================

  $(document).on('click.xe.dropdown.data-api', clearMenus).on('click.xe.dropdown.data-api', '.xe-dropdown form', function (e) {
    e.stopPropagation();
  }).on('click.xe.dropdown.data-api', toggle, Dropdown.prototype.toggle).on('keydown.xe.dropdown.data-api', toggle, Dropdown.prototype.keydown).on('keydown.xe.dropdown.data-api', '.xe-dropdown-menu', Dropdown.prototype.keydown);
})(window.jQuery);

/***/ }),
/* 18 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

/**
 * @name jQuery xeTooltip plugin
 */
(function ($) {
  // TOOLTIP PUBLIC CLASS DEFINITION
  // ===============================

  var Tooltip = function Tooltip(element, options) {
    this.type = null;
    this.options = null;
    this.enabled = null;
    this.timeout = null;
    this.hoverState = null;
    this.$element = null;
    this.inState = null;

    this.init('tooltip', element, options);
  };

  Tooltip.VERSION = '3.3.6';

  Tooltip.TRANSITION_DURATION = 150;

  Tooltip.DEFAULTS = {
    animation: true,
    placement: 'top',
    selector: false,
    template: '<div class="xe-tooltip" role="xe-tooltip"><div class="xe-tooltip-arrow"></div><div class="xe-tooltip-inner"></div></div>',
    trigger: 'hover focus',
    title: '',
    delay: 0,
    html: false,
    container: false,
    viewport: {
      selector: 'body',
      padding: 0
    }
  };

  Tooltip.prototype.init = function (type, element, options) {
    this.enabled = true;
    this.type = type;
    this.$element = $(element);
    this.options = this.getOptions(options);
    this.$viewport = this.options.viewport && $($.isFunction(this.options.viewport) ? this.options.viewport.call(this, this.$element) : this.options.viewport.selector || this.options.viewport);
    this.inState = { click: false, hover: false, focus: false };

    if (this.$element[0] instanceof document.constructor && !this.options.selector) {
      throw new Error('`selector` option must be specified when initializing ' + this.type + ' on the window.document object!');
    }

    var triggers = this.options.trigger.split(' ');

    for (var i = triggers.length; i--;) {
      var trigger = triggers[i];

      if (trigger == 'click') {
        this.$element.on('click.' + this.type, this.options.selector, $.proxy(this.toggle, this));
      } else if (trigger != 'manual') {
        var eventIn = trigger == 'hover' ? 'mouseenter' : 'focusin';
        var eventOut = trigger == 'hover' ? 'mouseleave' : 'focusout';

        this.$element.on(eventIn + '.' + this.type, this.options.selector, $.proxy(this.enter, this));
        this.$element.on(eventOut + '.' + this.type, this.options.selector, $.proxy(this.leave, this));
      }
    }

    this.options.selector ? this._options = $.extend({}, this.options, { trigger: 'manual', selector: '' }) : this.fixTitle();
  };

  Tooltip.prototype.getDefaults = function () {
    return Tooltip.DEFAULTS;
  };

  Tooltip.prototype.getOptions = function (options) {
    options = $.extend({}, this.getDefaults(), this.$element.data(), options);

    if (options.delay && typeof options.delay === 'number') {
      options.delay = {
        show: options.delay,
        hide: options.delay
      };
    }

    return options;
  };

  Tooltip.prototype.getDelegateOptions = function () {
    var options = {};
    var defaults = this.getDefaults();

    this._options && $.each(this._options, function (key, value) {
      if (defaults[key] != value) options[key] = value;
    });

    return options;
  };

  Tooltip.prototype.enter = function (obj) {
    var self = obj instanceof this.constructor ? obj : $(obj.currentTarget).data('xe.' + this.type);

    if (!self) {
      self = new this.constructor(obj.currentTarget, this.getDelegateOptions());
      $(obj.currentTarget).data('bxes.' + this.type, self);
    }

    if (obj instanceof $.Event) {
      self.inState[obj.type == 'focusin' ? 'focus' : 'hover'] = true;
    }

    if (self.tip().hasClass('in') || self.hoverState == 'in') {
      self.hoverState = 'in';
      return;
    }

    clearTimeout(self.timeout);

    self.hoverState = 'in';

    if (!self.options.delay || !self.options.delay.show) return self.show();

    self.timeout = setTimeout(function () {
      if (self.hoverState == 'in') self.show();
    }, self.options.delay.show);
  };

  Tooltip.prototype.isInStateTrue = function () {
    for (var key in this.inState) {
      if (this.inState[key]) return true;
    }

    return false;
  };

  Tooltip.prototype.leave = function (obj) {
    var self = obj instanceof this.constructor ? obj : $(obj.currentTarget).data('xe.' + this.type);

    if (!self) {
      self = new this.constructor(obj.currentTarget, this.getDelegateOptions());
      $(obj.currentTarget).data('xe.' + this.type, self);
    }

    if (obj instanceof $.Event) {
      self.inState[obj.type == 'focusout' ? 'focus' : 'hover'] = false;
    }

    if (self.isInStateTrue()) return;

    clearTimeout(self.timeout);

    self.hoverState = 'out';

    if (!self.options.delay || !self.options.delay.hide) return self.hide();

    self.timeout = setTimeout(function () {
      if (self.hoverState == 'out') self.hide();
    }, self.options.delay.hide);
  };

  Tooltip.prototype.show = function () {
    var e = $.Event('show.xe.' + this.type);

    if (this.hasContent() && this.enabled) {
      this.$element.trigger(e);

      var inDom = $.contains(this.$element[0].ownerDocument.documentElement, this.$element[0]);
      if (e.isDefaultPrevented() || !inDom) return;
      var _this = this;

      var $tip = this.tip();

      var tipId = this.getUID(this.type);

      this.setContent();
      $tip.attr('id', tipId);
      this.$element.attr('aria-describedby', tipId);

      if (this.options.animation) $tip.addClass('fade');

      var placement = typeof this.options.placement === 'function' ? this.options.placement.call(this, $tip[0], this.$element[0]) : this.options.placement;

      var autoToken = /\s?auto?\s?/i;
      var autoPlace = autoToken.test(placement);
      if (autoPlace) placement = placement.replace(autoToken, '') || 'top';

      $tip.detach().css({ top: 0, left: 0, display: 'block' }).addClass(placement).data('xe.' + this.type, this);

      this.options.container ? $tip.appendTo(this.options.container) : $tip.insertAfter(this.$element);
      this.$element.trigger('inserted.xe.' + this.type);

      var pos = this.getPosition();
      var actualWidth = $tip[0].offsetWidth;
      var actualHeight = $tip[0].offsetHeight;

      if (autoPlace) {
        var orgPlacement = placement;
        var viewportDim = this.getPosition(this.$viewport);

        placement = placement == 'bottom' && pos.bottom + actualHeight > viewportDim.bottom ? 'top' : placement == 'top' && pos.top - actualHeight < viewportDim.top ? 'bottom' : placement == 'right' && pos.right + actualWidth > viewportDim.width ? 'left' : placement == 'left' && pos.left - actualWidth < viewportDim.left ? 'right' : placement;

        $tip.removeClass(orgPlacement).addClass(placement);
      }

      var calculatedOffset = this.getCalculatedOffset(placement, pos, actualWidth, actualHeight);

      this.applyPlacement(calculatedOffset, placement);

      var complete = function complete() {
        var prevHoverState = _this.hoverState;
        _this.$element.trigger('shown.xe.' + _this.type);
        _this.hoverState = null;

        if (prevHoverState == 'out') _this.leave(_this);
      };

      $.support.transition && this.$tip.hasClass('fade') ? $tip.one('xeTransitionEnd', complete).emulateTransitionEnd(Tooltip.TRANSITION_DURATION) : complete();
    }
  };

  Tooltip.prototype.applyPlacement = function (offset, placement) {
    var $tip = this.tip();
    var width = $tip[0].offsetWidth;
    var height = $tip[0].offsetHeight;

    // manually read margins because getBoundingClientRect includes difference
    var marginTop = parseInt($tip.css('margin-top'), 10);
    var marginLeft = parseInt($tip.css('margin-left'), 10);

    // we must check for NaN for ie 8/9
    if (isNaN(marginTop)) marginTop = 0;
    if (isNaN(marginLeft)) marginLeft = 0;

    offset.top += marginTop;
    offset.left += marginLeft;

    // $.fn.offset doesn't round pixel values
    // so we use setOffset directly with our own function B-0
    $.offset.setOffset($tip[0], $.extend({
      using: function using(props) {
        $tip.css({
          top: Math.round(props.top),
          left: Math.round(props.left)
        });
      }
    }, offset), 0);

    $tip.addClass('in');

    // check to see if placing tip in new offset caused the tip to resize itself
    var actualWidth = $tip[0].offsetWidth;
    var actualHeight = $tip[0].offsetHeight;

    if (placement == 'top' && actualHeight != height) {
      offset.top = offset.top + height - actualHeight;
    }

    var delta = this.getViewportAdjustedDelta(placement, offset, actualWidth, actualHeight);

    if (delta.left) offset.left += delta.left;else offset.top += delta.top;

    var isVertical = /top|bottom/.test(placement);
    var arrowDelta = isVertical ? delta.left * 2 - width + actualWidth : delta.top * 2 - height + actualHeight;
    var arrowOffsetPosition = isVertical ? 'offsetWidth' : 'offsetHeight';

    $tip.offset(offset);
    this.replaceArrow(arrowDelta, $tip[0][arrowOffsetPosition], isVertical);
  };

  Tooltip.prototype.replaceArrow = function (delta, dimension, isVertical) {
    this.arrow().css(isVertical ? 'left' : 'top', 50 * (1 - delta / dimension) + '%').css(isVertical ? 'top' : 'left', '');
  };

  Tooltip.prototype.setContent = function () {
    var $tip = this.tip();
    var title = this.getTitle();

    $tip.find('.xe-tooltip-inner')[this.options.html ? 'html' : 'text'](title);
    $tip.removeClass('fade in top bottom left right');
  };

  Tooltip.prototype.hide = function (callback) {
    var _this = this;
    var $tip = $(this.$tip);
    var e = $.Event('hide.xe.' + this.type);

    function complete() {
      if (_this.hoverState != 'in') $tip.detach();
      _this.$element.removeAttr('aria-describedby').trigger('hidden.xe.' + _this.type);
      callback && callback();
    }

    this.$element.trigger(e);

    if (e.isDefaultPrevented()) return;

    $tip.removeClass('in');

    $.support.transition && $tip.hasClass('fade') ? $tip.one('xeTransitionEnd', complete).emulateTransitionEnd(Tooltip.TRANSITION_DURATION) : complete();

    this.hoverState = null;

    return this;
  };

  Tooltip.prototype.fixTitle = function () {
    var $e = this.$element;
    if ($e.attr('title') || typeof $e.attr('data-original-title') !== 'string') {
      $e.attr('data-original-title', $e.attr('title') || '').attr('title', '');
    }
  };

  Tooltip.prototype.hasContent = function () {
    return this.getTitle();
  };

  Tooltip.prototype.getPosition = function ($element) {
    $element = $element || this.$element;

    var el = $element[0];
    var isBody = el.tagName == 'BODY';

    var elRect = el.getBoundingClientRect();
    if (elRect.width == null) {
      // width and height are missing in IE8, so compute them manually; see https://github.com/twbs/bootstrap/issues/14093
      elRect = $.extend({}, elRect, {
        width: elRect.right - elRect.left,
        height: elRect.bottom - elRect.top
      });
    }

    var elOffset = isBody ? { top: 0, left: 0 } : $element.offset();
    var scroll = { scroll: isBody ? document.documentElement.scrollTop || document.body.scrollTop : $element.scrollTop() };
    var outerDims = isBody ? { width: $(window).width(), height: $(window).height() } : null;

    return $.extend({}, elRect, scroll, outerDims, elOffset);
  };

  Tooltip.prototype.getCalculatedOffset = function (placement, pos, actualWidth, actualHeight) {
    return placement == 'bottom' ? {
      top: pos.top + pos.height,
      left: pos.left + pos.width / 2 - actualWidth / 2
    } : placement == 'top' ? {
      top: pos.top - actualHeight,
      left: pos.left + pos.width / 2 - actualWidth / 2
    } : placement == 'left' ? {
      top: pos.top + pos.height / 2 - actualHeight / 2,
      left: pos.left - actualWidth
      /* placement == 'right' */ } : {
      top: pos.top + pos.height / 2 - actualHeight / 2,
      left: pos.left + pos.width
    };
  };

  Tooltip.prototype.getViewportAdjustedDelta = function (placement, pos, actualWidth, actualHeight) {
    var delta = { top: 0, left: 0 };
    if (!this.$viewport) return delta;

    var viewportPadding = this.options.viewport && this.options.viewport.padding || 0;
    var viewportDimensions = this.getPosition(this.$viewport);

    if (/right|left/.test(placement)) {
      var topEdgeOffset = pos.top - viewportPadding - viewportDimensions.scroll;
      var bottomEdgeOffset = pos.top + viewportPadding - viewportDimensions.scroll + actualHeight;
      if (topEdgeOffset < viewportDimensions.top) {
        // top overflow
        delta.top = viewportDimensions.top - topEdgeOffset;
      } else if (bottomEdgeOffset > viewportDimensions.top + viewportDimensions.height) {
        // bottom overflow
        delta.top = viewportDimensions.top + viewportDimensions.height - bottomEdgeOffset;
      }
    } else {
      var leftEdgeOffset = pos.left - viewportPadding;
      var rightEdgeOffset = pos.left + viewportPadding + actualWidth;
      if (leftEdgeOffset < viewportDimensions.left) {
        // left overflow
        delta.left = viewportDimensions.left - leftEdgeOffset;
      } else if (rightEdgeOffset > viewportDimensions.right) {
        // right overflow
        delta.left = viewportDimensions.left + viewportDimensions.width - rightEdgeOffset;
      }
    }

    return delta;
  };

  Tooltip.prototype.getTitle = function () {
    var title;
    var $e = this.$element;
    var o = this.options;

    title = $e.attr('data-original-title') || (typeof o.title === 'function' ? o.title.call($e[0]) : o.title);

    return title;
  };

  Tooltip.prototype.getUID = function (prefix) {
    do {
      prefix += ~~(Math.random() * 1000000);
    } while (document.getElementById(prefix));
    return prefix;
  };

  Tooltip.prototype.tip = function () {
    if (!this.$tip) {
      this.$tip = $(this.options.template);
      if (this.$tip.length != 1) {
        throw new Error(this.type + ' `template` option must consist of exactly 1 top-level element!');
      }
    }

    return this.$tip;
  };

  Tooltip.prototype.arrow = function () {
    return this.$arrow = this.$arrow || this.tip().find('.xe-tooltip-arrow');
  };

  Tooltip.prototype.enable = function () {
    this.enabled = true;
  };

  Tooltip.prototype.disable = function () {
    this.enabled = false;
  };

  Tooltip.prototype.toggleEnabled = function () {
    this.enabled = !this.enabled;
  };

  Tooltip.prototype.toggle = function (e) {
    var _this = this;
    if (e) {
      _this = $(e.currentTarget).data('xe.' + this.type);
      if (!_this) {
        _this = new this.constructor(e.currentTarget, this.getDelegateOptions());
        $(e.currentTarget).data('xe.' + this.type, _this);
      }
    }

    if (e) {
      _this.inState.click = !_this.inState.click;
      if (_this.isInStateTrue()) _this.enter(_this);else _this.leave(_this);
    } else {
      _this.tip().hasClass('in') ? _this.leave(_this) : _this.enter(_this);
    }
  };

  Tooltip.prototype.destroy = function () {
    var _this = this;
    clearTimeout(this.timeout);
    this.hide(function () {
      _this.$element.off('.' + _this.type).removeData('xe.' + _this.type);
      if (_this.$tip) {
        _this.$tip.detach();
      }

      _this.$tip = null;
      _this.$arrow = null;
      _this.$viewport = null;
    });
  };

  // TOOLTIP PLUGIN DEFINITION
  // =========================

  function Plugin(option) {
    return this.each(function () {
      var $this = $(this);
      var data = $this.data('xe.tooltip');
      var options = (typeof option === 'undefined' ? 'undefined' : _typeof(option)) === 'object' && option;

      if (!data && /destroy|hide/.test(option)) return;
      if (!data) $this.data('xe.tooltip', data = new Tooltip(this, options));
      if (typeof option === 'string') data[option]();
    });
  }

  var old = $.fn.tooltip;

  $.fn.xeTooltip = Plugin;
  $.fn.xeTooltip.Constructor = Tooltip;

  // TOOLTIP NO CONFLICT
  // ===================

  $.fn.xeTooltip.noConflict = function () {
    $.fn.tooltip = old;
    return this;
  };
})(window.jQuery);

/***/ }),
/* 19 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = (__webpack_require__(1))(108);

/***/ }),
/* 20 */,
/* 21 */,
/* 22 */,
/* 23 */,
/* 24 */,
/* 25 */,
/* 26 */,
/* 27 */,
/* 28 */,
/* 29 */,
/* 30 */,
/* 31 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(32);


/***/ }),
/* 32 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _jquery = __webpack_require__(0);

var _jquery2 = _interopRequireDefault(_jquery);

var _xe = __webpack_require__(6);

var _xe2 = _interopRequireDefault(_xe);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

// TODO:: mouseover,

var Keys = {
  ENTER: 13,
  TAB: 9,
  BACKSPACE: 8,
  UP_ARROW: 38,
  DOWN_ARROW: 40,
  ESCAPE: 27
};

var Permission = function () {
  function Permission(_ref) {
    var $wrapper = _ref.$wrapper,
        key = _ref.key,
        userSearchUrl = _ref.userSearchUrl,
        groupSearchUrl = _ref.groupSearchUrl,
        permission = _ref.permission,
        type = _ref.type,
        vgroupAll = _ref.vgroupAll;

    _classCallCheck(this, Permission);

    this.$wrapper = $wrapper;
    this.key = key;
    this.userSearchUrl = userSearchUrl;
    this.groupSearchUrl = groupSearchUrl;
    this.permission = permission;
    this.type = type;
    this.vgroupAll = vgroupAll;
    this.query = '';
    this.suggestion = [];
    this.placeholder = _xe2.default.Lang.trans('xe::explainIncludeUserOrGroup');
    this.selectedIndex = '';
    this.includeSelectedIndex = -1;
    this.excludeSelectedIndex = -1;
    this.MIN_QUERY_LENGTH = 2;
  }

  _createClass(Permission, [{
    key: 'bindEvents',
    value: function bindEvents() {
      var _this = this;

      this.$wrapper.on('change', '.chkModeAble', function (e) {
        var $target = (0, _jquery2.default)(e.target);
        var checked = $target.is(':checked');

        if (checked) {
          _this.$wrapper.find('input:not(.chkModeAble)').prop('disabled', true);
        } else {
          _this.$wrapper.find('input:not(.chkModeAble)').prop('disabled', false);
        }
      });

      this.$wrapper.on('keydown', '.inputUserGroup', function (e) {
        var query = e.target.value.trim();
        var $this = (0, _jquery2.default)(this);
        var keyCode = e.keyCode;
        var $ul = $this.parent().find('.ReactTags__suggestions ul');
        var dataInput = $this.data('input'); // include, exclude

        if (query.length >= _this.MIN_QUERY_LENGTH) {
          if ($ul.length > 0) {
            var index = parseInt($this.data('index'), 10);
            var focusedIndex = 0;

            switch (keyCode) {
              case Keys.UP_ARROW:
                if (index == 0) {
                  focusedIndex = $ul.find('li').length - 1;
                } else {
                  focusedIndex = index - 1;
                }

                $this.data('index', focusedIndex);
                $ul.find('li').eq(focusedIndex).addClass('active').siblings().removeClass('active');

                break;
              case Keys.DOWN_ARROW:
                if (index == $ul.find('li').length - 1) {
                  focusedIndex = 0;
                } else {
                  focusedIndex = index + 1;
                }

                $this.data('index', focusedIndex);
                $ul.find('li').eq(focusedIndex).addClass('active').siblings().removeClass('active');

                break;
              case Keys.ENTER:
              case Keys.TAB:
                e.preventDefault();

                if ($ul.find('li.active').length > 0) {
                  var tag = $ul.find('li.active').data('tag');
                  var name = '';
                  var pType = '';
                  var prefix = '';

                  // user
                  if ($ul.data('target') == 'user') {
                    // include
                    if (dataInput == 'include') {
                      name = _this.type + 'User';
                      pType = 'user';
                      prefix = '@';
                      // exclude
                    } else {
                      name = _this.type + 'Except';
                      pType = 'except';
                      prefix = '@';
                    }
                    // group
                  } else {
                    name = _this.type + 'Group';
                    pType = 'group';
                    prefix = '%';
                  }

                  var pTypes = _this.permission[pType];
                  var bSameWord = false;

                  if (pTypes.length > 0) {
                    pTypes.forEach(function (type, i) {
                      if (type.id === tag.id) {
                        bSameWord = true;
                      }
                    });

                    if (!bSameWord) {
                      _this.permission[pType].push(tag);
                    }
                  } else {
                    _this.permission[pType].push(tag);
                  }

                  var ids = _this.permission[pType].map(function (tag) {
                    return tag.id;
                  });

                  if (!bSameWord) {
                    $ul.closest('.ReactTags__tags').find('[name=' + name + ']').val(ids.join().trim());
                    $ul.closest('.ReactTags__tags').find('.' + pType + 'Wrap').append('<span class="ReactTags__tag">' + (prefix + (tag.display_name || tag.name)) + '<a class="ReactTags__remove btnRemoveTag" data-id="' + tag.id + '">x</a></span>');
                  }

                  $ul.remove();
                  $this.val('').data('index', -1).focus();
                }

                e.preventDefault(); // prevent tab

                break;
              case Keys.ESCAPE:
                _this[dataInput + 'SelectedIndex'] = 0;
                $ul.parent().empty();
                $this.focus();
                break;
            }
          }
        } else {
          if (Keys.BACKSPACE === keyCode) {
            var $tag = $this.closest('.ReactTags__tags').find('.ReactTags__selected span');
            if (!query && $tag.length > 0) {
              _this.removeTag($tag.eq($tag.length - 1));
            }
          }
        }
      });

      this.$wrapper.find('.ReactTags__suggestions').on('mouseenter', 'li', function () {
        var $this = (0, _jquery2.default)(this);
        var $ul = $this.closest('ul');

        $this.addClass('active').siblings().removeClass('active');
      });

      this.$wrapper.find('.ReactTags__suggestions').on('click', 'li', function () {
        var $this = (0, _jquery2.default)(this);
        var tag = $this.data('tag');
        var $ul = $this.closest('ul');
        var $input = $this.closest('.ReactTags__tagInput').find('input:text');
        var dataInput = $input.data('input');
        var id = tag.id;
        var name = '';
        var pType = '';
        var prefix = '';

        if ($ul.data('target') == 'user') {
          // include
          if (dataInput == 'include') {
            name = _this.type + 'User';
            pType = 'user';
            prefix = '@';
            // exclude
          } else {
            name = _this.type + 'Except';
            pType = 'except';
            prefix = '@';
          }
          // group
        } else {
          name = _this.type + 'Group';
          pType = 'group';
          prefix = '%';
        }

        var pTypes = _this.permission[pType];
        var bSameWord = false;

        if (pTypes.length > 0) {
          pTypes.forEach(function (type, i) {
            if (type.id === tag.id) {
              bSameWord = true;
            }
          });

          if (!bSameWord) {
            _this.permission[pType].push(tag);
          }
        } else {
          _this.permission[pType].push(tag);
        }

        var ids = _this.permission[pType].map(function (tag) {
          return tag.id;
        });

        if (!bSameWord) {
          $ul.closest('.ReactTags__tags').find('[name=' + name + ']').val(ids.join().trim());
          $ul.closest('.ReactTags__tags').find('.' + pType + 'Wrap').append('<span class="ReactTags__tag">' + (prefix + (tag.display_name || tag.name)) + '<a class="ReactTags__remove btnRemoveTag" data-id="' + tag.id + '">x</a></span>');
        }

        $ul.remove();
        $input.val('').data('index', -1).focus();
      });

      this.$wrapper.on('keyup', '.inputUserGroup', function (e) {
        var query = e.target.value.trim();
        var $this = (0, _jquery2.default)(this);
        var keyCode = e.keyCode;

        if (query.length >= _this.MIN_QUERY_LENGTH) {
          if ([Keys.ENTER, Keys.TAB, Keys.UP_ARROW, Keys.DOWN_ARROW, Keys.ESCAPE, 37, 39].indexOf(keyCode) == -1) {
            var temp = '';
            temp += '<ul>';
            temp += '<li>Searching ... <span class="spinner" role="spinner"><span class="spinner-icon"></span></span></li>';
            temp += '</ul>';

            $this.parent().find('.ReactTags__suggestions').html(temp);

            var identifier = query.substr(0, 1);
            switch (identifier) {
              case '@':
                query = query.substr(1, query.length);
                _this.searchUser($this, query);
                break;

              case '%':
                query = query.substr(1, query.length);
                _this.searchGroup($this, query);
                break;

              default:
                break;
            }
          }
        } else {
          $this.parent().find('.ReactTags__suggestions').empty();
        }
      });

      this.$wrapper.on('click', '.btnRemoveTag', function (e) {
        e.preventDefault();

        _this.removeTag((0, _jquery2.default)(this).closest('span'));
      });
    }
  }, {
    key: 'makeIt',
    value: function makeIt(item, query) {
      var escapedRegex = query.trim().replace(/[-\\^$*+?.()|[\]{}]/g, '\\$&');
      var r = RegExp(escapedRegex, 'gi');
      var itemName = item.display_name || item.name;

      return itemName.replace(r, '<mark>$&</mark>');
    }
  }, {
    key: 'removeTag',
    value: function removeTag($target) {
      var _this = this;
      var pType = $target.closest('.ReactTags__selected').data('ptype');
      var id = $target.data('id');
      var name = '';

      switch (pType) {
        case 'user':
          name = _this.type + 'User';
          break;
        case 'except':
          name = _this.type + 'Except';
          break;
        case 'group':
          name = _this.type + 'Group';
          break;
      }

      var pTypes = _this.permission[pType];

      pTypes.forEach(function (type, i) {
        if (type.id !== id) {
          _this.permission[pType].splice(i, 1); // .push(tag);
        }
      });

      var ids = _this.permission[pType].map(function (tag) {
        return tag.id;
      });

      $target.closest('.ReactTags__tags').find('[name=' + name + ']').val(ids.join().trim());
      $target.remove();
    }
  }, {
    key: 'searchUser',
    value: function searchUser($input, keyword) {
      var _this = this;
      var searchUserUrl = _this.userSearchUrl;

      _jquery2.default.ajax({
        url: searchUserUrl + '/' + keyword,
        method: 'get',
        dataType: 'json',
        cache: false,
        success: function success(data) {
          if (data.length > 0) {
            var temp = '';
            temp += '<ul data-target="user">';

            data.forEach(function (item, i) {
              temp += '<li class="" data-tag=\'' + JSON.stringify(item) + '\'>';
              temp += '<span>' + _this.makeIt(item, keyword) + '</span>';
              temp += '</li>';
            });

            temp += '</ul>';

            $input.parent().find('.ReactTags__suggestions').html(temp);
          } else {
            $input.parent().find('.ReactTags__suggestions').empty();
          }
        },
        error: function error(xhr, status, err) {}
      });
    }
  }, {
    key: 'searchGroup',
    value: function searchGroup($input, keyword) {
      var _this = this;
      var searchGroupUrl = _this.groupSearchUrl;

      _jquery2.default.ajax({
        url: searchGroupUrl + '/' + keyword,
        method: 'get',
        dataType: 'json',
        cache: false,
        success: function success(data) {
          console.log(data);
          // TODO:: view renderin
          if (data.length > 0) {
            var temp = '';
            temp += '<ul data-target="group">';

            data.forEach(function (item, i) {
              temp += '<li data-tag=\'' + JSON.stringify(item) + '\'>';
              temp += '<span>' + _this.makeIt(item, keyword) + '</span>';
              temp += '</li>';
            });

            temp += '</ul>';

            $input.parent().find('.ReactTags__suggestions').html(temp);
          } else {
            $input.parent().find('.ReactTags__suggestions').empty();
          }
        },
        error: function error(xhr, status, err) {}
      });
    }
  }, {
    key: 'render',
    value: function render() {
      var _this = this;
      var mode = this.permission.mode;
      var rating = this.permission.rating;
      var modeEnable = false;
      var permissionTypes = [{ value: 'super', name: _xe2.default.Lang.trans('xe::memberRatingAdministrator') }, { value: 'manager', name: _xe2.default.Lang.trans('xe::memberRatingManager') }, { value: 'user', name: _xe2.default.Lang.trans('xe::member') }, { value: 'guest', name: _xe2.default.Lang.trans('xe::guest') }];

      var disabled = false;

      if (mode === 'manual' || mode === 'inherit') {
        modeEnable = true;
        if (mode !== 'manual') {
          disabled = true;
        }
      }

      var includeGroups = this.permission.group.map(function (group) {
        return group.id;
      });

      var includeUsers = this.permission.user.map(function (user) {
        return user.id;
      });

      var excludeUsers = this.permission.except.map(function (user) {
        return user.id;
      });

      var temp = '';
      temp += '<div>';

      if (modeEnable) {
        var checked = mode === 'inherit' ? 'checked="checked"' : '';

        temp += '<div class="form-group">';
        temp += '<div class="checkbox">';
        temp += '<label><input type="checkbox" name="' + (this.type + 'Mode') + '" class="chkModeAble" value="inherit" ' + checked + ' /> ' + _xe2.default.Lang.trans('xe::inheritMode') + '</label>';
        temp += '</div>';
        temp += '</div>';
      }

      temp += '<div class="form-group">';
      temp += '<label>\uD68C\uC6D0 \uB4F1\uAE09</label>';
      temp += '<div class="radio">';
      permissionTypes.forEach(function (permissionType) {
        var checked = permissionType.value == rating ? 'checked' : '';

        temp += '<label><input type="radio" ' + (disabled ? 'disabled="disabled"' : '') + ' name="' + (_this.type + 'Rating') + '" value="' + permissionType.value + '" ' + (checked ? 'checked="checked"' : '') + ' /> ' + permissionType.name + ' &nbsp;</label>';
      });
      temp += '</div>';
      temp += '</div>';
      temp += '<div class="form-group">';
      temp += '<label>' + _xe2.default.Lang.trans('xe::includeUserOrGroup') + '</label>';
      temp += '<div class="ReactTags__tags">';

      temp += '<div class="ReactTags__selected groupWrap" data-ptype="group">';
      this.permission.group.forEach(function (g) {
        var tag = g;
        var label = '%' + (tag.display_name || tag.name);

        temp += '<span class="ReactTags__tag">' + label + '<a href="#" class="ReactTags__remove btnRemoveTag" data-id="' + tag.id + '">x</a></span>';
      });
      temp += '</div>';

      temp += '<div class="ReactTags__selected userWrap" data-ptype="user">';
      this.permission.user.forEach(function (tag) {
        var label = '@' + (tag.display_name || tag.name);

        temp += '<span class="ReactTags__tag">' + label + '<a href="#" class="ReactTags__remove btnRemoveTag" data-id="' + tag.id + '|">x</a></span>';
      });
      temp += '</div>';

      temp += '<div class="ReactTags__tagInput">';
      temp += '<input type="text" placeholder="' + this.placeholder + '" class="form-control inputUserGroup" data-input="include" ' + (disabled ? 'disabled="disabled"' : '') + ' value="' + this.query + '" data-index="-1" />'; // TODO:: PermissionInclude handleKeyDown
      temp += '<div class="ReactTags__suggestions" data-input="include"></div>';
      temp += '</div>'; // ReactTags__tagInput
      temp += '<input type="hidden" name="' + (this.type + 'Group') + '" class="form-control includeGroups" value="' + includeGroups.join().trim() + '" />';
      temp += '<input type="hidden" name="' + (this.type + 'User') + '" class="form-control includeUsers" value="' + includeUsers.join().trim() + '" />';
      temp += '</div>'; // ReactTags__tags
      temp += '</div>'; // form-group

      if (this.vgroupAll.length >= 1) {
        temp += '<div class="form-group">';
        temp += '<label>' + _xe2.default.Lang.trans('xe::includeVGroup') + '</label>';

        temp += _this.vgroupAll.map(function (data) {
          var checked = false;

          var inArray = function inArray(val, arr) {
            for (var i = 0; i < arr.length; i++) {
              if (arr[i] == val) {
                return i;
              }
            }

            return -1;
          };

          if (inArray(data.id, this.permission.vgroup) != -1) {
            checked = true;
          }

          return '<label><input type="checkbox" ' + (disabled ? 'disabled="disabled"' : '') + ' name="' + (_this.type + 'VGroup[]') + '" value="' + data.id + '" ' + (checked ? 'checked="checked"' : '') + ' /> ' + data.title + ' &nbsp;</label>';
        });

        temp += '</div>';
      }

      temp += '<div class="form-group">';
      temp += '<label>' + _xe2.default.Lang.trans('xe::excludeUser') + '</label>';
      temp += '<div class="ReactTags__tags">';
      temp += '<div class="ReactTags__selected exceptWrap" data-ptype="except">';

      this.permission.except.forEach(function (tag) {
        var label = tag.display_name || tag.name;
        label = '@' + label;

        temp += '<span class="ReactTags__tag">' + label + '<a href="#" class="ReactTags__remove btnRemoveTag" data-id="' + tag.id + '">x</a></span>';
      });

      temp += '</div>';
      temp += '<div class="ReactTags__tagInput">';
      temp += '<input type="text" placeholder="' + _xe2.default.Lang.trans('xe::explainExcludeUser') + '" class="form-control inputUserGroup" data-input="exclude" ' + (disabled ? 'disabled="disabled"' : '') + ' data-index="-1" />'; // TODO:: PermissionExclude handleKeyDown
      temp += '<div class="ReactTags__suggestions" data-input="exclude"></div>';
      temp += '</div>'; // ReactTags__tagInput
      temp += '<input type="hidden" name="' + (this.type + 'Except') + '" class="form-control excludeUsers" value="' + excludeUsers + '" />';
      temp += '</div>'; // ReactTags__tags
      temp += '</div>'; // form-group

      temp += '</div>';

      this.$wrapper.html(temp);
    }
  }]);

  return Permission;
}();

(0, _jquery2.default)('.__xe__uiobject_permission').each(function (i) {
  var $this = (0, _jquery2.default)(this);
  var permission = $this.data('data');

  var key = $this.data('key');
  var type = $this.data('type');
  var userSearchUrl = $this.data('userUrl');
  var groupSearchUrl = $this.data('groupUrl');
  var vgroupAll = $this.data('vgroupAll');

  var p = new Permission({ $wrapper: $this, key: key, userSearchUrl: userSearchUrl, groupSearchUrl: groupSearchUrl, permission: permission, type: type, vgroupAll: vgroupAll });
  p.render();
  p.bindEvents();
});

/***/ })
/******/ ]);