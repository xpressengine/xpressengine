/**
 * @namespace Tree
 * */
var Tree = (function () {
  /** @private */
  var _this;
  /** @private */
  var _prevent = false;

  return {
    /**
     * Tree를 초기화한다.
     * @memberof Tree
     * */
    init: function () {
      _this = this;

      return this;
    },

    /**
     *
     * @memberof Tree
     * @param {object} obj
     * <pre>
     *   rootId: tree root id
     *   nodeTemplate: item안에 생성할 html
     *   items: Tree 구성 데이터
     * </pre>
     * @return {string} items html
     */
    getItemsTemplate: function (obj) {
      return Item.getTemplate(obj);
    },

    /**
     * @memberof Tree
     * @param {boolean} flag
     * @description Tree 이동 방지
     * */
    setPrevent: function (flag) {
      _prevent = flag;
    },

    /**
     * @memberof Tree
     * @param {object} $target tree구성의 wrapper
     * @param {object} config
     * <pre>
     *   추가옵션
     *   dragStart : drag 시작시 호출 treeOption의 start를 오버라이드 가능함.
     *   dragStop : drop시 호출 treeOption의 end를 오버라이드 가능함.
     *   update : drag를 통한 tree의 변동사항이 있을 경우 호출 item, parent, target, ordering등의 정보를 인자로 보내준다
     * </pre>
     * @param {object} treeOptions nestedSortable Tree Options
     * @description 트리 구성
     * */
    run: function ($target, config, treeOptions) {
      var parentId;
      var ordering;
      var itemId;

      var defaultOptions = {
        connectWith: '.item-container',
        forcePlaceholderSize: true,
        helper:	'clone',
        handle: '.item-content .handler',
        listType: 'ul',
        items: 'li',
        opacity: 0.6,
        isTree: true,
        cancel: '',
        tolerance: 'pointer',
        toleranceElement: '> div',
      };

      //custom option 추가
      if (_this.isObject(treeOptions)) {
        defaultOptions = $.extend({}, defaultOptions, treeOptions);
      }

      //start function 추가
      if (_this.isObject(treeOptions) && _this.isFunction(treeOptions.start)) {
        defaultOptions.start = treeOptions.start;
      } else {
        defaultOptions.start = function (e, ui) {
          var $item = $(ui.item);
          var itemData = $item.find('> .item-content').data('item');

          parentId = itemData.parentId;
          ordering = itemData.ordering;
          itemId = itemData.id;

          if (_this.isObject(config) && _this.isFunction(config.dragStart)) {
            config.dragStart();
          }
        };
      }

      //stop function 추가
      if (_this.isObject(treeOptions) && _this.isFunction(treeOptions.stop)) {
        defaultOptions.stop = treeOptions.stop;
      } else {
        defaultOptions.stop = function (e, ui) {
          var $item = $(ui.item);
          var $parentItem = $item.parents('li.item').eq(0);
          var moveParentId = ($parentItem.length > 0) ? $parentItem.find('> .item-content').data('item').id : $item.parents('.item-container').data('parent');
          var moveOrdering = $item.closest('ul').addClass('item-container').find('> li.item').index($item);

          if (_this.isObject(config) && _this.isFunction(config.dragStop)) {
            config.dragStop();
          }

          if (parentId !== moveParentId && !_prevent || ordering !== moveOrdering && !_prevent) {
            if (_this.isObject(config) && _this.isFunction(config.update)) {
              config.update({
                item: $item,
                itemId: itemId,
                parentId: moveParentId,
                ordering: moveOrdering,
              });
            }
          }
        };
      }

      //relocate function 추가 default 사용안함.
      if (_this.isObject(treeOptions) && _this.isFunction(treeOptions.relocate)) {
        defaultOptions.relocate = treeOptions.relocate;
      }

      //receive function 추가 default 사용안함.
      if (_this.isObject(treeOptions) && _this.isFunction(treeOptions.receive)) {
        defaultOptions.receive = treeOptions.receive;
      }

      //placeholder 추가
      if (_this.isObject(treeOptions) && treeOptions.placeholder) {
        defaultOptions.placeholder = treeOptions.placeholder;
      } else {
        defaultOptions.placeholder = {
          element: function ($target) {
            return $target.clone().addClass('copy').show().wrapAll('<div />').parent().html();
          },

          update: function () {
            return;
          },
        };
      }

      if (_this.isObject(treeOptions) && _this.isFunction(treeOptions.isAllowed)) {
        defaultOptions.isAllowed = treeOptions.isAllowed;
      } else {
        defaultOptions.isAllowed = function (placeholder, placeholderParent, currentItem) {
          if (_prevent) {
            return false;
          } else {
            return true;
          }
        };
      }

      if ($target.find('.item-container').length > 0) {
        $target.find('.item-container').nestedSortable(defaultOptions);

      } else {
        var container = [
          '<ul class="item-container"></ul>',
        ];

        $target.append(container);
        $target.find('.item-container').nestedSortable(defaultOptions);
      }

    },

    /**
     * @memberof Tree
     * @param {object} $container
     * @oaram {object} obj
     * <pre>
     *   nodeTemplate: item안에 생성할 html
     *   item
     *   nested - 하위 depth 노드일 경우 ul.item-container를 포함하여 append. 아닐 경우 li.item만 append
     * </pre>
     * @param {function} fn callback
     * */
    add: function ($container, obj, fn) {

      if (obj.nested) {
        $container.append(Item.getTemplate(obj));
      } else {
        $container.append(Item.makeItem(obj.items, obj.nodeTemplate));
      }

      if (fn && typeof fn === 'function') {
        fn();
      }
    },
    /**
     * @memberof Tree
     * @param {object} obj
     * */
    isObject: function (obj) {
      return (obj && obj instanceof Object) ? true : false;
    },
    /**
     * @memberof Tree
     * @param {function} fn
     * */
    isFunction: function (fn) {
      return (typeof fn === 'function') ? true : false;
    },
  }.init();
})();
