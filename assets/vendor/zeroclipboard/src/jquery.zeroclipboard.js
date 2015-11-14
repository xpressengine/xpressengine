/*
 * jquery.zeroclipboard
 * https://github.com/zeroclipboard/jquery.zeroclipboard
 *
 * Copyright (c) 2014 James M. Greene
 * Licensed under the MIT license.
 */

(function($, window, undefined) {
  "use strict";


  var mouseEnterBindingCount = 0,
      customEventNamespace = ".zeroclipboard",
      ZeroClipboard = window.ZeroClipboard,
      _trustedDomains = ZeroClipboard.config("trustedDomains");


  function getSelectionData() {
    var range,
        selectedText = "",
        selectedData = {},
        sel = window.getSelection(),
        tmp = document.createElement("div");

    for (var i = 0, len = sel.rangeCount; i < len; i++) {
      range = sel.getRangeAt(i);
      selectedText += range.toString();
      tmp.appendChild(range.cloneContents());
    }

    selectedData["text/plain"] = selectedText;
    if (selectedText.replace(/\s/g, "")) {
      selectedData["text/html"] = tmp.innerHTML;
    }

    return selectedData;
  }

  //
  // Testing: http://jsfiddle.net/JamesMGreene/2b6Lc/
  //
  function convertHtmlToRtf(html) {
    if (!(typeof html === "string" && html)) {
      return null;
    }

    var tmpRichText, hasHyperlinks,
        richText = html;

    // Singleton tags
    richText = richText.replace(/<(?:hr)(?:\s+[^>]*)?\s*[\/]?>/ig, "{\\pard \\brdrb \\brdrs \\brdrw10 \\brsp20 \\par}\n{\\pard\\par}\n");
    richText = richText.replace(/<(?:br)(?:\s+[^>]*)?\s*[\/]?>/ig, "{\\pard\\par}\n");

    // Empty tags
    richText = richText.replace(/<(?:p|div|section|article)(?:\s+[^>]*)?\s*[\/]>/ig, "{\\pard\\par}\n");
    richText = richText.replace(/<(?:[^>]+)\/>/g, "");

    // Hyperlinks
    richText = richText.replace(
      /<a(?:\s+[^>]*)?(?:\s+href=(["'])(?:javascript:void\(0?\);?|#|return false;?|void\(0?\);?|)\1)(?:\s+[^>]*)?>/ig,
      "{{{\n"
    );
    tmpRichText = richText;
    richText = richText.replace(
      /<a(?:\s+[^>]*)?(?:\s+href=(["'])(.+)\1)(?:\s+[^>]*)?>/ig,
      "{\\field{\\*\\fldinst{HYPERLINK\n \"$2\"\n}}{\\fldrslt{\\ul\\cf1\n"
    );
    hasHyperlinks = richText !== tmpRichText;
    richText = richText.replace(/<a(?:\s+[^>]*)?>/ig, "{{{\n");
    richText = richText.replace(/<\/a(?:\s+[^>]*)?>/ig, "\n}}}");

    // Start tags
    richText = richText.replace(/<(?:b|strong)(?:\s+[^>]*)?>/ig, "{\\b\n");
    richText = richText.replace(/<(?:i|em)(?:\s+[^>]*)?>/ig, "{\\i\n");
    richText = richText.replace(/<(?:u|ins)(?:\s+[^>]*)?>/ig, "{\\ul\n");
    richText = richText.replace(/<(?:strike|del)(?:\s+[^>]*)?>/ig, "{\\strike\n");
    richText = richText.replace(/<sup(?:\s+[^>]*)?>/ig, "{\\super\n");
    richText = richText.replace(/<sub(?:\s+[^>]*)?>/ig, "{\\sub\n");
    richText = richText.replace(/<(?:p|div|section|article)(?:\s+[^>]*)?>/ig, "{\\pard\n");

    // End tags
    richText = richText.replace(/<\/(?:p|div|section|article)(?:\s+[^>]*)?>/ig, "\n\\par}\n");
    richText = richText.replace(/<\/(?:b|strong|i|em|u|ins|strike|del|sup|sub)(?:\s+[^>]*)?>/ig, "\n}");

    // Strip any other remaining HTML tags [but leave their contents]
    richText = richText.replace(/<(?:[^>]+)>/g, "");

    // Prefix and suffix the rich text with the necessary syntax
    richText =
      "{\\rtf1\\ansi\n" +
      (hasHyperlinks ? "{\\colortbl\n;\n\\red0\\green0\\blue255;\n}\n" : "") +
      richText +
      "\n}";

    return richText;
  }

  function zcEventHandler(e) {
    var $event = $.Event(e.type, $.extend(e, { "_source": "swf" }));
    $(e.target).trigger($event);

    if ($event.type === "copy") {
      // If `$event.preventDefault();` was not called...
      if (
        $.event.special.copy.options.requirePreventDefault === true &&
        !$event.isDefaultPrevented()
      ) {
        // Clear out any pending data
        e.clipboardData.clearData();

        // And then copy the currently selected text instead, if any
        var selectionData = getSelectionData();
        if (selectionData["text/plain"] || selectionData["text/html"]) {
          e.clipboardData.setData(selectionData);
        }
      }

      // If there is pending HTML to transfer but no RTF, automatically do a basic conversion of HTML to RTF
      var _clipData = ZeroClipboard.getData();
      if (
        $.event.special.copy.options.autoConvertHtmlToRtf === true &&
        _clipData["text/html"] &&
        !_clipData["application/rtf"]
      ) {
        var richText = convertHtmlToRtf(_clipData["text/html"]);
        e.clipboardData.setData("application/rtf", richText);
      }
    }
  }

  function zcErrorHandler(e) {
    var $event = $.Event("copy-error", $.extend(e, { "type": "copy-error", "_source": "swf" }));
    $(e.target).trigger($event);
  }

  function setup() {
    $.event.props.push("clipboardData");

    ZeroClipboard.config($.extend(true, { autoActivate: false }, copyEventDef.options));
    ZeroClipboard.on("beforecopy copy aftercopy", zcEventHandler);
    ZeroClipboard.on("error", zcErrorHandler);
    ZeroClipboard.create();
  }

  function teardown() {
    ZeroClipboard.destroy();

    var indy = $.event.props.indexOf("clipboardData");
    if (indy !== -1) {
      $.event.props.splice(indy, 1);
    }
  }

  function mouseEnterHandler($event) {
    mouseSuppressor($event);

    if (
      $event.target &&
      $event.target !== ZeroClipboard.activeElement() &&
      $event.target !== $("#" + ZeroClipboard.config("containerId"))[0] &&
      $event.target !== $("#" + ZeroClipboard.config("swfObjectId"))[0]
    ) {
      ZeroClipboard.focus($event.target);
    }
  }

  function mouseLeaveHandler($event) {
    mouseSuppressor($event);

    if (
      $event.relatedTarget &&
      $event.relatedTarget !== ZeroClipboard.activeElement() &&
      $event.relatedTarget !== $("#" + ZeroClipboard.config("containerId"))[0] &&
      $event.relatedTarget !== $("#" + ZeroClipboard.config("swfObjectId"))[0]
    ) {
      ZeroClipboard.blur();
    }
  }

  function mouseSuppressor($event) {
    if (!ZeroClipboard.isFlashUnusable() && $event.originalEvent._source !== "js") {
      $event.stopImmediatePropagation();
      $event.preventDefault();
    }
  }



  var copyEventDef = {

    /* Invoked each time this event is bound */
    add: function(handleObj) {
      // If this is the first 'beforecopy'/'copy' binding on the page, we need to configure and create ZeroClipboard
      if (0 === mouseEnterBindingCount++) {
        setup();
      }

      var namespaces = customEventNamespace + (handleObj.namespace ? "." + handleObj.namespace : ""),
          selector = handleObj.selector,
          zcDataKey = "zc|{" + selector + "}|{" + namespaces + "}|count",
          $this = $(this);

      if (typeof $this.data(zcDataKey) !== "number") {
        $this.data(zcDataKey, 0);
      }

      if ($this.data(zcDataKey) === 0) {
        $this.on("mouseenter" + namespaces, selector, mouseEnterHandler);
        $this.on("mouseleave" + namespaces, selector, mouseLeaveHandler);
        $this.on("mouseover" + namespaces, selector, mouseSuppressor);
        $this.on("mouseout" + namespaces, selector, mouseSuppressor);
        $this.on("mousemove" + namespaces, selector, mouseSuppressor);
        $this.on("mousedown" + namespaces, selector, mouseSuppressor);
        $this.on("mouseup" + namespaces, selector, mouseSuppressor);
        $this.on("click" + namespaces, selector, mouseSuppressor);
      }

      $this.data(zcDataKey, $this.data(zcDataKey) + 1);
    },


    /* Invoked each time this event is unbound */
    remove: function(handleObj) {
      var namespaces = customEventNamespace + (handleObj.namespace ? "." + handleObj.namespace : ""),
          selector = handleObj.selector,
          zcDataKey = "zc|{" + selector + "}|{" + namespaces + "}|count",
          $this = $(this);

      $this.data(zcDataKey, $this.data(zcDataKey) - 1);

      if ($this.data(zcDataKey) === 0) {
        $this.off("click" + namespaces, selector, mouseSuppressor);
        $this.off("mouseup" + namespaces, selector, mouseSuppressor);
        $this.off("mousedown" + namespaces, selector, mouseSuppressor);
        $this.off("mousemove" + namespaces, selector, mouseSuppressor);
        $this.off("mouseout" + namespaces, selector, mouseSuppressor);
        $this.off("mouseover" + namespaces, selector, mouseSuppressor);
        $this.off("mouseleave" + namespaces, selector, mouseLeaveHandler);
        $this.off("mouseenter" + namespaces, selector, mouseEnterHandler);

        $this.removeData(zcDataKey);
      }

      // If this is the last 'beforecopy'/'copy' unbinding on the page, we should also destroy ZeroClipboard
      if (0 === --mouseEnterBindingCount) {
        teardown();
      }
    },


    /* Invoked each time a manual call to `trigger`/`triggerHandler` is made for this event type */
    trigger: function($event /*, data */) {
      if ($event.type === "copy") {
        var $this = $(this);

        var sourceIsSwf = $event._source === "swf";
        delete $event._source;

        if (!sourceIsSwf) {
          // First, trigger 'beforecopy' and ensure it gets handled before continuing
          $this.trigger($.extend(true, {}, $event, { type: "beforecopy" }));

          // Then allow this 'copy' event to be handled...

          // Then add a one-time handler for 'copy' to trigger an 'aftercopy' event
          $this.one("copy", function(/* $copyEvent */) {
            // Mark all statuses as failed since we can't inject into the clipboard during a simulated event
            var successData = {},
                _clipData = ZeroClipboard.getData();
            $.each(_clipData, function(key /*, val */) {
              successData[key] = false;
            });

            // Trigger an 'aftercopy' event
            var $e = $.extend(
              true,
              {},
              $event,
              {
                type: "aftercopy",
                data: $.extend(true, {}, _clipData),
                success: successData
              }
            );
            $this.trigger($e);
          });
        }
      }
    },


    /* Invoked each time this event type is about to dispatch its default action */
    _default: function(/* $event, data */) {
      // Prevent the element's default method from being called.
      return true;
    },


    /* Add some default configuration options that can be overridden */
    options: {

      // The default action for the W3C Clipboard API spec (as it stands today) is to
      // copy the currently selected text [and specificially ignore any pending data]
      // unless `e.preventDefault();` is called.
      requirePreventDefault: true,

      // If HTML has been added to the pending data, this plugin can automatically
      // convert the HTML into RTF (RichText) for use in non-HTML-capable editors.
      autoConvertHtmlToRtf: true,

      // SWF inbound scripting policy: page domains that the SWF should trust.
      // (single string, or array of strings)
      trustedDomains: _trustedDomains,

      // The CSS class name used to mimic the `:hover` pseudo-class
      hoverClass: "hover",

      // The CSS class name used to mimic the `:active` pseudo-class
      activeClass: "active"

    }

  };



  /* Leverage the jQuery Special Events API to expose these events in a seemingly more natural way */
  $.event.special.beforecopy = copyEventDef;
  $.event.special.copy = copyEventDef;
  $.event.special.aftercopy = copyEventDef;
  $.event.special["copy-error"] = copyEventDef;

})(
  jQuery,
  (function() {
    /*jshint strict: false */
    return this || window;
  })()
);

