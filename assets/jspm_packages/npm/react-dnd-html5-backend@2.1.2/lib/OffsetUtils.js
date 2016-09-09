/* */ 
'use strict';
exports.__esModule = true;
exports.getNodeClientOffset = getNodeClientOffset;
exports.getEventClientOffset = getEventClientOffset;
exports.getDragPreviewOffset = getDragPreviewOffset;
function _interopRequireDefault(obj) {
  return obj && obj.__esModule ? obj : {'default': obj};
}
var _BrowserDetector = require('./BrowserDetector');
var _MonotonicInterpolant = require('./MonotonicInterpolant');
var _MonotonicInterpolant2 = _interopRequireDefault(_MonotonicInterpolant);
var ELEMENT_NODE = 1;
function getNodeClientOffset(node) {
  var el = node.nodeType === ELEMENT_NODE ? node : node.parentElement;
  if (!el) {
    return null;
  }
  var _el$getBoundingClientRect = el.getBoundingClientRect();
  var top = _el$getBoundingClientRect.top;
  var left = _el$getBoundingClientRect.left;
  return {
    x: left,
    y: top
  };
}
function getEventClientOffset(e) {
  return {
    x: e.clientX,
    y: e.clientY
  };
}
function getDragPreviewOffset(sourceNode, dragPreview, clientOffset, anchorPoint) {
  var isImage = dragPreview.nodeName === 'IMG' && (_BrowserDetector.isFirefox() || !document.documentElement.contains(dragPreview));
  var dragPreviewNode = isImage ? sourceNode : dragPreview;
  var dragPreviewNodeOffsetFromClient = getNodeClientOffset(dragPreviewNode);
  var offsetFromDragPreview = {
    x: clientOffset.x - dragPreviewNodeOffsetFromClient.x,
    y: clientOffset.y - dragPreviewNodeOffsetFromClient.y
  };
  var sourceWidth = sourceNode.offsetWidth;
  var sourceHeight = sourceNode.offsetHeight;
  var anchorX = anchorPoint.anchorX;
  var anchorY = anchorPoint.anchorY;
  var dragPreviewWidth = isImage ? dragPreview.width : sourceWidth;
  var dragPreviewHeight = isImage ? dragPreview.height : sourceHeight;
  if (_BrowserDetector.isSafari() && isImage) {
    dragPreviewHeight /= window.devicePixelRatio;
    dragPreviewWidth /= window.devicePixelRatio;
  } else if (_BrowserDetector.isFirefox() && !isImage) {
    dragPreviewHeight *= window.devicePixelRatio;
    dragPreviewWidth *= window.devicePixelRatio;
  }
  var interpolantX = new _MonotonicInterpolant2['default']([0, 0.5, 1], [offsetFromDragPreview.x, offsetFromDragPreview.x / sourceWidth * dragPreviewWidth, offsetFromDragPreview.x + dragPreviewWidth - sourceWidth]);
  var interpolantY = new _MonotonicInterpolant2['default']([0, 0.5, 1], [offsetFromDragPreview.y, offsetFromDragPreview.y / sourceHeight * dragPreviewHeight, offsetFromDragPreview.y + dragPreviewHeight - sourceHeight]);
  var x = interpolantX.interpolate(anchorX);
  var y = interpolantY.interpolate(anchorY);
  if (_BrowserDetector.isSafari() && isImage) {
    y += (window.devicePixelRatio - 1) * dragPreviewHeight;
  }
  return {
    x: x,
    y: y
  };
}
