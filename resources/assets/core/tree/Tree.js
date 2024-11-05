import 'xe3-nested-sortable'
import $ from 'jquery'
import _ from 'lodash'
import Item from './Item'

let _prevent = false

const defaultOptions = {
  connectWith: '.item-container',
  forcePlaceholderSize: true,
  helper: 'clone',
  handle: '.item-content .handler',
  listType: 'ul',
  items: 'li',
  opacity: 0.6,
  isTree: true,
  cancel: '',
  tolerance: 'pointer',
  toleranceElement: '> div'
}

class Tree {
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
   **/
  getItemsTemplate (obj) {
    return Item.getTemplate(obj)
  }

  /**
     * @memberof Tree
     * @param {boolean} flag
     * @description Tree 이동 방지
     * */
  setPrevent (flag) {
    _prevent = flag
  }

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
   **/
  run ($target, config, treeOptions) {
    let parentId
    let ordering
    let itemId
    let options = $.extend({}, defaultOptions)

    // custom option 추가
    if (_.isObject(treeOptions)) {
      $.extend(options, treeOptions)
    }

    // start function 추가
    if (_.isObject(treeOptions) && _.isFunction(treeOptions.start)) {
      options.start = treeOptions.start
    } else {
      options.start = function (e, ui) {
        const $item = $(ui.item)
        const itemData = $item.find('> .item-content').data('item')

        parentId = itemData.parentId
        ordering = itemData.ordering
        itemId = itemData.id

        if (_.isObject(config) && _.isFunction(config.dragStart)) {
          config.dragStart()
        }
      }
    }

    // stop function 추가
    if (_.isObject(treeOptions) && _.isFunction(treeOptions.stop)) {
      options.stop = treeOptions.stop
    } else {
      options.stop = function (e, ui) {
        const $item = $(ui.item)
        const $parentItem = $item.parents('li.item').eq(0)
        const moveParentId = ($parentItem.length > 0) ? $parentItem.find('> .item-content').data('item').id : $item.parents('.item-container').data('parent')
        const moveOrdering = $item.closest('ul').addClass('item-container').find('> li.item').index($item)

        if (_.isObject(config) && _.isFunction(config.dragStop)) {
          config.dragStop()
        }

        if ((parentId !== moveParentId && !_prevent) || (ordering !== moveOrdering && !_prevent)) {
          if (_.isObject(config) && _.isFunction(config.update)) {
            config.update({
              item: $item,
              itemId: itemId,
              parentId: moveParentId,
              ordering: moveOrdering
            })
          }
        }
      }
    }

    // relocate function 추가 default 사용안함.
    if (_.isObject(treeOptions) && _.isFunction(treeOptions.relocate)) {
      options.relocate = treeOptions.relocate
    }

    // receive function 추가 default 사용안함.
    if (_.isObject(treeOptions) && _.isFunction(treeOptions.receive)) {
      options.receive = treeOptions.receive
    }

    // placeholder 추가
    if (_.isObject(treeOptions) && treeOptions.placeholder) {
      options.placeholder = treeOptions.placeholder
    } else {
      options.placeholder = {
        element: function ($target) {
          return $target.clone().addClass('copy').show().wrapAll('<div />').parent().html()
        },
        update: function () {}
      }
    }

    if (_.isObject(treeOptions) && _.isFunction(treeOptions.isAllowed)) {
      options.isAllowed = treeOptions.isAllowed
    } else {
      options.isAllowed = function (placeholder, placeholderParent, currentItem) {
        return !_prevent
      }
    }

    if ($target.find('.item-container').length > 0) {
      $target.find('.item-container').nestedSortable(options)
    } else {
      $target.append('<ul class="item-container"></ul>')
      $target.find('.item-container').nestedSortable(options)
    }
  }

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
   **/
  add ($container, obj, fn) {
    if (obj.nested) {
      $container.append(Item.getTemplate(obj))
    } else {
      $container.append(Item.makeItem(obj.items, obj.nodeTemplate))
    }

    if (fn && typeof fn === 'function') {
      fn()
    }
  }
}

window.Tree = new Tree()

export default window.Tree
