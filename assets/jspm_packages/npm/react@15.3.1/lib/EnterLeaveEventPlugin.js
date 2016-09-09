/* */ 
'use strict';
var EventConstants = require('./EventConstants');
var EventPropagators = require('./EventPropagators');
var ReactDOMComponentTree = require('./ReactDOMComponentTree');
var SyntheticMouseEvent = require('./SyntheticMouseEvent');
var keyOf = require('fbjs/lib/keyOf');
var topLevelTypes = EventConstants.topLevelTypes;
var eventTypes = {
  mouseEnter: {
    registrationName: keyOf({onMouseEnter: null}),
    dependencies: [topLevelTypes.topMouseOut, topLevelTypes.topMouseOver]
  },
  mouseLeave: {
    registrationName: keyOf({onMouseLeave: null}),
    dependencies: [topLevelTypes.topMouseOut, topLevelTypes.topMouseOver]
  }
};
var EnterLeaveEventPlugin = {
  eventTypes: eventTypes,
  extractEvents: function(topLevelType, targetInst, nativeEvent, nativeEventTarget) {
    if (topLevelType === topLevelTypes.topMouseOver && (nativeEvent.relatedTarget || nativeEvent.fromElement)) {
      return null;
    }
    if (topLevelType !== topLevelTypes.topMouseOut && topLevelType !== topLevelTypes.topMouseOver) {
      return null;
    }
    var win;
    if (nativeEventTarget.window === nativeEventTarget) {
      win = nativeEventTarget;
    } else {
      var doc = nativeEventTarget.ownerDocument;
      if (doc) {
        win = doc.defaultView || doc.parentWindow;
      } else {
        win = window;
      }
    }
    var from;
    var to;
    if (topLevelType === topLevelTypes.topMouseOut) {
      from = targetInst;
      var related = nativeEvent.relatedTarget || nativeEvent.toElement;
      to = related ? ReactDOMComponentTree.getClosestInstanceFromNode(related) : null;
    } else {
      from = null;
      to = targetInst;
    }
    if (from === to) {
      return null;
    }
    var fromNode = from == null ? win : ReactDOMComponentTree.getNodeFromInstance(from);
    var toNode = to == null ? win : ReactDOMComponentTree.getNodeFromInstance(to);
    var leave = SyntheticMouseEvent.getPooled(eventTypes.mouseLeave, from, nativeEvent, nativeEventTarget);
    leave.type = 'mouseleave';
    leave.target = fromNode;
    leave.relatedTarget = toNode;
    var enter = SyntheticMouseEvent.getPooled(eventTypes.mouseEnter, to, nativeEvent, nativeEventTarget);
    enter.type = 'mouseenter';
    enter.target = toNode;
    enter.relatedTarget = fromNode;
    EventPropagators.accumulateEnterLeaveDispatches(leave, enter, from, to);
    return [leave, enter];
  }
};
module.exports = EnterLeaveEventPlugin;
