/* */ 
"format cjs";
(function(process) {
  (function webpackUniversalModuleDefinition(root, factory) {
    if (typeof exports === 'object' && typeof module === 'object')
      module.exports = factory(require('react'));
    else if (typeof define === 'function' && define.amd)
      define(["react"], factory);
    else if (typeof exports === 'object')
      exports["ReactDnD"] = factory(require('react'));
    else
      root["ReactDnD"] = factory(root["React"]);
  })(this, function(__WEBPACK_EXTERNAL_MODULE_6__) {
    return (function(modules) {
      var installedModules = {};
      function __webpack_require__(moduleId) {
        if (installedModules[moduleId])
          return installedModules[moduleId].exports;
        var module = installedModules[moduleId] = {
          exports: {},
          id: moduleId,
          loaded: false
        };
        modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
        module.loaded = true;
        return module.exports;
      }
      __webpack_require__.m = modules;
      __webpack_require__.c = installedModules;
      __webpack_require__.p = "";
      return __webpack_require__(0);
    })([function(module, exports, __webpack_require__) {
      'use strict';
      exports.__esModule = true;
      function _interopRequire(obj) {
        return obj && obj.__esModule ? obj['default'] : obj;
      }
      var _DragDropContext = __webpack_require__(42);
      exports.DragDropContext = _interopRequire(_DragDropContext);
      var _DragLayer = __webpack_require__(43);
      exports.DragLayer = _interopRequire(_DragLayer);
      var _DragSource = __webpack_require__(44);
      exports.DragSource = _interopRequire(_DragSource);
      var _DropTarget = __webpack_require__(45);
      exports.DropTarget = _interopRequire(_DropTarget);
    }, function(module, exports, __webpack_require__) {
      'use strict';
      var invariant = function(condition, format, a, b, c, d, e, f) {
        if (false) {
          if (format === undefined) {
            throw new Error('invariant requires an error message argument');
          }
        }
        if (!condition) {
          var error;
          if (format === undefined) {
            error = new Error('Minified exception occurred; use the non-minified dev environment ' + 'for the full error message and additional helpful warnings.');
          } else {
            var args = [a, b, c, d, e, f];
            var argIndex = 0;
            error = new Error(format.replace(/%s/g, function() {
              return args[argIndex++];
            }));
            error.name = 'Invariant Violation';
          }
          error.framesToPop = 1;
          throw error;
        }
      };
      module.exports = invariant;
    }, function(module, exports, __webpack_require__) {
      var getPrototype = __webpack_require__(90),
          isHostObject = __webpack_require__(37),
          isObjectLike = __webpack_require__(12);
      var objectTag = '[object Object]';
      var objectProto = Object.prototype;
      var funcToString = Function.prototype.toString;
      var hasOwnProperty = objectProto.hasOwnProperty;
      var objectCtorString = funcToString.call(Object);
      var objectToString = objectProto.toString;
      function isPlainObject(value) {
        if (!isObjectLike(value) || objectToString.call(value) != objectTag || isHostObject(value)) {
          return false;
        }
        var proto = getPrototype(value);
        if (proto === null) {
          return true;
        }
        var Ctor = hasOwnProperty.call(proto, 'constructor') && proto.constructor;
        return (typeof Ctor == 'function' && Ctor instanceof Ctor && funcToString.call(Ctor) == objectCtorString);
      }
      module.exports = isPlainObject;
    }, function(module, exports) {
      function isKeyable(value) {
        var type = typeof value;
        return type == 'number' || type == 'boolean' || (type == 'string' && value != '__proto__') || value == null;
      }
      module.exports = isKeyable;
    }, function(module, exports, __webpack_require__) {
      var getNative = __webpack_require__(20),
          root = __webpack_require__(38);
      var Map = getNative(root, 'Map');
      module.exports = Map;
    }, function(module, exports) {
      var isArray = Array.isArray;
      module.exports = isArray;
    }, function(module, exports) {
      module.exports = __WEBPACK_EXTERNAL_MODULE_6__;
    }, function(module, exports, __webpack_require__) {
      'use strict';
      exports.__esModule = true;
      exports['default'] = checkDecoratorArguments;
      function checkDecoratorArguments(functionName, signature) {
        if (false) {
          for (var _len = arguments.length,
              args = Array(_len > 2 ? _len - 2 : 0),
              _key = 2; _key < _len; _key++) {
            args[_key - 2] = arguments[_key];
          }
          for (var i = 0; i < args.length; i++) {
            var arg = args[i];
            if (arg && arg.prototype && arg.prototype.render) {
              console.error('You seem to be applying the arguments in the wrong order. ' + ('It should be ' + functionName + '(' + signature + ')(Component), not the other way around. ') + 'Read more: http://gaearon.github.io/react-dnd/docs-troubleshooting.html#you-seem-to-be-applying-the-arguments-in-the-wrong-order');
              return;
            }
          }
        }
      }
      module.exports = exports['default'];
    }, function(module, exports, __webpack_require__) {
      'use strict';
      exports.__esModule = true;
      exports.beginDrag = beginDrag;
      exports.publishDragSource = publishDragSource;
      exports.hover = hover;
      exports.drop = drop;
      exports.endDrag = endDrag;
      function _interopRequireDefault(obj) {
        return obj && obj.__esModule ? obj : {'default': obj};
      }
      var _utilsMatchesType = __webpack_require__(33);
      var _utilsMatchesType2 = _interopRequireDefault(_utilsMatchesType);
      var _invariant = __webpack_require__(1);
      var _invariant2 = _interopRequireDefault(_invariant);
      var _lodashIsArray = __webpack_require__(5);
      var _lodashIsArray2 = _interopRequireDefault(_lodashIsArray);
      var _lodashIsObject = __webpack_require__(23);
      var _lodashIsObject2 = _interopRequireDefault(_lodashIsObject);
      var BEGIN_DRAG = 'dnd-core/BEGIN_DRAG';
      exports.BEGIN_DRAG = BEGIN_DRAG;
      var PUBLISH_DRAG_SOURCE = 'dnd-core/PUBLISH_DRAG_SOURCE';
      exports.PUBLISH_DRAG_SOURCE = PUBLISH_DRAG_SOURCE;
      var HOVER = 'dnd-core/HOVER';
      exports.HOVER = HOVER;
      var DROP = 'dnd-core/DROP';
      exports.DROP = DROP;
      var END_DRAG = 'dnd-core/END_DRAG';
      exports.END_DRAG = END_DRAG;
      function beginDrag(sourceIds) {
        var _ref = arguments.length <= 1 || arguments[1] === undefined ? {} : arguments[1];
        var _ref$publishSource = _ref.publishSource;
        var publishSource = _ref$publishSource === undefined ? true : _ref$publishSource;
        var _ref$clientOffset = _ref.clientOffset;
        var clientOffset = _ref$clientOffset === undefined ? null : _ref$clientOffset;
        var getSourceClientOffset = _ref.getSourceClientOffset;
        _invariant2['default'](_lodashIsArray2['default'](sourceIds), 'Expected sourceIds to be an array.');
        var monitor = this.getMonitor();
        var registry = this.getRegistry();
        _invariant2['default'](!monitor.isDragging(), 'Cannot call beginDrag while dragging.');
        for (var i = 0; i < sourceIds.length; i++) {
          _invariant2['default'](registry.getSource(sourceIds[i]), 'Expected sourceIds to be registered.');
        }
        var sourceId = null;
        for (var i = sourceIds.length - 1; i >= 0; i--) {
          if (monitor.canDragSource(sourceIds[i])) {
            sourceId = sourceIds[i];
            break;
          }
        }
        if (sourceId === null) {
          return;
        }
        var sourceClientOffset = null;
        if (clientOffset) {
          _invariant2['default'](typeof getSourceClientOffset === 'function', 'When clientOffset is provided, getSourceClientOffset must be a function.');
          sourceClientOffset = getSourceClientOffset(sourceId);
        }
        var source = registry.getSource(sourceId);
        var item = source.beginDrag(monitor, sourceId);
        _invariant2['default'](_lodashIsObject2['default'](item), 'Item must be an object.');
        registry.pinSource(sourceId);
        var itemType = registry.getSourceType(sourceId);
        return {
          type: BEGIN_DRAG,
          itemType: itemType,
          item: item,
          sourceId: sourceId,
          clientOffset: clientOffset,
          sourceClientOffset: sourceClientOffset,
          isSourcePublic: publishSource
        };
      }
      function publishDragSource(manager) {
        var monitor = this.getMonitor();
        if (!monitor.isDragging()) {
          return;
        }
        return {type: PUBLISH_DRAG_SOURCE};
      }
      function hover(targetIds) {
        var _ref2 = arguments.length <= 1 || arguments[1] === undefined ? {} : arguments[1];
        var _ref2$clientOffset = _ref2.clientOffset;
        var clientOffset = _ref2$clientOffset === undefined ? null : _ref2$clientOffset;
        _invariant2['default'](_lodashIsArray2['default'](targetIds), 'Expected targetIds to be an array.');
        targetIds = targetIds.slice(0);
        var monitor = this.getMonitor();
        var registry = this.getRegistry();
        _invariant2['default'](monitor.isDragging(), 'Cannot call hover while not dragging.');
        _invariant2['default'](!monitor.didDrop(), 'Cannot call hover after drop.');
        var draggedItemType = monitor.getItemType();
        for (var i = 0; i < targetIds.length; i++) {
          var targetId = targetIds[i];
          _invariant2['default'](targetIds.lastIndexOf(targetId) === i, 'Expected targetIds to be unique in the passed array.');
          var target = registry.getTarget(targetId);
          _invariant2['default'](target, 'Expected targetIds to be registered.');
          var targetType = registry.getTargetType(targetId);
          if (_utilsMatchesType2['default'](targetType, draggedItemType)) {
            target.hover(monitor, targetId);
          }
        }
        return {
          type: HOVER,
          targetIds: targetIds,
          clientOffset: clientOffset
        };
      }
      function drop() {
        var _this = this;
        var monitor = this.getMonitor();
        var registry = this.getRegistry();
        _invariant2['default'](monitor.isDragging(), 'Cannot call drop while not dragging.');
        _invariant2['default'](!monitor.didDrop(), 'Cannot call drop twice during one drag operation.');
        var targetIds = monitor.getTargetIds().filter(monitor.canDropOnTarget, monitor);
        targetIds.reverse();
        targetIds.forEach(function(targetId, index) {
          var target = registry.getTarget(targetId);
          var dropResult = target.drop(monitor, targetId);
          _invariant2['default'](typeof dropResult === 'undefined' || _lodashIsObject2['default'](dropResult), 'Drop result must either be an object or undefined.');
          if (typeof dropResult === 'undefined') {
            dropResult = index === 0 ? {} : monitor.getDropResult();
          }
          _this.store.dispatch({
            type: DROP,
            dropResult: dropResult
          });
        });
      }
      function endDrag() {
        var monitor = this.getMonitor();
        var registry = this.getRegistry();
        _invariant2['default'](monitor.isDragging(), 'Cannot call endDrag while not dragging.');
        var sourceId = monitor.getSourceId();
        var source = registry.getSource(sourceId, true);
        source.endDrag(monitor, sourceId);
        registry.unpinSource();
        return {type: END_DRAG};
      }
    }, function(module, exports) {
      'use strict';
      exports.__esModule = true;
      exports.addSource = addSource;
      exports.addTarget = addTarget;
      exports.removeSource = removeSource;
      exports.removeTarget = removeTarget;
      var ADD_SOURCE = 'dnd-core/ADD_SOURCE';
      exports.ADD_SOURCE = ADD_SOURCE;
      var ADD_TARGET = 'dnd-core/ADD_TARGET';
      exports.ADD_TARGET = ADD_TARGET;
      var REMOVE_SOURCE = 'dnd-core/REMOVE_SOURCE';
      exports.REMOVE_SOURCE = REMOVE_SOURCE;
      var REMOVE_TARGET = 'dnd-core/REMOVE_TARGET';
      exports.REMOVE_TARGET = REMOVE_TARGET;
      function addSource(sourceId) {
        return {
          type: ADD_SOURCE,
          sourceId: sourceId
        };
      }
      function addTarget(targetId) {
        return {
          type: ADD_TARGET,
          targetId: targetId
        };
      }
      function removeSource(sourceId) {
        return {
          type: REMOVE_SOURCE,
          sourceId: sourceId
        };
      }
      function removeTarget(targetId) {
        return {
          type: REMOVE_TARGET,
          targetId: targetId
        };
      }
    }, function(module, exports, __webpack_require__) {
      var eq = __webpack_require__(101);
      function assocIndexOf(array, key) {
        var length = array.length;
        while (length--) {
          if (eq(array[length][0], key)) {
            return length;
          }
        }
        return -1;
      }
      module.exports = assocIndexOf;
    }, function(module, exports, __webpack_require__) {
      var getNative = __webpack_require__(20);
      var nativeCreate = getNative(Object, 'create');
      module.exports = nativeCreate;
    }, function(module, exports) {
      function isObjectLike(value) {
        return !!value && typeof value == 'object';
      }
      module.exports = isObjectLike;
    }, function(module, exports) {
      "use strict";
      exports.__esModule = true;
      exports["default"] = shallowEqual;
      function shallowEqual(objA, objB) {
        if (objA === objB) {
          return true;
        }
        var keysA = Object.keys(objA);
        var keysB = Object.keys(objB);
        if (keysA.length !== keysB.length) {
          return false;
        }
        var hasOwn = Object.prototype.hasOwnProperty;
        for (var i = 0; i < keysA.length; i++) {
          if (!hasOwn.call(objB, keysA[i]) || objA[keysA[i]] !== objB[keysA[i]]) {
            return false;
          }
          var valA = objA[keysA[i]];
          var valB = objB[keysA[i]];
          if (valA !== valB) {
            return false;
          }
        }
        return true;
      }
      module.exports = exports["default"];
    }, function(module, exports) {
      'use strict';
      exports.__esModule = true;
      exports['default'] = isDisposable;
      function isDisposable(obj) {
        return Boolean(obj && typeof obj.dispose === 'function');
      }
      module.exports = exports['default'];
    }, function(module, exports, __webpack_require__) {
      var MapCache = __webpack_require__(71),
          cachePush = __webpack_require__(86);
      function SetCache(values) {
        var index = -1,
            length = values ? values.length : 0;
        this.__data__ = new MapCache;
        while (++index < length) {
          this.push(values[index]);
        }
      }
      SetCache.prototype.push = cachePush;
      module.exports = SetCache;
    }, function(module, exports, __webpack_require__) {
      var baseIndexOf = __webpack_require__(81);
      function arrayIncludes(array, value) {
        return !!array.length && baseIndexOf(array, value, 0) > -1;
      }
      module.exports = arrayIncludes;
    }, function(module, exports) {
      function arrayIncludesWith(array, value, comparator) {
        var index = -1,
            length = array.length;
        while (++index < length) {
          if (comparator(value, array[index])) {
            return true;
          }
        }
        return false;
      }
      module.exports = arrayIncludesWith;
    }, function(module, exports) {
      function arrayMap(array, iteratee) {
        var index = -1,
            length = array.length,
            result = Array(length);
        while (++index < length) {
          result[index] = iteratee(array[index], index, array);
        }
        return result;
      }
      module.exports = arrayMap;
    }, function(module, exports, __webpack_require__) {
      var isKeyable = __webpack_require__(3);
      var HASH_UNDEFINED = '__lodash_hash_undefined__';
      function cacheHas(cache, value) {
        var map = cache.__data__;
        if (isKeyable(value)) {
          var data = map.__data__,
              hash = typeof value == 'string' ? data.string : data.hash;
          return hash[value] === HASH_UNDEFINED;
        }
        return map.has(value);
      }
      module.exports = cacheHas;
    }, function(module, exports, __webpack_require__) {
      var isNative = __webpack_require__(105);
      function getNative(object, key) {
        var value = object[key];
        return isNative(value) ? value : undefined;
      }
      module.exports = getNative;
    }, function(module, exports, __webpack_require__) {
      var isArrayLike = __webpack_require__(103),
          isObjectLike = __webpack_require__(12);
      function isArrayLikeObject(value) {
        return isObjectLike(value) && isArrayLike(value);
      }
      module.exports = isArrayLikeObject;
    }, function(module, exports, __webpack_require__) {
      var isObject = __webpack_require__(23);
      var funcTag = '[object Function]',
          genTag = '[object GeneratorFunction]';
      var objectProto = Object.prototype;
      var objectToString = objectProto.toString;
      function isFunction(value) {
        var tag = isObject(value) ? objectToString.call(value) : '';
        return tag == funcTag || tag == genTag;
      }
      module.exports = isFunction;
    }, function(module, exports) {
      function isObject(value) {
        var type = typeof value;
        return !!value && (type == 'object' || type == 'function');
      }
      module.exports = isObject;
    }, function(module, exports, __webpack_require__) {
      var apply = __webpack_require__(73),
          toInteger = __webpack_require__(107);
      var FUNC_ERROR_TEXT = 'Expected a function';
      var nativeMax = Math.max;
      function rest(func, start) {
        if (typeof func != 'function') {
          throw new TypeError(FUNC_ERROR_TEXT);
        }
        start = nativeMax(start === undefined ? (func.length - 1) : toInteger(start), 0);
        return function() {
          var args = arguments,
              index = -1,
              length = nativeMax(args.length - start, 0),
              array = Array(length);
          while (++index < length) {
            array[index] = args[start + index];
          }
          switch (start) {
            case 0:
              return func.call(this, array);
            case 1:
              return func.call(this, args[0], array);
            case 2:
              return func.call(this, args[0], args[1], array);
          }
          var otherArgs = Array(start + 1);
          index = -1;
          while (++index < start) {
            otherArgs[index] = args[index];
          }
          otherArgs[start] = array;
          return apply(func, this, otherArgs);
        };
      }
      module.exports = rest;
    }, function(module, exports, __webpack_require__) {
      'use strict';
      exports.__esModule = true;
      exports['default'] = areOptionsEqual;
      function _interopRequireDefault(obj) {
        return obj && obj.__esModule ? obj : {'default': obj};
      }
      var _utilsShallowEqual = __webpack_require__(13);
      var _utilsShallowEqual2 = _interopRequireDefault(_utilsShallowEqual);
      function areOptionsEqual(nextOptions, currentOptions) {
        if (currentOptions === nextOptions) {
          return true;
        }
        return currentOptions !== null && nextOptions !== null && _utilsShallowEqual2['default'](currentOptions, nextOptions);
      }
      module.exports = exports['default'];
    }, function(module, exports, __webpack_require__) {
      'use strict';
      exports.__esModule = true;
      var _extends = Object.assign || function(target) {
        for (var i = 1; i < arguments.length; i++) {
          var source = arguments[i];
          for (var key in source) {
            if (Object.prototype.hasOwnProperty.call(source, key)) {
              target[key] = source[key];
            }
          }
        }
        return target;
      };
      var _createClass = (function() {
        function defineProperties(target, props) {
          for (var i = 0; i < props.length; i++) {
            var descriptor = props[i];
            descriptor.enumerable = descriptor.enumerable || false;
            descriptor.configurable = true;
            if ('value' in descriptor)
              descriptor.writable = true;
            Object.defineProperty(target, descriptor.key, descriptor);
          }
        }
        return function(Constructor, protoProps, staticProps) {
          if (protoProps)
            defineProperties(Constructor.prototype, protoProps);
          if (staticProps)
            defineProperties(Constructor, staticProps);
          return Constructor;
        };
      })();
      exports['default'] = decorateHandler;
      function _interopRequireDefault(obj) {
        return obj && obj.__esModule ? obj : {'default': obj};
      }
      function _classCallCheck(instance, Constructor) {
        if (!(instance instanceof Constructor)) {
          throw new TypeError('Cannot call a class as a function');
        }
      }
      function _inherits(subClass, superClass) {
        if (typeof superClass !== 'function' && superClass !== null) {
          throw new TypeError('Super expression must either be null or a function, not ' + typeof superClass);
        }
        subClass.prototype = Object.create(superClass && superClass.prototype, {constructor: {
            value: subClass,
            enumerable: false,
            writable: true,
            configurable: true
          }});
        if (superClass)
          Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass;
      }
      var _react = __webpack_require__(6);
      var _react2 = _interopRequireDefault(_react);
      var _disposables = __webpack_require__(58);
      var _utilsShallowEqual = __webpack_require__(13);
      var _utilsShallowEqual2 = _interopRequireDefault(_utilsShallowEqual);
      var _utilsShallowEqualScalar = __webpack_require__(28);
      var _utilsShallowEqualScalar2 = _interopRequireDefault(_utilsShallowEqualScalar);
      var _lodashIsPlainObject = __webpack_require__(2);
      var _lodashIsPlainObject2 = _interopRequireDefault(_lodashIsPlainObject);
      var _invariant = __webpack_require__(1);
      var _invariant2 = _interopRequireDefault(_invariant);
      function decorateHandler(_ref) {
        var DecoratedComponent = _ref.DecoratedComponent;
        var createHandler = _ref.createHandler;
        var createMonitor = _ref.createMonitor;
        var createConnector = _ref.createConnector;
        var registerHandler = _ref.registerHandler;
        var containerDisplayName = _ref.containerDisplayName;
        var getType = _ref.getType;
        var collect = _ref.collect;
        var options = _ref.options;
        var _options$arePropsEqual = options.arePropsEqual;
        var arePropsEqual = _options$arePropsEqual === undefined ? _utilsShallowEqualScalar2['default'] : _options$arePropsEqual;
        var displayName = DecoratedComponent.displayName || DecoratedComponent.name || 'Component';
        return (function(_Component) {
          _inherits(DragDropContainer, _Component);
          DragDropContainer.prototype.getHandlerId = function getHandlerId() {
            return this.handlerId;
          };
          DragDropContainer.prototype.getDecoratedComponentInstance = function getDecoratedComponentInstance() {
            return this.decoratedComponentInstance;
          };
          DragDropContainer.prototype.shouldComponentUpdate = function shouldComponentUpdate(nextProps, nextState) {
            return !arePropsEqual(nextProps, this.props) || !_utilsShallowEqual2['default'](nextState, this.state);
          };
          _createClass(DragDropContainer, null, [{
            key: 'DecoratedComponent',
            value: DecoratedComponent,
            enumerable: true
          }, {
            key: 'displayName',
            value: containerDisplayName + '(' + displayName + ')',
            enumerable: true
          }, {
            key: 'contextTypes',
            value: {dragDropManager: _react.PropTypes.object.isRequired},
            enumerable: true
          }]);
          function DragDropContainer(props, context) {
            _classCallCheck(this, DragDropContainer);
            _Component.call(this, props, context);
            this.handleChange = this.handleChange.bind(this);
            this.handleChildRef = this.handleChildRef.bind(this);
            _invariant2['default'](typeof this.context.dragDropManager === 'object', 'Could not find the drag and drop manager in the context of %s. ' + 'Make sure to wrap the top-level component of your app with DragDropContext. ' + 'Read more: http://gaearon.github.io/react-dnd/docs-troubleshooting.html#could-not-find-the-drag-and-drop-manager-in-the-context', displayName, displayName);
            this.manager = this.context.dragDropManager;
            this.handlerMonitor = createMonitor(this.manager);
            this.handlerConnector = createConnector(this.manager.getBackend());
            this.handler = createHandler(this.handlerMonitor);
            this.disposable = new _disposables.SerialDisposable();
            this.receiveProps(props);
            this.state = this.getCurrentState();
            this.dispose();
          }
          DragDropContainer.prototype.componentDidMount = function componentDidMount() {
            this.isCurrentlyMounted = true;
            this.disposable = new _disposables.SerialDisposable();
            this.currentType = null;
            this.receiveProps(this.props);
            this.handleChange();
          };
          DragDropContainer.prototype.componentWillReceiveProps = function componentWillReceiveProps(nextProps) {
            if (!arePropsEqual(nextProps, this.props)) {
              this.receiveProps(nextProps);
              this.handleChange();
            }
          };
          DragDropContainer.prototype.componentWillUnmount = function componentWillUnmount() {
            this.dispose();
            this.isCurrentlyMounted = false;
          };
          DragDropContainer.prototype.receiveProps = function receiveProps(props) {
            this.handler.receiveProps(props);
            this.receiveType(getType(props));
          };
          DragDropContainer.prototype.receiveType = function receiveType(type) {
            if (type === this.currentType) {
              return;
            }
            this.currentType = type;
            var _registerHandler = registerHandler(type, this.handler, this.manager);
            var handlerId = _registerHandler.handlerId;
            var unregister = _registerHandler.unregister;
            this.handlerId = handlerId;
            this.handlerMonitor.receiveHandlerId(handlerId);
            this.handlerConnector.receiveHandlerId(handlerId);
            var globalMonitor = this.manager.getMonitor();
            var unsubscribe = globalMonitor.subscribeToStateChange(this.handleChange, {handlerIds: [handlerId]});
            this.disposable.setDisposable(new _disposables.CompositeDisposable(new _disposables.Disposable(unsubscribe), new _disposables.Disposable(unregister)));
          };
          DragDropContainer.prototype.handleChange = function handleChange() {
            if (!this.isCurrentlyMounted) {
              return;
            }
            var nextState = this.getCurrentState();
            if (!_utilsShallowEqual2['default'](nextState, this.state)) {
              this.setState(nextState);
            }
          };
          DragDropContainer.prototype.dispose = function dispose() {
            this.disposable.dispose();
            this.handlerConnector.receiveHandlerId(null);
          };
          DragDropContainer.prototype.handleChildRef = function handleChildRef(component) {
            this.decoratedComponentInstance = component;
            this.handler.receiveComponent(component);
          };
          DragDropContainer.prototype.getCurrentState = function getCurrentState() {
            var nextState = collect(this.handlerConnector.hooks, this.handlerMonitor);
            if (false) {
              _invariant2['default'](_lodashIsPlainObject2['default'](nextState), 'Expected `collect` specified as the second argument to ' + '%s for %s to return a plain object of props to inject. ' + 'Instead, received %s.', containerDisplayName, displayName, nextState);
            }
            return nextState;
          };
          DragDropContainer.prototype.render = function render() {
            return _react2['default'].createElement(DecoratedComponent, _extends({}, this.props, this.state, {ref: this.handleChildRef}));
          };
          return DragDropContainer;
        })(_react.Component);
      }
      module.exports = exports['default'];
    }, function(module, exports, __webpack_require__) {
      'use strict';
      exports.__esModule = true;
      exports['default'] = isValidType;
      function _interopRequireDefault(obj) {
        return obj && obj.__esModule ? obj : {'default': obj};
      }
      var _lodashIsArray = __webpack_require__(5);
      var _lodashIsArray2 = _interopRequireDefault(_lodashIsArray);
      function isValidType(type, allowArray) {
        return typeof type === 'string' || typeof type === 'symbol' || allowArray && _lodashIsArray2['default'](type) && type.every(function(t) {
          return isValidType(t, false);
        });
      }
      module.exports = exports['default'];
    }, function(module, exports) {
      'use strict';
      exports.__esModule = true;
      exports['default'] = shallowEqualScalar;
      function shallowEqualScalar(objA, objB) {
        if (objA === objB) {
          return true;
        }
        if (typeof objA !== 'object' || objA === null || typeof objB !== 'object' || objB === null) {
          return false;
        }
        var keysA = Object.keys(objA);
        var keysB = Object.keys(objB);
        if (keysA.length !== keysB.length) {
          return false;
        }
        var hasOwn = Object.prototype.hasOwnProperty;
        for (var i = 0; i < keysA.length; i++) {
          if (!hasOwn.call(objB, keysA[i])) {
            return false;
          }
          var valA = objA[keysA[i]];
          var valB = objB[keysA[i]];
          if (valA !== valB || typeof valA === 'object' || typeof valB === 'object') {
            return false;
          }
        }
        return true;
      }
      module.exports = exports['default'];
    }, function(module, exports, __webpack_require__) {
      'use strict';
      exports.__esModule = true;
      exports['default'] = wrapConnectorHooks;
      function _interopRequireDefault(obj) {
        return obj && obj.__esModule ? obj : {'default': obj};
      }
      var _utilsCloneWithRef = __webpack_require__(54);
      var _utilsCloneWithRef2 = _interopRequireDefault(_utilsCloneWithRef);
      var _react = __webpack_require__(6);
      function throwIfCompositeComponentElement(element) {
        if (typeof element.type === 'string') {
          return;
        }
        var displayName = element.type.displayName || element.type.name || 'the component';
        throw new Error('Only native element nodes can now be passed to React DnD connectors. ' + ('You can either wrap ' + displayName + ' into a <div>, or turn it into a ') + 'drag source or a drop target itself.');
      }
      function wrapHookToRecognizeElement(hook) {
        return function() {
          var elementOrNode = arguments.length <= 0 || arguments[0] === undefined ? null : arguments[0];
          var options = arguments.length <= 1 || arguments[1] === undefined ? null : arguments[1];
          if (!_react.isValidElement(elementOrNode)) {
            var node = elementOrNode;
            hook(node, options);
            return;
          }
          var element = elementOrNode;
          throwIfCompositeComponentElement(element);
          var ref = options ? function(node) {
            return hook(node, options);
          } : hook;
          return _utilsCloneWithRef2['default'](element, ref);
        };
      }
      function wrapConnectorHooks(hooks) {
        var wrappedHooks = {};
        Object.keys(hooks).forEach(function(key) {
          var hook = hooks[key];
          var wrappedHook = wrapHookToRecognizeElement(hook);
          wrappedHooks[key] = function() {
            return wrappedHook;
          };
        });
        return wrappedHooks;
      }
      module.exports = exports['default'];
    }, function(module, exports, __webpack_require__) {
      'use strict';
      exports.__esModule = true;
      function _interopRequireDefault(obj) {
        return obj && obj.__esModule ? obj : {'default': obj};
      }
      function _classCallCheck(instance, Constructor) {
        if (!(instance instanceof Constructor)) {
          throw new TypeError('Cannot call a class as a function');
        }
      }
      function _typeof(obj) {
        return obj && obj.constructor === Symbol ? 'symbol' : typeof obj;
      }
      var _invariant = __webpack_require__(1);
      var _invariant2 = _interopRequireDefault(_invariant);
      var _lodashIsArray = __webpack_require__(5);
      var _lodashIsArray2 = _interopRequireDefault(_lodashIsArray);
      var _utilsGetNextUniqueId = __webpack_require__(69);
      var _utilsGetNextUniqueId2 = _interopRequireDefault(_utilsGetNextUniqueId);
      var _actionsRegistry = __webpack_require__(9);
      var _asap = __webpack_require__(40);
      var _asap2 = _interopRequireDefault(_asap);
      var HandlerRoles = {
        SOURCE: 'SOURCE',
        TARGET: 'TARGET'
      };
      function validateSourceContract(source) {
        _invariant2['default'](typeof source.canDrag === 'function', 'Expected canDrag to be a function.');
        _invariant2['default'](typeof source.beginDrag === 'function', 'Expected beginDrag to be a function.');
        _invariant2['default'](typeof source.endDrag === 'function', 'Expected endDrag to be a function.');
      }
      function validateTargetContract(target) {
        _invariant2['default'](typeof target.canDrop === 'function', 'Expected canDrop to be a function.');
        _invariant2['default'](typeof target.hover === 'function', 'Expected hover to be a function.');
        _invariant2['default'](typeof target.drop === 'function', 'Expected beginDrag to be a function.');
      }
      function validateType(type, allowArray) {
        if (allowArray && _lodashIsArray2['default'](type)) {
          type.forEach(function(t) {
            return validateType(t, false);
          });
          return;
        }
        _invariant2['default'](typeof type === 'string' || (typeof type === 'undefined' ? 'undefined' : _typeof(type)) === 'symbol', allowArray ? 'Type can only be a string, a symbol, or an array of either.' : 'Type can only be a string or a symbol.');
      }
      function getNextHandlerId(role) {
        var id = _utilsGetNextUniqueId2['default']().toString();
        switch (role) {
          case HandlerRoles.SOURCE:
            return 'S' + id;
          case HandlerRoles.TARGET:
            return 'T' + id;
          default:
            _invariant2['default'](false, 'Unknown role: ' + role);
        }
      }
      function parseRoleFromHandlerId(handlerId) {
        switch (handlerId[0]) {
          case 'S':
            return HandlerRoles.SOURCE;
          case 'T':
            return HandlerRoles.TARGET;
          default:
            _invariant2['default'](false, 'Cannot parse handler ID: ' + handlerId);
        }
      }
      var HandlerRegistry = (function() {
        function HandlerRegistry(store) {
          _classCallCheck(this, HandlerRegistry);
          this.store = store;
          this.types = {};
          this.handlers = {};
          this.pinnedSourceId = null;
          this.pinnedSource = null;
        }
        HandlerRegistry.prototype.addSource = function addSource(type, source) {
          validateType(type);
          validateSourceContract(source);
          var sourceId = this.addHandler(HandlerRoles.SOURCE, type, source);
          this.store.dispatch(_actionsRegistry.addSource(sourceId));
          return sourceId;
        };
        HandlerRegistry.prototype.addTarget = function addTarget(type, target) {
          validateType(type, true);
          validateTargetContract(target);
          var targetId = this.addHandler(HandlerRoles.TARGET, type, target);
          this.store.dispatch(_actionsRegistry.addTarget(targetId));
          return targetId;
        };
        HandlerRegistry.prototype.addHandler = function addHandler(role, type, handler) {
          var id = getNextHandlerId(role);
          this.types[id] = type;
          this.handlers[id] = handler;
          return id;
        };
        HandlerRegistry.prototype.containsHandler = function containsHandler(handler) {
          var _this = this;
          return Object.keys(this.handlers).some(function(key) {
            return _this.handlers[key] === handler;
          });
        };
        HandlerRegistry.prototype.getSource = function getSource(sourceId, includePinned) {
          _invariant2['default'](this.isSourceId(sourceId), 'Expected a valid source ID.');
          var isPinned = includePinned && sourceId === this.pinnedSourceId;
          var source = isPinned ? this.pinnedSource : this.handlers[sourceId];
          return source;
        };
        HandlerRegistry.prototype.getTarget = function getTarget(targetId) {
          _invariant2['default'](this.isTargetId(targetId), 'Expected a valid target ID.');
          return this.handlers[targetId];
        };
        HandlerRegistry.prototype.getSourceType = function getSourceType(sourceId) {
          _invariant2['default'](this.isSourceId(sourceId), 'Expected a valid source ID.');
          return this.types[sourceId];
        };
        HandlerRegistry.prototype.getTargetType = function getTargetType(targetId) {
          _invariant2['default'](this.isTargetId(targetId), 'Expected a valid target ID.');
          return this.types[targetId];
        };
        HandlerRegistry.prototype.isSourceId = function isSourceId(handlerId) {
          var role = parseRoleFromHandlerId(handlerId);
          return role === HandlerRoles.SOURCE;
        };
        HandlerRegistry.prototype.isTargetId = function isTargetId(handlerId) {
          var role = parseRoleFromHandlerId(handlerId);
          return role === HandlerRoles.TARGET;
        };
        HandlerRegistry.prototype.removeSource = function removeSource(sourceId) {
          var _this2 = this;
          _invariant2['default'](this.getSource(sourceId), 'Expected an existing source.');
          this.store.dispatch(_actionsRegistry.removeSource(sourceId));
          _asap2['default'](function() {
            delete _this2.handlers[sourceId];
            delete _this2.types[sourceId];
          });
        };
        HandlerRegistry.prototype.removeTarget = function removeTarget(targetId) {
          var _this3 = this;
          _invariant2['default'](this.getTarget(targetId), 'Expected an existing target.');
          this.store.dispatch(_actionsRegistry.removeTarget(targetId));
          _asap2['default'](function() {
            delete _this3.handlers[targetId];
            delete _this3.types[targetId];
          });
        };
        HandlerRegistry.prototype.pinSource = function pinSource(sourceId) {
          var source = this.getSource(sourceId);
          _invariant2['default'](source, 'Expected an existing source.');
          this.pinnedSourceId = sourceId;
          this.pinnedSource = source;
        };
        HandlerRegistry.prototype.unpinSource = function unpinSource() {
          _invariant2['default'](this.pinnedSource, 'No source is pinned at the time.');
          this.pinnedSourceId = null;
          this.pinnedSource = null;
        };
        return HandlerRegistry;
      })();
      exports['default'] = HandlerRegistry;
      module.exports = exports['default'];
    }, function(module, exports, __webpack_require__) {
      'use strict';
      exports.__esModule = true;
      exports['default'] = dirtyHandlerIds;
      exports.areDirty = areDirty;
      function _interopRequireDefault(obj) {
        return obj && obj.__esModule ? obj : {'default': obj};
      }
      var _lodashXor = __webpack_require__(110);
      var _lodashXor2 = _interopRequireDefault(_lodashXor);
      var _lodashIntersection = __webpack_require__(102);
      var _lodashIntersection2 = _interopRequireDefault(_lodashIntersection);
      var _actionsDragDrop = __webpack_require__(8);
      var _actionsRegistry = __webpack_require__(9);
      var NONE = [];
      var ALL = [];
      function dirtyHandlerIds(state, action, dragOperation) {
        if (state === undefined)
          state = NONE;
        switch (action.type) {
          case _actionsDragDrop.HOVER:
            break;
          case _actionsRegistry.ADD_SOURCE:
          case _actionsRegistry.ADD_TARGET:
          case _actionsRegistry.REMOVE_TARGET:
          case _actionsRegistry.REMOVE_SOURCE:
            return NONE;
          case _actionsDragDrop.BEGIN_DRAG:
          case _actionsDragDrop.PUBLISH_DRAG_SOURCE:
          case _actionsDragDrop.END_DRAG:
          case _actionsDragDrop.DROP:
          default:
            return ALL;
        }
        var targetIds = action.targetIds;
        var prevTargetIds = dragOperation.targetIds;
        var dirtyHandlerIds = _lodashXor2['default'](targetIds, prevTargetIds);
        var didChange = false;
        if (dirtyHandlerIds.length === 0) {
          for (var i = 0; i < targetIds.length; i++) {
            if (targetIds[i] !== prevTargetIds[i]) {
              didChange = true;
              break;
            }
          }
        } else {
          didChange = true;
        }
        if (!didChange) {
          return NONE;
        }
        var prevInnermostTargetId = prevTargetIds[prevTargetIds.length - 1];
        var innermostTargetId = targetIds[targetIds.length - 1];
        if (prevInnermostTargetId !== innermostTargetId) {
          if (prevInnermostTargetId) {
            dirtyHandlerIds.push(prevInnermostTargetId);
          }
          if (innermostTargetId) {
            dirtyHandlerIds.push(innermostTargetId);
          }
        }
        return dirtyHandlerIds;
      }
      function areDirty(state, handlerIds) {
        if (state === NONE) {
          return false;
        }
        if (state === ALL || typeof handlerIds === 'undefined') {
          return true;
        }
        return _lodashIntersection2['default'](handlerIds, state).length > 0;
      }
    }, function(module, exports, __webpack_require__) {
      'use strict';
      exports.__esModule = true;
      var _extends = Object.assign || function(target) {
        for (var i = 1; i < arguments.length; i++) {
          var source = arguments[i];
          for (var key in source) {
            if (Object.prototype.hasOwnProperty.call(source, key)) {
              target[key] = source[key];
            }
          }
        }
        return target;
      };
      exports['default'] = dragOffset;
      exports.getSourceClientOffset = getSourceClientOffset;
      exports.getDifferenceFromInitialOffset = getDifferenceFromInitialOffset;
      var _actionsDragDrop = __webpack_require__(8);
      var initialState = {
        initialSourceClientOffset: null,
        initialClientOffset: null,
        clientOffset: null
      };
      function areOffsetsEqual(offsetA, offsetB) {
        if (offsetA === offsetB) {
          return true;
        }
        return offsetA && offsetB && offsetA.x === offsetB.x && offsetA.y === offsetB.y;
      }
      function dragOffset(state, action) {
        if (state === undefined)
          state = initialState;
        switch (action.type) {
          case _actionsDragDrop.BEGIN_DRAG:
            return {
              initialSourceClientOffset: action.sourceClientOffset,
              initialClientOffset: action.clientOffset,
              clientOffset: action.clientOffset
            };
          case _actionsDragDrop.HOVER:
            if (areOffsetsEqual(state.clientOffset, action.clientOffset)) {
              return state;
            }
            return _extends({}, state, {clientOffset: action.clientOffset});
          case _actionsDragDrop.END_DRAG:
          case _actionsDragDrop.DROP:
            return initialState;
          default:
            return state;
        }
      }
      function getSourceClientOffset(state) {
        var clientOffset = state.clientOffset;
        var initialClientOffset = state.initialClientOffset;
        var initialSourceClientOffset = state.initialSourceClientOffset;
        if (!clientOffset || !initialClientOffset || !initialSourceClientOffset) {
          return null;
        }
        return {
          x: clientOffset.x + initialSourceClientOffset.x - initialClientOffset.x,
          y: clientOffset.y + initialSourceClientOffset.y - initialClientOffset.y
        };
      }
      function getDifferenceFromInitialOffset(state) {
        var clientOffset = state.clientOffset;
        var initialClientOffset = state.initialClientOffset;
        if (!clientOffset || !initialClientOffset) {
          return null;
        }
        return {
          x: clientOffset.x - initialClientOffset.x,
          y: clientOffset.y - initialClientOffset.y
        };
      }
    }, function(module, exports, __webpack_require__) {
      'use strict';
      exports.__esModule = true;
      exports['default'] = matchesType;
      function _interopRequireDefault(obj) {
        return obj && obj.__esModule ? obj : {'default': obj};
      }
      var _lodashIsArray = __webpack_require__(5);
      var _lodashIsArray2 = _interopRequireDefault(_lodashIsArray);
      function matchesType(targetType, draggedItemType) {
        if (_lodashIsArray2['default'](targetType)) {
          return targetType.some(function(t) {
            return t === draggedItemType;
          });
        } else {
          return targetType === draggedItemType;
        }
      }
      module.exports = exports['default'];
    }, function(module, exports, __webpack_require__) {
      var SetCache = __webpack_require__(15),
          arrayIncludes = __webpack_require__(16),
          arrayIncludesWith = __webpack_require__(17),
          arrayMap = __webpack_require__(18),
          baseUnary = __webpack_require__(35),
          cacheHas = __webpack_require__(19);
      var LARGE_ARRAY_SIZE = 200;
      function baseDifference(array, values, iteratee, comparator) {
        var index = -1,
            includes = arrayIncludes,
            isCommon = true,
            length = array.length,
            result = [],
            valuesLength = values.length;
        if (!length) {
          return result;
        }
        if (iteratee) {
          values = arrayMap(values, baseUnary(iteratee));
        }
        if (comparator) {
          includes = arrayIncludesWith;
          isCommon = false;
        } else if (values.length >= LARGE_ARRAY_SIZE) {
          includes = cacheHas;
          isCommon = false;
          values = new SetCache(values);
        }
        outer: while (++index < length) {
          var value = array[index],
              computed = iteratee ? iteratee(value) : value;
          if (isCommon && computed === computed) {
            var valuesIndex = valuesLength;
            while (valuesIndex--) {
              if (values[valuesIndex] === computed) {
                continue outer;
              }
            }
            result.push(value);
          } else if (!includes(values, computed, comparator)) {
            result.push(value);
          }
        }
        return result;
      }
      module.exports = baseDifference;
    }, function(module, exports) {
      function baseUnary(func) {
        return function(value) {
          return func(value);
        };
      }
      module.exports = baseUnary;
    }, function(module, exports, __webpack_require__) {
      var nativeCreate = __webpack_require__(11);
      var objectProto = Object.prototype;
      var hasOwnProperty = objectProto.hasOwnProperty;
      function hashHas(hash, key) {
        return nativeCreate ? hash[key] !== undefined : hasOwnProperty.call(hash, key);
      }
      module.exports = hashHas;
    }, function(module, exports) {
      function isHostObject(value) {
        var result = false;
        if (value != null && typeof value.toString != 'function') {
          try {
            result = !!(value + '');
          } catch (e) {}
        }
        return result;
      }
      module.exports = isHostObject;
    }, function(module, exports, __webpack_require__) {
      (function(module, global) {
        var checkGlobal = __webpack_require__(87);
        var objectTypes = {
          'function': true,
          'object': true
        };
        var freeExports = (objectTypes[typeof exports] && exports && !exports.nodeType) ? exports : undefined;
        var freeModule = (objectTypes[typeof module] && module && !module.nodeType) ? module : undefined;
        var freeGlobal = checkGlobal(freeExports && freeModule && typeof global == 'object' && global);
        var freeSelf = checkGlobal(objectTypes[typeof self] && self);
        var freeWindow = checkGlobal(objectTypes[typeof window] && window);
        var thisGlobal = checkGlobal(objectTypes[typeof this] && this);
        var root = freeGlobal || ((freeWindow !== (thisGlobal && thisGlobal.window)) && freeWindow) || freeSelf || thisGlobal || Function('return this')();
        module.exports = root;
      }.call(exports, __webpack_require__(112)(module), (function() {
        return this;
      }())));
    }, function(module, exports) {
      function noop() {}
      module.exports = noop;
    }, function(module, exports, __webpack_require__) {
      "use strict";
      var rawAsap = __webpack_require__(41);
      var freeTasks = [];
      var pendingErrors = [];
      var requestErrorThrow = rawAsap.makeRequestCallFromTimer(throwFirstError);
      function throwFirstError() {
        if (pendingErrors.length) {
          throw pendingErrors.shift();
        }
      }
      module.exports = asap;
      function asap(task) {
        var rawTask;
        if (freeTasks.length) {
          rawTask = freeTasks.pop();
        } else {
          rawTask = new RawTask();
        }
        rawTask.task = task;
        rawAsap(rawTask);
      }
      function RawTask() {
        this.task = null;
      }
      RawTask.prototype.call = function() {
        try {
          this.task.call();
        } catch (error) {
          if (asap.onerror) {
            asap.onerror(error);
          } else {
            pendingErrors.push(error);
            requestErrorThrow();
          }
        } finally {
          this.task = null;
          freeTasks[freeTasks.length] = this;
        }
      };
    }, function(module, exports) {
      (function(global) {
        "use strict";
        module.exports = rawAsap;
        function rawAsap(task) {
          if (!queue.length) {
            requestFlush();
            flushing = true;
          }
          queue[queue.length] = task;
        }
        var queue = [];
        var flushing = false;
        var requestFlush;
        var index = 0;
        var capacity = 1024;
        function flush() {
          while (index < queue.length) {
            var currentIndex = index;
            index = index + 1;
            queue[currentIndex].call();
            if (index > capacity) {
              for (var scan = 0,
                  newLength = queue.length - index; scan < newLength; scan++) {
                queue[scan] = queue[scan + index];
              }
              queue.length -= index;
              index = 0;
            }
          }
          queue.length = 0;
          index = 0;
          flushing = false;
        }
        var BrowserMutationObserver = global.MutationObserver || global.WebKitMutationObserver;
        if (typeof BrowserMutationObserver === "function") {
          requestFlush = makeRequestCallFromMutationObserver(flush);
        } else {
          requestFlush = makeRequestCallFromTimer(flush);
        }
        rawAsap.requestFlush = requestFlush;
        function makeRequestCallFromMutationObserver(callback) {
          var toggle = 1;
          var observer = new BrowserMutationObserver(callback);
          var node = document.createTextNode("");
          observer.observe(node, {characterData: true});
          return function requestCall() {
            toggle = -toggle;
            node.data = toggle;
          };
        }
        function makeRequestCallFromTimer(callback) {
          return function requestCall() {
            var timeoutHandle = setTimeout(handleTimer, 0);
            var intervalHandle = setInterval(handleTimer, 50);
            function handleTimer() {
              clearTimeout(timeoutHandle);
              clearInterval(intervalHandle);
              callback();
            }
          };
        }
        rawAsap.makeRequestCallFromTimer = makeRequestCallFromTimer;
      }.call(exports, (function() {
        return this;
      }())));
    }, function(module, exports, __webpack_require__) {
      'use strict';
      exports.__esModule = true;
      var _extends = Object.assign || function(target) {
        for (var i = 1; i < arguments.length; i++) {
          var source = arguments[i];
          for (var key in source) {
            if (Object.prototype.hasOwnProperty.call(source, key)) {
              target[key] = source[key];
            }
          }
        }
        return target;
      };
      var _slice = Array.prototype.slice;
      var _createClass = (function() {
        function defineProperties(target, props) {
          for (var i = 0; i < props.length; i++) {
            var descriptor = props[i];
            descriptor.enumerable = descriptor.enumerable || false;
            descriptor.configurable = true;
            if ('value' in descriptor)
              descriptor.writable = true;
            Object.defineProperty(target, descriptor.key, descriptor);
          }
        }
        return function(Constructor, protoProps, staticProps) {
          if (protoProps)
            defineProperties(Constructor.prototype, protoProps);
          if (staticProps)
            defineProperties(Constructor, staticProps);
          return Constructor;
        };
      })();
      exports['default'] = DragDropContext;
      function _interopRequireDefault(obj) {
        return obj && obj.__esModule ? obj : {'default': obj};
      }
      function _classCallCheck(instance, Constructor) {
        if (!(instance instanceof Constructor)) {
          throw new TypeError('Cannot call a class as a function');
        }
      }
      function _inherits(subClass, superClass) {
        if (typeof superClass !== 'function' && superClass !== null) {
          throw new TypeError('Super expression must either be null or a function, not ' + typeof superClass);
        }
        subClass.prototype = Object.create(superClass && superClass.prototype, {constructor: {
            value: subClass,
            enumerable: false,
            writable: true,
            configurable: true
          }});
        if (superClass)
          Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass;
      }
      var _react = __webpack_require__(6);
      var _react2 = _interopRequireDefault(_react);
      var _dndCore = __webpack_require__(64);
      var _invariant = __webpack_require__(1);
      var _invariant2 = _interopRequireDefault(_invariant);
      var _utilsCheckDecoratorArguments = __webpack_require__(7);
      var _utilsCheckDecoratorArguments2 = _interopRequireDefault(_utilsCheckDecoratorArguments);
      function DragDropContext(backendOrModule) {
        _utilsCheckDecoratorArguments2['default'].apply(undefined, ['DragDropContext', 'backend'].concat(_slice.call(arguments)));
        var backend = undefined;
        if (typeof backendOrModule === 'object' && typeof backendOrModule['default'] === 'function') {
          backend = backendOrModule['default'];
        } else {
          backend = backendOrModule;
        }
        _invariant2['default'](typeof backend === 'function', 'Expected the backend to be a function or an ES6 module exporting a default function. ' + 'Read more: http://gaearon.github.io/react-dnd/docs-drag-drop-context.html');
        var childContext = {dragDropManager: new _dndCore.DragDropManager(backend)};
        return function decorateContext(DecoratedComponent) {
          var displayName = DecoratedComponent.displayName || DecoratedComponent.name || 'Component';
          return (function(_Component) {
            _inherits(DragDropContextContainer, _Component);
            function DragDropContextContainer() {
              _classCallCheck(this, DragDropContextContainer);
              _Component.apply(this, arguments);
            }
            DragDropContextContainer.prototype.getDecoratedComponentInstance = function getDecoratedComponentInstance() {
              return this.refs.child;
            };
            DragDropContextContainer.prototype.getManager = function getManager() {
              return childContext.dragDropManager;
            };
            DragDropContextContainer.prototype.getChildContext = function getChildContext() {
              return childContext;
            };
            DragDropContextContainer.prototype.render = function render() {
              return _react2['default'].createElement(DecoratedComponent, _extends({}, this.props, {ref: 'child'}));
            };
            _createClass(DragDropContextContainer, null, [{
              key: 'DecoratedComponent',
              value: DecoratedComponent,
              enumerable: true
            }, {
              key: 'displayName',
              value: 'DragDropContext(' + displayName + ')',
              enumerable: true
            }, {
              key: 'childContextTypes',
              value: {dragDropManager: _react.PropTypes.object.isRequired},
              enumerable: true
            }]);
            return DragDropContextContainer;
          })(_react.Component);
        };
      }
      module.exports = exports['default'];
    }, function(module, exports, __webpack_require__) {
      'use strict';
      exports.__esModule = true;
      var _extends = Object.assign || function(target) {
        for (var i = 1; i < arguments.length; i++) {
          var source = arguments[i];
          for (var key in source) {
            if (Object.prototype.hasOwnProperty.call(source, key)) {
              target[key] = source[key];
            }
          }
        }
        return target;
      };
      var _slice = Array.prototype.slice;
      var _createClass = (function() {
        function defineProperties(target, props) {
          for (var i = 0; i < props.length; i++) {
            var descriptor = props[i];
            descriptor.enumerable = descriptor.enumerable || false;
            descriptor.configurable = true;
            if ('value' in descriptor)
              descriptor.writable = true;
            Object.defineProperty(target, descriptor.key, descriptor);
          }
        }
        return function(Constructor, protoProps, staticProps) {
          if (protoProps)
            defineProperties(Constructor.prototype, protoProps);
          if (staticProps)
            defineProperties(Constructor, staticProps);
          return Constructor;
        };
      })();
      exports['default'] = DragLayer;
      function _interopRequireDefault(obj) {
        return obj && obj.__esModule ? obj : {'default': obj};
      }
      function _classCallCheck(instance, Constructor) {
        if (!(instance instanceof Constructor)) {
          throw new TypeError('Cannot call a class as a function');
        }
      }
      function _inherits(subClass, superClass) {
        if (typeof superClass !== 'function' && superClass !== null) {
          throw new TypeError('Super expression must either be null or a function, not ' + typeof superClass);
        }
        subClass.prototype = Object.create(superClass && superClass.prototype, {constructor: {
            value: subClass,
            enumerable: false,
            writable: true,
            configurable: true
          }});
        if (superClass)
          Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass;
      }
      var _react = __webpack_require__(6);
      var _react2 = _interopRequireDefault(_react);
      var _utilsShallowEqual = __webpack_require__(13);
      var _utilsShallowEqual2 = _interopRequireDefault(_utilsShallowEqual);
      var _utilsShallowEqualScalar = __webpack_require__(28);
      var _utilsShallowEqualScalar2 = _interopRequireDefault(_utilsShallowEqualScalar);
      var _lodashIsPlainObject = __webpack_require__(2);
      var _lodashIsPlainObject2 = _interopRequireDefault(_lodashIsPlainObject);
      var _invariant = __webpack_require__(1);
      var _invariant2 = _interopRequireDefault(_invariant);
      var _utilsCheckDecoratorArguments = __webpack_require__(7);
      var _utilsCheckDecoratorArguments2 = _interopRequireDefault(_utilsCheckDecoratorArguments);
      function DragLayer(collect) {
        var options = arguments.length <= 1 || arguments[1] === undefined ? {} : arguments[1];
        _utilsCheckDecoratorArguments2['default'].apply(undefined, ['DragLayer', 'collect[, options]'].concat(_slice.call(arguments)));
        _invariant2['default'](typeof collect === 'function', 'Expected "collect" provided as the first argument to DragLayer ' + 'to be a function that collects props to inject into the component. ', 'Instead, received %s. ' + 'Read more: http://gaearon.github.io/react-dnd/docs-drag-layer.html', collect);
        _invariant2['default'](_lodashIsPlainObject2['default'](options), 'Expected "options" provided as the second argument to DragLayer to be ' + 'a plain object when specified. ' + 'Instead, received %s. ' + 'Read more: http://gaearon.github.io/react-dnd/docs-drag-layer.html', options);
        return function decorateLayer(DecoratedComponent) {
          var _options$arePropsEqual = options.arePropsEqual;
          var arePropsEqual = _options$arePropsEqual === undefined ? _utilsShallowEqualScalar2['default'] : _options$arePropsEqual;
          var displayName = DecoratedComponent.displayName || DecoratedComponent.name || 'Component';
          return (function(_Component) {
            _inherits(DragLayerContainer, _Component);
            DragLayerContainer.prototype.getDecoratedComponentInstance = function getDecoratedComponentInstance() {
              return this.refs.child;
            };
            DragLayerContainer.prototype.shouldComponentUpdate = function shouldComponentUpdate(nextProps, nextState) {
              return !arePropsEqual(nextProps, this.props) || !_utilsShallowEqual2['default'](nextState, this.state);
            };
            _createClass(DragLayerContainer, null, [{
              key: 'DecoratedComponent',
              value: DecoratedComponent,
              enumerable: true
            }, {
              key: 'displayName',
              value: 'DragLayer(' + displayName + ')',
              enumerable: true
            }, {
              key: 'contextTypes',
              value: {dragDropManager: _react.PropTypes.object.isRequired},
              enumerable: true
            }]);
            function DragLayerContainer(props, context) {
              _classCallCheck(this, DragLayerContainer);
              _Component.call(this, props);
              this.handleChange = this.handleChange.bind(this);
              this.manager = context.dragDropManager;
              _invariant2['default'](typeof this.manager === 'object', 'Could not find the drag and drop manager in the context of %s. ' + 'Make sure to wrap the top-level component of your app with DragDropContext. ' + 'Read more: http://gaearon.github.io/react-dnd/docs-troubleshooting.html#could-not-find-the-drag-and-drop-manager-in-the-context', displayName, displayName);
              this.state = this.getCurrentState();
            }
            DragLayerContainer.prototype.componentDidMount = function componentDidMount() {
              this.isCurrentlyMounted = true;
              var monitor = this.manager.getMonitor();
              this.unsubscribeFromOffsetChange = monitor.subscribeToOffsetChange(this.handleChange);
              this.unsubscribeFromStateChange = monitor.subscribeToStateChange(this.handleChange);
              this.handleChange();
            };
            DragLayerContainer.prototype.componentWillUnmount = function componentWillUnmount() {
              this.isCurrentlyMounted = false;
              this.unsubscribeFromOffsetChange();
              this.unsubscribeFromStateChange();
            };
            DragLayerContainer.prototype.handleChange = function handleChange() {
              if (!this.isCurrentlyMounted) {
                return;
              }
              var nextState = this.getCurrentState();
              if (!_utilsShallowEqual2['default'](nextState, this.state)) {
                this.setState(nextState);
              }
            };
            DragLayerContainer.prototype.getCurrentState = function getCurrentState() {
              var monitor = this.manager.getMonitor();
              return collect(monitor);
            };
            DragLayerContainer.prototype.render = function render() {
              return _react2['default'].createElement(DecoratedComponent, _extends({}, this.props, this.state, {ref: 'child'}));
            };
            return DragLayerContainer;
          })(_react.Component);
        };
      }
      module.exports = exports['default'];
    }, function(module, exports, __webpack_require__) {
      'use strict';
      exports.__esModule = true;
      var _slice = Array.prototype.slice;
      exports['default'] = DragSource;
      function _interopRequireDefault(obj) {
        return obj && obj.__esModule ? obj : {'default': obj};
      }
      var _invariant = __webpack_require__(1);
      var _invariant2 = _interopRequireDefault(_invariant);
      var _lodashIsPlainObject = __webpack_require__(2);
      var _lodashIsPlainObject2 = _interopRequireDefault(_lodashIsPlainObject);
      var _utilsCheckDecoratorArguments = __webpack_require__(7);
      var _utilsCheckDecoratorArguments2 = _interopRequireDefault(_utilsCheckDecoratorArguments);
      var _decorateHandler = __webpack_require__(26);
      var _decorateHandler2 = _interopRequireDefault(_decorateHandler);
      var _registerSource = __webpack_require__(52);
      var _registerSource2 = _interopRequireDefault(_registerSource);
      var _createSourceFactory = __webpack_require__(47);
      var _createSourceFactory2 = _interopRequireDefault(_createSourceFactory);
      var _createSourceMonitor = __webpack_require__(48);
      var _createSourceMonitor2 = _interopRequireDefault(_createSourceMonitor);
      var _createSourceConnector = __webpack_require__(46);
      var _createSourceConnector2 = _interopRequireDefault(_createSourceConnector);
      var _utilsIsValidType = __webpack_require__(27);
      var _utilsIsValidType2 = _interopRequireDefault(_utilsIsValidType);
      function DragSource(type, spec, collect) {
        var options = arguments.length <= 3 || arguments[3] === undefined ? {} : arguments[3];
        _utilsCheckDecoratorArguments2['default'].apply(undefined, ['DragSource', 'type, spec, collect[, options]'].concat(_slice.call(arguments)));
        var getType = type;
        if (typeof type !== 'function') {
          _invariant2['default'](_utilsIsValidType2['default'](type), 'Expected "type" provided as the first argument to DragSource to be ' + 'a string, or a function that returns a string given the current props. ' + 'Instead, received %s. ' + 'Read more: http://gaearon.github.io/react-dnd/docs-drag-source.html', type);
          getType = function() {
            return type;
          };
        }
        _invariant2['default'](_lodashIsPlainObject2['default'](spec), 'Expected "spec" provided as the second argument to DragSource to be ' + 'a plain object. Instead, received %s. ' + 'Read more: http://gaearon.github.io/react-dnd/docs-drag-source.html', spec);
        var createSource = _createSourceFactory2['default'](spec);
        _invariant2['default'](typeof collect === 'function', 'Expected "collect" provided as the third argument to DragSource to be ' + 'a function that returns a plain object of props to inject. ' + 'Instead, received %s. ' + 'Read more: http://gaearon.github.io/react-dnd/docs-drag-source.html', collect);
        _invariant2['default'](_lodashIsPlainObject2['default'](options), 'Expected "options" provided as the fourth argument to DragSource to be ' + 'a plain object when specified. ' + 'Instead, received %s. ' + 'Read more: http://gaearon.github.io/react-dnd/docs-drag-source.html', collect);
        return function decorateSource(DecoratedComponent) {
          return _decorateHandler2['default']({
            connectBackend: function connectBackend(backend, sourceId) {
              return backend.connectDragSource(sourceId);
            },
            containerDisplayName: 'DragSource',
            createHandler: createSource,
            registerHandler: _registerSource2['default'],
            createMonitor: _createSourceMonitor2['default'],
            createConnector: _createSourceConnector2['default'],
            DecoratedComponent: DecoratedComponent,
            getType: getType,
            collect: collect,
            options: options
          });
        };
      }
      module.exports = exports['default'];
    }, function(module, exports, __webpack_require__) {
      'use strict';
      exports.__esModule = true;
      var _slice = Array.prototype.slice;
      exports['default'] = DropTarget;
      function _interopRequireDefault(obj) {
        return obj && obj.__esModule ? obj : {'default': obj};
      }
      var _invariant = __webpack_require__(1);
      var _invariant2 = _interopRequireDefault(_invariant);
      var _lodashIsPlainObject = __webpack_require__(2);
      var _lodashIsPlainObject2 = _interopRequireDefault(_lodashIsPlainObject);
      var _utilsCheckDecoratorArguments = __webpack_require__(7);
      var _utilsCheckDecoratorArguments2 = _interopRequireDefault(_utilsCheckDecoratorArguments);
      var _decorateHandler = __webpack_require__(26);
      var _decorateHandler2 = _interopRequireDefault(_decorateHandler);
      var _registerTarget = __webpack_require__(53);
      var _registerTarget2 = _interopRequireDefault(_registerTarget);
      var _createTargetFactory = __webpack_require__(50);
      var _createTargetFactory2 = _interopRequireDefault(_createTargetFactory);
      var _createTargetMonitor = __webpack_require__(51);
      var _createTargetMonitor2 = _interopRequireDefault(_createTargetMonitor);
      var _createTargetConnector = __webpack_require__(49);
      var _createTargetConnector2 = _interopRequireDefault(_createTargetConnector);
      var _utilsIsValidType = __webpack_require__(27);
      var _utilsIsValidType2 = _interopRequireDefault(_utilsIsValidType);
      function DropTarget(type, spec, collect) {
        var options = arguments.length <= 3 || arguments[3] === undefined ? {} : arguments[3];
        _utilsCheckDecoratorArguments2['default'].apply(undefined, ['DropTarget', 'type, spec, collect[, options]'].concat(_slice.call(arguments)));
        var getType = type;
        if (typeof type !== 'function') {
          _invariant2['default'](_utilsIsValidType2['default'](type, true), 'Expected "type" provided as the first argument to DropTarget to be ' + 'a string, an array of strings, or a function that returns either given ' + 'the current props. Instead, received %s. ' + 'Read more: http://gaearon.github.io/react-dnd/docs-drop-target.html', type);
          getType = function() {
            return type;
          };
        }
        _invariant2['default'](_lodashIsPlainObject2['default'](spec), 'Expected "spec" provided as the second argument to DropTarget to be ' + 'a plain object. Instead, received %s. ' + 'Read more: http://gaearon.github.io/react-dnd/docs-drop-target.html', spec);
        var createTarget = _createTargetFactory2['default'](spec);
        _invariant2['default'](typeof collect === 'function', 'Expected "collect" provided as the third argument to DropTarget to be ' + 'a function that returns a plain object of props to inject. ' + 'Instead, received %s. ' + 'Read more: http://gaearon.github.io/react-dnd/docs-drop-target.html', collect);
        _invariant2['default'](_lodashIsPlainObject2['default'](options), 'Expected "options" provided as the fourth argument to DropTarget to be ' + 'a plain object when specified. ' + 'Instead, received %s. ' + 'Read more: http://gaearon.github.io/react-dnd/docs-drop-target.html', collect);
        return function decorateTarget(DecoratedComponent) {
          return _decorateHandler2['default']({
            connectBackend: function connectBackend(backend, targetId) {
              return backend.connectDropTarget(targetId);
            },
            containerDisplayName: 'DropTarget',
            createHandler: createTarget,
            registerHandler: _registerTarget2['default'],
            createMonitor: _createTargetMonitor2['default'],
            createConnector: _createTargetConnector2['default'],
            DecoratedComponent: DecoratedComponent,
            getType: getType,
            collect: collect,
            options: options
          });
        };
      }
      module.exports = exports['default'];
    }, function(module, exports, __webpack_require__) {
      'use strict';
      exports.__esModule = true;
      exports['default'] = createSourceConnector;
      function _interopRequireDefault(obj) {
        return obj && obj.__esModule ? obj : {'default': obj};
      }
      var _wrapConnectorHooks = __webpack_require__(29);
      var _wrapConnectorHooks2 = _interopRequireDefault(_wrapConnectorHooks);
      var _areOptionsEqual = __webpack_require__(25);
      var _areOptionsEqual2 = _interopRequireDefault(_areOptionsEqual);
      function createSourceConnector(backend) {
        var currentHandlerId = undefined;
        var currentDragSourceNode = undefined;
        var currentDragSourceOptions = undefined;
        var disconnectCurrentDragSource = undefined;
        var currentDragPreviewNode = undefined;
        var currentDragPreviewOptions = undefined;
        var disconnectCurrentDragPreview = undefined;
        function reconnectDragSource() {
          if (disconnectCurrentDragSource) {
            disconnectCurrentDragSource();
            disconnectCurrentDragSource = null;
          }
          if (currentHandlerId && currentDragSourceNode) {
            disconnectCurrentDragSource = backend.connectDragSource(currentHandlerId, currentDragSourceNode, currentDragSourceOptions);
          }
        }
        function reconnectDragPreview() {
          if (disconnectCurrentDragPreview) {
            disconnectCurrentDragPreview();
            disconnectCurrentDragPreview = null;
          }
          if (currentHandlerId && currentDragPreviewNode) {
            disconnectCurrentDragPreview = backend.connectDragPreview(currentHandlerId, currentDragPreviewNode, currentDragPreviewOptions);
          }
        }
        function receiveHandlerId(handlerId) {
          if (handlerId === currentHandlerId) {
            return;
          }
          currentHandlerId = handlerId;
          reconnectDragSource();
          reconnectDragPreview();
        }
        var hooks = _wrapConnectorHooks2['default']({
          dragSource: function connectDragSource(node, options) {
            if (node === currentDragSourceNode && _areOptionsEqual2['default'](options, currentDragSourceOptions)) {
              return;
            }
            currentDragSourceNode = node;
            currentDragSourceOptions = options;
            reconnectDragSource();
          },
          dragPreview: function connectDragPreview(node, options) {
            if (node === currentDragPreviewNode && _areOptionsEqual2['default'](options, currentDragPreviewOptions)) {
              return;
            }
            currentDragPreviewNode = node;
            currentDragPreviewOptions = options;
            reconnectDragPreview();
          }
        });
        return {
          receiveHandlerId: receiveHandlerId,
          hooks: hooks
        };
      }
      module.exports = exports['default'];
    }, function(module, exports, __webpack_require__) {
      'use strict';
      exports.__esModule = true;
      exports['default'] = createSourceFactory;
      function _interopRequireDefault(obj) {
        return obj && obj.__esModule ? obj : {'default': obj};
      }
      function _classCallCheck(instance, Constructor) {
        if (!(instance instanceof Constructor)) {
          throw new TypeError('Cannot call a class as a function');
        }
      }
      var _invariant = __webpack_require__(1);
      var _invariant2 = _interopRequireDefault(_invariant);
      var _lodashIsPlainObject = __webpack_require__(2);
      var _lodashIsPlainObject2 = _interopRequireDefault(_lodashIsPlainObject);
      var ALLOWED_SPEC_METHODS = ['canDrag', 'beginDrag', 'canDrag', 'isDragging', 'endDrag'];
      var REQUIRED_SPEC_METHODS = ['beginDrag'];
      function createSourceFactory(spec) {
        Object.keys(spec).forEach(function(key) {
          _invariant2['default'](ALLOWED_SPEC_METHODS.indexOf(key) > -1, 'Expected the drag source specification to only have ' + 'some of the following keys: %s. ' + 'Instead received a specification with an unexpected "%s" key. ' + 'Read more: http://gaearon.github.io/react-dnd/docs-drag-source.html', ALLOWED_SPEC_METHODS.join(', '), key);
          _invariant2['default'](typeof spec[key] === 'function', 'Expected %s in the drag source specification to be a function. ' + 'Instead received a specification with %s: %s. ' + 'Read more: http://gaearon.github.io/react-dnd/docs-drag-source.html', key, key, spec[key]);
        });
        REQUIRED_SPEC_METHODS.forEach(function(key) {
          _invariant2['default'](typeof spec[key] === 'function', 'Expected %s in the drag source specification to be a function. ' + 'Instead received a specification with %s: %s. ' + 'Read more: http://gaearon.github.io/react-dnd/docs-drag-source.html', key, key, spec[key]);
        });
        var Source = (function() {
          function Source(monitor) {
            _classCallCheck(this, Source);
            this.monitor = monitor;
            this.props = null;
            this.component = null;
          }
          Source.prototype.receiveProps = function receiveProps(props) {
            this.props = props;
          };
          Source.prototype.receiveComponent = function receiveComponent(component) {
            this.component = component;
          };
          Source.prototype.canDrag = function canDrag() {
            if (!spec.canDrag) {
              return true;
            }
            return spec.canDrag(this.props, this.monitor);
          };
          Source.prototype.isDragging = function isDragging(globalMonitor, sourceId) {
            if (!spec.isDragging) {
              return sourceId === globalMonitor.getSourceId();
            }
            return spec.isDragging(this.props, this.monitor);
          };
          Source.prototype.beginDrag = function beginDrag() {
            var item = spec.beginDrag(this.props, this.monitor, this.component);
            if (false) {
              _invariant2['default'](_lodashIsPlainObject2['default'](item), 'beginDrag() must return a plain object that represents the dragged item. ' + 'Instead received %s. ' + 'Read more: http://gaearon.github.io/react-dnd/docs-drag-source.html', item);
            }
            return item;
          };
          Source.prototype.endDrag = function endDrag() {
            if (!spec.endDrag) {
              return;
            }
            spec.endDrag(this.props, this.monitor, this.component);
          };
          return Source;
        })();
        return function createSource(monitor) {
          return new Source(monitor);
        };
      }
      module.exports = exports['default'];
    }, function(module, exports, __webpack_require__) {
      'use strict';
      exports.__esModule = true;
      exports['default'] = createSourceMonitor;
      function _interopRequireDefault(obj) {
        return obj && obj.__esModule ? obj : {'default': obj};
      }
      function _classCallCheck(instance, Constructor) {
        if (!(instance instanceof Constructor)) {
          throw new TypeError('Cannot call a class as a function');
        }
      }
      var _invariant = __webpack_require__(1);
      var _invariant2 = _interopRequireDefault(_invariant);
      var isCallingCanDrag = false;
      var isCallingIsDragging = false;
      var SourceMonitor = (function() {
        function SourceMonitor(manager) {
          _classCallCheck(this, SourceMonitor);
          this.internalMonitor = manager.getMonitor();
        }
        SourceMonitor.prototype.receiveHandlerId = function receiveHandlerId(sourceId) {
          this.sourceId = sourceId;
        };
        SourceMonitor.prototype.canDrag = function canDrag() {
          _invariant2['default'](!isCallingCanDrag, 'You may not call monitor.canDrag() inside your canDrag() implementation. ' + 'Read more: http://gaearon.github.io/react-dnd/docs-drag-source-monitor.html');
          try {
            isCallingCanDrag = true;
            return this.internalMonitor.canDragSource(this.sourceId);
          } finally {
            isCallingCanDrag = false;
          }
        };
        SourceMonitor.prototype.isDragging = function isDragging() {
          _invariant2['default'](!isCallingIsDragging, 'You may not call monitor.isDragging() inside your isDragging() implementation. ' + 'Read more: http://gaearon.github.io/react-dnd/docs-drag-source-monitor.html');
          try {
            isCallingIsDragging = true;
            return this.internalMonitor.isDraggingSource(this.sourceId);
          } finally {
            isCallingIsDragging = false;
          }
        };
        SourceMonitor.prototype.getItemType = function getItemType() {
          return this.internalMonitor.getItemType();
        };
        SourceMonitor.prototype.getItem = function getItem() {
          return this.internalMonitor.getItem();
        };
        SourceMonitor.prototype.getDropResult = function getDropResult() {
          return this.internalMonitor.getDropResult();
        };
        SourceMonitor.prototype.didDrop = function didDrop() {
          return this.internalMonitor.didDrop();
        };
        SourceMonitor.prototype.getInitialClientOffset = function getInitialClientOffset() {
          return this.internalMonitor.getInitialClientOffset();
        };
        SourceMonitor.prototype.getInitialSourceClientOffset = function getInitialSourceClientOffset() {
          return this.internalMonitor.getInitialSourceClientOffset();
        };
        SourceMonitor.prototype.getSourceClientOffset = function getSourceClientOffset() {
          return this.internalMonitor.getSourceClientOffset();
        };
        SourceMonitor.prototype.getClientOffset = function getClientOffset() {
          return this.internalMonitor.getClientOffset();
        };
        SourceMonitor.prototype.getDifferenceFromInitialOffset = function getDifferenceFromInitialOffset() {
          return this.internalMonitor.getDifferenceFromInitialOffset();
        };
        return SourceMonitor;
      })();
      function createSourceMonitor(manager) {
        return new SourceMonitor(manager);
      }
      module.exports = exports['default'];
    }, function(module, exports, __webpack_require__) {
      'use strict';
      exports.__esModule = true;
      exports['default'] = createTargetConnector;
      function _interopRequireDefault(obj) {
        return obj && obj.__esModule ? obj : {'default': obj};
      }
      var _wrapConnectorHooks = __webpack_require__(29);
      var _wrapConnectorHooks2 = _interopRequireDefault(_wrapConnectorHooks);
      var _areOptionsEqual = __webpack_require__(25);
      var _areOptionsEqual2 = _interopRequireDefault(_areOptionsEqual);
      function createTargetConnector(backend) {
        var currentHandlerId = undefined;
        var currentDropTargetNode = undefined;
        var currentDropTargetOptions = undefined;
        var disconnectCurrentDropTarget = undefined;
        function reconnectDropTarget() {
          if (disconnectCurrentDropTarget) {
            disconnectCurrentDropTarget();
            disconnectCurrentDropTarget = null;
          }
          if (currentHandlerId && currentDropTargetNode) {
            disconnectCurrentDropTarget = backend.connectDropTarget(currentHandlerId, currentDropTargetNode, currentDropTargetOptions);
          }
        }
        function receiveHandlerId(handlerId) {
          if (handlerId === currentHandlerId) {
            return;
          }
          currentHandlerId = handlerId;
          reconnectDropTarget();
        }
        var hooks = _wrapConnectorHooks2['default']({dropTarget: function connectDropTarget(node, options) {
            if (node === currentDropTargetNode && _areOptionsEqual2['default'](options, currentDropTargetOptions)) {
              return;
            }
            currentDropTargetNode = node;
            currentDropTargetOptions = options;
            reconnectDropTarget();
          }});
        return {
          receiveHandlerId: receiveHandlerId,
          hooks: hooks
        };
      }
      module.exports = exports['default'];
    }, function(module, exports, __webpack_require__) {
      'use strict';
      exports.__esModule = true;
      exports['default'] = createTargetFactory;
      function _interopRequireDefault(obj) {
        return obj && obj.__esModule ? obj : {'default': obj};
      }
      function _classCallCheck(instance, Constructor) {
        if (!(instance instanceof Constructor)) {
          throw new TypeError('Cannot call a class as a function');
        }
      }
      var _invariant = __webpack_require__(1);
      var _invariant2 = _interopRequireDefault(_invariant);
      var _lodashIsPlainObject = __webpack_require__(2);
      var _lodashIsPlainObject2 = _interopRequireDefault(_lodashIsPlainObject);
      var ALLOWED_SPEC_METHODS = ['canDrop', 'hover', 'drop'];
      function createTargetFactory(spec) {
        Object.keys(spec).forEach(function(key) {
          _invariant2['default'](ALLOWED_SPEC_METHODS.indexOf(key) > -1, 'Expected the drop target specification to only have ' + 'some of the following keys: %s. ' + 'Instead received a specification with an unexpected "%s" key. ' + 'Read more: http://gaearon.github.io/react-dnd/docs-drop-target.html', ALLOWED_SPEC_METHODS.join(', '), key);
          _invariant2['default'](typeof spec[key] === 'function', 'Expected %s in the drop target specification to be a function. ' + 'Instead received a specification with %s: %s. ' + 'Read more: http://gaearon.github.io/react-dnd/docs-drop-target.html', key, key, spec[key]);
        });
        var Target = (function() {
          function Target(monitor) {
            _classCallCheck(this, Target);
            this.monitor = monitor;
            this.props = null;
            this.component = null;
          }
          Target.prototype.receiveProps = function receiveProps(props) {
            this.props = props;
          };
          Target.prototype.receiveMonitor = function receiveMonitor(monitor) {
            this.monitor = monitor;
          };
          Target.prototype.receiveComponent = function receiveComponent(component) {
            this.component = component;
          };
          Target.prototype.canDrop = function canDrop() {
            if (!spec.canDrop) {
              return true;
            }
            return spec.canDrop(this.props, this.monitor);
          };
          Target.prototype.hover = function hover() {
            if (!spec.hover) {
              return;
            }
            spec.hover(this.props, this.monitor, this.component);
          };
          Target.prototype.drop = function drop() {
            if (!spec.drop) {
              return;
            }
            var dropResult = spec.drop(this.props, this.monitor, this.component);
            if (false) {
              _invariant2['default'](typeof dropResult === 'undefined' || _lodashIsPlainObject2['default'](dropResult), 'drop() must either return undefined, or an object that represents the drop result. ' + 'Instead received %s. ' + 'Read more: http://gaearon.github.io/react-dnd/docs-drop-target.html', dropResult);
            }
            return dropResult;
          };
          return Target;
        })();
        return function createTarget(monitor) {
          return new Target(monitor);
        };
      }
      module.exports = exports['default'];
    }, function(module, exports, __webpack_require__) {
      'use strict';
      exports.__esModule = true;
      exports['default'] = createTargetMonitor;
      function _interopRequireDefault(obj) {
        return obj && obj.__esModule ? obj : {'default': obj};
      }
      function _classCallCheck(instance, Constructor) {
        if (!(instance instanceof Constructor)) {
          throw new TypeError('Cannot call a class as a function');
        }
      }
      var _invariant = __webpack_require__(1);
      var _invariant2 = _interopRequireDefault(_invariant);
      var isCallingCanDrop = false;
      var TargetMonitor = (function() {
        function TargetMonitor(manager) {
          _classCallCheck(this, TargetMonitor);
          this.internalMonitor = manager.getMonitor();
        }
        TargetMonitor.prototype.receiveHandlerId = function receiveHandlerId(targetId) {
          this.targetId = targetId;
        };
        TargetMonitor.prototype.canDrop = function canDrop() {
          _invariant2['default'](!isCallingCanDrop, 'You may not call monitor.canDrop() inside your canDrop() implementation. ' + 'Read more: http://gaearon.github.io/react-dnd/docs-drop-target-monitor.html');
          try {
            isCallingCanDrop = true;
            return this.internalMonitor.canDropOnTarget(this.targetId);
          } finally {
            isCallingCanDrop = false;
          }
        };
        TargetMonitor.prototype.isOver = function isOver(options) {
          return this.internalMonitor.isOverTarget(this.targetId, options);
        };
        TargetMonitor.prototype.getItemType = function getItemType() {
          return this.internalMonitor.getItemType();
        };
        TargetMonitor.prototype.getItem = function getItem() {
          return this.internalMonitor.getItem();
        };
        TargetMonitor.prototype.getDropResult = function getDropResult() {
          return this.internalMonitor.getDropResult();
        };
        TargetMonitor.prototype.didDrop = function didDrop() {
          return this.internalMonitor.didDrop();
        };
        TargetMonitor.prototype.getInitialClientOffset = function getInitialClientOffset() {
          return this.internalMonitor.getInitialClientOffset();
        };
        TargetMonitor.prototype.getInitialSourceClientOffset = function getInitialSourceClientOffset() {
          return this.internalMonitor.getInitialSourceClientOffset();
        };
        TargetMonitor.prototype.getSourceClientOffset = function getSourceClientOffset() {
          return this.internalMonitor.getSourceClientOffset();
        };
        TargetMonitor.prototype.getClientOffset = function getClientOffset() {
          return this.internalMonitor.getClientOffset();
        };
        TargetMonitor.prototype.getDifferenceFromInitialOffset = function getDifferenceFromInitialOffset() {
          return this.internalMonitor.getDifferenceFromInitialOffset();
        };
        return TargetMonitor;
      })();
      function createTargetMonitor(manager) {
        return new TargetMonitor(manager);
      }
      module.exports = exports['default'];
    }, function(module, exports) {
      "use strict";
      exports.__esModule = true;
      exports["default"] = registerSource;
      function registerSource(type, source, manager) {
        var registry = manager.getRegistry();
        var sourceId = registry.addSource(type, source);
        function unregisterSource() {
          registry.removeSource(sourceId);
        }
        return {
          handlerId: sourceId,
          unregister: unregisterSource
        };
      }
      module.exports = exports["default"];
    }, function(module, exports) {
      "use strict";
      exports.__esModule = true;
      exports["default"] = registerTarget;
      function registerTarget(type, target, manager) {
        var registry = manager.getRegistry();
        var targetId = registry.addTarget(type, target);
        function unregisterTarget() {
          registry.removeTarget(targetId);
        }
        return {
          handlerId: targetId,
          unregister: unregisterTarget
        };
      }
      module.exports = exports["default"];
    }, function(module, exports, __webpack_require__) {
      'use strict';
      exports.__esModule = true;
      exports['default'] = cloneWithRef;
      function _interopRequireDefault(obj) {
        return obj && obj.__esModule ? obj : {'default': obj};
      }
      var _invariant = __webpack_require__(1);
      var _invariant2 = _interopRequireDefault(_invariant);
      var _react = __webpack_require__(6);
      function cloneWithRef(element, newRef) {
        var previousRef = element.ref;
        _invariant2['default'](typeof previousRef !== 'string', 'Cannot connect React DnD to an element with an existing string ref. ' + 'Please convert it to use a callback ref instead, or wrap it into a <span> or <div>. ' + 'Read more: https://facebook.github.io/react/docs/more-about-refs.html#the-ref-callback-attribute');
        if (!previousRef) {
          return _react.cloneElement(element, {ref: newRef});
        }
        return _react.cloneElement(element, {ref: function ref(node) {
            newRef(node);
            if (previousRef) {
              previousRef(node);
            }
          }});
      }
      module.exports = exports['default'];
    }, function(module, exports, __webpack_require__) {
      'use strict';
      var _interopRequireWildcard = function(obj) {
        return obj && obj.__esModule ? obj : {'default': obj};
      };
      var _classCallCheck = function(instance, Constructor) {
        if (!(instance instanceof Constructor)) {
          throw new TypeError('Cannot call a class as a function');
        }
      };
      exports.__esModule = true;
      var _isDisposable = __webpack_require__(14);
      var _isDisposable2 = _interopRequireWildcard(_isDisposable);
      var CompositeDisposable = (function() {
        function CompositeDisposable() {
          for (var _len = arguments.length,
              disposables = Array(_len),
              _key = 0; _key < _len; _key++) {
            disposables[_key] = arguments[_key];
          }
          _classCallCheck(this, CompositeDisposable);
          if (Array.isArray(disposables[0]) && disposables.length === 1) {
            disposables = disposables[0];
          }
          for (var i = 0; i < disposables.length; i++) {
            if (!_isDisposable2['default'](disposables[i])) {
              throw new Error('Expected a disposable');
            }
          }
          this.disposables = disposables;
          this.isDisposed = false;
        }
        CompositeDisposable.prototype.add = function add(item) {
          if (this.isDisposed) {
            item.dispose();
          } else {
            this.disposables.push(item);
          }
        };
        CompositeDisposable.prototype.remove = function remove(item) {
          if (this.isDisposed) {
            return false;
          }
          var index = this.disposables.indexOf(item);
          if (index === -1) {
            return false;
          }
          this.disposables.splice(index, 1);
          item.dispose();
          return true;
        };
        CompositeDisposable.prototype.dispose = function dispose() {
          if (this.isDisposed) {
            return;
          }
          var len = this.disposables.length;
          var currentDisposables = new Array(len);
          for (var i = 0; i < len; i++) {
            currentDisposables[i] = this.disposables[i];
          }
          this.isDisposed = true;
          this.disposables = [];
          this.length = 0;
          for (var i = 0; i < len; i++) {
            currentDisposables[i].dispose();
          }
        };
        return CompositeDisposable;
      })();
      exports['default'] = CompositeDisposable;
      module.exports = exports['default'];
    }, function(module, exports) {
      "use strict";
      var _classCallCheck = function(instance, Constructor) {
        if (!(instance instanceof Constructor)) {
          throw new TypeError("Cannot call a class as a function");
        }
      };
      var _createClass = (function() {
        function defineProperties(target, props) {
          for (var i = 0; i < props.length; i++) {
            var descriptor = props[i];
            descriptor.enumerable = descriptor.enumerable || false;
            descriptor.configurable = true;
            if ("value" in descriptor)
              descriptor.writable = true;
            Object.defineProperty(target, descriptor.key, descriptor);
          }
        }
        return function(Constructor, protoProps, staticProps) {
          if (protoProps)
            defineProperties(Constructor.prototype, protoProps);
          if (staticProps)
            defineProperties(Constructor, staticProps);
          return Constructor;
        };
      })();
      exports.__esModule = true;
      var noop = function noop() {};
      var Disposable = (function() {
        function Disposable(action) {
          _classCallCheck(this, Disposable);
          this.isDisposed = false;
          this.action = action || noop;
        }
        Disposable.prototype.dispose = function dispose() {
          if (!this.isDisposed) {
            this.action.call(null);
            this.isDisposed = true;
          }
        };
        _createClass(Disposable, null, [{
          key: "empty",
          enumerable: true,
          value: {dispose: noop}
        }]);
        return Disposable;
      })();
      exports["default"] = Disposable;
      module.exports = exports["default"];
    }, function(module, exports, __webpack_require__) {
      'use strict';
      var _interopRequireWildcard = function(obj) {
        return obj && obj.__esModule ? obj : {'default': obj};
      };
      var _classCallCheck = function(instance, Constructor) {
        if (!(instance instanceof Constructor)) {
          throw new TypeError('Cannot call a class as a function');
        }
      };
      exports.__esModule = true;
      var _isDisposable = __webpack_require__(14);
      var _isDisposable2 = _interopRequireWildcard(_isDisposable);
      var SerialDisposable = (function() {
        function SerialDisposable() {
          _classCallCheck(this, SerialDisposable);
          this.isDisposed = false;
          this.current = null;
        }
        SerialDisposable.prototype.getDisposable = function getDisposable() {
          return this.current;
        };
        SerialDisposable.prototype.setDisposable = function setDisposable() {
          var value = arguments[0] === undefined ? null : arguments[0];
          if (value != null && !_isDisposable2['default'](value)) {
            throw new Error('Expected either an empty value or a valid disposable');
          }
          var isDisposed = this.isDisposed;
          var previous = undefined;
          if (!isDisposed) {
            previous = this.current;
            this.current = value;
          }
          if (previous) {
            previous.dispose();
          }
          if (isDisposed && value) {
            value.dispose();
          }
        };
        SerialDisposable.prototype.dispose = function dispose() {
          if (this.isDisposed) {
            return;
          }
          this.isDisposed = true;
          var previous = this.current;
          this.current = null;
          if (previous) {
            previous.dispose();
          }
        };
        return SerialDisposable;
      })();
      exports['default'] = SerialDisposable;
      module.exports = exports['default'];
    }, function(module, exports, __webpack_require__) {
      'use strict';
      var _interopRequireWildcard = function(obj) {
        return obj && obj.__esModule ? obj : {'default': obj};
      };
      exports.__esModule = true;
      var _isDisposable2 = __webpack_require__(14);
      var _isDisposable3 = _interopRequireWildcard(_isDisposable2);
      exports.isDisposable = _isDisposable3['default'];
      var _Disposable2 = __webpack_require__(56);
      var _Disposable3 = _interopRequireWildcard(_Disposable2);
      exports.Disposable = _Disposable3['default'];
      var _CompositeDisposable2 = __webpack_require__(55);
      var _CompositeDisposable3 = _interopRequireWildcard(_CompositeDisposable2);
      exports.CompositeDisposable = _CompositeDisposable3['default'];
      var _SerialDisposable2 = __webpack_require__(57);
      var _SerialDisposable3 = _interopRequireWildcard(_SerialDisposable2);
      exports.SerialDisposable = _SerialDisposable3['default'];
    }, function(module, exports, __webpack_require__) {
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
      var _reduxLibCreateStore = __webpack_require__(111);
      var _reduxLibCreateStore2 = _interopRequireDefault(_reduxLibCreateStore);
      var _reducers = __webpack_require__(66);
      var _reducers2 = _interopRequireDefault(_reducers);
      var _actionsDragDrop = __webpack_require__(8);
      var dragDropActions = _interopRequireWildcard(_actionsDragDrop);
      var _DragDropMonitor = __webpack_require__(60);
      var _DragDropMonitor2 = _interopRequireDefault(_DragDropMonitor);
      var _HandlerRegistry = __webpack_require__(30);
      var _HandlerRegistry2 = _interopRequireDefault(_HandlerRegistry);
      var DragDropManager = (function() {
        function DragDropManager(createBackend) {
          _classCallCheck(this, DragDropManager);
          var store = _reduxLibCreateStore2['default'](_reducers2['default']);
          this.store = store;
          this.monitor = new _DragDropMonitor2['default'](store);
          this.registry = this.monitor.registry;
          this.backend = createBackend(this);
          store.subscribe(this.handleRefCountChange.bind(this));
        }
        DragDropManager.prototype.handleRefCountChange = function handleRefCountChange() {
          var shouldSetUp = this.store.getState().refCount > 0;
          if (shouldSetUp && !this.isSetUp) {
            this.backend.setup();
            this.isSetUp = true;
          } else if (!shouldSetUp && this.isSetUp) {
            this.backend.teardown();
            this.isSetUp = false;
          }
        };
        DragDropManager.prototype.getMonitor = function getMonitor() {
          return this.monitor;
        };
        DragDropManager.prototype.getBackend = function getBackend() {
          return this.backend;
        };
        DragDropManager.prototype.getRegistry = function getRegistry() {
          return this.registry;
        };
        DragDropManager.prototype.getActions = function getActions() {
          var manager = this;
          var dispatch = this.store.dispatch;
          function bindActionCreator(actionCreator) {
            return function() {
              var action = actionCreator.apply(manager, arguments);
              if (typeof action !== 'undefined') {
                dispatch(action);
              }
            };
          }
          return Object.keys(dragDropActions).filter(function(key) {
            return typeof dragDropActions[key] === 'function';
          }).reduce(function(boundActions, key) {
            boundActions[key] = bindActionCreator(dragDropActions[key]);
            return boundActions;
          }, {});
        };
        return DragDropManager;
      })();
      exports['default'] = DragDropManager;
      module.exports = exports['default'];
    }, function(module, exports, __webpack_require__) {
      'use strict';
      exports.__esModule = true;
      function _interopRequireDefault(obj) {
        return obj && obj.__esModule ? obj : {'default': obj};
      }
      function _classCallCheck(instance, Constructor) {
        if (!(instance instanceof Constructor)) {
          throw new TypeError('Cannot call a class as a function');
        }
      }
      var _invariant = __webpack_require__(1);
      var _invariant2 = _interopRequireDefault(_invariant);
      var _utilsMatchesType = __webpack_require__(33);
      var _utilsMatchesType2 = _interopRequireDefault(_utilsMatchesType);
      var _lodashIsArray = __webpack_require__(5);
      var _lodashIsArray2 = _interopRequireDefault(_lodashIsArray);
      var _HandlerRegistry = __webpack_require__(30);
      var _HandlerRegistry2 = _interopRequireDefault(_HandlerRegistry);
      var _reducersDragOffset = __webpack_require__(32);
      var _reducersDirtyHandlerIds = __webpack_require__(31);
      var DragDropMonitor = (function() {
        function DragDropMonitor(store) {
          _classCallCheck(this, DragDropMonitor);
          this.store = store;
          this.registry = new _HandlerRegistry2['default'](store);
        }
        DragDropMonitor.prototype.subscribeToStateChange = function subscribeToStateChange(listener) {
          var _this = this;
          var _ref = arguments.length <= 1 || arguments[1] === undefined ? {} : arguments[1];
          var handlerIds = _ref.handlerIds;
          _invariant2['default'](typeof listener === 'function', 'listener must be a function.');
          _invariant2['default'](typeof handlerIds === 'undefined' || _lodashIsArray2['default'](handlerIds), 'handlerIds, when specified, must be an array of strings.');
          var prevStateId = this.store.getState().stateId;
          var handleChange = function handleChange() {
            var state = _this.store.getState();
            var currentStateId = state.stateId;
            try {
              var canSkipListener = currentStateId === prevStateId || currentStateId === prevStateId + 1 && !_reducersDirtyHandlerIds.areDirty(state.dirtyHandlerIds, handlerIds);
              if (!canSkipListener) {
                listener();
              }
            } finally {
              prevStateId = currentStateId;
            }
          };
          return this.store.subscribe(handleChange);
        };
        DragDropMonitor.prototype.subscribeToOffsetChange = function subscribeToOffsetChange(listener) {
          var _this2 = this;
          _invariant2['default'](typeof listener === 'function', 'listener must be a function.');
          var previousState = this.store.getState().dragOffset;
          var handleChange = function handleChange() {
            var nextState = _this2.store.getState().dragOffset;
            if (nextState === previousState) {
              return;
            }
            previousState = nextState;
            listener();
          };
          return this.store.subscribe(handleChange);
        };
        DragDropMonitor.prototype.canDragSource = function canDragSource(sourceId) {
          var source = this.registry.getSource(sourceId);
          _invariant2['default'](source, 'Expected to find a valid source.');
          if (this.isDragging()) {
            return false;
          }
          return source.canDrag(this, sourceId);
        };
        DragDropMonitor.prototype.canDropOnTarget = function canDropOnTarget(targetId) {
          var target = this.registry.getTarget(targetId);
          _invariant2['default'](target, 'Expected to find a valid target.');
          if (!this.isDragging() || this.didDrop()) {
            return false;
          }
          var targetType = this.registry.getTargetType(targetId);
          var draggedItemType = this.getItemType();
          return _utilsMatchesType2['default'](targetType, draggedItemType) && target.canDrop(this, targetId);
        };
        DragDropMonitor.prototype.isDragging = function isDragging() {
          return Boolean(this.getItemType());
        };
        DragDropMonitor.prototype.isDraggingSource = function isDraggingSource(sourceId) {
          var source = this.registry.getSource(sourceId, true);
          _invariant2['default'](source, 'Expected to find a valid source.');
          if (!this.isDragging() || !this.isSourcePublic()) {
            return false;
          }
          var sourceType = this.registry.getSourceType(sourceId);
          var draggedItemType = this.getItemType();
          if (sourceType !== draggedItemType) {
            return false;
          }
          return source.isDragging(this, sourceId);
        };
        DragDropMonitor.prototype.isOverTarget = function isOverTarget(targetId) {
          var _ref2 = arguments.length <= 1 || arguments[1] === undefined ? {} : arguments[1];
          var _ref2$shallow = _ref2.shallow;
          var shallow = _ref2$shallow === undefined ? false : _ref2$shallow;
          if (!this.isDragging()) {
            return false;
          }
          var targetType = this.registry.getTargetType(targetId);
          var draggedItemType = this.getItemType();
          if (!_utilsMatchesType2['default'](targetType, draggedItemType)) {
            return false;
          }
          var targetIds = this.getTargetIds();
          if (!targetIds.length) {
            return false;
          }
          var index = targetIds.indexOf(targetId);
          if (shallow) {
            return index === targetIds.length - 1;
          } else {
            return index > -1;
          }
        };
        DragDropMonitor.prototype.getItemType = function getItemType() {
          return this.store.getState().dragOperation.itemType;
        };
        DragDropMonitor.prototype.getItem = function getItem() {
          return this.store.getState().dragOperation.item;
        };
        DragDropMonitor.prototype.getSourceId = function getSourceId() {
          return this.store.getState().dragOperation.sourceId;
        };
        DragDropMonitor.prototype.getTargetIds = function getTargetIds() {
          return this.store.getState().dragOperation.targetIds;
        };
        DragDropMonitor.prototype.getDropResult = function getDropResult() {
          return this.store.getState().dragOperation.dropResult;
        };
        DragDropMonitor.prototype.didDrop = function didDrop() {
          return this.store.getState().dragOperation.didDrop;
        };
        DragDropMonitor.prototype.isSourcePublic = function isSourcePublic() {
          return this.store.getState().dragOperation.isSourcePublic;
        };
        DragDropMonitor.prototype.getInitialClientOffset = function getInitialClientOffset() {
          return this.store.getState().dragOffset.initialClientOffset;
        };
        DragDropMonitor.prototype.getInitialSourceClientOffset = function getInitialSourceClientOffset() {
          return this.store.getState().dragOffset.initialSourceClientOffset;
        };
        DragDropMonitor.prototype.getClientOffset = function getClientOffset() {
          return this.store.getState().dragOffset.clientOffset;
        };
        DragDropMonitor.prototype.getSourceClientOffset = function getSourceClientOffset() {
          return _reducersDragOffset.getSourceClientOffset(this.store.getState().dragOffset);
        };
        DragDropMonitor.prototype.getDifferenceFromInitialOffset = function getDifferenceFromInitialOffset() {
          return _reducersDragOffset.getDifferenceFromInitialOffset(this.store.getState().dragOffset);
        };
        return DragDropMonitor;
      })();
      exports['default'] = DragDropMonitor;
      module.exports = exports['default'];
    }, function(module, exports) {
      "use strict";
      exports.__esModule = true;
      function _classCallCheck(instance, Constructor) {
        if (!(instance instanceof Constructor)) {
          throw new TypeError("Cannot call a class as a function");
        }
      }
      var DragSource = (function() {
        function DragSource() {
          _classCallCheck(this, DragSource);
        }
        DragSource.prototype.canDrag = function canDrag() {
          return true;
        };
        DragSource.prototype.isDragging = function isDragging(monitor, handle) {
          return handle === monitor.getSourceId();
        };
        DragSource.prototype.endDrag = function endDrag() {};
        return DragSource;
      })();
      exports["default"] = DragSource;
      module.exports = exports["default"];
    }, function(module, exports) {
      "use strict";
      exports.__esModule = true;
      function _classCallCheck(instance, Constructor) {
        if (!(instance instanceof Constructor)) {
          throw new TypeError("Cannot call a class as a function");
        }
      }
      var DropTarget = (function() {
        function DropTarget() {
          _classCallCheck(this, DropTarget);
        }
        DropTarget.prototype.canDrop = function canDrop() {
          return true;
        };
        DropTarget.prototype.hover = function hover() {};
        DropTarget.prototype.drop = function drop() {};
        return DropTarget;
      })();
      exports["default"] = DropTarget;
      module.exports = exports["default"];
    }, function(module, exports, __webpack_require__) {
      'use strict';
      exports.__esModule = true;
      exports['default'] = createBackend;
      function _interopRequireDefault(obj) {
        return obj && obj.__esModule ? obj : {'default': obj};
      }
      function _classCallCheck(instance, Constructor) {
        if (!(instance instanceof Constructor)) {
          throw new TypeError('Cannot call a class as a function');
        }
      }
      var _lodashNoop = __webpack_require__(39);
      var _lodashNoop2 = _interopRequireDefault(_lodashNoop);
      var TestBackend = (function() {
        function TestBackend(manager) {
          _classCallCheck(this, TestBackend);
          this.actions = manager.getActions();
        }
        TestBackend.prototype.setup = function setup() {
          this.didCallSetup = true;
        };
        TestBackend.prototype.teardown = function teardown() {
          this.didCallTeardown = true;
        };
        TestBackend.prototype.connectDragSource = function connectDragSource() {
          return _lodashNoop2['default'];
        };
        TestBackend.prototype.connectDragPreview = function connectDragPreview() {
          return _lodashNoop2['default'];
        };
        TestBackend.prototype.connectDropTarget = function connectDropTarget() {
          return _lodashNoop2['default'];
        };
        TestBackend.prototype.simulateBeginDrag = function simulateBeginDrag(sourceIds, options) {
          this.actions.beginDrag(sourceIds, options);
        };
        TestBackend.prototype.simulatePublishDragSource = function simulatePublishDragSource() {
          this.actions.publishDragSource();
        };
        TestBackend.prototype.simulateHover = function simulateHover(targetIds, options) {
          this.actions.hover(targetIds, options);
        };
        TestBackend.prototype.simulateDrop = function simulateDrop() {
          this.actions.drop();
        };
        TestBackend.prototype.simulateEndDrag = function simulateEndDrag() {
          this.actions.endDrag();
        };
        return TestBackend;
      })();
      function createBackend(manager) {
        return new TestBackend(manager);
      }
      module.exports = exports['default'];
    }, function(module, exports, __webpack_require__) {
      'use strict';
      exports.__esModule = true;
      function _interopRequire(obj) {
        return obj && obj.__esModule ? obj['default'] : obj;
      }
      var _DragDropManager = __webpack_require__(59);
      exports.DragDropManager = _interopRequire(_DragDropManager);
      var _DragSource = __webpack_require__(61);
      exports.DragSource = _interopRequire(_DragSource);
      var _DropTarget = __webpack_require__(62);
      exports.DropTarget = _interopRequire(_DropTarget);
      var _backendsCreateTestBackend = __webpack_require__(63);
      exports.createTestBackend = _interopRequire(_backendsCreateTestBackend);
    }, function(module, exports, __webpack_require__) {
      'use strict';
      exports.__esModule = true;
      var _extends = Object.assign || function(target) {
        for (var i = 1; i < arguments.length; i++) {
          var source = arguments[i];
          for (var key in source) {
            if (Object.prototype.hasOwnProperty.call(source, key)) {
              target[key] = source[key];
            }
          }
        }
        return target;
      };
      exports['default'] = dragOperation;
      function _interopRequireDefault(obj) {
        return obj && obj.__esModule ? obj : {'default': obj};
      }
      var _actionsDragDrop = __webpack_require__(8);
      var _actionsRegistry = __webpack_require__(9);
      var _lodashWithout = __webpack_require__(109);
      var _lodashWithout2 = _interopRequireDefault(_lodashWithout);
      var initialState = {
        itemType: null,
        item: null,
        sourceId: null,
        targetIds: [],
        dropResult: null,
        didDrop: false,
        isSourcePublic: null
      };
      function dragOperation(state, action) {
        if (state === undefined)
          state = initialState;
        switch (action.type) {
          case _actionsDragDrop.BEGIN_DRAG:
            return _extends({}, state, {
              itemType: action.itemType,
              item: action.item,
              sourceId: action.sourceId,
              isSourcePublic: action.isSourcePublic,
              dropResult: null,
              didDrop: false
            });
          case _actionsDragDrop.PUBLISH_DRAG_SOURCE:
            return _extends({}, state, {isSourcePublic: true});
          case _actionsDragDrop.HOVER:
            return _extends({}, state, {targetIds: action.targetIds});
          case _actionsDragDrop.PUBLISH_DRAG_SOURCE:
            return _extends({}, state, {isSourcePublic: true});
          case _actionsRegistry.REMOVE_TARGET:
            if (state.targetIds.indexOf(action.targetId) === -1) {
              return state;
            }
            return _extends({}, state, {targetIds: _lodashWithout2['default'](state.targetIds, action.targetId)});
          case _actionsDragDrop.DROP:
            return _extends({}, state, {
              dropResult: action.dropResult,
              didDrop: true,
              targetIds: []
            });
          case _actionsDragDrop.END_DRAG:
            return _extends({}, state, {
              itemType: null,
              item: null,
              sourceId: null,
              dropResult: null,
              didDrop: false,
              isSourcePublic: null,
              targetIds: []
            });
          default:
            return state;
        }
      }
      module.exports = exports['default'];
    }, function(module, exports, __webpack_require__) {
      'use strict';
      exports.__esModule = true;
      function _interopRequireDefault(obj) {
        return obj && obj.__esModule ? obj : {'default': obj};
      }
      var _dragOffset = __webpack_require__(32);
      var _dragOffset2 = _interopRequireDefault(_dragOffset);
      var _dragOperation = __webpack_require__(65);
      var _dragOperation2 = _interopRequireDefault(_dragOperation);
      var _refCount = __webpack_require__(67);
      var _refCount2 = _interopRequireDefault(_refCount);
      var _dirtyHandlerIds = __webpack_require__(31);
      var _dirtyHandlerIds2 = _interopRequireDefault(_dirtyHandlerIds);
      var _stateId = __webpack_require__(68);
      var _stateId2 = _interopRequireDefault(_stateId);
      exports['default'] = function(state, action) {
        if (state === undefined)
          state = {};
        return {
          dirtyHandlerIds: _dirtyHandlerIds2['default'](state.dirtyHandlerIds, action, state.dragOperation),
          dragOffset: _dragOffset2['default'](state.dragOffset, action),
          refCount: _refCount2['default'](state.refCount, action),
          dragOperation: _dragOperation2['default'](state.dragOperation, action),
          stateId: _stateId2['default'](state.stateId)
        };
      };
      module.exports = exports['default'];
    }, function(module, exports, __webpack_require__) {
      'use strict';
      exports.__esModule = true;
      exports['default'] = refCount;
      var _actionsRegistry = __webpack_require__(9);
      function refCount(state, action) {
        if (state === undefined)
          state = 0;
        switch (action.type) {
          case _actionsRegistry.ADD_SOURCE:
          case _actionsRegistry.ADD_TARGET:
            return state + 1;
          case _actionsRegistry.REMOVE_SOURCE:
          case _actionsRegistry.REMOVE_TARGET:
            return state - 1;
          default:
            return state;
        }
      }
      module.exports = exports['default'];
    }, function(module, exports) {
      "use strict";
      exports.__esModule = true;
      exports["default"] = stateId;
      function stateId() {
        var state = arguments.length <= 0 || arguments[0] === undefined ? 0 : arguments[0];
        return state + 1;
      }
      module.exports = exports["default"];
    }, function(module, exports) {
      "use strict";
      exports.__esModule = true;
      exports["default"] = getNextUniqueId;
      var nextUniqueId = 0;
      function getNextUniqueId() {
        return nextUniqueId++;
      }
      module.exports = exports["default"];
    }, function(module, exports, __webpack_require__) {
      var nativeCreate = __webpack_require__(11);
      var objectProto = Object.prototype;
      function Hash() {}
      Hash.prototype = nativeCreate ? nativeCreate(null) : objectProto;
      module.exports = Hash;
    }, function(module, exports, __webpack_require__) {
      var mapClear = __webpack_require__(95),
          mapDelete = __webpack_require__(96),
          mapGet = __webpack_require__(97),
          mapHas = __webpack_require__(98),
          mapSet = __webpack_require__(99);
      function MapCache(values) {
        var index = -1,
            length = values ? values.length : 0;
        this.clear();
        while (++index < length) {
          var entry = values[index];
          this.set(entry[0], entry[1]);
        }
      }
      MapCache.prototype.clear = mapClear;
      MapCache.prototype['delete'] = mapDelete;
      MapCache.prototype.get = mapGet;
      MapCache.prototype.has = mapHas;
      MapCache.prototype.set = mapSet;
      module.exports = MapCache;
    }, function(module, exports, __webpack_require__) {
      var getNative = __webpack_require__(20),
          root = __webpack_require__(38);
      var Set = getNative(root, 'Set');
      module.exports = Set;
    }, function(module, exports) {
      function apply(func, thisArg, args) {
        var length = args.length;
        switch (length) {
          case 0:
            return func.call(thisArg);
          case 1:
            return func.call(thisArg, args[0]);
          case 2:
            return func.call(thisArg, args[0], args[1]);
          case 3:
            return func.call(thisArg, args[0], args[1], args[2]);
        }
        return func.apply(thisArg, args);
      }
      module.exports = apply;
    }, function(module, exports) {
      function arrayFilter(array, predicate) {
        var index = -1,
            length = array.length,
            resIndex = 0,
            result = [];
        while (++index < length) {
          var value = array[index];
          if (predicate(value, index, array)) {
            result[resIndex++] = value;
          }
        }
        return result;
      }
      module.exports = arrayFilter;
    }, function(module, exports) {
      function arrayPush(array, values) {
        var index = -1,
            length = values.length,
            offset = array.length;
        while (++index < length) {
          array[offset + index] = values[index];
        }
        return array;
      }
      module.exports = arrayPush;
    }, function(module, exports, __webpack_require__) {
      var assocIndexOf = __webpack_require__(10);
      var arrayProto = Array.prototype;
      var splice = arrayProto.splice;
      function assocDelete(array, key) {
        var index = assocIndexOf(array, key);
        if (index < 0) {
          return false;
        }
        var lastIndex = array.length - 1;
        if (index == lastIndex) {
          array.pop();
        } else {
          splice.call(array, index, 1);
        }
        return true;
      }
      module.exports = assocDelete;
    }, function(module, exports, __webpack_require__) {
      var assocIndexOf = __webpack_require__(10);
      function assocGet(array, key) {
        var index = assocIndexOf(array, key);
        return index < 0 ? undefined : array[index][1];
      }
      module.exports = assocGet;
    }, function(module, exports, __webpack_require__) {
      var assocIndexOf = __webpack_require__(10);
      function assocHas(array, key) {
        return assocIndexOf(array, key) > -1;
      }
      module.exports = assocHas;
    }, function(module, exports, __webpack_require__) {
      var assocIndexOf = __webpack_require__(10);
      function assocSet(array, key, value) {
        var index = assocIndexOf(array, key);
        if (index < 0) {
          array.push([key, value]);
        } else {
          array[index][1] = value;
        }
      }
      module.exports = assocSet;
    }, function(module, exports, __webpack_require__) {
      var isArrayLikeObject = __webpack_require__(21);
      function baseCastArrayLikeObject(value) {
        return isArrayLikeObject(value) ? value : [];
      }
      module.exports = baseCastArrayLikeObject;
    }, function(module, exports, __webpack_require__) {
      var indexOfNaN = __webpack_require__(94);
      function baseIndexOf(array, value, fromIndex) {
        if (value !== value) {
          return indexOfNaN(array, fromIndex);
        }
        var index = fromIndex - 1,
            length = array.length;
        while (++index < length) {
          if (array[index] === value) {
            return index;
          }
        }
        return -1;
      }
      module.exports = baseIndexOf;
    }, function(module, exports, __webpack_require__) {
      var SetCache = __webpack_require__(15),
          arrayIncludes = __webpack_require__(16),
          arrayIncludesWith = __webpack_require__(17),
          arrayMap = __webpack_require__(18),
          baseUnary = __webpack_require__(35),
          cacheHas = __webpack_require__(19);
      var nativeMin = Math.min;
      function baseIntersection(arrays, iteratee, comparator) {
        var includes = comparator ? arrayIncludesWith : arrayIncludes,
            length = arrays[0].length,
            othLength = arrays.length,
            othIndex = othLength,
            caches = Array(othLength),
            maxLength = Infinity,
            result = [];
        while (othIndex--) {
          var array = arrays[othIndex];
          if (othIndex && iteratee) {
            array = arrayMap(array, baseUnary(iteratee));
          }
          maxLength = nativeMin(array.length, maxLength);
          caches[othIndex] = !comparator && (iteratee || (length >= 120 && array.length >= 120)) ? new SetCache(othIndex && array) : undefined;
        }
        array = arrays[0];
        var index = -1,
            seen = caches[0];
        outer: while (++index < length && result.length < maxLength) {
          var value = array[index],
              computed = iteratee ? iteratee(value) : value;
          if (!(seen ? cacheHas(seen, computed) : includes(result, computed, comparator))) {
            othIndex = othLength;
            while (--othIndex) {
              var cache = caches[othIndex];
              if (!(cache ? cacheHas(cache, computed) : includes(arrays[othIndex], computed, comparator))) {
                continue outer;
              }
            }
            if (seen) {
              seen.push(computed);
            }
            result.push(value);
          }
        }
        return result;
      }
      module.exports = baseIntersection;
    }, function(module, exports) {
      function baseProperty(key) {
        return function(object) {
          return object == null ? undefined : object[key];
        };
      }
      module.exports = baseProperty;
    }, function(module, exports, __webpack_require__) {
      var SetCache = __webpack_require__(15),
          arrayIncludes = __webpack_require__(16),
          arrayIncludesWith = __webpack_require__(17),
          cacheHas = __webpack_require__(19),
          createSet = __webpack_require__(88),
          setToArray = __webpack_require__(100);
      var LARGE_ARRAY_SIZE = 200;
      function baseUniq(array, iteratee, comparator) {
        var index = -1,
            includes = arrayIncludes,
            length = array.length,
            isCommon = true,
            result = [],
            seen = result;
        if (comparator) {
          isCommon = false;
          includes = arrayIncludesWith;
        } else if (length >= LARGE_ARRAY_SIZE) {
          var set = iteratee ? null : createSet(array);
          if (set) {
            return setToArray(set);
          }
          isCommon = false;
          includes = cacheHas;
          seen = new SetCache;
        } else {
          seen = iteratee ? [] : result;
        }
        outer: while (++index < length) {
          var value = array[index],
              computed = iteratee ? iteratee(value) : value;
          if (isCommon && computed === computed) {
            var seenIndex = seen.length;
            while (seenIndex--) {
              if (seen[seenIndex] === computed) {
                continue outer;
              }
            }
            if (iteratee) {
              seen.push(computed);
            }
            result.push(value);
          } else if (!includes(seen, computed, comparator)) {
            if (seen !== result) {
              seen.push(computed);
            }
            result.push(value);
          }
        }
        return result;
      }
      module.exports = baseUniq;
    }, function(module, exports, __webpack_require__) {
      var arrayPush = __webpack_require__(75),
          baseDifference = __webpack_require__(34),
          baseUniq = __webpack_require__(84);
      function baseXor(arrays, iteratee, comparator) {
        var index = -1,
            length = arrays.length;
        while (++index < length) {
          var result = result ? arrayPush(baseDifference(result, arrays[index], iteratee, comparator), baseDifference(arrays[index], result, iteratee, comparator)) : arrays[index];
        }
        return (result && result.length) ? baseUniq(result, iteratee, comparator) : [];
      }
      module.exports = baseXor;
    }, function(module, exports, __webpack_require__) {
      var isKeyable = __webpack_require__(3);
      var HASH_UNDEFINED = '__lodash_hash_undefined__';
      function cachePush(value) {
        var map = this.__data__;
        if (isKeyable(value)) {
          var data = map.__data__,
              hash = typeof value == 'string' ? data.string : data.hash;
          hash[value] = HASH_UNDEFINED;
        } else {
          map.set(value, HASH_UNDEFINED);
        }
      }
      module.exports = cachePush;
    }, function(module, exports) {
      function checkGlobal(value) {
        return (value && value.Object === Object) ? value : null;
      }
      module.exports = checkGlobal;
    }, function(module, exports, __webpack_require__) {
      var Set = __webpack_require__(72),
          noop = __webpack_require__(39);
      var createSet = !(Set && new Set([1, 2]).size === 2) ? noop : function(values) {
        return new Set(values);
      };
      module.exports = createSet;
    }, function(module, exports, __webpack_require__) {
      var baseProperty = __webpack_require__(83);
      var getLength = baseProperty('length');
      module.exports = getLength;
    }, function(module, exports) {
      var nativeGetPrototype = Object.getPrototypeOf;
      function getPrototype(value) {
        return nativeGetPrototype(Object(value));
      }
      module.exports = getPrototype;
    }, function(module, exports, __webpack_require__) {
      var hashHas = __webpack_require__(36);
      function hashDelete(hash, key) {
        return hashHas(hash, key) && delete hash[key];
      }
      module.exports = hashDelete;
    }, function(module, exports, __webpack_require__) {
      var nativeCreate = __webpack_require__(11);
      var HASH_UNDEFINED = '__lodash_hash_undefined__';
      var objectProto = Object.prototype;
      var hasOwnProperty = objectProto.hasOwnProperty;
      function hashGet(hash, key) {
        if (nativeCreate) {
          var result = hash[key];
          return result === HASH_UNDEFINED ? undefined : result;
        }
        return hasOwnProperty.call(hash, key) ? hash[key] : undefined;
      }
      module.exports = hashGet;
    }, function(module, exports, __webpack_require__) {
      var nativeCreate = __webpack_require__(11);
      var HASH_UNDEFINED = '__lodash_hash_undefined__';
      function hashSet(hash, key, value) {
        hash[key] = (nativeCreate && value === undefined) ? HASH_UNDEFINED : value;
      }
      module.exports = hashSet;
    }, function(module, exports) {
      function indexOfNaN(array, fromIndex, fromRight) {
        var length = array.length,
            index = fromIndex + (fromRight ? 0 : -1);
        while ((fromRight ? index-- : ++index < length)) {
          var other = array[index];
          if (other !== other) {
            return index;
          }
        }
        return -1;
      }
      module.exports = indexOfNaN;
    }, function(module, exports, __webpack_require__) {
      var Hash = __webpack_require__(70),
          Map = __webpack_require__(4);
      function mapClear() {
        this.__data__ = {
          'hash': new Hash,
          'map': Map ? new Map : [],
          'string': new Hash
        };
      }
      module.exports = mapClear;
    }, function(module, exports, __webpack_require__) {
      var Map = __webpack_require__(4),
          assocDelete = __webpack_require__(76),
          hashDelete = __webpack_require__(91),
          isKeyable = __webpack_require__(3);
      function mapDelete(key) {
        var data = this.__data__;
        if (isKeyable(key)) {
          return hashDelete(typeof key == 'string' ? data.string : data.hash, key);
        }
        return Map ? data.map['delete'](key) : assocDelete(data.map, key);
      }
      module.exports = mapDelete;
    }, function(module, exports, __webpack_require__) {
      var Map = __webpack_require__(4),
          assocGet = __webpack_require__(77),
          hashGet = __webpack_require__(92),
          isKeyable = __webpack_require__(3);
      function mapGet(key) {
        var data = this.__data__;
        if (isKeyable(key)) {
          return hashGet(typeof key == 'string' ? data.string : data.hash, key);
        }
        return Map ? data.map.get(key) : assocGet(data.map, key);
      }
      module.exports = mapGet;
    }, function(module, exports, __webpack_require__) {
      var Map = __webpack_require__(4),
          assocHas = __webpack_require__(78),
          hashHas = __webpack_require__(36),
          isKeyable = __webpack_require__(3);
      function mapHas(key) {
        var data = this.__data__;
        if (isKeyable(key)) {
          return hashHas(typeof key == 'string' ? data.string : data.hash, key);
        }
        return Map ? data.map.has(key) : assocHas(data.map, key);
      }
      module.exports = mapHas;
    }, function(module, exports, __webpack_require__) {
      var Map = __webpack_require__(4),
          assocSet = __webpack_require__(79),
          hashSet = __webpack_require__(93),
          isKeyable = __webpack_require__(3);
      function mapSet(key, value) {
        var data = this.__data__;
        if (isKeyable(key)) {
          hashSet(typeof key == 'string' ? data.string : data.hash, key, value);
        } else if (Map) {
          data.map.set(key, value);
        } else {
          assocSet(data.map, key, value);
        }
        return this;
      }
      module.exports = mapSet;
    }, function(module, exports) {
      function setToArray(set) {
        var index = -1,
            result = Array(set.size);
        set.forEach(function(value) {
          result[++index] = value;
        });
        return result;
      }
      module.exports = setToArray;
    }, function(module, exports) {
      function eq(value, other) {
        return value === other || (value !== value && other !== other);
      }
      module.exports = eq;
    }, function(module, exports, __webpack_require__) {
      var arrayMap = __webpack_require__(18),
          baseCastArrayLikeObject = __webpack_require__(80),
          baseIntersection = __webpack_require__(82),
          rest = __webpack_require__(24);
      var intersection = rest(function(arrays) {
        var mapped = arrayMap(arrays, baseCastArrayLikeObject);
        return (mapped.length && mapped[0] === arrays[0]) ? baseIntersection(mapped) : [];
      });
      module.exports = intersection;
    }, function(module, exports, __webpack_require__) {
      var getLength = __webpack_require__(89),
          isFunction = __webpack_require__(22),
          isLength = __webpack_require__(104);
      function isArrayLike(value) {
        return value != null && isLength(getLength(value)) && !isFunction(value);
      }
      module.exports = isArrayLike;
    }, function(module, exports) {
      var MAX_SAFE_INTEGER = 9007199254740991;
      function isLength(value) {
        return typeof value == 'number' && value > -1 && value % 1 == 0 && value <= MAX_SAFE_INTEGER;
      }
      module.exports = isLength;
    }, function(module, exports, __webpack_require__) {
      var isFunction = __webpack_require__(22),
          isHostObject = __webpack_require__(37),
          isObjectLike = __webpack_require__(12);
      var reRegExpChar = /[\\^$.*+?()[\]{}|]/g;
      var reIsHostCtor = /^\[object .+?Constructor\]$/;
      var objectProto = Object.prototype;
      var funcToString = Function.prototype.toString;
      var hasOwnProperty = objectProto.hasOwnProperty;
      var reIsNative = RegExp('^' + funcToString.call(hasOwnProperty).replace(reRegExpChar, '\\$&').replace(/hasOwnProperty|(function).*?(?=\\\()| for .+?(?=\\\])/g, '$1.*?') + '$');
      function isNative(value) {
        if (value == null) {
          return false;
        }
        if (isFunction(value)) {
          return reIsNative.test(funcToString.call(value));
        }
        return isObjectLike(value) && (isHostObject(value) ? reIsNative : reIsHostCtor).test(value);
      }
      module.exports = isNative;
    }, function(module, exports, __webpack_require__) {
      var isObjectLike = __webpack_require__(12);
      var symbolTag = '[object Symbol]';
      var objectProto = Object.prototype;
      var objectToString = objectProto.toString;
      function isSymbol(value) {
        return typeof value == 'symbol' || (isObjectLike(value) && objectToString.call(value) == symbolTag);
      }
      module.exports = isSymbol;
    }, function(module, exports, __webpack_require__) {
      var toNumber = __webpack_require__(108);
      var INFINITY = 1 / 0,
          MAX_INTEGER = 1.7976931348623157e+308;
      function toInteger(value) {
        if (!value) {
          return value === 0 ? value : 0;
        }
        value = toNumber(value);
        if (value === INFINITY || value === -INFINITY) {
          var sign = (value < 0 ? -1 : 1);
          return sign * MAX_INTEGER;
        }
        var remainder = value % 1;
        return value === value ? (remainder ? value - remainder : value) : 0;
      }
      module.exports = toInteger;
    }, function(module, exports, __webpack_require__) {
      var isFunction = __webpack_require__(22),
          isObject = __webpack_require__(23),
          isSymbol = __webpack_require__(106);
      var NAN = 0 / 0;
      var reTrim = /^\s+|\s+$/g;
      var reIsBadHex = /^[-+]0x[0-9a-f]+$/i;
      var reIsBinary = /^0b[01]+$/i;
      var reIsOctal = /^0o[0-7]+$/i;
      var freeParseInt = parseInt;
      function toNumber(value) {
        if (typeof value == 'number') {
          return value;
        }
        if (isSymbol(value)) {
          return NAN;
        }
        if (isObject(value)) {
          var other = isFunction(value.valueOf) ? value.valueOf() : value;
          value = isObject(other) ? (other + '') : other;
        }
        if (typeof value != 'string') {
          return value === 0 ? value : +value;
        }
        value = value.replace(reTrim, '');
        var isBinary = reIsBinary.test(value);
        return (isBinary || reIsOctal.test(value)) ? freeParseInt(value.slice(2), isBinary ? 2 : 8) : (reIsBadHex.test(value) ? NAN : +value);
      }
      module.exports = toNumber;
    }, function(module, exports, __webpack_require__) {
      var baseDifference = __webpack_require__(34),
          isArrayLikeObject = __webpack_require__(21),
          rest = __webpack_require__(24);
      var without = rest(function(array, values) {
        return isArrayLikeObject(array) ? baseDifference(array, values) : [];
      });
      module.exports = without;
    }, function(module, exports, __webpack_require__) {
      var arrayFilter = __webpack_require__(74),
          baseXor = __webpack_require__(85),
          isArrayLikeObject = __webpack_require__(21),
          rest = __webpack_require__(24);
      var xor = rest(function(arrays) {
        return baseXor(arrayFilter(arrays, isArrayLikeObject));
      });
      module.exports = xor;
    }, function(module, exports, __webpack_require__) {
      'use strict';
      exports.__esModule = true;
      exports.ActionTypes = undefined;
      exports["default"] = createStore;
      var _isPlainObject = __webpack_require__(2);
      var _isPlainObject2 = _interopRequireDefault(_isPlainObject);
      function _interopRequireDefault(obj) {
        return obj && obj.__esModule ? obj : {"default": obj};
      }
      var ActionTypes = exports.ActionTypes = {INIT: '@@redux/INIT'};
      function createStore(reducer, initialState, enhancer) {
        if (typeof initialState === 'function' && typeof enhancer === 'undefined') {
          enhancer = initialState;
          initialState = undefined;
        }
        if (typeof enhancer !== 'undefined') {
          if (typeof enhancer !== 'function') {
            throw new Error('Expected the enhancer to be a function.');
          }
          return enhancer(createStore)(reducer, initialState);
        }
        if (typeof reducer !== 'function') {
          throw new Error('Expected the reducer to be a function.');
        }
        var currentReducer = reducer;
        var currentState = initialState;
        var currentListeners = [];
        var nextListeners = currentListeners;
        var isDispatching = false;
        function ensureCanMutateNextListeners() {
          if (nextListeners === currentListeners) {
            nextListeners = currentListeners.slice();
          }
        }
        function getState() {
          return currentState;
        }
        function subscribe(listener) {
          if (typeof listener !== 'function') {
            throw new Error('Expected listener to be a function.');
          }
          var isSubscribed = true;
          ensureCanMutateNextListeners();
          nextListeners.push(listener);
          return function unsubscribe() {
            if (!isSubscribed) {
              return;
            }
            isSubscribed = false;
            ensureCanMutateNextListeners();
            var index = nextListeners.indexOf(listener);
            nextListeners.splice(index, 1);
          };
        }
        function dispatch(action) {
          if (!(0, _isPlainObject2["default"])(action)) {
            throw new Error('Actions must be plain objects. ' + 'Use custom middleware for async actions.');
          }
          if (typeof action.type === 'undefined') {
            throw new Error('Actions may not have an undefined "type" property. ' + 'Have you misspelled a constant?');
          }
          if (isDispatching) {
            throw new Error('Reducers may not dispatch actions.');
          }
          try {
            isDispatching = true;
            currentState = currentReducer(currentState, action);
          } finally {
            isDispatching = false;
          }
          var listeners = currentListeners = nextListeners;
          for (var i = 0; i < listeners.length; i++) {
            listeners[i]();
          }
          return action;
        }
        function replaceReducer(nextReducer) {
          if (typeof nextReducer !== 'function') {
            throw new Error('Expected the nextReducer to be a function.');
          }
          currentReducer = nextReducer;
          dispatch({type: ActionTypes.INIT});
        }
        dispatch({type: ActionTypes.INIT});
        return {
          dispatch: dispatch,
          subscribe: subscribe,
          getState: getState,
          replaceReducer: replaceReducer
        };
      }
    }, function(module, exports) {
      module.exports = function(module) {
        if (!module.webpackPolyfill) {
          module.deprecate = function() {};
          module.paths = [];
          module.children = [];
          module.webpackPolyfill = 1;
        }
        return module;
      };
    }]);
  });
  ;
})(require('process'));
