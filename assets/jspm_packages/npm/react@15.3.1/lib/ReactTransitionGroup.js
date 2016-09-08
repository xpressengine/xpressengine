/* */ 
(function(process) {
  'use strict';
  var _assign = require('object-assign');
  var React = require('./React');
  var ReactInstanceMap = require('./ReactInstanceMap');
  var ReactTransitionChildMapping = require('./ReactTransitionChildMapping');
  var emptyFunction = require('fbjs/lib/emptyFunction');
  var ReactTransitionGroup = React.createClass({
    displayName: 'ReactTransitionGroup',
    propTypes: {
      component: React.PropTypes.any,
      childFactory: React.PropTypes.func
    },
    getDefaultProps: function() {
      return {
        component: 'span',
        childFactory: emptyFunction.thatReturnsArgument
      };
    },
    getInitialState: function() {
      return {children: ReactTransitionChildMapping.getChildMapping(this.props.children)};
    },
    componentWillMount: function() {
      this.currentlyTransitioningKeys = {};
      this.keysToEnter = [];
      this.keysToLeave = [];
    },
    componentDidMount: function() {
      var initialChildMapping = this.state.children;
      for (var key in initialChildMapping) {
        if (initialChildMapping[key]) {
          this.performAppear(key);
        }
      }
    },
    componentWillReceiveProps: function(nextProps) {
      var nextChildMapping;
      if (process.env.NODE_ENV !== 'production') {
        nextChildMapping = ReactTransitionChildMapping.getChildMapping(nextProps.children, ReactInstanceMap.get(this)._debugID);
      } else {
        nextChildMapping = ReactTransitionChildMapping.getChildMapping(nextProps.children);
      }
      var prevChildMapping = this.state.children;
      this.setState({children: ReactTransitionChildMapping.mergeChildMappings(prevChildMapping, nextChildMapping)});
      var key;
      for (key in nextChildMapping) {
        var hasPrev = prevChildMapping && prevChildMapping.hasOwnProperty(key);
        if (nextChildMapping[key] && !hasPrev && !this.currentlyTransitioningKeys[key]) {
          this.keysToEnter.push(key);
        }
      }
      for (key in prevChildMapping) {
        var hasNext = nextChildMapping && nextChildMapping.hasOwnProperty(key);
        if (prevChildMapping[key] && !hasNext && !this.currentlyTransitioningKeys[key]) {
          this.keysToLeave.push(key);
        }
      }
    },
    componentDidUpdate: function() {
      var keysToEnter = this.keysToEnter;
      this.keysToEnter = [];
      keysToEnter.forEach(this.performEnter);
      var keysToLeave = this.keysToLeave;
      this.keysToLeave = [];
      keysToLeave.forEach(this.performLeave);
    },
    performAppear: function(key) {
      this.currentlyTransitioningKeys[key] = true;
      var component = this.refs[key];
      if (component.componentWillAppear) {
        component.componentWillAppear(this._handleDoneAppearing.bind(this, key));
      } else {
        this._handleDoneAppearing(key);
      }
    },
    _handleDoneAppearing: function(key) {
      var component = this.refs[key];
      if (component.componentDidAppear) {
        component.componentDidAppear();
      }
      delete this.currentlyTransitioningKeys[key];
      var currentChildMapping;
      if (process.env.NODE_ENV !== 'production') {
        currentChildMapping = ReactTransitionChildMapping.getChildMapping(this.props.children, ReactInstanceMap.get(this)._debugID);
      } else {
        currentChildMapping = ReactTransitionChildMapping.getChildMapping(this.props.children);
      }
      if (!currentChildMapping || !currentChildMapping.hasOwnProperty(key)) {
        this.performLeave(key);
      }
    },
    performEnter: function(key) {
      this.currentlyTransitioningKeys[key] = true;
      var component = this.refs[key];
      if (component.componentWillEnter) {
        component.componentWillEnter(this._handleDoneEntering.bind(this, key));
      } else {
        this._handleDoneEntering(key);
      }
    },
    _handleDoneEntering: function(key) {
      var component = this.refs[key];
      if (component.componentDidEnter) {
        component.componentDidEnter();
      }
      delete this.currentlyTransitioningKeys[key];
      var currentChildMapping;
      if (process.env.NODE_ENV !== 'production') {
        currentChildMapping = ReactTransitionChildMapping.getChildMapping(this.props.children, ReactInstanceMap.get(this)._debugID);
      } else {
        currentChildMapping = ReactTransitionChildMapping.getChildMapping(this.props.children);
      }
      if (!currentChildMapping || !currentChildMapping.hasOwnProperty(key)) {
        this.performLeave(key);
      }
    },
    performLeave: function(key) {
      this.currentlyTransitioningKeys[key] = true;
      var component = this.refs[key];
      if (component.componentWillLeave) {
        component.componentWillLeave(this._handleDoneLeaving.bind(this, key));
      } else {
        this._handleDoneLeaving(key);
      }
    },
    _handleDoneLeaving: function(key) {
      var component = this.refs[key];
      if (component.componentDidLeave) {
        component.componentDidLeave();
      }
      delete this.currentlyTransitioningKeys[key];
      var currentChildMapping;
      if (process.env.NODE_ENV !== 'production') {
        currentChildMapping = ReactTransitionChildMapping.getChildMapping(this.props.children, ReactInstanceMap.get(this)._debugID);
      } else {
        currentChildMapping = ReactTransitionChildMapping.getChildMapping(this.props.children);
      }
      if (currentChildMapping && currentChildMapping.hasOwnProperty(key)) {
        this.performEnter(key);
      } else {
        this.setState(function(state) {
          var newChildren = _assign({}, state.children);
          delete newChildren[key];
          return {children: newChildren};
        });
      }
    },
    render: function() {
      var childrenToRender = [];
      for (var key in this.state.children) {
        var child = this.state.children[key];
        if (child) {
          childrenToRender.push(React.cloneElement(this.props.childFactory(child), {
            ref: key,
            key: key
          }));
        }
      }
      var props = _assign({}, this.props);
      delete props.transitionLeave;
      delete props.transitionName;
      delete props.transitionAppear;
      delete props.transitionEnter;
      delete props.childFactory;
      delete props.transitionLeaveTimeout;
      delete props.transitionEnterTimeout;
      delete props.transitionAppearTimeout;
      delete props.component;
      return React.createElement(this.props.component, props, childrenToRender);
    }
  });
  module.exports = ReactTransitionGroup;
})(require('process'));
