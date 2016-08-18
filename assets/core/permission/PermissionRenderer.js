$('.__xe__uiobject_permission').each(function (i) {
  var el = $(this),
    data = el.data('data');

  var key = el.data('key')
    , type = el.data('type')
    , memberUrl = el.data('memberUrl')
    , groupUrl = el.data('groupUrl')
    , vgroupAll = el.data('vgroupAll');

  React.render(
    React.createElement(Permission, {
      key: key, 
      memberSearchUrl: memberUrl, 
      groupSearchUrl: groupUrl, 
      permission: data, 
      type: type, 
      vgroupAll: vgroupAll}), this);
});