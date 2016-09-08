/* */ 
(function(process) {
  'use strict';
  var _assign = require('object-assign');
  var EventListener = require('fbjs/lib/EventListener');
  var ExecutionEnvironment = require('fbjs/lib/ExecutionEnvironment');
  var PooledClass = require('./PooledClass');
  var ReactDOMComponentTree = require('./ReactDOMComponentTree');
  var ReactUpdates = require('./ReactUpdates');
  var getEventTarget = require('./getEventTarget');
  var getUnboundedScrollPosition = require('fbjs/lib/getUnboundedScrollPosition');
  function findParent(inst) {
    while (inst._hostParent) {
      inst = inst._hostParent;
    }
    var rootNode = ReactDOMComponentTree.getNodeFromInstance(inst);
    var container = rootNode.parentNode;
    return ReactDOMComponentTree.getClosestInstanceFromNode(container);
  }
  function TopLevelCallbackBookKeeping(topLevelType, nativeEvent) {
    this.topLevelType = topLevelType;
    this.nativeEvent = nativeEvent;
    this.ancestors = [];
  }
  _assign(TopLevelCallbackBookKeeping.prototype, {destructor: function() {
      this.topLevelType = null;
      this.nativeEvent = null;
      this.ancestors.length = 0;
    }});
  PooledClass.addPoolingTo(TopLevelCallbackBookKeeping, PooledClass.twoArgumentPooler);
  function handleTopLevelImpl(bookKeeping) {
    var nativeEventTarget = getEventTarget(bookKeeping.nativeEvent);
    var targetInst = ReactDOMComponentTree.getClosestInstanceFromNode(nativeEventTarget);
    var ancestor = targetInst;
    do {
      bookKeeping.ancestors.push(ancestor);
      ancestor = ancestor && findParent(ancestor);
    } while (ancestor);
    for (var i = 0; i < bookKeeping.ancestors.length; i++) {
      targetInst = bookKeeping.ancestors[i];
      ReactEventListener._handleTopLevel(bookKeeping.topLevelType, targetInst, bookKeeping.nativeEvent, getEventTarget(bookKeeping.nativeEvent));
    }
  }
  function scrollValueMonitor(cb) {
    var scrollPosition = getUnboundedScrollPosition(window);
    cb(scrollPosition);
  }
  var ReactEventListener = {
    _enabled: true,
    _handleTopLevel: null,
    WINDOW_HANDLE: ExecutionEnvironment.canUseDOM ? window : null,
    setHandleTopLevel: function(handleTopLevel) {
      ReactEventListener._handleTopLevel = handleTopLevel;
    },
    setEnabled: function(enabled) {
      ReactEventListener._enabled = !!enabled;
    },
    isEnabled: function() {
      return ReactEventListener._enabled;
    },
    trapBubbledEvent: function(topLevelType, handlerBaseName, handle) {
      var element = handle;
      if (!element) {
        return null;
      }
      return EventListener.listen(element, handlerBaseName, ReactEventListener.dispatchEvent.bind(null, topLevelType));
    },
    trapCapturedEvent: function(topLevelType, handlerBaseName, handle) {
      var element = handle;
      if (!element) {
        return null;
      }
      return EventListener.capture(element, handlerBaseName, ReactEventListener.dispatchEvent.bind(null, topLevelType));
    },
    monitorScrollValue: function(refresh) {
      var callback = scrollValueMonitor.bind(null, refresh);
      EventListener.listen(window, 'scroll', callback);
    },
    dispatchEvent: function(topLevelType, nativeEvent) {
      if (!ReactEventListener._enabled) {
        return;
      }
      var bookKeeping = TopLevelCallbackBookKeeping.getPooled(topLevelType, nativeEvent);
      try {
        ReactUpdates.batchedUpdates(handleTopLevelImpl, bookKeeping);
      } finally {
        TopLevelCallbackBookKeeping.release(bookKeeping);
      }
    }
  };
  module.exports = ReactEventListener;
})(require('process'));
