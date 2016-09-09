/* */ 
'use strict';
var ReactNodeTypes = require('./ReactNodeTypes');
function getHostComponentFromComposite(inst) {
  var type;
  while ((type = inst._renderedNodeType) === ReactNodeTypes.COMPOSITE) {
    inst = inst._renderedComponent;
  }
  if (type === ReactNodeTypes.HOST) {
    return inst._renderedComponent;
  } else if (type === ReactNodeTypes.EMPTY) {
    return null;
  }
}
module.exports = getHostComponentFromComposite;
