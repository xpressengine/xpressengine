var instances = [];
var cssLoaded = false;

var Progress = {
  cssLoad: function () {
    if (cssLoaded === false) {
      cssLoaded = true;
      DynamicLoadManager.cssLoad('/assets/core/common/css/progress.css'); // @TODO
    }
  },

  start: function (context) {
    if ($('link[href*="assets/core/common/css/progress.css"]').length == 0) {
      DynamicLoadManager.cssLoad('/assets/core/common/css/progress.css'); // @TODO
    }

    var $context = $(context);
    if ($context.context === undefined) {
      $context = $('body');
    }

    setInstance($context);

    $context.trigger('progressStart');
  },

  done: function (context) {
    var $context = $(context);
    if ($context.context === undefined) {
      $context = $('body');
    }

    $context.trigger('progressDone');
  },
};

function getInstance($context) {
  var instanceId = $context.attr('data-progress-instance');

  var instance = null;
  if (instanceId != undefined) {
    instance = instances[instanceId];
  }

  return instance;
}

function getCount($context) {
  var count = $context.attr('data-progress-count');

  if (count != undefined) {
    count = parseInt(count);
  }

  return count;
}

function setCount($context, count) {
  if (parseInt(count) < 0) {
    count = 0;
  }

  $context.attr('data-progress-count', count);
}

function setInstance($context, instance) {
  if (getInstance($context) === null) {
    var progress = new XeProgress();
    var parent = 'body';
    var type = $context.data('progress-type') === undefined ? 'default' : $context.data('progress-type');
    var showSpinner = type !== 'nospin';

    if ($context.attr('id') !== undefined) {
      parent = '#' + $context.attr('id');
    } else if ($context.selector !== undefined) {
      parent = $context.selector;
    }

    progress.configure({
      parent: parent,
      type: type,
      showSpinner: showSpinner,
    });
    instances.push(progress);
    var instanceId = instances.length - 1;
    $context.attr('data-progress-instance', instanceId);

    progress.setInstanceId(instanceId);

    setCount($context, 0);
    attachInstance($context);
  }
}

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

    var count = getCount($(this)) - 1;
    setCount($(this), count);
    if (getCount($(this)) === 0) {
      var instance = getInstance($context);
      instance.done(instance.getTime());
    }
  });
}

/**
 * progress bar 없이 spinner 만 사용
 */
var xeSpinner = function () {

};

/**
 * NProgress, (c) 2013, 2014 Rico Sta. Cruz - http://ricostacruz.com/nprogress
 * @license MIT
 *
 * NProgress 모듈을 instance 화 할 수 있도록 하기위해 수정함
 * */
function XeProgress() {
  this.settings = {
    type: 'default',    // defautl, cover, nospin
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
    parent: 'body',
    template: {
      default: '<div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div>',
      cover: '<div class="cover" role="bar"><div class="peg"></div></div><div class="spinner spinner-center" role="spinner"><div class="spinner-icon"></div></div>',
    },
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
    $.extend(this.settings, options);
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

    var work = function () {
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
    this.status = (n === 1 ? null : n);

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
          opacity: 1,
        });

        setTimeout(function () {
          Progress.css(_this.$progress, {
            transition: 'all ' + speed + 'ms linear',
            opacity: 0,
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
    //if (this.isRendered()) {
    //    return $(this.settings.parent).children('.xe-progress');
    //}

    if (this.isRendered()) {
      return this.$progress;
    }

    var $progress = $('<div>');
    $progress.addClass('xe-progress');
    if (this.settings.template[this.settings.type] === undefined) {
      this.settings.type = 'default';
    }

    $progress.html(this.settings.template[this.settings.type]);

    var $bar = $progress.find(this.settings.barSelector);
    var perc = fromStart ? '-100' : toBarPerc(this.status || 0);
    var $parent = $(this.settings.parent);
    var $spinner;

    $bar.attr('title-name', this.instanceId);
    this.$bar = $bar;

    Progress.css($bar, {
      transition: 'all 0 linear',
      transform: 'translate3d(' + perc + '%,0,0)',
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

    $(this.settings.parent).removeClass('xe-progress-custom-parent xe-progress-' + this.settings.type);

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
    //return !!$(this.settings.parent).children('.xe-progress').length;
    return this.$progress !== null;
  };

  /**
   * Determine which positioning CSS rule to use.
   */
  this.getPositioningCSS = function () {
    var bodyStyle = document.body.style;

    // Sniff prefixes
    var vendorPrefix = ('WebkitTransform' in bodyStyle) ? 'Webkit' :
      ('MozTransform' in bodyStyle) ? 'Moz' :
        ('msTransform' in bodyStyle) ? 'ms' :
          ('OTransform' in bodyStyle) ? 'O' : '';

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
 */
function clamp(n, min, max) {
  if (n < min) return min;
  if (n > max) return max;
  return n;
}

function toBarPerc(n) {
  return (-1 + n) * 100;
}

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

//queue
var pending = [];

function next() {
  var fn = pending.shift();
  if (fn) {
    fn(next);
  }
}

Progress.queue = function (fn) {
  pending.push(fn);
  if (pending.length == 1) next();
};

//css
var cssPrefixes = ['Webkit', 'O', 'Moz', 'ms'];
var cssProps = {};

function camelCase(string) {
  return string.replace(/^-ms-/, 'ms-').replace(/-([\da-z])/gi, function (match, letter) {
    return letter.toUpperCase();
  });
}

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

function getStyleProp(name) {
  name = camelCase(name);
  return cssProps[name] || (cssProps[name] = getVendorProp(name));
}

function applyCss(element, prop, value) {
  prop = getStyleProp(prop);
  if (element) {
    element[0].style[prop] = value;
  }
}

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

export default Progress;

