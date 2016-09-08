/* */ 
(function(process) {
  'use strict';
  var _prodInvariant = require('./reactProdInvariant');
  var ReactDOMContainerInfo = require('./ReactDOMContainerInfo');
  var ReactDefaultBatchingStrategy = require('./ReactDefaultBatchingStrategy');
  var ReactElement = require('./ReactElement');
  var ReactInstrumentation = require('./ReactInstrumentation');
  var ReactMarkupChecksum = require('./ReactMarkupChecksum');
  var ReactReconciler = require('./ReactReconciler');
  var ReactServerBatchingStrategy = require('./ReactServerBatchingStrategy');
  var ReactServerRenderingTransaction = require('./ReactServerRenderingTransaction');
  var ReactUpdates = require('./ReactUpdates');
  var emptyObject = require('fbjs/lib/emptyObject');
  var instantiateReactComponent = require('./instantiateReactComponent');
  var invariant = require('fbjs/lib/invariant');
  var pendingTransactions = 0;
  function renderToStringImpl(element, makeStaticMarkup) {
    var transaction;
    try {
      ReactUpdates.injection.injectBatchingStrategy(ReactServerBatchingStrategy);
      transaction = ReactServerRenderingTransaction.getPooled(makeStaticMarkup);
      pendingTransactions++;
      return transaction.perform(function() {
        var componentInstance = instantiateReactComponent(element, true);
        var markup = ReactReconciler.mountComponent(componentInstance, transaction, null, ReactDOMContainerInfo(), emptyObject, 0);
        if (process.env.NODE_ENV !== 'production') {
          ReactInstrumentation.debugTool.onUnmountComponent(componentInstance._debugID);
        }
        if (!makeStaticMarkup) {
          markup = ReactMarkupChecksum.addChecksumToMarkup(markup);
        }
        return markup;
      }, null);
    } finally {
      pendingTransactions--;
      ReactServerRenderingTransaction.release(transaction);
      if (!pendingTransactions) {
        ReactUpdates.injection.injectBatchingStrategy(ReactDefaultBatchingStrategy);
      }
    }
  }
  function renderToString(element) {
    !ReactElement.isValidElement(element) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'renderToString(): You must pass a valid ReactElement.') : _prodInvariant('46') : void 0;
    return renderToStringImpl(element, false);
  }
  function renderToStaticMarkup(element) {
    !ReactElement.isValidElement(element) ? process.env.NODE_ENV !== 'production' ? invariant(false, 'renderToStaticMarkup(): You must pass a valid ReactElement.') : _prodInvariant('47') : void 0;
    return renderToStringImpl(element, true);
  }
  module.exports = {
    renderToString: renderToString,
    renderToStaticMarkup: renderToStaticMarkup
  };
})(require('process'));
