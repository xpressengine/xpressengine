/* */ 
'use strict';
var SyntheticEvent = require('./SyntheticEvent');
var InputEventInterface = {data: null};
function SyntheticInputEvent(dispatchConfig, dispatchMarker, nativeEvent, nativeEventTarget) {
  return SyntheticEvent.call(this, dispatchConfig, dispatchMarker, nativeEvent, nativeEventTarget);
}
SyntheticEvent.augmentClass(SyntheticInputEvent, InputEventInterface);
module.exports = SyntheticInputEvent;
