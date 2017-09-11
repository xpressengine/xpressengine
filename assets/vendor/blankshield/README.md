# blankshield

Prevent [reverse tabnabbing](https://sites.google.com/site/bughunteruniversity/nonvuln/phishing-with-window-opener)
based phishing attacks that take advantage of _blank targets.
[Demo](http://danielstjules.github.io/blankshield/). The library has been tested
and is compatible with the latest versions of Chrome, Firefox, Safari, Opera,
as well as IE6-11. This is a cross-browser solution for browsers that do not
support [noopener](http://caniuse.com/#feat=rel-noopener).

* [Overview](#overview)
* [Vulnerable browsers](#vulnerable-browsers)
* [Installation](#installation)
* [Usage](#usage)
  * [blankshield(target)](#blankshieldtarget)
  * [blankshield.open(strUrl, \[strWindowName\], \[strWindowFeatures\])](#blankshieldopenstrurl-strwindowname-strwindowfeatures)
  * [blankshield.patch()](#blankshieldpatch)
* [Solutions](#solutions)

## Overview

Tabs or windows opened using JavaScript or `target="_blank"` have some limited
access to the parent window, ignoring cross-origin restrictions. Among that
is the ability to redirect the parent tab or window using
`window.opener.location`.

While it may seem harmless, a phishing attack is possible when web applications
permit or make use of user-submitted anchors with `target="_blank"` or
`window.open()`. Consider the following scenario:

You're an admin using some forum or chat software. You're currently logged
into the app, and view a message left by a user. The user asks or convinces
you to click a link in his message, which opens in a new tab. While the new
page may look completely safe - perhaps just a screenshot or bug report in some
HTML, it executes the following JS:

``` JavaScript
window.opener.location.assign('https://yourcompanyname.phishing.com');
```

What you don't realize is that while dealing with this illegitimate customer or
user complaint, your application's tab was redirected in the background. To
what? An identical phishing website, simply requesting that you enter your
credentials to log back in.

Is there a chance you might not check the URL? That you didn't notice the tab
icon refresh? While many are suspicious of links they click and new tabs they
open - what about existing tabs?

![demo](http://danielstjules.com/github/blankshield-chrome-demo.gif)

## Vulnerable browsers

The following table outlines the scope of affected browsers:

<table>
  <tr>
    <td>Browser</td>
    <td>Click</td>
    <td>Shift + click</td>
    <td>Meta/Ctrl + click</td>
  </tr>
  <tr>
    <td>Chrome 40</td>
    <td>x</td>
    <td>x</td>
    <td>x</td>
  </tr>
  <tr>
    <td>Firefox 34</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>Opera 26</td>
    <td>x</td>
    <td>x</td>
    <td>x</td>
  </tr>
  <tr>
    <td>Safari 7, 8</td>
    <td>x</td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>IE6...11</td>
    <td colspan="3"><sup>[1]</sup></td>
  </tr>
</table>

<sup>[1]</sup> IE is not vulnerable to the attack by default. However, this can
change depending on security zone settings.

## Installation

The library can be installed via npm:

``` bash
npm install --save blankshield
```

Or using bower:

``` bash
bower install blankshield
```

## Usage

blankshield.js works in global, CommonJS and AMD contexts.

#### blankshield(target)

blankshield is the main function exported by the library. It accepts an
anchor element or array of elements, adding an event listener to each to
help mitigate a potential reverse tabnabbing attack. For performance, any
supplied object with a length attribute is assumed to be an array.

``` JavaScript
// It works on a single element
blankshield(document.getElementById('some-anchor'));

// Array-like objects such as HTMLCollections
blankshield(document.getElementsByClassName('user-submitted-link'));
blankshield(document.getElementsByTagName('a'));
blankshield(document.querySelectorAll('a[target=_blank]'));

// As well as jQuery
blankshield($('a[target=_blank]'));

// But make sure not to bind listeners to the anchors that would stop event
// propagation. In the example below, blankshield is not able to intercept the
// click behavior.
var anchor = document.getElementById('some-anchor')
anchor.addEventListener('click', function(e) {
   e.stopImmediatePropagation();
});
blankshield(document.getElementById('some-anchor'));
```

#### blankshield.open(strUrl, \[strWindowName\], \[strWindowFeatures\])

Accepts the same arguments as window.open. If the strWindowName is not
equal to one of the safe targets (_top, _self or _parent), then it opens
the destination url using "window.open" from an injected iframe, then
removes the iframe. This behavior applies to all browsers except IE < 11,
which use "window.open" followed by setting the child window's opener to
null. If the strWindowName is set to some other value, the url is simply
opened with window.open().

``` JavaScript
// To open an url with blankshield, instead of window.open()
blankshield.open('https://www.github.com/danielstjules');

// To bind a listener using jQuery with event delegation
// (Assumes no other listeners prevent propagation)
$('body').on('click', 'a[target=_blank]', function(event) {
  var href = $(this).attr('href');
  blankshield.open(href);
  event.preventDefault();
});
```

#### blankshield.patch()

Patches window.open() to use blankshield.open() for _blank targets.

``` JavaScript
blankshield.patch();
```

## Solutions

A handful of solutions exist to prevent this sort of attack. You could:

* Remove or disallow `target="_blank"` for any anchors pointing to a
  different origin.
* Append `rel="noreferrer"` to any links with `target="_blank"`. When done,
  `window.opener` will be null from the child window. It's well supported among
  webkit-based browsers, though you'll fall short with IE and Safari. And of
  course, it prevents sending the referrer in the request headers. You could
  fall off as an identifiable source of traffic for some friendly sites.
* Append `rel="noopener"` to any links with `target="_blank"`. When done,
  `window.opener` will be null from the child window. See
  [caniuse](http://caniuse.com/#feat=rel-noopener) for current browser support.
* Listen for the click event and prevent the default browser behavior of
  opening a new tab. Then, call `window.open()` with the href and set the
  the child's opener to null. Unfortunately, this does not work for Safari.
  Safari's cross-origin security prevents the modification of `window.opener` of a
  child window if it lies on a different origin, yet still allows the child
  window to access `window.opener.location`.
* Listen for the click event and prevent the default browser behavior of
  opening a new tab. Inject a hidden iframe that opens the new tab, then
  immediately remove the iframe. This is what blankshield does.
