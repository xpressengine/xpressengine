/* */ 
(function(process) {
  'use strict';
  var _prodInvariant = require('./reactProdInvariant'),
      _assign = require('object-assign');
  var AutoFocusUtils = require('./AutoFocusUtils');
  var CSSPropertyOperations = require('./CSSPropertyOperations');
  var DOMLazyTree = require('./DOMLazyTree');
  var DOMNamespaces = require('./DOMNamespaces');
  var DOMProperty = require('./DOMProperty');
  var DOMPropertyOperations = require('./DOMPropertyOperations');
  var EventConstants = require('./EventConstants');
  var EventPluginHub = require('./EventPluginHub');
  var EventPluginRegistry = require('./EventPluginRegistry');
  var ReactBrowserEventEmitter = require('./ReactBrowserEventEmitter');
  var ReactDOMButton = require('./ReactDOMButton');
  var ReactDOMComponentFlags = require('./ReactDOMComponentFlags');
  var ReactDOMComponentTree = require('./ReactDOMComponentTree');
  var ReactDOMInput = require('./ReactDOMInput');
  var ReactDOMOption = require('./ReactDOMOption');
  var ReactDOMSelect = require('./ReactDOMSelect');
  var ReactDOMTextarea = require('./ReactDOMTextarea');
  var ReactInstrumentation = require('./ReactInstrumentation');
  var ReactMultiChild = require('./ReactMultiChild');
  var ReactServerRenderingTransaction = require('./ReactServerRenderingTransaction');
  var emptyFunction = require('fbjs/lib/emptyFunction');
  var escapeTextContentForBrowser = require('./escapeTextContentForBrowser');
  var invariant = require('fbjs/lib/invariant');
  var isEventSupported = require('./isEventSupported');
  var keyOf = require('fbjs/lib/keyOf');
  var shallowEqual = require('fbjs/lib/shallowEqual');
  var validateDOMNesting = require('./validateDOMNesting');
  var warning = require('fbjs/lib/warning');
  var Flags = ReactDOMComponentFlags;
  var deleteListener = EventPluginHub.deleteListener;
  var getNode = ReactDOMComponentTree.getNodeFromInstance;
  var listenTo = ReactBrowserEventEmitter.listenTo;
  var registrationNameModules = EventPluginRegistry.registrationNameModules;
  var CONTENT_TYPES = {
    'string': true,
    'number': true
  };
  var STYLE = keyOf({style: null});
  var HTML = keyOf({__html: null});
  var RESERVED_PROPS = {
    children: null,
    dangerouslySetInnerHTML: null,
    suppressContentEditableWarning: null
  };
  var DOC_FRAGMENT_TYPE = 11;
  function getDeclarationErrorAddendum(internalInstance) {
    if (internalInstance) {
      var owner = internalInstance._currentElement._owner || null;
      if (owner) {
        var name = owner.getName();
        if (name) {
          return ' This DOM node was rendered by `' + name + '`.';
        }
      }
    }
    return '';
  }
  function friendlyStringify(obj) {
    if (typeof obj === 'object') {
      if (Array.isArray(obj)) {
        return '[' + obj.map(friendlyStringify).join(', ') + ']';
      } else {
        var pairs = [];
        for (var key in obj) {
          if (Object.prototype.hasOwnProperty.call(obj, key)) {
            var keyEscaped = /^[a-z$_][\w$_]*$/i.test(key) ? key : JSON.stringify(key);
            pairs.push(keyEscaped + ': ' + friendlyStringify(obj[key]));
          }
        }
        return '{' + pairs.join(', ') + '}';
      }
    } else if (typeof obj === 'string') {
      return JSON.stringify(obj);
    } else if (typeof obj === 'function') {
      return '[function object]';
    }
    return String(obj);
  }
  var styleMutationWarning = {};
  function checkAndWarnForMutatedStyle(style1, style2, component) {
    if (style1 == null || style2 == null) {
      return;
    }
    if (shallowEqual(style1, style2)) {
      return;
    }
    var componentName = component._tag;
    var owner = component._currentElement._owner;
    var ownerName;
    if (owner) {
      ownerName = owner.getName();
    }
    var hash = ownerName + '|' + componentName;
    if (styleMutationWarning.hasOwnProperty(hash)) {
      return;
    }
    styleMutationWarning[hash] = true;
    process.env.NODE_ENV !== 'production' ? warning(false, '`%s` was passed a style object that has previously been mutated. ' + 'Mutating `style` is deprecated. Consider cloning it beforehand. Check ' + 'the `render` %s. Previous style: %s. Mutated style: %s.', componentName, owner ? 'of `' + ownerName + '`' : 'using <' + componentName + '>', friendlyStringify(style1), friendlyStringify(style2)) : void 0;
  }
  function assertValidProps(component, props) {
    if (!props) {
      return;
    }
    if (voidElementTags[component._tag]) {
      !(props.children == null && props.dangerouslySetInnerHTML == null) ? process.env.NODE_ENV !== 'production' ? invariant(false, '%s is a void element tag and must neither have `children` nor use `dangerouslySetInnerHTML`.%s', component._tag, component._currentElement._owner ? ' Check the render method of ' + component._currentElement._owner.getName() + '.' : '') : _prodInvariant('137', component._tag, component._currentElement._owner ? ' Check the render method of ' + component._currentElement._owner.getName() + '.' : '') : void 0;
    }
    if (props.dangerouslySetInnerHTML != null) {
      !(props.children == null) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'Can only set one of `children` or `props.dangerouslySetInnerHTML`.') : _prodInvariant('60') : void 0;
      !(typeof props.dangerouslySetInnerHTML === 'object' && HTML in props.dangerouslySetInnerHTML) ? process.env.NODE_ENV !== 'production' ? invariant(false, '`props.dangerouslySetInnerHTML` must be in the form `{__html: ...}`. Please visit https://fb.me/react-invariant-dangerously-set-inner-html for more information.') : _prodInvariant('61') : void 0;
    }
    if (process.env.NODE_ENV !== 'production') {
      process.env.NODE_ENV !== 'production' ? warning(props.innerHTML == null, 'Directly setting property `innerHTML` is not permitted. ' + 'For more information, lookup documentation on `dangerouslySetInnerHTML`.') : void 0;
      process.env.NODE_ENV !== 'production' ? warning(props.suppressContentEditableWarning || !props.contentEditable || props.children == null, 'A component is `contentEditable` and contains `children` managed by ' + 'React. It is now your responsibility to guarantee that none of ' + 'those nodes are unexpectedly modified or duplicated. This is ' + 'probably not intentional.') : void 0;
      process.env.NODE_ENV !== 'production' ? warning(props.onFocusIn == null && props.onFocusOut == null, 'React uses onFocus and onBlur instead of onFocusIn and onFocusOut. ' + 'All React events are normalized to bubble, so onFocusIn and onFocusOut ' + 'are not needed/supported by React.') : void 0;
    }
    !(props.style == null || typeof props.style === 'object') ? process.env.NODE_ENV !== 'production' ? invariant(false, 'The `style` prop expects a mapping from style properties to values, not a string. For example, style={{marginRight: spacing + \'em\'}} when using JSX.%s', getDeclarationErrorAddendum(component)) : _prodInvariant('62', getDeclarationErrorAddendum(component)) : void 0;
  }
  function enqueuePutListener(inst, registrationName, listener, transaction) {
    if (transaction instanceof ReactServerRenderingTransaction) {
      return;
    }
    if (process.env.NODE_ENV !== 'production') {
      process.env.NODE_ENV !== 'production' ? warning(registrationName !== 'onScroll' || isEventSupported('scroll', true), 'This browser doesn\'t support the `onScroll` event') : void 0;
    }
    var containerInfo = inst._hostContainerInfo;
    var isDocumentFragment = containerInfo._node && containerInfo._node.nodeType === DOC_FRAGMENT_TYPE;
    var doc = isDocumentFragment ? containerInfo._node : containerInfo._ownerDocument;
    listenTo(registrationName, doc);
    transaction.getReactMountReady().enqueue(putListener, {
      inst: inst,
      registrationName: registrationName,
      listener: listener
    });
  }
  function putListener() {
    var listenerToPut = this;
    EventPluginHub.putListener(listenerToPut.inst, listenerToPut.registrationName, listenerToPut.listener);
  }
  function inputPostMount() {
    var inst = this;
    ReactDOMInput.postMountWrapper(inst);
  }
  function textareaPostMount() {
    var inst = this;
    ReactDOMTextarea.postMountWrapper(inst);
  }
  function optionPostMount() {
    var inst = this;
    ReactDOMOption.postMountWrapper(inst);
  }
  var setContentChildForInstrumentation = emptyFunction;
  if (process.env.NODE_ENV !== 'production') {
    setContentChildForInstrumentation = function(content) {
      var hasExistingContent = this._contentDebugID != null;
      var debugID = this._debugID;
      var contentDebugID = -debugID;
      if (content == null) {
        if (hasExistingContent) {
          ReactInstrumentation.debugTool.onUnmountComponent(this._contentDebugID);
        }
        this._contentDebugID = null;
        return;
      }
      this._contentDebugID = contentDebugID;
      if (hasExistingContent) {
        ReactInstrumentation.debugTool.onBeforeUpdateComponent(contentDebugID, content);
        ReactInstrumentation.debugTool.onUpdateComponent(contentDebugID);
      } else {
        ReactInstrumentation.debugTool.onBeforeMountComponent(contentDebugID, content, debugID);
        ReactInstrumentation.debugTool.onMountComponent(contentDebugID);
        ReactInstrumentation.debugTool.onSetChildren(debugID, [contentDebugID]);
      }
    };
  }
  var mediaEvents = {
    topAbort: 'abort',
    topCanPlay: 'canplay',
    topCanPlayThrough: 'canplaythrough',
    topDurationChange: 'durationchange',
    topEmptied: 'emptied',
    topEncrypted: 'encrypted',
    topEnded: 'ended',
    topError: 'error',
    topLoadedData: 'loadeddata',
    topLoadedMetadata: 'loadedmetadata',
    topLoadStart: 'loadstart',
    topPause: 'pause',
    topPlay: 'play',
    topPlaying: 'playing',
    topProgress: 'progress',
    topRateChange: 'ratechange',
    topSeeked: 'seeked',
    topSeeking: 'seeking',
    topStalled: 'stalled',
    topSuspend: 'suspend',
    topTimeUpdate: 'timeupdate',
    topVolumeChange: 'volumechange',
    topWaiting: 'waiting'
  };
  function trapBubbledEventsLocal() {
    var inst = this;
    !inst._rootNodeID ? process.env.NODE_ENV !== 'production' ? invariant(false, 'Must be mounted to trap events') : _prodInvariant('63') : void 0;
    var node = getNode(inst);
    !node ? process.env.NODE_ENV !== 'production' ? invariant(false, 'trapBubbledEvent(...): Requires node to be rendered.') : _prodInvariant('64') : void 0;
    switch (inst._tag) {
      case 'iframe':
      case 'object':
        inst._wrapperState.listeners = [ReactBrowserEventEmitter.trapBubbledEvent(EventConstants.topLevelTypes.topLoad, 'load', node)];
        break;
      case 'video':
      case 'audio':
        inst._wrapperState.listeners = [];
        for (var event in mediaEvents) {
          if (mediaEvents.hasOwnProperty(event)) {
            inst._wrapperState.listeners.push(ReactBrowserEventEmitter.trapBubbledEvent(EventConstants.topLevelTypes[event], mediaEvents[event], node));
          }
        }
        break;
      case 'source':
        inst._wrapperState.listeners = [ReactBrowserEventEmitter.trapBubbledEvent(EventConstants.topLevelTypes.topError, 'error', node)];
        break;
      case 'img':
        inst._wrapperState.listeners = [ReactBrowserEventEmitter.trapBubbledEvent(EventConstants.topLevelTypes.topError, 'error', node), ReactBrowserEventEmitter.trapBubbledEvent(EventConstants.topLevelTypes.topLoad, 'load', node)];
        break;
      case 'form':
        inst._wrapperState.listeners = [ReactBrowserEventEmitter.trapBubbledEvent(EventConstants.topLevelTypes.topReset, 'reset', node), ReactBrowserEventEmitter.trapBubbledEvent(EventConstants.topLevelTypes.topSubmit, 'submit', node)];
        break;
      case 'input':
      case 'select':
      case 'textarea':
        inst._wrapperState.listeners = [ReactBrowserEventEmitter.trapBubbledEvent(EventConstants.topLevelTypes.topInvalid, 'invalid', node)];
        break;
    }
  }
  function postUpdateSelectWrapper() {
    ReactDOMSelect.postUpdateWrapper(this);
  }
  var omittedCloseTags = {
    'area': true,
    'base': true,
    'br': true,
    'col': true,
    'embed': true,
    'hr': true,
    'img': true,
    'input': true,
    'keygen': true,
    'link': true,
    'meta': true,
    'param': true,
    'source': true,
    'track': true,
    'wbr': true
  };
  var newlineEatingTags = {
    'listing': true,
    'pre': true,
    'textarea': true
  };
  var voidElementTags = _assign({'menuitem': true}, omittedCloseTags);
  var VALID_TAG_REGEX = /^[a-zA-Z][a-zA-Z:_\.\-\d]*$/;
  var validatedTagCache = {};
  var hasOwnProperty = {}.hasOwnProperty;
  function validateDangerousTag(tag) {
    if (!hasOwnProperty.call(validatedTagCache, tag)) {
      !VALID_TAG_REGEX.test(tag) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'Invalid tag: %s', tag) : _prodInvariant('65', tag) : void 0;
      validatedTagCache[tag] = true;
    }
  }
  function isCustomComponent(tagName, props) {
    return tagName.indexOf('-') >= 0 || props.is != null;
  }
  var globalIdCounter = 1;
  function ReactDOMComponent(element) {
    var tag = element.type;
    validateDangerousTag(tag);
    this._currentElement = element;
    this._tag = tag.toLowerCase();
    this._namespaceURI = null;
    this._renderedChildren = null;
    this._previousStyle = null;
    this._previousStyleCopy = null;
    this._hostNode = null;
    this._hostParent = null;
    this._rootNodeID = 0;
    this._domID = 0;
    this._hostContainerInfo = null;
    this._wrapperState = null;
    this._topLevelWrapper = null;
    this._flags = 0;
    if (process.env.NODE_ENV !== 'production') {
      this._ancestorInfo = null;
      setContentChildForInstrumentation.call(this, null);
    }
  }
  ReactDOMComponent.displayName = 'ReactDOMComponent';
  ReactDOMComponent.Mixin = {
    mountComponent: function(transaction, hostParent, hostContainerInfo, context) {
      this._rootNodeID = globalIdCounter++;
      this._domID = hostContainerInfo._idCounter++;
      this._hostParent = hostParent;
      this._hostContainerInfo = hostContainerInfo;
      var props = this._currentElement.props;
      switch (this._tag) {
        case 'audio':
        case 'form':
        case 'iframe':
        case 'img':
        case 'link':
        case 'object':
        case 'source':
        case 'video':
          this._wrapperState = {listeners: null};
          transaction.getReactMountReady().enqueue(trapBubbledEventsLocal, this);
          break;
        case 'button':
          props = ReactDOMButton.getHostProps(this, props, hostParent);
          break;
        case 'input':
          ReactDOMInput.mountWrapper(this, props, hostParent);
          props = ReactDOMInput.getHostProps(this, props);
          transaction.getReactMountReady().enqueue(trapBubbledEventsLocal, this);
          break;
        case 'option':
          ReactDOMOption.mountWrapper(this, props, hostParent);
          props = ReactDOMOption.getHostProps(this, props);
          break;
        case 'select':
          ReactDOMSelect.mountWrapper(this, props, hostParent);
          props = ReactDOMSelect.getHostProps(this, props);
          transaction.getReactMountReady().enqueue(trapBubbledEventsLocal, this);
          break;
        case 'textarea':
          ReactDOMTextarea.mountWrapper(this, props, hostParent);
          props = ReactDOMTextarea.getHostProps(this, props);
          transaction.getReactMountReady().enqueue(trapBubbledEventsLocal, this);
          break;
      }
      assertValidProps(this, props);
      var namespaceURI;
      var parentTag;
      if (hostParent != null) {
        namespaceURI = hostParent._namespaceURI;
        parentTag = hostParent._tag;
      } else if (hostContainerInfo._tag) {
        namespaceURI = hostContainerInfo._namespaceURI;
        parentTag = hostContainerInfo._tag;
      }
      if (namespaceURI == null || namespaceURI === DOMNamespaces.svg && parentTag === 'foreignobject') {
        namespaceURI = DOMNamespaces.html;
      }
      if (namespaceURI === DOMNamespaces.html) {
        if (this._tag === 'svg') {
          namespaceURI = DOMNamespaces.svg;
        } else if (this._tag === 'math') {
          namespaceURI = DOMNamespaces.mathml;
        }
      }
      this._namespaceURI = namespaceURI;
      if (process.env.NODE_ENV !== 'production') {
        var parentInfo;
        if (hostParent != null) {
          parentInfo = hostParent._ancestorInfo;
        } else if (hostContainerInfo._tag) {
          parentInfo = hostContainerInfo._ancestorInfo;
        }
        if (parentInfo) {
          validateDOMNesting(this._tag, this, parentInfo);
        }
        this._ancestorInfo = validateDOMNesting.updatedAncestorInfo(parentInfo, this._tag, this);
      }
      var mountImage;
      if (transaction.useCreateElement) {
        var ownerDocument = hostContainerInfo._ownerDocument;
        var el;
        if (namespaceURI === DOMNamespaces.html) {
          if (this._tag === 'script') {
            var div = ownerDocument.createElement('div');
            var type = this._currentElement.type;
            div.innerHTML = '<' + type + '></' + type + '>';
            el = div.removeChild(div.firstChild);
          } else if (props.is) {
            el = ownerDocument.createElement(this._currentElement.type, props.is);
          } else {
            el = ownerDocument.createElement(this._currentElement.type);
          }
        } else {
          el = ownerDocument.createElementNS(namespaceURI, this._currentElement.type);
        }
        ReactDOMComponentTree.precacheNode(this, el);
        this._flags |= Flags.hasCachedChildNodes;
        if (!this._hostParent) {
          DOMPropertyOperations.setAttributeForRoot(el);
        }
        this._updateDOMProperties(null, props, transaction);
        var lazyTree = DOMLazyTree(el);
        this._createInitialChildren(transaction, props, context, lazyTree);
        mountImage = lazyTree;
      } else {
        var tagOpen = this._createOpenTagMarkupAndPutListeners(transaction, props);
        var tagContent = this._createContentMarkup(transaction, props, context);
        if (!tagContent && omittedCloseTags[this._tag]) {
          mountImage = tagOpen + '/>';
        } else {
          mountImage = tagOpen + '>' + tagContent + '</' + this._currentElement.type + '>';
        }
      }
      switch (this._tag) {
        case 'input':
          transaction.getReactMountReady().enqueue(inputPostMount, this);
          if (props.autoFocus) {
            transaction.getReactMountReady().enqueue(AutoFocusUtils.focusDOMComponent, this);
          }
          break;
        case 'textarea':
          transaction.getReactMountReady().enqueue(textareaPostMount, this);
          if (props.autoFocus) {
            transaction.getReactMountReady().enqueue(AutoFocusUtils.focusDOMComponent, this);
          }
          break;
        case 'select':
          if (props.autoFocus) {
            transaction.getReactMountReady().enqueue(AutoFocusUtils.focusDOMComponent, this);
          }
          break;
        case 'button':
          if (props.autoFocus) {
            transaction.getReactMountReady().enqueue(AutoFocusUtils.focusDOMComponent, this);
          }
          break;
        case 'option':
          transaction.getReactMountReady().enqueue(optionPostMount, this);
          break;
      }
      return mountImage;
    },
    _createOpenTagMarkupAndPutListeners: function(transaction, props) {
      var ret = '<' + this._currentElement.type;
      for (var propKey in props) {
        if (!props.hasOwnProperty(propKey)) {
          continue;
        }
        var propValue = props[propKey];
        if (propValue == null) {
          continue;
        }
        if (registrationNameModules.hasOwnProperty(propKey)) {
          if (propValue) {
            enqueuePutListener(this, propKey, propValue, transaction);
          }
        } else {
          if (propKey === STYLE) {
            if (propValue) {
              if (process.env.NODE_ENV !== 'production') {
                this._previousStyle = propValue;
              }
              propValue = this._previousStyleCopy = _assign({}, props.style);
            }
            propValue = CSSPropertyOperations.createMarkupForStyles(propValue, this);
          }
          var markup = null;
          if (this._tag != null && isCustomComponent(this._tag, props)) {
            if (!RESERVED_PROPS.hasOwnProperty(propKey)) {
              markup = DOMPropertyOperations.createMarkupForCustomAttribute(propKey, propValue);
            }
          } else {
            markup = DOMPropertyOperations.createMarkupForProperty(propKey, propValue);
          }
          if (markup) {
            ret += ' ' + markup;
          }
        }
      }
      if (transaction.renderToStaticMarkup) {
        return ret;
      }
      if (!this._hostParent) {
        ret += ' ' + DOMPropertyOperations.createMarkupForRoot();
      }
      ret += ' ' + DOMPropertyOperations.createMarkupForID(this._domID);
      return ret;
    },
    _createContentMarkup: function(transaction, props, context) {
      var ret = '';
      var innerHTML = props.dangerouslySetInnerHTML;
      if (innerHTML != null) {
        if (innerHTML.__html != null) {
          ret = innerHTML.__html;
        }
      } else {
        var contentToUse = CONTENT_TYPES[typeof props.children] ? props.children : null;
        var childrenToUse = contentToUse != null ? null : props.children;
        if (contentToUse != null) {
          ret = escapeTextContentForBrowser(contentToUse);
          if (process.env.NODE_ENV !== 'production') {
            setContentChildForInstrumentation.call(this, contentToUse);
          }
        } else if (childrenToUse != null) {
          var mountImages = this.mountChildren(childrenToUse, transaction, context);
          ret = mountImages.join('');
        }
      }
      if (newlineEatingTags[this._tag] && ret.charAt(0) === '\n') {
        return '\n' + ret;
      } else {
        return ret;
      }
    },
    _createInitialChildren: function(transaction, props, context, lazyTree) {
      var innerHTML = props.dangerouslySetInnerHTML;
      if (innerHTML != null) {
        if (innerHTML.__html != null) {
          DOMLazyTree.queueHTML(lazyTree, innerHTML.__html);
        }
      } else {
        var contentToUse = CONTENT_TYPES[typeof props.children] ? props.children : null;
        var childrenToUse = contentToUse != null ? null : props.children;
        if (contentToUse != null) {
          if (process.env.NODE_ENV !== 'production') {
            setContentChildForInstrumentation.call(this, contentToUse);
          }
          DOMLazyTree.queueText(lazyTree, contentToUse);
        } else if (childrenToUse != null) {
          var mountImages = this.mountChildren(childrenToUse, transaction, context);
          for (var i = 0; i < mountImages.length; i++) {
            DOMLazyTree.queueChild(lazyTree, mountImages[i]);
          }
        }
      }
    },
    receiveComponent: function(nextElement, transaction, context) {
      var prevElement = this._currentElement;
      this._currentElement = nextElement;
      this.updateComponent(transaction, prevElement, nextElement, context);
    },
    updateComponent: function(transaction, prevElement, nextElement, context) {
      var lastProps = prevElement.props;
      var nextProps = this._currentElement.props;
      switch (this._tag) {
        case 'button':
          lastProps = ReactDOMButton.getHostProps(this, lastProps);
          nextProps = ReactDOMButton.getHostProps(this, nextProps);
          break;
        case 'input':
          lastProps = ReactDOMInput.getHostProps(this, lastProps);
          nextProps = ReactDOMInput.getHostProps(this, nextProps);
          break;
        case 'option':
          lastProps = ReactDOMOption.getHostProps(this, lastProps);
          nextProps = ReactDOMOption.getHostProps(this, nextProps);
          break;
        case 'select':
          lastProps = ReactDOMSelect.getHostProps(this, lastProps);
          nextProps = ReactDOMSelect.getHostProps(this, nextProps);
          break;
        case 'textarea':
          lastProps = ReactDOMTextarea.getHostProps(this, lastProps);
          nextProps = ReactDOMTextarea.getHostProps(this, nextProps);
          break;
      }
      assertValidProps(this, nextProps);
      this._updateDOMProperties(lastProps, nextProps, transaction);
      this._updateDOMChildren(lastProps, nextProps, transaction, context);
      switch (this._tag) {
        case 'input':
          ReactDOMInput.updateWrapper(this);
          break;
        case 'textarea':
          ReactDOMTextarea.updateWrapper(this);
          break;
        case 'select':
          transaction.getReactMountReady().enqueue(postUpdateSelectWrapper, this);
          break;
      }
    },
    _updateDOMProperties: function(lastProps, nextProps, transaction) {
      var propKey;
      var styleName;
      var styleUpdates;
      for (propKey in lastProps) {
        if (nextProps.hasOwnProperty(propKey) || !lastProps.hasOwnProperty(propKey) || lastProps[propKey] == null) {
          continue;
        }
        if (propKey === STYLE) {
          var lastStyle = this._previousStyleCopy;
          for (styleName in lastStyle) {
            if (lastStyle.hasOwnProperty(styleName)) {
              styleUpdates = styleUpdates || {};
              styleUpdates[styleName] = '';
            }
          }
          this._previousStyleCopy = null;
        } else if (registrationNameModules.hasOwnProperty(propKey)) {
          if (lastProps[propKey]) {
            deleteListener(this, propKey);
          }
        } else if (isCustomComponent(this._tag, lastProps)) {
          if (!RESERVED_PROPS.hasOwnProperty(propKey)) {
            DOMPropertyOperations.deleteValueForAttribute(getNode(this), propKey);
          }
        } else if (DOMProperty.properties[propKey] || DOMProperty.isCustomAttribute(propKey)) {
          DOMPropertyOperations.deleteValueForProperty(getNode(this), propKey);
        }
      }
      for (propKey in nextProps) {
        var nextProp = nextProps[propKey];
        var lastProp = propKey === STYLE ? this._previousStyleCopy : lastProps != null ? lastProps[propKey] : undefined;
        if (!nextProps.hasOwnProperty(propKey) || nextProp === lastProp || nextProp == null && lastProp == null) {
          continue;
        }
        if (propKey === STYLE) {
          if (nextProp) {
            if (process.env.NODE_ENV !== 'production') {
              checkAndWarnForMutatedStyle(this._previousStyleCopy, this._previousStyle, this);
              this._previousStyle = nextProp;
            }
            nextProp = this._previousStyleCopy = _assign({}, nextProp);
          } else {
            this._previousStyleCopy = null;
          }
          if (lastProp) {
            for (styleName in lastProp) {
              if (lastProp.hasOwnProperty(styleName) && (!nextProp || !nextProp.hasOwnProperty(styleName))) {
                styleUpdates = styleUpdates || {};
                styleUpdates[styleName] = '';
              }
            }
            for (styleName in nextProp) {
              if (nextProp.hasOwnProperty(styleName) && lastProp[styleName] !== nextProp[styleName]) {
                styleUpdates = styleUpdates || {};
                styleUpdates[styleName] = nextProp[styleName];
              }
            }
          } else {
            styleUpdates = nextProp;
          }
        } else if (registrationNameModules.hasOwnProperty(propKey)) {
          if (nextProp) {
            enqueuePutListener(this, propKey, nextProp, transaction);
          } else if (lastProp) {
            deleteListener(this, propKey);
          }
        } else if (isCustomComponent(this._tag, nextProps)) {
          if (!RESERVED_PROPS.hasOwnProperty(propKey)) {
            DOMPropertyOperations.setValueForAttribute(getNode(this), propKey, nextProp);
          }
        } else if (DOMProperty.properties[propKey] || DOMProperty.isCustomAttribute(propKey)) {
          var node = getNode(this);
          if (nextProp != null) {
            DOMPropertyOperations.setValueForProperty(node, propKey, nextProp);
          } else {
            DOMPropertyOperations.deleteValueForProperty(node, propKey);
          }
        }
      }
      if (styleUpdates) {
        CSSPropertyOperations.setValueForStyles(getNode(this), styleUpdates, this);
      }
    },
    _updateDOMChildren: function(lastProps, nextProps, transaction, context) {
      var lastContent = CONTENT_TYPES[typeof lastProps.children] ? lastProps.children : null;
      var nextContent = CONTENT_TYPES[typeof nextProps.children] ? nextProps.children : null;
      var lastHtml = lastProps.dangerouslySetInnerHTML && lastProps.dangerouslySetInnerHTML.__html;
      var nextHtml = nextProps.dangerouslySetInnerHTML && nextProps.dangerouslySetInnerHTML.__html;
      var lastChildren = lastContent != null ? null : lastProps.children;
      var nextChildren = nextContent != null ? null : nextProps.children;
      var lastHasContentOrHtml = lastContent != null || lastHtml != null;
      var nextHasContentOrHtml = nextContent != null || nextHtml != null;
      if (lastChildren != null && nextChildren == null) {
        this.updateChildren(null, transaction, context);
      } else if (lastHasContentOrHtml && !nextHasContentOrHtml) {
        this.updateTextContent('');
        if (process.env.NODE_ENV !== 'production') {
          ReactInstrumentation.debugTool.onSetChildren(this._debugID, []);
        }
      }
      if (nextContent != null) {
        if (lastContent !== nextContent) {
          this.updateTextContent('' + nextContent);
          if (process.env.NODE_ENV !== 'production') {
            setContentChildForInstrumentation.call(this, nextContent);
          }
        }
      } else if (nextHtml != null) {
        if (lastHtml !== nextHtml) {
          this.updateMarkup('' + nextHtml);
        }
        if (process.env.NODE_ENV !== 'production') {
          ReactInstrumentation.debugTool.onSetChildren(this._debugID, []);
        }
      } else if (nextChildren != null) {
        if (process.env.NODE_ENV !== 'production') {
          setContentChildForInstrumentation.call(this, null);
        }
        this.updateChildren(nextChildren, transaction, context);
      }
    },
    getHostNode: function() {
      return getNode(this);
    },
    unmountComponent: function(safely) {
      switch (this._tag) {
        case 'audio':
        case 'form':
        case 'iframe':
        case 'img':
        case 'link':
        case 'object':
        case 'source':
        case 'video':
          var listeners = this._wrapperState.listeners;
          if (listeners) {
            for (var i = 0; i < listeners.length; i++) {
              listeners[i].remove();
            }
          }
          break;
        case 'html':
        case 'head':
        case 'body':
          !false ? process.env.NODE_ENV !== 'production' ? invariant(false, '<%s> tried to unmount. Because of cross-browser quirks it is impossible to unmount some top-level components (eg <html>, <head>, and <body>) reliably and efficiently. To fix this, have a single top-level component that never unmounts render these elements.', this._tag) : _prodInvariant('66', this._tag) : void 0;
          break;
      }
      this.unmountChildren(safely);
      ReactDOMComponentTree.uncacheNode(this);
      EventPluginHub.deleteAllListeners(this);
      this._rootNodeID = 0;
      this._domID = 0;
      this._wrapperState = null;
      if (process.env.NODE_ENV !== 'production') {
        setContentChildForInstrumentation.call(this, null);
      }
    },
    getPublicInstance: function() {
      return getNode(this);
    }
  };
  _assign(ReactDOMComponent.prototype, ReactDOMComponent.Mixin, ReactMultiChild.Mixin);
  module.exports = ReactDOMComponent;
})(require('process'));
