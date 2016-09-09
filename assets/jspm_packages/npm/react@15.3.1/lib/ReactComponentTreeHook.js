/* */ 
(function(process) {
  'use strict';
  var _prodInvariant = require('./reactProdInvariant');
  var ReactCurrentOwner = require('./ReactCurrentOwner');
  var invariant = require('fbjs/lib/invariant');
  var warning = require('fbjs/lib/warning');
  function isNative(fn) {
    var funcToString = Function.prototype.toString;
    var hasOwnProperty = Object.prototype.hasOwnProperty;
    var reIsNative = RegExp('^' + funcToString.call(hasOwnProperty).replace(/[\\^$.*+?()[\]{}|]/g, '\\$&').replace(/hasOwnProperty|(function).*?(?=\\\()| for .+?(?=\\\])/g, '$1.*?') + '$');
    try {
      var source = funcToString.call(fn);
      return reIsNative.test(source);
    } catch (err) {
      return false;
    }
  }
  var canUseCollections = typeof Array.from === 'function' && typeof Map === 'function' && isNative(Map) && Map.prototype != null && typeof Map.prototype.keys === 'function' && isNative(Map.prototype.keys) && typeof Set === 'function' && isNative(Set) && Set.prototype != null && typeof Set.prototype.keys === 'function' && isNative(Set.prototype.keys);
  var itemMap;
  var rootIDSet;
  var itemByKey;
  var rootByKey;
  if (canUseCollections) {
    itemMap = new Map();
    rootIDSet = new Set();
  } else {
    itemByKey = {};
    rootByKey = {};
  }
  var unmountedIDs = [];
  function getKeyFromID(id) {
    return '.' + id;
  }
  function getIDFromKey(key) {
    return parseInt(key.substr(1), 10);
  }
  function get(id) {
    if (canUseCollections) {
      return itemMap.get(id);
    } else {
      var key = getKeyFromID(id);
      return itemByKey[key];
    }
  }
  function remove(id) {
    if (canUseCollections) {
      itemMap['delete'](id);
    } else {
      var key = getKeyFromID(id);
      delete itemByKey[key];
    }
  }
  function create(id, element, parentID) {
    var item = {
      element: element,
      parentID: parentID,
      text: null,
      childIDs: [],
      isMounted: false,
      updateCount: 0
    };
    if (canUseCollections) {
      itemMap.set(id, item);
    } else {
      var key = getKeyFromID(id);
      itemByKey[key] = item;
    }
  }
  function addRoot(id) {
    if (canUseCollections) {
      rootIDSet.add(id);
    } else {
      var key = getKeyFromID(id);
      rootByKey[key] = true;
    }
  }
  function removeRoot(id) {
    if (canUseCollections) {
      rootIDSet['delete'](id);
    } else {
      var key = getKeyFromID(id);
      delete rootByKey[key];
    }
  }
  function getRegisteredIDs() {
    if (canUseCollections) {
      return Array.from(itemMap.keys());
    } else {
      return Object.keys(itemByKey).map(getIDFromKey);
    }
  }
  function getRootIDs() {
    if (canUseCollections) {
      return Array.from(rootIDSet.keys());
    } else {
      return Object.keys(rootByKey).map(getIDFromKey);
    }
  }
  function purgeDeep(id) {
    var item = get(id);
    if (item) {
      var childIDs = item.childIDs;
      remove(id);
      childIDs.forEach(purgeDeep);
    }
  }
  function describeComponentFrame(name, source, ownerName) {
    return '\n    in ' + name + (source ? ' (at ' + source.fileName.replace(/^.*[\\\/]/, '') + ':' + source.lineNumber + ')' : ownerName ? ' (created by ' + ownerName + ')' : '');
  }
  function getDisplayName(element) {
    if (element == null) {
      return '#empty';
    } else if (typeof element === 'string' || typeof element === 'number') {
      return '#text';
    } else if (typeof element.type === 'string') {
      return element.type;
    } else {
      return element.type.displayName || element.type.name || 'Unknown';
    }
  }
  function describeID(id) {
    var name = ReactComponentTreeHook.getDisplayName(id);
    var element = ReactComponentTreeHook.getElement(id);
    var ownerID = ReactComponentTreeHook.getOwnerID(id);
    var ownerName;
    if (ownerID) {
      ownerName = ReactComponentTreeHook.getDisplayName(ownerID);
    }
    process.env.NODE_ENV !== 'production' ? warning(element, 'ReactComponentTreeHook: Missing React element for debugID %s when ' + 'building stack', id) : void 0;
    return describeComponentFrame(name, element && element._source, ownerName);
  }
  var ReactComponentTreeHook = {
    onSetChildren: function(id, nextChildIDs) {
      var item = get(id);
      item.childIDs = nextChildIDs;
      for (var i = 0; i < nextChildIDs.length; i++) {
        var nextChildID = nextChildIDs[i];
        var nextChild = get(nextChildID);
        !nextChild ? process.env.NODE_ENV !== 'production' ? invariant(false, 'Expected hook events to fire for the child before its parent includes it in onSetChildren().') : _prodInvariant('140') : void 0;
        !(nextChild.childIDs != null || typeof nextChild.element !== 'object' || nextChild.element == null) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'Expected onSetChildren() to fire for a container child before its parent includes it in onSetChildren().') : _prodInvariant('141') : void 0;
        !nextChild.isMounted ? process.env.NODE_ENV !== 'production' ? invariant(false, 'Expected onMountComponent() to fire for the child before its parent includes it in onSetChildren().') : _prodInvariant('71') : void 0;
        if (nextChild.parentID == null) {
          nextChild.parentID = id;
        }
        !(nextChild.parentID === id) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'Expected onBeforeMountComponent() parent and onSetChildren() to be consistent (%s has parents %s and %s).', nextChildID, nextChild.parentID, id) : _prodInvariant('142', nextChildID, nextChild.parentID, id) : void 0;
      }
    },
    onBeforeMountComponent: function(id, element, parentID) {
      create(id, element, parentID);
    },
    onBeforeUpdateComponent: function(id, element) {
      var item = get(id);
      if (!item || !item.isMounted) {
        return;
      }
      item.element = element;
    },
    onMountComponent: function(id) {
      var item = get(id);
      item.isMounted = true;
      var isRoot = item.parentID === 0;
      if (isRoot) {
        addRoot(id);
      }
    },
    onUpdateComponent: function(id) {
      var item = get(id);
      if (!item || !item.isMounted) {
        return;
      }
      item.updateCount++;
    },
    onUnmountComponent: function(id) {
      var item = get(id);
      if (item) {
        item.isMounted = false;
        var isRoot = item.parentID === 0;
        if (isRoot) {
          removeRoot(id);
        }
      }
      unmountedIDs.push(id);
    },
    purgeUnmountedComponents: function() {
      if (ReactComponentTreeHook._preventPurging) {
        return;
      }
      for (var i = 0; i < unmountedIDs.length; i++) {
        var id = unmountedIDs[i];
        purgeDeep(id);
      }
      unmountedIDs.length = 0;
    },
    isMounted: function(id) {
      var item = get(id);
      return item ? item.isMounted : false;
    },
    getCurrentStackAddendum: function(topElement) {
      var info = '';
      if (topElement) {
        var type = topElement.type;
        var name = typeof type === 'function' ? type.displayName || type.name : type;
        var owner = topElement._owner;
        info += describeComponentFrame(name || 'Unknown', topElement._source, owner && owner.getName());
      }
      var currentOwner = ReactCurrentOwner.current;
      var id = currentOwner && currentOwner._debugID;
      info += ReactComponentTreeHook.getStackAddendumByID(id);
      return info;
    },
    getStackAddendumByID: function(id) {
      var info = '';
      while (id) {
        info += describeID(id);
        id = ReactComponentTreeHook.getParentID(id);
      }
      return info;
    },
    getChildIDs: function(id) {
      var item = get(id);
      return item ? item.childIDs : [];
    },
    getDisplayName: function(id) {
      var element = ReactComponentTreeHook.getElement(id);
      if (!element) {
        return null;
      }
      return getDisplayName(element);
    },
    getElement: function(id) {
      var item = get(id);
      return item ? item.element : null;
    },
    getOwnerID: function(id) {
      var element = ReactComponentTreeHook.getElement(id);
      if (!element || !element._owner) {
        return null;
      }
      return element._owner._debugID;
    },
    getParentID: function(id) {
      var item = get(id);
      return item ? item.parentID : null;
    },
    getSource: function(id) {
      var item = get(id);
      var element = item ? item.element : null;
      var source = element != null ? element._source : null;
      return source;
    },
    getText: function(id) {
      var element = ReactComponentTreeHook.getElement(id);
      if (typeof element === 'string') {
        return element;
      } else if (typeof element === 'number') {
        return '' + element;
      } else {
        return null;
      }
    },
    getUpdateCount: function(id) {
      var item = get(id);
      return item ? item.updateCount : 0;
    },
    getRegisteredIDs: getRegisteredIDs,
    getRootIDs: getRootIDs
  };
  module.exports = ReactComponentTreeHook;
})(require('process'));
