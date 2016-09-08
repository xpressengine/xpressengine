/* */ 
(function(process) {
  'use strict';
  var _prodInvariant = require('./reactProdInvariant');
  var DOMLazyTree = require('./DOMLazyTree');
  var DOMProperty = require('./DOMProperty');
  var ReactBrowserEventEmitter = require('./ReactBrowserEventEmitter');
  var ReactCurrentOwner = require('./ReactCurrentOwner');
  var ReactDOMComponentTree = require('./ReactDOMComponentTree');
  var ReactDOMContainerInfo = require('./ReactDOMContainerInfo');
  var ReactDOMFeatureFlags = require('./ReactDOMFeatureFlags');
  var ReactElement = require('./ReactElement');
  var ReactFeatureFlags = require('./ReactFeatureFlags');
  var ReactInstanceMap = require('./ReactInstanceMap');
  var ReactInstrumentation = require('./ReactInstrumentation');
  var ReactMarkupChecksum = require('./ReactMarkupChecksum');
  var ReactReconciler = require('./ReactReconciler');
  var ReactUpdateQueue = require('./ReactUpdateQueue');
  var ReactUpdates = require('./ReactUpdates');
  var emptyObject = require('fbjs/lib/emptyObject');
  var instantiateReactComponent = require('./instantiateReactComponent');
  var invariant = require('fbjs/lib/invariant');
  var setInnerHTML = require('./setInnerHTML');
  var shouldUpdateReactComponent = require('./shouldUpdateReactComponent');
  var warning = require('fbjs/lib/warning');
  var ATTR_NAME = DOMProperty.ID_ATTRIBUTE_NAME;
  var ROOT_ATTR_NAME = DOMProperty.ROOT_ATTRIBUTE_NAME;
  var ELEMENT_NODE_TYPE = 1;
  var DOC_NODE_TYPE = 9;
  var DOCUMENT_FRAGMENT_NODE_TYPE = 11;
  var instancesByReactRootID = {};
  function firstDifferenceIndex(string1, string2) {
    var minLen = Math.min(string1.length, string2.length);
    for (var i = 0; i < minLen; i++) {
      if (string1.charAt(i) !== string2.charAt(i)) {
        return i;
      }
    }
    return string1.length === string2.length ? -1 : minLen;
  }
  function getReactRootElementInContainer(container) {
    if (!container) {
      return null;
    }
    if (container.nodeType === DOC_NODE_TYPE) {
      return container.documentElement;
    } else {
      return container.firstChild;
    }
  }
  function internalGetID(node) {
    return node.getAttribute && node.getAttribute(ATTR_NAME) || '';
  }
  function mountComponentIntoNode(wrapperInstance, container, transaction, shouldReuseMarkup, context) {
    var markerName;
    if (ReactFeatureFlags.logTopLevelRenders) {
      var wrappedElement = wrapperInstance._currentElement.props;
      var type = wrappedElement.type;
      markerName = 'React mount: ' + (typeof type === 'string' ? type : type.displayName || type.name);
      console.time(markerName);
    }
    var markup = ReactReconciler.mountComponent(wrapperInstance, transaction, null, ReactDOMContainerInfo(wrapperInstance, container), context, 0);
    if (markerName) {
      console.timeEnd(markerName);
    }
    wrapperInstance._renderedComponent._topLevelWrapper = wrapperInstance;
    ReactMount._mountImageIntoNode(markup, container, wrapperInstance, shouldReuseMarkup, transaction);
  }
  function batchedMountComponentIntoNode(componentInstance, container, shouldReuseMarkup, context) {
    var transaction = ReactUpdates.ReactReconcileTransaction.getPooled(!shouldReuseMarkup && ReactDOMFeatureFlags.useCreateElement);
    transaction.perform(mountComponentIntoNode, null, componentInstance, container, transaction, shouldReuseMarkup, context);
    ReactUpdates.ReactReconcileTransaction.release(transaction);
  }
  function unmountComponentFromNode(instance, container, safely) {
    if (process.env.NODE_ENV !== 'production') {
      ReactInstrumentation.debugTool.onBeginFlush();
    }
    ReactReconciler.unmountComponent(instance, safely);
    if (process.env.NODE_ENV !== 'production') {
      ReactInstrumentation.debugTool.onEndFlush();
    }
    if (container.nodeType === DOC_NODE_TYPE) {
      container = container.documentElement;
    }
    while (container.lastChild) {
      container.removeChild(container.lastChild);
    }
  }
  function hasNonRootReactChild(container) {
    var rootEl = getReactRootElementInContainer(container);
    if (rootEl) {
      var inst = ReactDOMComponentTree.getInstanceFromNode(rootEl);
      return !!(inst && inst._hostParent);
    }
  }
  function nodeIsRenderedByOtherInstance(container) {
    var rootEl = getReactRootElementInContainer(container);
    return !!(rootEl && isReactNode(rootEl) && !ReactDOMComponentTree.getInstanceFromNode(rootEl));
  }
  function isValidContainer(node) {
    return !!(node && (node.nodeType === ELEMENT_NODE_TYPE || node.nodeType === DOC_NODE_TYPE || node.nodeType === DOCUMENT_FRAGMENT_NODE_TYPE));
  }
  function isReactNode(node) {
    return isValidContainer(node) && (node.hasAttribute(ROOT_ATTR_NAME) || node.hasAttribute(ATTR_NAME));
  }
  function getHostRootInstanceInContainer(container) {
    var rootEl = getReactRootElementInContainer(container);
    var prevHostInstance = rootEl && ReactDOMComponentTree.getInstanceFromNode(rootEl);
    return prevHostInstance && !prevHostInstance._hostParent ? prevHostInstance : null;
  }
  function getTopLevelWrapperInContainer(container) {
    var root = getHostRootInstanceInContainer(container);
    return root ? root._hostContainerInfo._topLevelWrapper : null;
  }
  var topLevelRootCounter = 1;
  var TopLevelWrapper = function() {
    this.rootID = topLevelRootCounter++;
  };
  TopLevelWrapper.prototype.isReactComponent = {};
  if (process.env.NODE_ENV !== 'production') {
    TopLevelWrapper.displayName = 'TopLevelWrapper';
  }
  TopLevelWrapper.prototype.render = function() {
    return this.props;
  };
  var ReactMount = {
    TopLevelWrapper: TopLevelWrapper,
    _instancesByReactRootID: instancesByReactRootID,
    scrollMonitor: function(container, renderCallback) {
      renderCallback();
    },
    _updateRootComponent: function(prevComponent, nextElement, nextContext, container, callback) {
      ReactMount.scrollMonitor(container, function() {
        ReactUpdateQueue.enqueueElementInternal(prevComponent, nextElement, nextContext);
        if (callback) {
          ReactUpdateQueue.enqueueCallbackInternal(prevComponent, callback);
        }
      });
      return prevComponent;
    },
    _renderNewRootComponent: function(nextElement, container, shouldReuseMarkup, context) {
      process.env.NODE_ENV !== 'production' ? warning(ReactCurrentOwner.current == null, '_renderNewRootComponent(): Render methods should be a pure function ' + 'of props and state; triggering nested component updates from ' + 'render is not allowed. If necessary, trigger nested updates in ' + 'componentDidUpdate. Check the render method of %s.', ReactCurrentOwner.current && ReactCurrentOwner.current.getName() || 'ReactCompositeComponent') : void 0;
      !isValidContainer(container) ? process.env.NODE_ENV !== 'production' ? invariant(false, '_registerComponent(...): Target container is not a DOM element.') : _prodInvariant('37') : void 0;
      ReactBrowserEventEmitter.ensureScrollValueMonitoring();
      var componentInstance = instantiateReactComponent(nextElement, false);
      ReactUpdates.batchedUpdates(batchedMountComponentIntoNode, componentInstance, container, shouldReuseMarkup, context);
      var wrapperID = componentInstance._instance.rootID;
      instancesByReactRootID[wrapperID] = componentInstance;
      return componentInstance;
    },
    renderSubtreeIntoContainer: function(parentComponent, nextElement, container, callback) {
      !(parentComponent != null && ReactInstanceMap.has(parentComponent)) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'parentComponent must be a valid React Component') : _prodInvariant('38') : void 0;
      return ReactMount._renderSubtreeIntoContainer(parentComponent, nextElement, container, callback);
    },
    _renderSubtreeIntoContainer: function(parentComponent, nextElement, container, callback) {
      ReactUpdateQueue.validateCallback(callback, 'ReactDOM.render');
      !ReactElement.isValidElement(nextElement) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'ReactDOM.render(): Invalid component element.%s', typeof nextElement === 'string' ? ' Instead of passing a string like \'div\', pass ' + 'React.createElement(\'div\') or <div />.' : typeof nextElement === 'function' ? ' Instead of passing a class like Foo, pass ' + 'React.createElement(Foo) or <Foo />.' : nextElement != null && nextElement.props !== undefined ? ' This may be caused by unintentionally loading two independent ' + 'copies of React.' : '') : _prodInvariant('39', typeof nextElement === 'string' ? ' Instead of passing a string like \'div\', pass ' + 'React.createElement(\'div\') or <div />.' : typeof nextElement === 'function' ? ' Instead of passing a class like Foo, pass ' + 'React.createElement(Foo) or <Foo />.' : nextElement != null && nextElement.props !== undefined ? ' This may be caused by unintentionally loading two independent ' + 'copies of React.' : '') : void 0;
      process.env.NODE_ENV !== 'production' ? warning(!container || !container.tagName || container.tagName.toUpperCase() !== 'BODY', 'render(): Rendering components directly into document.body is ' + 'discouraged, since its children are often manipulated by third-party ' + 'scripts and browser extensions. This may lead to subtle ' + 'reconciliation issues. Try rendering into a container element created ' + 'for your app.') : void 0;
      var nextWrappedElement = ReactElement(TopLevelWrapper, null, null, null, null, null, nextElement);
      var nextContext;
      if (parentComponent) {
        var parentInst = ReactInstanceMap.get(parentComponent);
        nextContext = parentInst._processChildContext(parentInst._context);
      } else {
        nextContext = emptyObject;
      }
      var prevComponent = getTopLevelWrapperInContainer(container);
      if (prevComponent) {
        var prevWrappedElement = prevComponent._currentElement;
        var prevElement = prevWrappedElement.props;
        if (shouldUpdateReactComponent(prevElement, nextElement)) {
          var publicInst = prevComponent._renderedComponent.getPublicInstance();
          var updatedCallback = callback && function() {
            callback.call(publicInst);
          };
          ReactMount._updateRootComponent(prevComponent, nextWrappedElement, nextContext, container, updatedCallback);
          return publicInst;
        } else {
          ReactMount.unmountComponentAtNode(container);
        }
      }
      var reactRootElement = getReactRootElementInContainer(container);
      var containerHasReactMarkup = reactRootElement && !!internalGetID(reactRootElement);
      var containerHasNonRootReactChild = hasNonRootReactChild(container);
      if (process.env.NODE_ENV !== 'production') {
        process.env.NODE_ENV !== 'production' ? warning(!containerHasNonRootReactChild, 'render(...): Replacing React-rendered children with a new root ' + 'component. If you intended to update the children of this node, ' + 'you should instead have the existing children update their state ' + 'and render the new components instead of calling ReactDOM.render.') : void 0;
        if (!containerHasReactMarkup || reactRootElement.nextSibling) {
          var rootElementSibling = reactRootElement;
          while (rootElementSibling) {
            if (internalGetID(rootElementSibling)) {
              process.env.NODE_ENV !== 'production' ? warning(false, 'render(): Target node has markup rendered by React, but there ' + 'are unrelated nodes as well. This is most commonly caused by ' + 'white-space inserted around server-rendered markup.') : void 0;
              break;
            }
            rootElementSibling = rootElementSibling.nextSibling;
          }
        }
      }
      var shouldReuseMarkup = containerHasReactMarkup && !prevComponent && !containerHasNonRootReactChild;
      var component = ReactMount._renderNewRootComponent(nextWrappedElement, container, shouldReuseMarkup, nextContext)._renderedComponent.getPublicInstance();
      if (callback) {
        callback.call(component);
      }
      return component;
    },
    render: function(nextElement, container, callback) {
      return ReactMount._renderSubtreeIntoContainer(null, nextElement, container, callback);
    },
    unmountComponentAtNode: function(container) {
      process.env.NODE_ENV !== 'production' ? warning(ReactCurrentOwner.current == null, 'unmountComponentAtNode(): Render methods should be a pure function ' + 'of props and state; triggering nested component updates from render ' + 'is not allowed. If necessary, trigger nested updates in ' + 'componentDidUpdate. Check the render method of %s.', ReactCurrentOwner.current && ReactCurrentOwner.current.getName() || 'ReactCompositeComponent') : void 0;
      !isValidContainer(container) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'unmountComponentAtNode(...): Target container is not a DOM element.') : _prodInvariant('40') : void 0;
      if (process.env.NODE_ENV !== 'production') {
        process.env.NODE_ENV !== 'production' ? warning(!nodeIsRenderedByOtherInstance(container), 'unmountComponentAtNode(): The node you\'re attempting to unmount ' + 'was rendered by another copy of React.') : void 0;
      }
      var prevComponent = getTopLevelWrapperInContainer(container);
      if (!prevComponent) {
        var containerHasNonRootReactChild = hasNonRootReactChild(container);
        var isContainerReactRoot = container.nodeType === 1 && container.hasAttribute(ROOT_ATTR_NAME);
        if (process.env.NODE_ENV !== 'production') {
          process.env.NODE_ENV !== 'production' ? warning(!containerHasNonRootReactChild, 'unmountComponentAtNode(): The node you\'re attempting to unmount ' + 'was rendered by React and is not a top-level container. %s', isContainerReactRoot ? 'You may have accidentally passed in a React root node instead ' + 'of its container.' : 'Instead, have the parent component update its state and ' + 'rerender in order to remove this component.') : void 0;
        }
        return false;
      }
      delete instancesByReactRootID[prevComponent._instance.rootID];
      ReactUpdates.batchedUpdates(unmountComponentFromNode, prevComponent, container, false);
      return true;
    },
    _mountImageIntoNode: function(markup, container, instance, shouldReuseMarkup, transaction) {
      !isValidContainer(container) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'mountComponentIntoNode(...): Target container is not valid.') : _prodInvariant('41') : void 0;
      if (shouldReuseMarkup) {
        var rootElement = getReactRootElementInContainer(container);
        if (ReactMarkupChecksum.canReuseMarkup(markup, rootElement)) {
          ReactDOMComponentTree.precacheNode(instance, rootElement);
          return;
        } else {
          var checksum = rootElement.getAttribute(ReactMarkupChecksum.CHECKSUM_ATTR_NAME);
          rootElement.removeAttribute(ReactMarkupChecksum.CHECKSUM_ATTR_NAME);
          var rootMarkup = rootElement.outerHTML;
          rootElement.setAttribute(ReactMarkupChecksum.CHECKSUM_ATTR_NAME, checksum);
          var normalizedMarkup = markup;
          if (process.env.NODE_ENV !== 'production') {
            var normalizer;
            if (container.nodeType === ELEMENT_NODE_TYPE) {
              normalizer = document.createElement('div');
              normalizer.innerHTML = markup;
              normalizedMarkup = normalizer.innerHTML;
            } else {
              normalizer = document.createElement('iframe');
              document.body.appendChild(normalizer);
              normalizer.contentDocument.write(markup);
              normalizedMarkup = normalizer.contentDocument.documentElement.outerHTML;
              document.body.removeChild(normalizer);
            }
          }
          var diffIndex = firstDifferenceIndex(normalizedMarkup, rootMarkup);
          var difference = ' (client) ' + normalizedMarkup.substring(diffIndex - 20, diffIndex + 20) + '\n (server) ' + rootMarkup.substring(diffIndex - 20, diffIndex + 20);
          !(container.nodeType !== DOC_NODE_TYPE) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'You\'re trying to render a component to the document using server rendering but the checksum was invalid. This usually means you rendered a different component type or props on the client from the one on the server, or your render() methods are impure. React cannot handle this case due to cross-browser quirks by rendering at the document root. You should look for environment dependent code in your components and ensure the props are the same client and server side:\n%s', difference) : _prodInvariant('42', difference) : void 0;
          if (process.env.NODE_ENV !== 'production') {
            process.env.NODE_ENV !== 'production' ? warning(false, 'React attempted to reuse markup in a container but the ' + 'checksum was invalid. This generally means that you are ' + 'using server rendering and the markup generated on the ' + 'server was not what the client was expecting. React injected ' + 'new markup to compensate which works but you have lost many ' + 'of the benefits of server rendering. Instead, figure out ' + 'why the markup being generated is different on the client ' + 'or server:\n%s', difference) : void 0;
          }
        }
      }
      !(container.nodeType !== DOC_NODE_TYPE) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'You\'re trying to render a component to the document but you didn\'t use server rendering. We can\'t do this without using server rendering due to cross-browser quirks. See ReactDOMServer.renderToString() for server rendering.') : _prodInvariant('43') : void 0;
      if (transaction.useCreateElement) {
        while (container.lastChild) {
          container.removeChild(container.lastChild);
        }
        DOMLazyTree.insertTreeBefore(container, markup, null);
      } else {
        setInnerHTML(container, markup);
        ReactDOMComponentTree.precacheNode(instance, container.firstChild);
      }
      if (process.env.NODE_ENV !== 'production') {
        var hostNode = ReactDOMComponentTree.getInstanceFromNode(container.firstChild);
        if (hostNode._debugID !== 0) {
          ReactInstrumentation.debugTool.onHostOperation(hostNode._debugID, 'mount', markup.toString());
        }
      }
    }
  };
  module.exports = ReactMount;
})(require('process'));
