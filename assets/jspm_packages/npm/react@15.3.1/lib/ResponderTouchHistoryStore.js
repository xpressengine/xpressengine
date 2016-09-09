/* */ 
(function(process) {
  'use strict';
  var _prodInvariant = require('./reactProdInvariant');
  var EventPluginUtils = require('./EventPluginUtils');
  var invariant = require('fbjs/lib/invariant');
  var warning = require('fbjs/lib/warning');
  var isEndish = EventPluginUtils.isEndish;
  var isMoveish = EventPluginUtils.isMoveish;
  var isStartish = EventPluginUtils.isStartish;
  var MAX_TOUCH_BANK = 20;
  var touchBank = [];
  var touchHistory = {
    touchBank: touchBank,
    numberActiveTouches: 0,
    indexOfSingleActiveTouch: -1,
    mostRecentTimeStamp: 0
  };
  function timestampForTouch(touch) {
    return touch.timeStamp || touch.timestamp;
  }
  function createTouchRecord(touch) {
    return {
      touchActive: true,
      startPageX: touch.pageX,
      startPageY: touch.pageY,
      startTimeStamp: timestampForTouch(touch),
      currentPageX: touch.pageX,
      currentPageY: touch.pageY,
      currentTimeStamp: timestampForTouch(touch),
      previousPageX: touch.pageX,
      previousPageY: touch.pageY,
      previousTimeStamp: timestampForTouch(touch)
    };
  }
  function resetTouchRecord(touchRecord, touch) {
    touchRecord.touchActive = true;
    touchRecord.startPageX = touch.pageX;
    touchRecord.startPageY = touch.pageY;
    touchRecord.startTimeStamp = timestampForTouch(touch);
    touchRecord.currentPageX = touch.pageX;
    touchRecord.currentPageY = touch.pageY;
    touchRecord.currentTimeStamp = timestampForTouch(touch);
    touchRecord.previousPageX = touch.pageX;
    touchRecord.previousPageY = touch.pageY;
    touchRecord.previousTimeStamp = timestampForTouch(touch);
  }
  function getTouchIdentifier(_ref) {
    var identifier = _ref.identifier;
    !(identifier != null) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'Touch object is missing identifier.') : _prodInvariant('138') : void 0;
    process.env.NODE_ENV !== 'production' ? warning(identifier <= MAX_TOUCH_BANK, 'Touch identifier %s is greater than maximum supported %s which causes ' + 'performance issues backfilling array locations for all of the indices.', identifier, MAX_TOUCH_BANK) : void 0;
    return identifier;
  }
  function recordTouchStart(touch) {
    var identifier = getTouchIdentifier(touch);
    var touchRecord = touchBank[identifier];
    if (touchRecord) {
      resetTouchRecord(touchRecord, touch);
    } else {
      touchBank[identifier] = createTouchRecord(touch);
    }
    touchHistory.mostRecentTimeStamp = timestampForTouch(touch);
  }
  function recordTouchMove(touch) {
    var touchRecord = touchBank[getTouchIdentifier(touch)];
    if (touchRecord) {
      touchRecord.touchActive = true;
      touchRecord.previousPageX = touchRecord.currentPageX;
      touchRecord.previousPageY = touchRecord.currentPageY;
      touchRecord.previousTimeStamp = touchRecord.currentTimeStamp;
      touchRecord.currentPageX = touch.pageX;
      touchRecord.currentPageY = touch.pageY;
      touchRecord.currentTimeStamp = timestampForTouch(touch);
      touchHistory.mostRecentTimeStamp = timestampForTouch(touch);
    } else {
      console.error('Cannot record touch move without a touch start.\n' + 'Touch Move: %s\n', 'Touch Bank: %s', printTouch(touch), printTouchBank());
    }
  }
  function recordTouchEnd(touch) {
    var touchRecord = touchBank[getTouchIdentifier(touch)];
    if (touchRecord) {
      touchRecord.touchActive = false;
      touchRecord.previousPageX = touchRecord.currentPageX;
      touchRecord.previousPageY = touchRecord.currentPageY;
      touchRecord.previousTimeStamp = touchRecord.currentTimeStamp;
      touchRecord.currentPageX = touch.pageX;
      touchRecord.currentPageY = touch.pageY;
      touchRecord.currentTimeStamp = timestampForTouch(touch);
      touchHistory.mostRecentTimeStamp = timestampForTouch(touch);
    } else {
      console.error('Cannot record touch end without a touch start.\n' + 'Touch End: %s\n', 'Touch Bank: %s', printTouch(touch), printTouchBank());
    }
  }
  function printTouch(touch) {
    return JSON.stringify({
      identifier: touch.identifier,
      pageX: touch.pageX,
      pageY: touch.pageY,
      timestamp: timestampForTouch(touch)
    });
  }
  function printTouchBank() {
    var printed = JSON.stringify(touchBank.slice(0, MAX_TOUCH_BANK));
    if (touchBank.length > MAX_TOUCH_BANK) {
      printed += ' (original size: ' + touchBank.length + ')';
    }
    return printed;
  }
  var ResponderTouchHistoryStore = {
    recordTouchTrack: function(topLevelType, nativeEvent) {
      if (isMoveish(topLevelType)) {
        nativeEvent.changedTouches.forEach(recordTouchMove);
      } else if (isStartish(topLevelType)) {
        nativeEvent.changedTouches.forEach(recordTouchStart);
        touchHistory.numberActiveTouches = nativeEvent.touches.length;
        if (touchHistory.numberActiveTouches === 1) {
          touchHistory.indexOfSingleActiveTouch = nativeEvent.touches[0].identifier;
        }
      } else if (isEndish(topLevelType)) {
        nativeEvent.changedTouches.forEach(recordTouchEnd);
        touchHistory.numberActiveTouches = nativeEvent.touches.length;
        if (touchHistory.numberActiveTouches === 1) {
          for (var i = 0; i < touchBank.length; i++) {
            var touchTrackToCheck = touchBank[i];
            if (touchTrackToCheck != null && touchTrackToCheck.touchActive) {
              touchHistory.indexOfSingleActiveTouch = i;
              break;
            }
          }
          if (process.env.NODE_ENV !== 'production') {
            var activeRecord = touchBank[touchHistory.indexOfSingleActiveTouch];
            process.env.NODE_ENV !== 'production' ? warning(activeRecord != null && activeRecord.touchActive, 'Cannot find single active touch.') : void 0;
          }
        }
      }
    },
    touchHistory: touchHistory
  };
  module.exports = ResponderTouchHistoryStore;
})(require('process'));
