/**
 * @namespace Menu
 * */
var Menu = (function () {
  return {
    /**
     *
     * @memberof Menu
     * */
    render: function (data, url) {
      return [
        '<div class="panel-heading">',
        '<div class="pull-left">',
        '<a href="' + url + '/' + data.id + '"><i class="xi-folder"></i><h3>' + data.title + '</h3></a>',
        '</div>',
        '<div class="pull-right">',
        '<a href="' + url + '/' + data.id + '/types' + '" class="btn btn-primary"><i class="xi-paper"></i><span>' + window.XE.Lang.trans('xe::addItem') + '</span></a>',
        '</div>',
        '</div>'
      ].join('\n')
    }
  }
})()
