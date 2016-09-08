/* */ 
(function(process) {
  'use strict';
  var _prodInvariant = require('./reactProdInvariant'),
      _assign = require('object-assign');
  var ReactComponentEnvironment = require('./ReactComponentEnvironment');
  var ReactCurrentOwner = require('./ReactCurrentOwner');
  var ReactElement = require('./ReactElement');
  var ReactErrorUtils = require('./ReactErrorUtils');
  var ReactInstanceMap = require('./ReactInstanceMap');
  var ReactInstrumentation = require('./ReactInstrumentation');
  var ReactNodeTypes = require('./ReactNodeTypes');
  var ReactPropTypeLocations = require('./ReactPropTypeLocations');
  var ReactReconciler = require('./ReactReconciler');
  var checkReactTypeSpec = require('./checkReactTypeSpec');
  var emptyObject = require('fbjs/lib/emptyObject');
  var invariant = require('fbjs/lib/invariant');
  var shallowEqual = require('fbjs/lib/shallowEqual');
  var shouldUpdateReactComponent = require('./shouldUpdateReactComponent');
  var warning = require('fbjs/lib/warning');
  var CompositeTypes = {
    ImpureClass: 0,
    PureClass: 1,
    StatelessFunctional: 2
  };
  function StatelessComponent(Component) {}
  StatelessComponent.prototype.render = function() {
    var Component = ReactInstanceMap.get(this)._currentElement.type;
    var element = Component(this.props, this.context, this.updater);
    warnIfInvalidElement(Component, element);
    return element;
  };
  function warnIfInvalidElement(Component, element) {
    if (process.env.NODE_ENV !== 'production') {
      process.env.NODE_ENV !== 'production' ? warning(element === null || element === false || ReactElement.isValidElement(element), '%s(...): A valid React element (or null) must be returned. You may have ' + 'returned undefined, an array or some other invalid object.', Component.displayName || Component.name || 'Component') : void 0;
      process.env.NODE_ENV !== 'production' ? warning(!Component.childContextTypes, '%s(...): childContextTypes cannot be defined on a functional component.', Component.displayName || Component.name || 'Component') : void 0;
    }
  }
  function invokeComponentDidMountWithTimer() {
    var publicInstance = this._instance;
    if (this._debugID !== 0) {
      ReactInstrumentation.debugTool.onBeginLifeCycleTimer(this._debugID, 'componentDidMount');
    }
    publicInstance.componentDidMount();
    if (this._debugID !== 0) {
      ReactInstrumentation.debugTool.onEndLifeCycleTimer(this._debugID, 'componentDidMount');
    }
  }
  function invokeComponentDidUpdateWithTimer(prevProps, prevState, prevContext) {
    var publicInstance = this._instance;
    if (this._debugID !== 0) {
      ReactInstrumentation.debugTool.onBeginLifeCycleTimer(this._debugID, 'componentDidUpdate');
    }
    publicInstance.componentDidUpdate(prevProps, prevState, prevContext);
    if (this._debugID !== 0) {
      ReactInstrumentation.debugTool.onEndLifeCycleTimer(this._debugID, 'componentDidUpdate');
    }
  }
  function shouldConstruct(Component) {
    return !!(Component.prototype && Component.prototype.isReactComponent);
  }
  function isPureComponent(Component) {
    return !!(Component.prototype && Component.prototype.isPureReactComponent);
  }
  var nextMountID = 1;
  var ReactCompositeComponentMixin = {
    construct: function(element) {
      this._currentElement = element;
      this._rootNodeID = 0;
      this._compositeType = null;
      this._instance = null;
      this._hostParent = null;
      this._hostContainerInfo = null;
      this._updateBatchNumber = null;
      this._pendingElement = null;
      this._pendingStateQueue = null;
      this._pendingReplaceState = false;
      this._pendingForceUpdate = false;
      this._renderedNodeType = null;
      this._renderedComponent = null;
      this._context = null;
      this._mountOrder = 0;
      this._topLevelWrapper = null;
      this._pendingCallbacks = null;
      this._calledComponentWillUnmount = false;
      if (process.env.NODE_ENV !== 'production') {
        this._warnedAboutRefsInRender = false;
      }
    },
    mountComponent: function(transaction, hostParent, hostContainerInfo, context) {
      this._context = context;
      this._mountOrder = nextMountID++;
      this._hostParent = hostParent;
      this._hostContainerInfo = hostContainerInfo;
      var publicProps = this._currentElement.props;
      var publicContext = this._processContext(context);
      var Component = this._currentElement.type;
      var updateQueue = transaction.getUpdateQueue();
      var doConstruct = shouldConstruct(Component);
      var inst = this._constructComponent(doConstruct, publicProps, publicContext, updateQueue);
      var renderedElement;
      if (!doConstruct && (inst == null || inst.render == null)) {
        renderedElement = inst;
        warnIfInvalidElement(Component, renderedElement);
        !(inst === null || inst === false || ReactElement.isValidElement(inst)) ? process.env.NODE_ENV !== 'production' ? invariant(false, '%s(...): A valid React element (or null) must be returned. You may have returned undefined, an array or some other invalid object.', Component.displayName || Component.name || 'Component') : _prodInvariant('105', Component.displayName || Component.name || 'Component') : void 0;
        inst = new StatelessComponent(Component);
        this._compositeType = CompositeTypes.StatelessFunctional;
      } else {
        if (isPureComponent(Component)) {
          this._compositeType = CompositeTypes.PureClass;
        } else {
          this._compositeType = CompositeTypes.ImpureClass;
        }
      }
      if (process.env.NODE_ENV !== 'production') {
        if (inst.render == null) {
          process.env.NODE_ENV !== 'production' ? warning(false, '%s(...): No `render` method found on the returned component ' + 'instance: you may have forgotten to define `render`.', Component.displayName || Component.name || 'Component') : void 0;
        }
        var propsMutated = inst.props !== publicProps;
        var componentName = Component.displayName || Component.name || 'Component';
        process.env.NODE_ENV !== 'production' ? warning(inst.props === undefined || !propsMutated, '%s(...): When calling super() in `%s`, make sure to pass ' + 'up the same props that your component\'s constructor was passed.', componentName, componentName) : void 0;
      }
      inst.props = publicProps;
      inst.context = publicContext;
      inst.refs = emptyObject;
      inst.updater = updateQueue;
      this._instance = inst;
      ReactInstanceMap.set(inst, this);
      if (process.env.NODE_ENV !== 'production') {
        process.env.NODE_ENV !== 'production' ? warning(!inst.getInitialState || inst.getInitialState.isReactClassApproved, 'getInitialState was defined on %s, a plain JavaScript class. ' + 'This is only supported for classes created using React.createClass. ' + 'Did you mean to define a state property instead?', this.getName() || 'a component') : void 0;
        process.env.NODE_ENV !== 'production' ? warning(!inst.getDefaultProps || inst.getDefaultProps.isReactClassApproved, 'getDefaultProps was defined on %s, a plain JavaScript class. ' + 'This is only supported for classes created using React.createClass. ' + 'Use a static property to define defaultProps instead.', this.getName() || 'a component') : void 0;
        process.env.NODE_ENV !== 'production' ? warning(!inst.propTypes, 'propTypes was defined as an instance property on %s. Use a static ' + 'property to define propTypes instead.', this.getName() || 'a component') : void 0;
        process.env.NODE_ENV !== 'production' ? warning(!inst.contextTypes, 'contextTypes was defined as an instance property on %s. Use a ' + 'static property to define contextTypes instead.', this.getName() || 'a component') : void 0;
        process.env.NODE_ENV !== 'production' ? warning(typeof inst.componentShouldUpdate !== 'function', '%s has a method called ' + 'componentShouldUpdate(). Did you mean shouldComponentUpdate()? ' + 'The name is phrased as a question because the function is ' + 'expected to return a value.', this.getName() || 'A component') : void 0;
        process.env.NODE_ENV !== 'production' ? warning(typeof inst.componentDidUnmount !== 'function', '%s has a method called ' + 'componentDidUnmount(). But there is no such lifecycle method. ' + 'Did you mean componentWillUnmount()?', this.getName() || 'A component') : void 0;
        process.env.NODE_ENV !== 'production' ? warning(typeof inst.componentWillRecieveProps !== 'function', '%s has a method called ' + 'componentWillRecieveProps(). Did you mean componentWillReceiveProps()?', this.getName() || 'A component') : void 0;
      }
      var initialState = inst.state;
      if (initialState === undefined) {
        inst.state = initialState = null;
      }
      !(typeof initialState === 'object' && !Array.isArray(initialState)) ? process.env.NODE_ENV !== 'production' ? invariant(false, '%s.state: must be set to an object or null', this.getName() || 'ReactCompositeComponent') : _prodInvariant('106', this.getName() || 'ReactCompositeComponent') : void 0;
      this._pendingStateQueue = null;
      this._pendingReplaceState = false;
      this._pendingForceUpdate = false;
      var markup;
      if (inst.unstable_handleError) {
        markup = this.performInitialMountWithErrorHandling(renderedElement, hostParent, hostContainerInfo, transaction, context);
      } else {
        markup = this.performInitialMount(renderedElement, hostParent, hostContainerInfo, transaction, context);
      }
      if (inst.componentDidMount) {
        if (process.env.NODE_ENV !== 'production') {
          transaction.getReactMountReady().enqueue(invokeComponentDidMountWithTimer, this);
        } else {
          transaction.getReactMountReady().enqueue(inst.componentDidMount, inst);
        }
      }
      return markup;
    },
    _constructComponent: function(doConstruct, publicProps, publicContext, updateQueue) {
      if (process.env.NODE_ENV !== 'production') {
        ReactCurrentOwner.current = this;
        try {
          return this._constructComponentWithoutOwner(doConstruct, publicProps, publicContext, updateQueue);
        } finally {
          ReactCurrentOwner.current = null;
        }
      } else {
        return this._constructComponentWithoutOwner(doConstruct, publicProps, publicContext, updateQueue);
      }
    },
    _constructComponentWithoutOwner: function(doConstruct, publicProps, publicContext, updateQueue) {
      var Component = this._currentElement.type;
      var instanceOrElement;
      if (doConstruct) {
        if (process.env.NODE_ENV !== 'production') {
          if (this._debugID !== 0) {
            ReactInstrumentation.debugTool.onBeginLifeCycleTimer(this._debugID, 'ctor');
          }
        }
        instanceOrElement = new Component(publicProps, publicContext, updateQueue);
        if (process.env.NODE_ENV !== 'production') {
          if (this._debugID !== 0) {
            ReactInstrumentation.debugTool.onEndLifeCycleTimer(this._debugID, 'ctor');
          }
        }
      } else {
        if (process.env.NODE_ENV !== 'production') {
          if (this._debugID !== 0) {
            ReactInstrumentation.debugTool.onBeginLifeCycleTimer(this._debugID, 'render');
          }
        }
        instanceOrElement = Component(publicProps, publicContext, updateQueue);
        if (process.env.NODE_ENV !== 'production') {
          if (this._debugID !== 0) {
            ReactInstrumentation.debugTool.onEndLifeCycleTimer(this._debugID, 'render');
          }
        }
      }
      return instanceOrElement;
    },
    performInitialMountWithErrorHandling: function(renderedElement, hostParent, hostContainerInfo, transaction, context) {
      var markup;
      var checkpoint = transaction.checkpoint();
      try {
        markup = this.performInitialMount(renderedElement, hostParent, hostContainerInfo, transaction, context);
      } catch (e) {
        if (process.env.NODE_ENV !== 'production') {
          if (this._debugID !== 0) {
            ReactInstrumentation.debugTool.onError();
          }
        }
        transaction.rollback(checkpoint);
        this._instance.unstable_handleError(e);
        if (this._pendingStateQueue) {
          this._instance.state = this._processPendingState(this._instance.props, this._instance.context);
        }
        checkpoint = transaction.checkpoint();
        this._renderedComponent.unmountComponent(true);
        transaction.rollback(checkpoint);
        markup = this.performInitialMount(renderedElement, hostParent, hostContainerInfo, transaction, context);
      }
      return markup;
    },
    performInitialMount: function(renderedElement, hostParent, hostContainerInfo, transaction, context) {
      var inst = this._instance;
      if (inst.componentWillMount) {
        if (process.env.NODE_ENV !== 'production') {
          if (this._debugID !== 0) {
            ReactInstrumentation.debugTool.onBeginLifeCycleTimer(this._debugID, 'componentWillMount');
          }
        }
        inst.componentWillMount();
        if (process.env.NODE_ENV !== 'production') {
          if (this._debugID !== 0) {
            ReactInstrumentation.debugTool.onEndLifeCycleTimer(this._debugID, 'componentWillMount');
          }
        }
        if (this._pendingStateQueue) {
          inst.state = this._processPendingState(inst.props, inst.context);
        }
      }
      if (renderedElement === undefined) {
        renderedElement = this._renderValidatedComponent();
      }
      var nodeType = ReactNodeTypes.getType(renderedElement);
      this._renderedNodeType = nodeType;
      var child = this._instantiateReactComponent(renderedElement, nodeType !== ReactNodeTypes.EMPTY);
      this._renderedComponent = child;
      var selfDebugID = 0;
      if (process.env.NODE_ENV !== 'production') {
        selfDebugID = this._debugID;
      }
      var markup = ReactReconciler.mountComponent(child, transaction, hostParent, hostContainerInfo, this._processChildContext(context), selfDebugID);
      if (process.env.NODE_ENV !== 'production') {
        if (this._debugID !== 0) {
          ReactInstrumentation.debugTool.onSetChildren(this._debugID, child._debugID !== 0 ? [child._debugID] : []);
        }
      }
      return markup;
    },
    getHostNode: function() {
      return ReactReconciler.getHostNode(this._renderedComponent);
    },
    unmountComponent: function(safely) {
      if (!this._renderedComponent) {
        return;
      }
      var inst = this._instance;
      if (inst.componentWillUnmount && !inst._calledComponentWillUnmount) {
        inst._calledComponentWillUnmount = true;
        if (process.env.NODE_ENV !== 'production') {
          if (this._debugID !== 0) {
            ReactInstrumentation.debugTool.onBeginLifeCycleTimer(this._debugID, 'componentWillUnmount');
          }
        }
        if (safely) {
          var name = this.getName() + '.componentWillUnmount()';
          ReactErrorUtils.invokeGuardedCallback(name, inst.componentWillUnmount.bind(inst));
        } else {
          inst.componentWillUnmount();
        }
        if (process.env.NODE_ENV !== 'production') {
          if (this._debugID !== 0) {
            ReactInstrumentation.debugTool.onEndLifeCycleTimer(this._debugID, 'componentWillUnmount');
          }
        }
      }
      if (this._renderedComponent) {
        ReactReconciler.unmountComponent(this._renderedComponent, safely);
        this._renderedNodeType = null;
        this._renderedComponent = null;
        this._instance = null;
      }
      this._pendingStateQueue = null;
      this._pendingReplaceState = false;
      this._pendingForceUpdate = false;
      this._pendingCallbacks = null;
      this._pendingElement = null;
      this._context = null;
      this._rootNodeID = 0;
      this._topLevelWrapper = null;
      ReactInstanceMap.remove(inst);
    },
    _maskContext: function(context) {
      var Component = this._currentElement.type;
      var contextTypes = Component.contextTypes;
      if (!contextTypes) {
        return emptyObject;
      }
      var maskedContext = {};
      for (var contextName in contextTypes) {
        maskedContext[contextName] = context[contextName];
      }
      return maskedContext;
    },
    _processContext: function(context) {
      var maskedContext = this._maskContext(context);
      if (process.env.NODE_ENV !== 'production') {
        var Component = this._currentElement.type;
        if (Component.contextTypes) {
          this._checkContextTypes(Component.contextTypes, maskedContext, ReactPropTypeLocations.context);
        }
      }
      return maskedContext;
    },
    _processChildContext: function(currentContext) {
      var Component = this._currentElement.type;
      var inst = this._instance;
      if (process.env.NODE_ENV !== 'production') {
        ReactInstrumentation.debugTool.onBeginProcessingChildContext();
      }
      var childContext = inst.getChildContext && inst.getChildContext();
      if (process.env.NODE_ENV !== 'production') {
        ReactInstrumentation.debugTool.onEndProcessingChildContext();
      }
      if (childContext) {
        !(typeof Component.childContextTypes === 'object') ? process.env.NODE_ENV !== 'production' ? invariant(false, '%s.getChildContext(): childContextTypes must be defined in order to use getChildContext().', this.getName() || 'ReactCompositeComponent') : _prodInvariant('107', this.getName() || 'ReactCompositeComponent') : void 0;
        if (process.env.NODE_ENV !== 'production') {
          this._checkContextTypes(Component.childContextTypes, childContext, ReactPropTypeLocations.childContext);
        }
        for (var name in childContext) {
          !(name in Component.childContextTypes) ? process.env.NODE_ENV !== 'production' ? invariant(false, '%s.getChildContext(): key "%s" is not defined in childContextTypes.', this.getName() || 'ReactCompositeComponent', name) : _prodInvariant('108', this.getName() || 'ReactCompositeComponent', name) : void 0;
        }
        return _assign({}, currentContext, childContext);
      }
      return currentContext;
    },
    _checkContextTypes: function(typeSpecs, values, location) {
      checkReactTypeSpec(typeSpecs, values, location, this.getName(), null, this._debugID);
    },
    receiveComponent: function(nextElement, transaction, nextContext) {
      var prevElement = this._currentElement;
      var prevContext = this._context;
      this._pendingElement = null;
      this.updateComponent(transaction, prevElement, nextElement, prevContext, nextContext);
    },
    performUpdateIfNecessary: function(transaction) {
      if (this._pendingElement != null) {
        ReactReconciler.receiveComponent(this, this._pendingElement, transaction, this._context);
      } else if (this._pendingStateQueue !== null || this._pendingForceUpdate) {
        this.updateComponent(transaction, this._currentElement, this._currentElement, this._context, this._context);
      } else {
        this._updateBatchNumber = null;
      }
    },
    updateComponent: function(transaction, prevParentElement, nextParentElement, prevUnmaskedContext, nextUnmaskedContext) {
      var inst = this._instance;
      !(inst != null) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'Attempted to update component `%s` that has already been unmounted (or failed to mount).', this.getName() || 'ReactCompositeComponent') : _prodInvariant('136', this.getName() || 'ReactCompositeComponent') : void 0;
      var willReceive = false;
      var nextContext;
      if (this._context === nextUnmaskedContext) {
        nextContext = inst.context;
      } else {
        nextContext = this._processContext(nextUnmaskedContext);
        willReceive = true;
      }
      var prevProps = prevParentElement.props;
      var nextProps = nextParentElement.props;
      if (prevParentElement !== nextParentElement) {
        willReceive = true;
      }
      if (willReceive && inst.componentWillReceiveProps) {
        if (process.env.NODE_ENV !== 'production') {
          if (this._debugID !== 0) {
            ReactInstrumentation.debugTool.onBeginLifeCycleTimer(this._debugID, 'componentWillReceiveProps');
          }
        }
        inst.componentWillReceiveProps(nextProps, nextContext);
        if (process.env.NODE_ENV !== 'production') {
          if (this._debugID !== 0) {
            ReactInstrumentation.debugTool.onEndLifeCycleTimer(this._debugID, 'componentWillReceiveProps');
          }
        }
      }
      var nextState = this._processPendingState(nextProps, nextContext);
      var shouldUpdate = true;
      if (!this._pendingForceUpdate) {
        if (inst.shouldComponentUpdate) {
          if (process.env.NODE_ENV !== 'production') {
            if (this._debugID !== 0) {
              ReactInstrumentation.debugTool.onBeginLifeCycleTimer(this._debugID, 'shouldComponentUpdate');
            }
          }
          shouldUpdate = inst.shouldComponentUpdate(nextProps, nextState, nextContext);
          if (process.env.NODE_ENV !== 'production') {
            if (this._debugID !== 0) {
              ReactInstrumentation.debugTool.onEndLifeCycleTimer(this._debugID, 'shouldComponentUpdate');
            }
          }
        } else {
          if (this._compositeType === CompositeTypes.PureClass) {
            shouldUpdate = !shallowEqual(prevProps, nextProps) || !shallowEqual(inst.state, nextState);
          }
        }
      }
      if (process.env.NODE_ENV !== 'production') {
        process.env.NODE_ENV !== 'production' ? warning(shouldUpdate !== undefined, '%s.shouldComponentUpdate(): Returned undefined instead of a ' + 'boolean value. Make sure to return true or false.', this.getName() || 'ReactCompositeComponent') : void 0;
      }
      this._updateBatchNumber = null;
      if (shouldUpdate) {
        this._pendingForceUpdate = false;
        this._performComponentUpdate(nextParentElement, nextProps, nextState, nextContext, transaction, nextUnmaskedContext);
      } else {
        this._currentElement = nextParentElement;
        this._context = nextUnmaskedContext;
        inst.props = nextProps;
        inst.state = nextState;
        inst.context = nextContext;
      }
    },
    _processPendingState: function(props, context) {
      var inst = this._instance;
      var queue = this._pendingStateQueue;
      var replace = this._pendingReplaceState;
      this._pendingReplaceState = false;
      this._pendingStateQueue = null;
      if (!queue) {
        return inst.state;
      }
      if (replace && queue.length === 1) {
        return queue[0];
      }
      var nextState = _assign({}, replace ? queue[0] : inst.state);
      for (var i = replace ? 1 : 0; i < queue.length; i++) {
        var partial = queue[i];
        _assign(nextState, typeof partial === 'function' ? partial.call(inst, nextState, props, context) : partial);
      }
      return nextState;
    },
    _performComponentUpdate: function(nextElement, nextProps, nextState, nextContext, transaction, unmaskedContext) {
      var inst = this._instance;
      var hasComponentDidUpdate = Boolean(inst.componentDidUpdate);
      var prevProps;
      var prevState;
      var prevContext;
      if (hasComponentDidUpdate) {
        prevProps = inst.props;
        prevState = inst.state;
        prevContext = inst.context;
      }
      if (inst.componentWillUpdate) {
        if (process.env.NODE_ENV !== 'production') {
          if (this._debugID !== 0) {
            ReactInstrumentation.debugTool.onBeginLifeCycleTimer(this._debugID, 'componentWillUpdate');
          }
        }
        inst.componentWillUpdate(nextProps, nextState, nextContext);
        if (process.env.NODE_ENV !== 'production') {
          if (this._debugID !== 0) {
            ReactInstrumentation.debugTool.onEndLifeCycleTimer(this._debugID, 'componentWillUpdate');
          }
        }
      }
      this._currentElement = nextElement;
      this._context = unmaskedContext;
      inst.props = nextProps;
      inst.state = nextState;
      inst.context = nextContext;
      this._updateRenderedComponent(transaction, unmaskedContext);
      if (hasComponentDidUpdate) {
        if (process.env.NODE_ENV !== 'production') {
          transaction.getReactMountReady().enqueue(invokeComponentDidUpdateWithTimer.bind(this, prevProps, prevState, prevContext), this);
        } else {
          transaction.getReactMountReady().enqueue(inst.componentDidUpdate.bind(inst, prevProps, prevState, prevContext), inst);
        }
      }
    },
    _updateRenderedComponent: function(transaction, context) {
      var prevComponentInstance = this._renderedComponent;
      var prevRenderedElement = prevComponentInstance._currentElement;
      var nextRenderedElement = this._renderValidatedComponent();
      if (shouldUpdateReactComponent(prevRenderedElement, nextRenderedElement)) {
        ReactReconciler.receiveComponent(prevComponentInstance, nextRenderedElement, transaction, this._processChildContext(context));
      } else {
        var oldHostNode = ReactReconciler.getHostNode(prevComponentInstance);
        ReactReconciler.unmountComponent(prevComponentInstance, false);
        var nodeType = ReactNodeTypes.getType(nextRenderedElement);
        this._renderedNodeType = nodeType;
        var child = this._instantiateReactComponent(nextRenderedElement, nodeType !== ReactNodeTypes.EMPTY);
        this._renderedComponent = child;
        var selfDebugID = 0;
        if (process.env.NODE_ENV !== 'production') {
          selfDebugID = this._debugID;
        }
        var nextMarkup = ReactReconciler.mountComponent(child, transaction, this._hostParent, this._hostContainerInfo, this._processChildContext(context), selfDebugID);
        if (process.env.NODE_ENV !== 'production') {
          if (this._debugID !== 0) {
            ReactInstrumentation.debugTool.onSetChildren(this._debugID, child._debugID !== 0 ? [child._debugID] : []);
          }
        }
        this._replaceNodeWithMarkup(oldHostNode, nextMarkup, prevComponentInstance);
      }
    },
    _replaceNodeWithMarkup: function(oldHostNode, nextMarkup, prevInstance) {
      ReactComponentEnvironment.replaceNodeWithMarkup(oldHostNode, nextMarkup, prevInstance);
    },
    _renderValidatedComponentWithoutOwnerOrContext: function() {
      var inst = this._instance;
      if (process.env.NODE_ENV !== 'production') {
        if (this._debugID !== 0) {
          ReactInstrumentation.debugTool.onBeginLifeCycleTimer(this._debugID, 'render');
        }
      }
      var renderedComponent = inst.render();
      if (process.env.NODE_ENV !== 'production') {
        if (this._debugID !== 0) {
          ReactInstrumentation.debugTool.onEndLifeCycleTimer(this._debugID, 'render');
        }
      }
      if (process.env.NODE_ENV !== 'production') {
        if (renderedComponent === undefined && inst.render._isMockFunction) {
          renderedComponent = null;
        }
      }
      return renderedComponent;
    },
    _renderValidatedComponent: function() {
      var renderedComponent;
      if (process.env.NODE_ENV !== 'production' || this._compositeType !== CompositeTypes.StatelessFunctional) {
        ReactCurrentOwner.current = this;
        try {
          renderedComponent = this._renderValidatedComponentWithoutOwnerOrContext();
        } finally {
          ReactCurrentOwner.current = null;
        }
      } else {
        renderedComponent = this._renderValidatedComponentWithoutOwnerOrContext();
      }
      !(renderedComponent === null || renderedComponent === false || ReactElement.isValidElement(renderedComponent)) ? process.env.NODE_ENV !== 'production' ? invariant(false, '%s.render(): A valid React element (or null) must be returned. You may have returned undefined, an array or some other invalid object.', this.getName() || 'ReactCompositeComponent') : _prodInvariant('109', this.getName() || 'ReactCompositeComponent') : void 0;
      return renderedComponent;
    },
    attachRef: function(ref, component) {
      var inst = this.getPublicInstance();
      !(inst != null) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'Stateless function components cannot have refs.') : _prodInvariant('110') : void 0;
      var publicComponentInstance = component.getPublicInstance();
      if (process.env.NODE_ENV !== 'production') {
        var componentName = component && component.getName ? component.getName() : 'a component';
        process.env.NODE_ENV !== 'production' ? warning(publicComponentInstance != null, 'Stateless function components cannot be given refs ' + '(See ref "%s" in %s created by %s). ' + 'Attempts to access this ref will fail.', ref, componentName, this.getName()) : void 0;
      }
      var refs = inst.refs === emptyObject ? inst.refs = {} : inst.refs;
      refs[ref] = publicComponentInstance;
    },
    detachRef: function(ref) {
      var refs = this.getPublicInstance().refs;
      delete refs[ref];
    },
    getName: function() {
      var type = this._currentElement.type;
      var constructor = this._instance && this._instance.constructor;
      return type.displayName || constructor && constructor.displayName || type.name || constructor && constructor.name || null;
    },
    getPublicInstance: function() {
      var inst = this._instance;
      if (this._compositeType === CompositeTypes.StatelessFunctional) {
        return null;
      }
      return inst;
    },
    _instantiateReactComponent: null
  };
  var ReactCompositeComponent = {Mixin: ReactCompositeComponentMixin};
  module.exports = ReactCompositeComponent;
})(require('process'));
