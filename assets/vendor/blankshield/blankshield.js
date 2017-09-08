;(function(root) {
  'use strict';

  /**
   * Detect IE versions older than 11.
   *
   * @var {boolean}
   */
  var oldIE = navigator.userAgent.indexOf('MSIE') !== -1;

  /**
   * Cached window.open function.
   *
   * @var {function}
   */
  var open = window.open;

  /**
   * blankshield is the main function exported by the library. It accepts an
   * anchor element or array of elements, adding an event listener to each to
   * help mitigate a potential reverse tabnabbing attack. For performance, any
   * supplied object with a length attribute is assumed to be an array.
   *
   * @param {HTMLAnchorElement|HTMLAnchorElement[]} target
   */
  function blankshield(target) {
    if (typeof target.length === 'undefined') {
      addEventListener(target, 'click', clickListener);
    } else if (typeof target !== 'string' && !(target instanceof String)) {
      for (var i = 0; i < target.length; i++) {
        addEventListener(target[i], 'click', clickListener);
      }
    }
  }

  /**
   * Accepts the same arguments as window.open. If the strWindowName is not
   * equal to one of the safe targets (_top, _self or _parent), then it opens
   * the destination url using "window.open" from an injected iframe, then
   * removes the iframe. This behavior applies to all browsers except IE < 11,
   * which use "window.open" followed by setting the child window's opener to
   * null. If the strWindowName is set to some other value, the url is simply
   * opened with window.open().
   *
   * @param   {string} strUrl
   * @param   {string} [strWindowName]
   * @param   {string} [strWindowFeatures]
   * @returns {Window}
   */
  blankshield.open = function(strUrl, strWindowName, strWindowFeatures) {
    var child;

    if (safeTarget(strWindowName)) {
      return open.apply(window, arguments);
    } else if (!oldIE) {
      return iframeOpen(strUrl, strWindowName, strWindowFeatures);
    } else {
      // Replace child.opener for old IE to avoid appendChild errors
      // We do it for all to avoid having to sniff for specific versions
      child = open.apply(window, arguments);
      child.opener = null;
      return child;
    }
  };

  /**
   * Patches window.open() to use blankshield.open() for new window/tab targets.
   */
  blankshield.patch = function() {
    window.open = function() {
      return blankshield.open.apply(this, arguments);
    };
  };

  /**
   * An event listener that can be attached to a click event to protect against
   * reverse tabnabbing. It retrieves the target anchors href, and if the link
   * was intended to open in a new tab or window, the browser's default
   * behavior is canceled. Instead, the destination url is opened using
   * "window.open" from an injected iframe, and the iframe is removed. Except
   * for IE < 11, which uses "window.open" followed by setting the child
   * window's opener to null.
   *
   * @param {Event} e The click event for a given anchor
   */
  function clickListener(e) {
    var target, targetName, href, usedModifier;

    // Use global event object for IE8 and below to get target
    e = e || window.event;
    // Won't work for IE8 and below for cases when e.srcElement
    // refers not to the anchor, but to the element inside it e.g. an image
    target = e.currentTarget || e.srcElement;

    // Ignore anchors without an href
    href = target.getAttribute('href');
    if (!href) return;

    // Ignore anchors without an unsafe target or modifier key
    usedModifier = (e.ctrlKey || e.shiftKey || e.metaKey);
    targetName = target.getAttribute('target');
    if (!usedModifier && (!targetName || safeTarget(targetName))) {
      return;
    }

    blankshield.open(href);

    // IE8 and below don't support preventDefault
    if (e.preventDefault) {
      e.preventDefault();
    } else {
      e.returnValue = false;
    }

    return false;
  }

  /**
   * A cross-browser addEventListener function that adds a listener for the
   * supplied event type to the specified target.
   *
   * @param {object}   target
   * @param {string}   type
   * @param {function} listener
   */
  function addEventListener(target, type, listener) {
    var onType, prevListener;

    // Modern browsers
    if (target.addEventListener) {
      return target.addEventListener(type, listener, false);
    }

    // Older browsers
    onType = 'on' + type;
    if (target.attachEvent) {
      target.attachEvent(onType, listener);
    } else if (target[onType]) {
      prevListener = target[onType];
      target[onType] = function() {
        listener();
        prevListener();
      };
    } else {
      target[onType] = listener;
    }
  }

  /**
   * Opens the provided url by injecting a hidden iframe that calls
   * window.open(), then removes the iframe from the DOM.
   *
   * @param   {string} url The url to open
   * @param   {string} [strWindowName]
   * @param   {string} [strWindowFeatures]
   * @returns {Window}
   */
  function iframeOpen(url, strWindowName, strWindowFeatures) {
    var iframe, iframeDoc, script, openArgs, newWin;

    iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    document.body.appendChild(iframe);
    iframeDoc = iframe.contentDocument || iframe.contentWindow.document;

    openArgs = '"' + url + '"';
    if (strWindowName) {
      openArgs += ', "' + strWindowName + '"';
    }
    if (strWindowFeatures) {
      openArgs += ', "' + strWindowFeatures + '"';
    }

    script = iframeDoc.createElement('script');
    script.type = 'text/javascript';
    script.text = 'window.parent = null; window.top = null;' +
      'window.frameElement = null; var child = window.open(' + openArgs + ');' +
      'child.opener = null';
    iframeDoc.body.appendChild(script);
    newWin = iframe.contentWindow.child;

    document.body.removeChild(iframe);
    return newWin;
  }

  /**
   * Returns whether or not the given target is safe.
   *
   * @param  {string}  target
   * @return {boolean}
   */
  function safeTarget(target) {
    return target === '_top' || target === '_self' || target === '_parent';
  }

  /**
   * Export for various environments.
   */

  // Export CommonJS
  if (typeof exports !== 'undefined') {
    if (typeof module !== 'undefined' && module.exports) {
      module.exports = blankshield;
    } else {
      exports.blankshield = blankshield;
    }
  }

  // Register with AMD
  if (typeof define == 'function' && typeof define.amd == 'object') {
    define('blankshield', [], function() {
      return blankshield;
    });
  }

  // export default blankshield function
  root.blankshield = blankshield;
}(this));
