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

      for (var prop in items) {
        var item = items[prop];
        var move = (item.items && item.items.length > 0) ? 'move' : '';

        temp += "<li class='item " + move + "' id='item_" + item.id + "'>";
        temp +=   "<div class='item-content' data-item='" + JSON.stringify(item) + "'>";
        temp +=     "<button class='btn handler'><i class='xi-drag-vertical'></i></button>";
        temp +=     _nodeTemplate(item);
        temp +=   '</div>';

        if (item.items && item.items instanceof Object) {
          temp += _this.getItemsTemplate(item.items);
        }

        temp += '</liv>';

      }

      if (items && items.length != 0 || isRoot) {
        temp += '</ul>';
      }

      return temp;
    },
  }.init();
})();
