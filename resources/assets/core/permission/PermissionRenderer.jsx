import React from 'react';
import ReactDOM from 'react-dom';

import Permission from './Permission';

$('.__xe__uiobject_permission').each(function (i) {
  var $this = $(this);
  var data = $this.data('data');

  var key = $this.data('key');
  var type = $this.data('type');
  var memberUrl = $this.data('memberUrl');
  var groupUrl = $this.data('groupUrl');
  var vgroupAll = $this.data('vgroupAll');

  ReactDOM.render(
    <Permission
      key={key}
      memberSearchUrl={memberUrl}
      groupSearchUrl={groupUrl}
      permission={data}
      type={type}
      vgroupAll={vgroupAll}/>, this
  );
});
