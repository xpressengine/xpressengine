/* */ 
'use strict';
var SyntheticEvent = require('./SyntheticEvent');
var TransitionEventInterface = {
  propertyName: null,
  elapsedTime: null,
  pseudoElement: null
};
function SyntheticTransitionEvent(dispatchConfig, dispatchMarker, nativeEvent, nativeEventTarget) {
  return SyntheticEvent.call(this, dispatchConfig, dispatchMarker, nativeEvent, nativeEventTarget);
}
SyntheticEvent.augmentClass(SyntheticTransitionEvent, TransitionEventInterface);
module.exports = SyntheticTransitionEvent;
