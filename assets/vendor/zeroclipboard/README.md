[![Build Status](https://travis-ci.org/zeroclipboard/jquery.zeroclipboard.png)](https://travis-ci.org/zeroclipboard/jquery.zeroclipboard)

# jquery.zeroclipboard

Bind to the `beforecopy`, `copy`, `aftercopy`, and `copy-error` events, custom DOM-like events for clipboard injection generated using jQuery's Special Events API and [ZeroClipboard](http://zeroclipboard.org/)'s Core module.

The `beforecopy` and `copy` events trigger when the user clicks on a bound element.

The `aftercopy` event triggers after the clipboard injection has been attempted, regardless of whether or not the injection succeeded.

The `copy-error` event triggers if any of the underlying ZeroClipboard error events occur.

The `click` event will also be bubbled after the `aftercopy` event handlers have all been triggered or stopped.


## Prerequisites

ZeroClipboard requires the use of Flash Player 11.0.0 or higher. See [ZeroClipboard](https://github.com/zeroclipboard/zeroclipboard) for more details about the underlying mechanism.

This plugin's functionality is made possible by the smart default configuration values made in ZeroClipboard `v2.x`, plus internally overriding a few configuration options.


## Getting Started
Check the [jQuery Plugins Registry](http://plugins.jquery.com/zeroclipboard/) for the latest published version of this plugin!

You can also download the [production version][min] or the [development version][max] from GitHub. You will also need a [ZeroClipboard v2.x SWF][swf].

[min]: https://raw.github.com/zeroclipboard/jquery.zeroclipboard/master/dist/jquery.zeroclipboard.min.js
[max]: https://raw.github.com/zeroclipboard/jquery.zeroclipboard/master/dist/jquery.zeroclipboard.js
[swf]: https://raw.github.com/zeroclipboard/jquery.zeroclipboard/master/dist/ZeroClipboard.swf

In your web page:

```html
<script src="jquery.js"></script>
<script src="dist/jquery.zeroclipboard.min.js"></script>
<script>
  jQuery(document).ready(function($) {
    $("body")
      .on("copy", ".zclip", function(/* ClipboardEvent */ e) {
        e.clipboardData.clearData();
        e.clipboardData.setData("text/plain", $(this).data("zclip-text"));
        e.preventDefault();
      });
  });
</script>
<button class="zclip" data-zclip-text="Testing 1-2-3!">Click to copy!</button>
```


## Options

There are a handful of options that can be configured to customize the use of this jQuery Special Event:

```js
$.event.special.copy.options = {

  // The default action for the W3C Clipboard API spec (as it stands today) is to
  // copy the currently selected text [and specificially ignore any pending data]
  // unless `e.preventDefault();` is called.
  requirePreventDefault: true,

  // If HTML has been added to the pending data, this plugin can automatically
  // convert the HTML into RTF (RichText) for use in non-HTML-capable editors.
  autoConvertHtmlToRtf: true,

  // SWF inbound scripting policy: page domains that the SWF should trust.
  // (single string, or array of strings)
  trustedDomains: ZeroClipboard.config("trustedDomains"),

  // The CSS class name used to mimic the `:hover` pseudo-class
  hoverClass: "hover",

  // The CSS class name used to mimic the `:active` pseudo-class
  activeClass: "active"

};
```


## Examples

Offers an API similar to the HTML5 Clipboard API.
_NOTE:_ Some of these examples will also be leveraging the [jQuery.Range plugin](http://jquerypp.com/#range) where noted.

### Example 1: Using `beforecopy`

The following example uses the `beforecopy` event to change the selected text before it is copied. The modified selection is what will be copied into the clipboard if the action is not prevented.

```js
jQuery(document).ready(function($) {
  $("body").on("beforecopy", ".zclip", function() {
    // Select the text of this element; this will be copied by default
    $("#textToCopy").range().select();  // ** Using the jQuery.Range plugin
  });
});
```


### Example 2: Using `copy`

The following example uses the `copy` event to set data into several different clipboard sectors.

```js
jQuery(document).ready(function($) {
  $("body").on("copy", ".zclip", function(/* ClipboardEvent */ e) {
    // Get the currently selected text
    var textToCopy = $.Range.current().toString();  // ** Using the jQuery.Range plugin
    
    // If there isn't any currently selected text, just ignore this event
    if (!textToCopy) {
      return;
    }
    
    // Clear out any existing data in the pending clipboard transaction
    e.clipboardData.clearData();

    // Set your own data into the pending clipboard transaction
    e.clipboardData.setData("text/plain", textToCopy);
    e.clipboardData.setData("text/html", "<b>" + textToCopy + "</b>");
    e.clipboardData.setData("application/rtf", "{\\rtf1\\ansi\n{\\b " + textToCopy + "}}");
    
    // Prevent the default action of copying the currently selected text into the clipboard
    e.preventDefault();
  });
});
```

### Example 3: Using `aftercopy`

This is the same as [Example #1](#example-1-using-beforecopy), except that it also uses the `aftercopy` event to "celebrate" and the `copy-error` event to watch for errors.

```js
jQuery(document).ready(function($) {
  var eventsMap = {
    "beforecopy": function() {
      // Select the text of this element; this will be copied by default
      $("#textToCopy").range().select();  // ** Using the jQuery.Range plugin
    },
    "aftercopy": function(/* aftercopyEvent */ e) {
      // NOTE: The `aftercopyEvent` event interface is not based on any existing DOM event, so the event model
      // is still just a draft version. If you have any suggestions, please submit a new issue in this repo!
      if (e.status["text/plain"] === true) {
        alert("Copy succeeded. Yay! Text: " + e.data["text/plain"]);
      }
      else {
        alert("Copy failed... BOOOOOO!!!");
      }
    },
    "copy-error": function(errorEvent) {
      alert("ERROR! " + errorEvent);
    }
  };
  $("body").on(eventsMap, ".zclip");
});
```


## `file://` Protocol Limitations

If you want to host a page locally on the `file://` protocol, you must specifically configure
ZeroClipboard to trust ALL domains for SWF interaction via a wildcard. This configuration must be
set _before_ attaching any event handlers for the `beforecopy`, `copy`, `aftercopy`, or `copy-error`
events:

```js
$.event.special.copy.options.trustedDomains = ["*"];
```

This wildcard configuration should _**NOT**_ be used in environments hosted over HTTP/HTTPS.


## Compatibility
**Works 100% with jQuery versions:**  
 - 1.7.x and above

**Untested jQuery versions:**  
 - Anything below 1.7.x (incompatible jQuery Special Events API)
