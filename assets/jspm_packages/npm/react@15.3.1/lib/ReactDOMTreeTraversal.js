/* */ 
(function(process) {
  'use strict';
  var _prodInvariant = require('./reactProdInvariant');
  var invariant = require('fbjs/lib/invariant');
  function getLowestCommonAncestor(instA, instB) {
    !('_hostNode' in instA) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'getNodeFromInstance: Invalid argument.') : _prodInvariant('33') : void 0;
    !('_hostNode' in instB) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'getNodeFromInstance: Invalid argument.') : _prodInvariant('33') : void 0;
    var depthA = 0;
    for (var tempA = instA; tempA; tempA = tempA._hostParent) {
      depthA++;
    }
    var depthB = 0;
    for (var tempB = instB; tempB; tempB = tempB._hostParent) {
      depthB++;
    }
    while (depthA - depthB > 0) {
      instA = instA._hostParent;
      depthA--;
    }
    while (depthB - depthA > 0) {
      instB = instB._hostParent;
      depthB--;
    }
    var depth = depthA;
    while (depth--) {
      if (instA === instB) {
        return instA;
      }
      instA = instA._hostParent;
      instB = instB._hostParent;
    }
    return null;
  }
  function isAncestor(instA, instB) {
    !('_hostNode' in instA) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'isAncestor: Invalid argument.') : _prodInvariant('35') : void 0;
    !('_hostNode' in instB) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'isAncestor: Invalid argument.') : _prodInvariant('35') : void 0;
    while (instB) {
      if (instB === instA) {
        return true;
      }
      instB = instB._hostParent;
    }
    return false;
  }
  function getParentInstance(inst) {
    !('_hostNode' in inst) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'getParentInstance: Invalid argument.') : _prodInvariant('36') : void 0;
    return inst._hostParent;
  }
  function traverseTwoPhase(inst, fn, arg) {
    var path = [];
    while (inst) {
      path.push(inst);
      inst = inst._hostParent;
    }
    var i;
    for (i = path.length; i-- > 0; ) {
      fn(path[i], false, arg);
    }
    for (i = 0; i < path.length; i++) {
      fn(path[i], true, arg);
    }
  }
  function traverseEnterLeave(from, to, fn, argFrom, argTo) {
    var common = from && to ? getLowestCommonAncestor(from, to) : null;
    var pathFrom = [];
    while (from && from !== common) {
      pathFrom.push(from);
      from = from._hostParent;
    }
    var pathTo = [];
    while (to && to !== common) {
      pathTo.push(to);
      to = to._hostParent;
    }
    var i;
    for (i = 0; i < pathFrom.length; i++) {
      fn(pathFrom[i], true, argFrom);
    }
    for (i = pathTo.length; i-- > 0; ) {
      fn(pathTo[i], false, argTo);
    }
  }
  module.exports = {
    isAncestor: isAncestor,
    getLowestCommonAncestor: getLowestCommonAncestor,
    getParentInstance: getParentInstance,
    traverseTwoPhase: traverseTwoPhase,
    traverseEnterLeave: traverseEnterLeave
  };
})(require('process'));
