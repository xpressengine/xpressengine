var Item = (function () {
  var _this = this;
  var _nodeTemplate;

  return {
    init: function () {
      _this = this;

      return this;
    },

    getTemplate: function (obj) {
      _nodeTemplate = obj.nodeTemplate;

      return _this.getItemsTemplate(obj.items, obj.rootId,  true);

    },

    getItemsTemplate: function (items, rootId, isRoot) {
      var temp = '';

      if (items && items.length != 0 || isRoot) {
        if (isRoot && rootId) {
          temp += '<ul class="item-container" data-parent="' + rootId + '">';
        } else {
          temp += '<ul class="item-container">';
        }

      }

      temp += _this.makeItem(items, _nodeTemplate);

      if (items && items.length != 0 || isRoot) {
        temp += '</ul>';
      }

      return temp;
    },
    /**
     * @param {object} obj
     * <pre>
     *   items
     *   nodeTemplate
     * </pre>
     * */
    makeItem: function (items, nodeTemplate) {
      var itemNode = '';

      for (var prop in items) {
        var item = items[prop];
        var move = (item.items && item.items.length > 0) ? 'move' : '';

        itemNode += "<li class='item " + move + "' id='item_" + item.id + "'>";
        itemNode +=   "<div class='item-content' data-item='" + JSON.stringify(item) + "'>";
        itemNode +=     "<button class='btn handler'><i class='xi-drag-vertical'></i></button>";
        itemNode +=     nodeTemplate(item);
        itemNode +=   '</div>';

        if (item.items && item.items instanceof Object) {
          itemNode += _this.getItemsTemplate(item.items);
        }

        itemNode += '</li>';
      }

      return itemNode;
    },
  }.init();
})();
