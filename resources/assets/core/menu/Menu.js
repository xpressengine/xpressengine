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
        '<a href="' + url + '/' + data.id + '"><h3><i class="xi-folder"></i>' + data.title + '</h3></a>',
        '</div>',
        '<div class="pull-right">',
        '<a href="' + url + '/' + data.id + '/types' + '" class="btn btn-primary"><i class="xi-plus"></i><span>' + window.XE.Lang.trans('xe::addItem') + '</span></a>',
        '</div>',
        '</div>'
      ].join('\n')
    }
  }
})()
