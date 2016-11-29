import griper from 'griper';
import Progress from './xe.progress';
import Lang from './xe.lang';
import Component from './xe.component';
import Request from './xe.request';
import window from 'window';

var XE = {
  ajax: ajax,
  setup: setup,
  configure: configure,
  cssLoad: cssLoad,
  jsLoad: jsLoad,
  toast: toast,
  toastByStatus: toastByStatus,
  formError: formError,
  formErrorClear: formErrorClear,
  formValidate: formValidate,
  getLocale: getLocale,
  getDefaultLocale: getDefaultLocale,

  options: {},

  Lang: Lang,
  Progress: Progress,
  Request: Request,
  Component: Component,
};

function ajax(url, options) {
  if (typeof url === 'object') {
    options = $.extend({}, XE.Request.options, url);
    url = undefined;
  } else {
    options = $.extend({}, options, XE.Request.options, { url: url });
    url = undefined;
  }

  return $.ajax(url, options);
}

/**
  * @param {object} options
  * */
function setup(options) {
  XE.options.loginUserId = options.loginUserId;
  XE.Request.setup({
    headers: {
      'X-CSRF-TOKEN': options['X-CSRF-TOKEN'],
    },
  });

}

/**
  * @param {object} options
  * */
function configure(options) {
  $.extend(XE.options, options);
}

// @DEPRECATED
function cssLoad(url) {
  DynamicLoadManager.cssLoad(url);
}

function jsLoad(url) {
  DynamicLoadManager.jsLoad(url);
}

function toast(type, message) {
  if (type == '') {
    type = 'danger';
  }

  griper.toast(type, message);
}

function toastByStatus(status, message) {
  return griper.toast(griper.toast.fn.statusToType(status), message);
}

function formError($element, message) {
  return griper.form($element, message);
}

function formErrorClear($form) {
  return griper.form.fn.clear($form);
}

function formValidate($form) {
  validator.formValidate($form);
}

function getLocale() {
  return XE.options.locale;
}

function getDefaultLocale() {
  return XE.options.defaultLocale;
}

window.XE = XE;

