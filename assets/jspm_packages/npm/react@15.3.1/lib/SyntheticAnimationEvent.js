/* */ 
'use strict';
var SyntheticEvent = require('./SyntheticEvent');
var AnimationEventInterface = {
  animationName: null,
  elapsedTime: null,
  pseudoElement: null
};
function SyntheticAnimationEvent(dispatchConfig, dispatchMarker, nativeEvent, nativeEventTarget) {
  return SyntheticEvent.call(this, dispatchConfig, dispatchMarker, nativeEvent, nativeEventTarget);
}
SyntheticEvent.augmentClass(SyntheticAnimationEvent, AnimationEventInterface);
module.exports = SyntheticAnimationEvent;
