/** @private */
let _nodeTemplate

class Item {
  /**
   * item 템플릿을 리턴한다.
   * @memberof Item
   * @param {object} obj
   **/
  getTemplate (obj) {
    _nodeTemplate = obj.nodeTemplate

    return this.getItemsTemplate(obj.items, obj.rootId, true)
  }

  /**
   * item 템플릿을 리턴한다.
   * @memberof Item
   * @param {object} items
   * @param {string} rootId
   * @param {boolean} isRoot
   * @return {string}
   **/
  getItemsTemplate (items, rootId, isRoot) {
    let temp = ''

    if (items && items.length != 0 || isRoot) {
      if (isRoot && rootId) {
        temp += '<ul class="item-container" data-parent="' + rootId + '">'
      } else {
        temp += '<ul class="item-container">'
      }
    }

    temp += this.makeItem(items, _nodeTemplate)

    if (items && items.length != 0 || isRoot) {
      temp += '</ul>'
    }

    return temp
  }

  /**
     * item 템플릿을 만든다.
     * @memberof Item
     * @param {object} obj
     * <pre>
     *   items
     *   nodeTemplate
     * </pre>
     * @param {function} nodeTemplate
     * @return {string}
     **/
  makeItem (items, nodeTemplate) {
    let itemNode = ''

    for (const prop in items) {
      const item = items[prop]
      const move = (item.items && item.items.length) ? 'move' : ''

      itemNode += "<li class='item " + move + "' id='item_" + item.id + "'>"
      itemNode += "<div class='item-content' data-item='" + JSON.stringify(item) + "'>"
      itemNode += "<button class='btn handler'><i class='xi-drag-vertical'></i></button>"
      itemNode += nodeTemplate(item)
      itemNode += '</div>'

      if (item.items && item.items instanceof Object) {
        itemNode += this.getItemsTemplate(item.items)
      }

      itemNode += '</li>'
    }

    return itemNode
  }
}

export default new Item()
