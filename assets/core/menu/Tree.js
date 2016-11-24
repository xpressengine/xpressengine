function Tree(obj) {
  this.cnt = 0;
  this.obj = obj || { items: [] };
  this.indexes = {};
  this.nodes = {};
  this.build(this.obj);
}

var proto = Tree.prototype;

proto.build = function (obj) {
  var indexes = this.indexes;
  var nodes = this.nodes;
  var _this = this;

  var indexId = obj.id || this.cnt;
  var indexOrdering = obj.ordering || 0;
  var depth = obj.depth || 0;

  obj.depth = depth;

  var index = {
    id: indexId,
    node: obj,
    ordering: indexOrdering,
    children: [],
    collapsed: obj.collapsed,
    depth: depth,
  };
  indexes[indexId + ''] = index;
  nodes[obj.id] = this.cnt;
  this.cnt++;

  if (obj.items && (obj.items.constructor == Object)) {
    walk(obj.items, index, depth);
  }

  function walk(objs, parent, depth) {
    var children = [];
    depth++;
    _.forEach(objs, function (obj) {
      var index = {};
      index.id = obj.id;
      index.node = obj;
      index.ordering = obj.ordering;
      index.collapsed = obj.collapsed;
      index.depth = depth;

      obj.depth = depth;
      if (parent) index.parent = parent.id;

      indexes[obj.id + ''] = index;
      nodes[obj.id] = _this.cnt;
      children.push(obj.id);
      _this.cnt++;

      if (obj.items && obj.items.constructor == Object) {
        walk(obj.items, index, depth);
      }
    });

    children.sort(function (a, b) {
      a = _this.getIndex(a);
      b = _this.getIndex(b);
      if (a.ordering > b.ordering)
       return 1;
      else if (a.ordering < b.ordering)
       return -1;
      else
       return 0;
    });

    parent.children = children;

    children.forEach(function (id, i) {
      var index = indexes[id + ''];
      if (i > 0) index.prev = children[i - 1];
      if (i < children.length - 1) index.next = children[i + 1];
    });
  }

  return index;
};

proto.getIndex = function (id) {
  var index = this.indexes[id + ''];
  if (index) return index;
};

proto.get = function (id) {
  var index = this.getIndex(id);
  if (index && index.node) return index.node;
  return null;
};

proto.removeIndex = function (index) {
  var _this = this;
  del(index);

  function del(index) {
    delete _this.indexes[index.id + ''];
    if (index.children && index.children.length) {
      index.children.forEach(function (child) {
        del(_this.getIndex(child));
      });
    }
  }
};

proto.remove = function (id) {
  var index = this.getIndex(id);
  var node = this.get(id);
  var parentIndex = this.getIndex(index.parent);
  var parentNode = this.get(index.parent);

  delete(parentNode.items[node.id]);
  parentIndex.children.splice(parentIndex.children.indexOf(id), 1);
  this.removeIndex(index);
  this.updateChildren(parentIndex.children);

  return node;
};

proto.updateChildren = function (children) {

  children.forEach(function (id, i) {
    var index = this.getIndex(id);

    index.prev = index.next = null;
    if (i > 0) {
      index.prev = children[i - 1];
    }

    if (i < children.length - 1) {
      index.next = children[i + 1];
    }
  }.bind(this));
};

proto.insert = function (obj, parentId, i) {
  var parentIndex = this.getIndex(parentId);
  var parentNode = this.get(parentId);

  obj.ordering = i;
  obj.depth = parentIndex.depth + 1;

  var index = this.build(obj);
  index.parent = parentId;
  obj.parentId = parentNode.id;

  if (parentNode.items.constructor == Array) {
    parentNode.items = {};
  }

  parentIndex.children = parentIndex.children || [];

  _.forEach(parentNode.items, function (item) {
    if (item.ordering >= i)item.ordering += 1;
  });

  parentNode.items[obj.id] = obj;

  parentIndex.children.splice(i, 0, index.id);

  this.updateChildren(parentIndex.children);
  if (parentIndex.parent) {
    this.updateChildren(this.getIndex(parentIndex.parent).children);
  }

  return index;
};

proto.insertBefore = function (obj, destId) {
  var destIndex = this.getIndex(destId);
  var parentId = destIndex.parent;
  var i = this.getIndex(parentId).children.indexOf(destId);
  return this.insert(obj, parentId, i);
};

proto.insertAfter = function (obj, destId) {
  var destIndex = this.getIndex(destId);
  var parentId = destIndex.parent;
  var i = this.getIndex(parentId).children.indexOf(destId);
  return this.insert(obj, parentId, i + 1);
};

proto.prepend = function (obj, destId) {
  return this.insert(obj, destId, 0);
};

proto.append = function (obj, destId) {
  var destIndex = this.getIndex(destId);
  destIndex.children = destIndex.children || [];
  return this.insert(obj, destId, destIndex.children.length);
};

proto.updateNodesPosition = function () {
  var top = 0;
  var left = 1;
  var root = this.getIndex(0);
  var _this = this;

  root.top = top++;
  root.left = left++;

  if (root.children && root.children.constructor == Array) {
    walk(root.children, root, left, root.collapsed);
  }

  function walk(children, parent, left, collapsed) {
    var height = 1;
    children.forEach(function (id) {
      var node = _this.getIndex(id);
      if (collapsed) {
        node.top = null;
        node.left = null;
      } else {
        node.top = top++;
        node.left = left;
      }

      if (node.children && node.children.length) {
        height += walk(node.children, node, left + 1, collapsed || node.collapsed);
      } else {
        node.height = 1;
        height += 1;
      }
    });

    if (parent.collapsed) parent.height = 1;
    else parent.height = height;
    return parent.height;
  }
};

proto.move = function (fromId, toId, placement) {
  if (fromId === toId || toId === 0) return;

  if (this.movementFilter) {
    var result = this.movementFilter(
      {
      fromId: fromId,
      toId: toId,
      placement: placement,
      tree: this,
    }
    );

    if (!result) {
      return;
    }

    fromId = result.fromId;
    toId = result.toId;
    placement = result.placement;
  }

  var obj = this.remove(fromId);
  var index = null;
  if (placement === 'before') {
    index = this.insertBefore(obj, toId);
  } else if (placement === 'after') {
    index = this.insertAfter(obj, toId);
  } else if (placement === 'prepend') {
    index = this.prepend(obj, toId);
  } else if (placement === 'append') {
    index = this.append(obj, toId);
  }

  this.updateNodesPosition();
  return index;
};

proto.newNode = function (obj, toId) {
  var index = this.append(obj, toId);
  this.updateNodesPosition();
  return index;
};

proto.getNodeByTop = function (top) {
  var indexes = this.indexes;
  for (var id in indexes) {
    if (indexes.hasOwnProperty(id)) {
      if (indexes[id].top === top) return indexes[id];
    }
  }
};
