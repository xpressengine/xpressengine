/* */ 
'use strict';
exports.__esModule = true;
function _interopRequireWildcard(obj) {
  if (obj && obj.__esModule) {
    return obj;
  } else {
    var newObj = {};
    if (obj != null) {
      for (var key in obj) {
        if (Object.prototype.hasOwnProperty.call(obj, key))
          newObj[key] = obj[key];
      }
    }
    newObj['default'] = obj;
    return newObj;
  }
}
function _interopRequireDefault(obj) {
  return obj && obj.__esModule ? obj : {'default': obj};
}
function _classCallCheck(instance, Constructor) {
  if (!(instance instanceof Constructor)) {
    throw new TypeError('Cannot call a class as a function');
  }
}
var _lodashDefaults = require('lodash/defaults');
var _lodashDefaults2 = _interopRequireDefault(_lodashDefaults);
var _shallowEqual = require('./shallowEqual');
var _shallowEqual2 = _interopRequireDefault(_shallowEqual);
var _EnterLeaveCounter = require('./EnterLeaveCounter');
var _EnterLeaveCounter2 = _interopRequireDefault(_EnterLeaveCounter);
var _BrowserDetector = require('./BrowserDetector');
var _OffsetUtils = require('./OffsetUtils');
var _NativeDragSources = require('./NativeDragSources');
var _NativeTypes = require('./NativeTypes');
var NativeTypes = _interopRequireWildcard(_NativeTypes);
var HTML5Backend = (function() {
  function HTML5Backend(manager) {
    _classCallCheck(this, HTML5Backend);
    this.actions = manager.getActions();
    this.monitor = manager.getMonitor();
    this.registry = manager.getRegistry();
    this.sourcePreviewNodes = {};
    this.sourcePreviewNodeOptions = {};
    this.sourceNodes = {};
    this.sourceNodeOptions = {};
    this.enterLeaveCounter = new _EnterLeaveCounter2['default']();
    this.getSourceClientOffset = this.getSourceClientOffset.bind(this);
    this.handleTopDragStart = this.handleTopDragStart.bind(this);
    this.handleTopDragStartCapture = this.handleTopDragStartCapture.bind(this);
    this.handleTopDragEndCapture = this.handleTopDragEndCapture.bind(this);
    this.handleTopDragEnter = this.handleTopDragEnter.bind(this);
    this.handleTopDragEnterCapture = this.handleTopDragEnterCapture.bind(this);
    this.handleTopDragLeaveCapture = this.handleTopDragLeaveCapture.bind(this);
    this.handleTopDragOver = this.handleTopDragOver.bind(this);
    this.handleTopDragOverCapture = this.handleTopDragOverCapture.bind(this);
    this.handleTopDrop = this.handleTopDrop.bind(this);
    this.handleTopDropCapture = this.handleTopDropCapture.bind(this);
    this.handleSelectStart = this.handleSelectStart.bind(this);
    this.endDragIfSourceWasRemovedFromDOM = this.endDragIfSourceWasRemovedFromDOM.bind(this);
    this.endDragNativeItem = this.endDragNativeItem.bind(this);
  }
  HTML5Backend.prototype.setup = function setup() {
    if (typeof window === 'undefined') {
      return;
    }
    if (this.constructor.isSetUp) {
      throw new Error('Cannot have two HTML5 backends at the same time.');
    }
    this.constructor.isSetUp = true;
    this.addEventListeners(window);
  };
  HTML5Backend.prototype.teardown = function teardown() {
    if (typeof window === 'undefined') {
      return;
    }
    this.constructor.isSetUp = false;
    this.removeEventListeners(window);
    this.clearCurrentDragSourceNode();
  };
  HTML5Backend.prototype.addEventListeners = function addEventListeners(target) {
    target.addEventListener('dragstart', this.handleTopDragStart);
    target.addEventListener('dragstart', this.handleTopDragStartCapture, true);
    target.addEventListener('dragend', this.handleTopDragEndCapture, true);
    target.addEventListener('dragenter', this.handleTopDragEnter);
    target.addEventListener('dragenter', this.handleTopDragEnterCapture, true);
    target.addEventListener('dragleave', this.handleTopDragLeaveCapture, true);
    target.addEventListener('dragover', this.handleTopDragOver);
    target.addEventListener('dragover', this.handleTopDragOverCapture, true);
    target.addEventListener('drop', this.handleTopDrop);
    target.addEventListener('drop', this.handleTopDropCapture, true);
  };
  HTML5Backend.prototype.removeEventListeners = function removeEventListeners(target) {
    target.removeEventListener('dragstart', this.handleTopDragStart);
    target.removeEventListener('dragstart', this.handleTopDragStartCapture, true);
    target.removeEventListener('dragend', this.handleTopDragEndCapture, true);
    target.removeEventListener('dragenter', this.handleTopDragEnter);
    target.removeEventListener('dragenter', this.handleTopDragEnterCapture, true);
    target.removeEventListener('dragleave', this.handleTopDragLeaveCapture, true);
    target.removeEventListener('dragover', this.handleTopDragOver);
    target.removeEventListener('dragover', this.handleTopDragOverCapture, true);
    target.removeEventListener('drop', this.handleTopDrop);
    target.removeEventListener('drop', this.handleTopDropCapture, true);
  };
  HTML5Backend.prototype.connectDragPreview = function connectDragPreview(sourceId, node, options) {
    var _this = this;
    this.sourcePreviewNodeOptions[sourceId] = options;
    this.sourcePreviewNodes[sourceId] = node;
    return function() {
      delete _this.sourcePreviewNodes[sourceId];
      delete _this.sourcePreviewNodeOptions[sourceId];
    };
  };
  HTML5Backend.prototype.connectDragSource = function connectDragSource(sourceId, node, options) {
    var _this2 = this;
    this.sourceNodes[sourceId] = node;
    this.sourceNodeOptions[sourceId] = options;
    var handleDragStart = function handleDragStart(e) {
      return _this2.handleDragStart(e, sourceId);
    };
    var handleSelectStart = function handleSelectStart(e) {
      return _this2.handleSelectStart(e, sourceId);
    };
    node.setAttribute('draggable', true);
    node.addEventListener('dragstart', handleDragStart);
    node.addEventListener('selectstart', handleSelectStart);
    return function() {
      delete _this2.sourceNodes[sourceId];
      delete _this2.sourceNodeOptions[sourceId];
      node.removeEventListener('dragstart', handleDragStart);
      node.removeEventListener('selectstart', handleSelectStart);
      node.setAttribute('draggable', false);
    };
  };
  HTML5Backend.prototype.connectDropTarget = function connectDropTarget(targetId, node) {
    var _this3 = this;
    var handleDragEnter = function handleDragEnter(e) {
      return _this3.handleDragEnter(e, targetId);
    };
    var handleDragOver = function handleDragOver(e) {
      return _this3.handleDragOver(e, targetId);
    };
    var handleDrop = function handleDrop(e) {
      return _this3.handleDrop(e, targetId);
    };
    node.addEventListener('dragenter', handleDragEnter);
    node.addEventListener('dragover', handleDragOver);
    node.addEventListener('drop', handleDrop);
    return function() {
      node.removeEventListener('dragenter', handleDragEnter);
      node.removeEventListener('dragover', handleDragOver);
      node.removeEventListener('drop', handleDrop);
    };
  };
  HTML5Backend.prototype.getCurrentSourceNodeOptions = function getCurrentSourceNodeOptions() {
    var sourceId = this.monitor.getSourceId();
    var sourceNodeOptions = this.sourceNodeOptions[sourceId];
    return _lodashDefaults2['default'](sourceNodeOptions || {}, {dropEffect: 'move'});
  };
  HTML5Backend.prototype.getCurrentDropEffect = function getCurrentDropEffect() {
    if (this.isDraggingNativeItem()) {
      return 'copy';
    }
    return this.getCurrentSourceNodeOptions().dropEffect;
  };
  HTML5Backend.prototype.getCurrentSourcePreviewNodeOptions = function getCurrentSourcePreviewNodeOptions() {
    var sourceId = this.monitor.getSourceId();
    var sourcePreviewNodeOptions = this.sourcePreviewNodeOptions[sourceId];
    return _lodashDefaults2['default'](sourcePreviewNodeOptions || {}, {
      anchorX: 0.5,
      anchorY: 0.5,
      captureDraggingState: false
    });
  };
  HTML5Backend.prototype.getSourceClientOffset = function getSourceClientOffset(sourceId) {
    return _OffsetUtils.getNodeClientOffset(this.sourceNodes[sourceId]);
  };
  HTML5Backend.prototype.isDraggingNativeItem = function isDraggingNativeItem() {
    var itemType = this.monitor.getItemType();
    return Object.keys(NativeTypes).some(function(key) {
      return NativeTypes[key] === itemType;
    });
  };
  HTML5Backend.prototype.beginDragNativeItem = function beginDragNativeItem(type) {
    this.clearCurrentDragSourceNode();
    var SourceType = _NativeDragSources.createNativeDragSource(type);
    this.currentNativeSource = new SourceType();
    this.currentNativeHandle = this.registry.addSource(type, this.currentNativeSource);
    this.actions.beginDrag([this.currentNativeHandle]);
    if (_BrowserDetector.isFirefox()) {
      window.addEventListener('mousemove', this.endDragNativeItem, true);
    }
  };
  HTML5Backend.prototype.endDragNativeItem = function endDragNativeItem() {
    if (!this.isDraggingNativeItem()) {
      return;
    }
    if (_BrowserDetector.isFirefox()) {
      window.removeEventListener('mousemove', this.endDragNativeItem, true);
    }
    this.actions.endDrag();
    this.registry.removeSource(this.currentNativeHandle);
    this.currentNativeHandle = null;
    this.currentNativeSource = null;
  };
  HTML5Backend.prototype.endDragIfSourceWasRemovedFromDOM = function endDragIfSourceWasRemovedFromDOM() {
    var node = this.currentDragSourceNode;
    if (document.body.contains(node)) {
      return;
    }
    if (this.clearCurrentDragSourceNode()) {
      this.actions.endDrag();
    }
  };
  HTML5Backend.prototype.setCurrentDragSourceNode = function setCurrentDragSourceNode(node) {
    this.clearCurrentDragSourceNode();
    this.currentDragSourceNode = node;
    this.currentDragSourceNodeOffset = _OffsetUtils.getNodeClientOffset(node);
    this.currentDragSourceNodeOffsetChanged = false;
    window.addEventListener('mousemove', this.endDragIfSourceWasRemovedFromDOM, true);
  };
  HTML5Backend.prototype.clearCurrentDragSourceNode = function clearCurrentDragSourceNode() {
    if (this.currentDragSourceNode) {
      this.currentDragSourceNode = null;
      this.currentDragSourceNodeOffset = null;
      this.currentDragSourceNodeOffsetChanged = false;
      window.removeEventListener('mousemove', this.endDragIfSourceWasRemovedFromDOM, true);
      return true;
    }
    return false;
  };
  HTML5Backend.prototype.checkIfCurrentDragSourceRectChanged = function checkIfCurrentDragSourceRectChanged() {
    var node = this.currentDragSourceNode;
    if (!node) {
      return false;
    }
    if (this.currentDragSourceNodeOffsetChanged) {
      return true;
    }
    this.currentDragSourceNodeOffsetChanged = !_shallowEqual2['default'](_OffsetUtils.getNodeClientOffset(node), this.currentDragSourceNodeOffset);
    return this.currentDragSourceNodeOffsetChanged;
  };
  HTML5Backend.prototype.handleTopDragStartCapture = function handleTopDragStartCapture() {
    this.clearCurrentDragSourceNode();
    this.dragStartSourceIds = [];
  };
  HTML5Backend.prototype.handleDragStart = function handleDragStart(e, sourceId) {
    this.dragStartSourceIds.unshift(sourceId);
  };
  HTML5Backend.prototype.handleTopDragStart = function handleTopDragStart(e) {
    var _this4 = this;
    var dragStartSourceIds = this.dragStartSourceIds;
    this.dragStartSourceIds = null;
    var clientOffset = _OffsetUtils.getEventClientOffset(e);
    this.actions.beginDrag(dragStartSourceIds, {
      publishSource: false,
      getSourceClientOffset: this.getSourceClientOffset,
      clientOffset: clientOffset
    });
    var dataTransfer = e.dataTransfer;
    var nativeType = _NativeDragSources.matchNativeItemType(dataTransfer);
    if (this.monitor.isDragging()) {
      if (typeof dataTransfer.setDragImage === 'function') {
        var sourceId = this.monitor.getSourceId();
        var sourceNode = this.sourceNodes[sourceId];
        var dragPreview = this.sourcePreviewNodes[sourceId] || sourceNode;
        var _getCurrentSourcePreviewNodeOptions = this.getCurrentSourcePreviewNodeOptions();
        var anchorX = _getCurrentSourcePreviewNodeOptions.anchorX;
        var anchorY = _getCurrentSourcePreviewNodeOptions.anchorY;
        var anchorPoint = {
          anchorX: anchorX,
          anchorY: anchorY
        };
        var dragPreviewOffset = _OffsetUtils.getDragPreviewOffset(sourceNode, dragPreview, clientOffset, anchorPoint);
        dataTransfer.setDragImage(dragPreview, dragPreviewOffset.x, dragPreviewOffset.y);
      }
      try {
        dataTransfer.setData('application/json', {});
      } catch (err) {}
      this.setCurrentDragSourceNode(e.target);
      var _getCurrentSourcePreviewNodeOptions2 = this.getCurrentSourcePreviewNodeOptions();
      var captureDraggingState = _getCurrentSourcePreviewNodeOptions2.captureDraggingState;
      if (!captureDraggingState) {
        setTimeout(function() {
          return _this4.actions.publishDragSource();
        });
      } else {
        this.actions.publishDragSource();
      }
    } else if (nativeType) {
      this.beginDragNativeItem(nativeType);
    } else if (!dataTransfer.types && (!e.target.hasAttribute || !e.target.hasAttribute('draggable'))) {
      return;
    } else {
      e.preventDefault();
    }
  };
  HTML5Backend.prototype.handleTopDragEndCapture = function handleTopDragEndCapture() {
    if (this.clearCurrentDragSourceNode()) {
      this.actions.endDrag();
    }
  };
  HTML5Backend.prototype.handleTopDragEnterCapture = function handleTopDragEnterCapture(e) {
    this.dragEnterTargetIds = [];
    var isFirstEnter = this.enterLeaveCounter.enter(e.target);
    if (!isFirstEnter || this.monitor.isDragging()) {
      return;
    }
    var dataTransfer = e.dataTransfer;
    var nativeType = _NativeDragSources.matchNativeItemType(dataTransfer);
    if (nativeType) {
      this.beginDragNativeItem(nativeType);
    }
  };
  HTML5Backend.prototype.handleDragEnter = function handleDragEnter(e, targetId) {
    this.dragEnterTargetIds.unshift(targetId);
  };
  HTML5Backend.prototype.handleTopDragEnter = function handleTopDragEnter(e) {
    var _this5 = this;
    var dragEnterTargetIds = this.dragEnterTargetIds;
    this.dragEnterTargetIds = [];
    if (!this.monitor.isDragging()) {
      return;
    }
    if (!_BrowserDetector.isFirefox()) {
      this.actions.hover(dragEnterTargetIds, {clientOffset: _OffsetUtils.getEventClientOffset(e)});
    }
    var canDrop = dragEnterTargetIds.some(function(targetId) {
      return _this5.monitor.canDropOnTarget(targetId);
    });
    if (canDrop) {
      e.preventDefault();
      e.dataTransfer.dropEffect = this.getCurrentDropEffect();
    }
  };
  HTML5Backend.prototype.handleTopDragOverCapture = function handleTopDragOverCapture() {
    this.dragOverTargetIds = [];
  };
  HTML5Backend.prototype.handleDragOver = function handleDragOver(e, targetId) {
    this.dragOverTargetIds.unshift(targetId);
  };
  HTML5Backend.prototype.handleTopDragOver = function handleTopDragOver(e) {
    var _this6 = this;
    var dragOverTargetIds = this.dragOverTargetIds;
    this.dragOverTargetIds = [];
    if (!this.monitor.isDragging()) {
      e.preventDefault();
      e.dataTransfer.dropEffect = 'none';
      return;
    }
    this.actions.hover(dragOverTargetIds, {clientOffset: _OffsetUtils.getEventClientOffset(e)});
    var canDrop = dragOverTargetIds.some(function(targetId) {
      return _this6.monitor.canDropOnTarget(targetId);
    });
    if (canDrop) {
      e.preventDefault();
      e.dataTransfer.dropEffect = this.getCurrentDropEffect();
    } else if (this.isDraggingNativeItem()) {
      e.preventDefault();
      e.dataTransfer.dropEffect = 'none';
    } else if (this.checkIfCurrentDragSourceRectChanged()) {
      e.preventDefault();
      e.dataTransfer.dropEffect = 'move';
    }
  };
  HTML5Backend.prototype.handleTopDragLeaveCapture = function handleTopDragLeaveCapture(e) {
    if (this.isDraggingNativeItem()) {
      e.preventDefault();
    }
    var isLastLeave = this.enterLeaveCounter.leave(e.target);
    if (!isLastLeave) {
      return;
    }
    if (this.isDraggingNativeItem()) {
      this.endDragNativeItem();
    }
  };
  HTML5Backend.prototype.handleTopDropCapture = function handleTopDropCapture(e) {
    this.dropTargetIds = [];
    e.preventDefault();
    if (this.isDraggingNativeItem()) {
      this.currentNativeSource.mutateItemByReadingDataTransfer(e.dataTransfer);
    }
    this.enterLeaveCounter.reset();
  };
  HTML5Backend.prototype.handleDrop = function handleDrop(e, targetId) {
    this.dropTargetIds.unshift(targetId);
  };
  HTML5Backend.prototype.handleTopDrop = function handleTopDrop(e) {
    var dropTargetIds = this.dropTargetIds;
    this.dropTargetIds = [];
    this.actions.hover(dropTargetIds, {clientOffset: _OffsetUtils.getEventClientOffset(e)});
    this.actions.drop();
    if (this.isDraggingNativeItem()) {
      this.endDragNativeItem();
    } else {
      this.endDragIfSourceWasRemovedFromDOM();
    }
  };
  HTML5Backend.prototype.handleSelectStart = function handleSelectStart(e) {
    var target = e.target;
    if (typeof target.dragDrop !== 'function') {
      return;
    }
    if (target.tagName === 'INPUT' || target.tagName === 'SELECT' || target.tagName === 'TEXTAREA' || target.isContentEditable) {
      return;
    }
    e.preventDefault();
    target.dragDrop();
  };
  return HTML5Backend;
})();
exports['default'] = HTML5Backend;
module.exports = exports['default'];
