import React from 'react';
import ReactDOM from 'react-dom';

import MenuTree from './MenuTree';

$(function () {
  const $container = $('#menuContainer');

  ReactDOM.render(
    React.createElement(MenuTree, {
    baseUrl: $container.data('url'),
    home: $container.data('home'),
    menus: $container.data('menus'),
    menuRoutes: {
      createMenu: $container.data('createmenu'),
    },
  }, null),
    $container[0]
  );
});
