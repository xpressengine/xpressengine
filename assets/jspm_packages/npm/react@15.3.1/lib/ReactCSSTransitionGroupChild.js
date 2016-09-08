/* */ 
'use strict';
var React = require('./React');
var ReactDOM = require('./ReactDOM');
var CSSCore = require('fbjs/lib/CSSCore');
var ReactTransitionEvents = require('./ReactTransitionEvents');
var onlyChild = require('./onlyChild');
var TICK = 17;
var ReactCSSTransitionGroupChild = React.createClass({
  displayName: 'ReactCSSTransitionGroupChild',
  propTypes: {
    name: React.PropTypes.oneOfType([React.PropTypes.string, React.PropTypes.shape({
      enter: React.PropTypes.string,
      leave: React.PropTypes.string,
      active: React.PropTypes.string
    }), React.PropTypes.shape({
      enter: React.PropTypes.string,
      enterActive: React.PropTypes.string,
      leave: React.PropTypes.string,
      leaveActive: React.PropTypes.string,
      appear: React.PropTypes.string,
      appearActive: React.PropTypes.string
    })]).isRequired,
    appear: React.PropTypes.bool,
    enter: React.PropTypes.bool,
    leave: React.PropTypes.bool,
    appearTimeout: React.PropTypes.number,
    enterTimeout: React.PropTypes.number,
    leaveTimeout: React.PropTypes.number
  },
  transition: function(animationType, finishCallback, userSpecifiedDelay) {
    var node = ReactDOM.findDOMNode(this);
    if (!node) {
      if (finishCallback) {
        finishCallback();
      }
      return;
    }
    var className = this.props.name[animationType] || this.props.name + '-' + animationType;
    var activeClassName = this.props.name[animationType + 'Active'] || className + '-active';
    var timeout = null;
    var endListener = function(e) {
      if (e && e.target !== node) {
        return;
      }
      clearTimeout(timeout);
      CSSCore.removeClass(node, className);
      CSSCore.removeClass(node, activeClassName);
      ReactTransitionEvents.removeEndEventListener(node, endListener);
      if (finishCallback) {
        finishCallback();
      }
    };
    CSSCore.addClass(node, className);
    this.queueClassAndNode(activeClassName, node);
    if (userSpecifiedDelay) {
      timeout = setTimeout(endListener, userSpecifiedDelay);
      this.transitionTimeouts.push(timeout);
    } else {
      ReactTransitionEvents.addEndEventListener(node, endListener);
    }
  },
  queueClassAndNode: function(className, node) {
    this.classNameAndNodeQueue.push({
      className: className,
      node: node
    });
    if (!this.timeout) {
      this.timeout = setTimeout(this.flushClassNameAndNodeQueue, TICK);
    }
  },
  flushClassNameAndNodeQueue: function() {
    if (this.isMounted()) {
      this.classNameAndNodeQueue.forEach(function(obj) {
        CSSCore.addClass(obj.node, obj.className);
      });
    }
    this.classNameAndNodeQueue.length = 0;
    this.timeout = null;
  },
  componentWillMount: function() {
    this.classNameAndNodeQueue = [];
    this.transitionTimeouts = [];
  },
  componentWillUnmount: function() {
    if (this.timeout) {
      clearTimeout(this.timeout);
    }
    this.transitionTimeouts.forEach(function(timeout) {
      clearTimeout(timeout);
    });
    this.classNameAndNodeQueue.length = 0;
  },
  componentWillAppear: function(done) {
    if (this.props.appear) {
      this.transition('appear', done, this.props.appearTimeout);
    } else {
      done();
    }
  },
  componentWillEnter: function(done) {
    if (this.props.enter) {
      this.transition('enter', done, this.props.enterTimeout);
    } else {
      done();
    }
  },
  componentWillLeave: function(done) {
    if (this.props.leave) {
      this.transition('leave', done, this.props.leaveTimeout);
    } else {
      done();
    }
  },
  render: function() {
    return onlyChild(this.props.children);
  }
});
module.exports = ReactCSSTransitionGroupChild;
