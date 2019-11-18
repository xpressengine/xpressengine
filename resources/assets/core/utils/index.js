import EventEmitter from './EventEmitter'
import config from 'xe/config'
import lodash from 'lodash'

export * from './_deprecated'

export {
  EventEmitter
}

export const curry = lodash.curry
export const debounce = lodash.debounce
export const find = lodash.find
export const forEach = lodash.forEach
export const mapValues = lodash.mapValues
export const throttle = lodash.throttle
export const trim = lodash.trim
export const trimEnd = lodash.trimEnd
export const trimStart = lodash.trimStart

/**
 * @module Utils
 */

/**
 * @deprecated
 * @param {String} url
 */
export function setBaseURL (url) {
  config.dispatch('router/changeOrigin', url)
}

/**
 * object, function에 EventEmmiter 확장
 *
 * @param {object|function}
 */
export function eventify (target) {
  EventEmitter.eventify(target)
}

/**
 * image mime type의 결과를 리턴한다.
 * @param {string} mime
 * @return {boolean}
 */
export function isImage (mime) {
  return ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'].includes(mime)
}

/**
 * video mime type의 결과를 리턴한다.
 * @param {string} mime
 * @return {boolean}
 */
export function isVideo (mime) {
  return ['video/mp4', 'video/webm', 'video/ogg'].includes(mime)
}

/**
 * audio mime type의 결과를 리턴한다.
 * @param {string} mime
 * @return {boolean}
 */
export function isAudio (mime) {
  return ['audio/mpeg', 'audio/ogg', 'audio/wav'].includes(mime)
}

/**
 * 파일 사이즈 포멧을 변경하여 리턴한다.
 * @param {number} bytes
 * @return {string}
 * @FIXME
 */
export function formatSizeUnits (bytes) {
  if (bytes >= 1073741824) {
    bytes = (bytes / 1073741824).toFixed(2) + 'GB'
  } else if (bytes >= 1048576) {
    bytes = (bytes / 1048576).toFixed(2) + 'MB'
  } else if (bytes >= 1024) {
    bytes = (bytes / 1024).toFixed(2) + 'KB'
  } else if (bytes > 1) {
    bytes = bytes + 'bytes'
  } else if (bytes == 1) {
    bytes = bytes + 'byte'
  } else {
    bytes = '0MB'
  }

  return bytes
}

/**
 * GB, MB, KB, bytes, byte로 정의된 파일 크기를 byte단위로 리턴한다.
 * @param {string} str
 * @return {number}
 * @FIXME
 */
export function sizeFormatToBytes (str) {
  var bytes = 0

  if (str.indexOf('GB') != -1) {
    bytes = parseFloat(str) * 1024 * 1024 * 1024
  } else if (str.indexOf('MB') != -1) {
    bytes = parseFloat(str) * 1024 * 1024
  } else if (str.indexOf('KB') != -1) {
    bytes = parseFloat(str) * 1024
  } else if (str.indexOf('bytes') != -1) {
    bytes = parseFloat(str)
  } else if (str.indexOf('byte') != -1) {
    bytes = parseFloat(str)
  }

  return bytes
}

/**
 * URL문자열인지의 결과를 리턴한다.
 * @param {string} url
 * @return {boolean}
 * @FIXME
 */
export function isURL (url) {
  return /(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/.test(url)
}

/**
 * full url을 리턴한다.
 * @param {string} url
 * @return {string}
 */
export function asset (resourceUri) {
  let result = ''

  // 절대 경로로 변경
  if (!isURL(resourceUri)) {
    result = config.getters['router/assetsOrigin']

    if (result.substr(-1) === '/') {
      result = result.substr(0, -1)
    }

    if (resourceUri.substr(0, 1) !== '/') {
      result += '/'
    }
  }

  result += resourceUri

  return _.trimEnd(result.split(/[?#]/)[0], '/')
}

const windowObjectReference = {}
const defaultWindowFeatures = {
  // position and dimension
  width: 450,
  height: 500,
  // Toolbar and chrome features
  menubar: false,
  toolbar: false,
  location: false,
  status: false,
  // Window functionality features
  noopener: false,
  resizable: true,
  scrollbars: true,
  // Features requiring privileges
  titlebar: false
}

/**
 * { function_description }
 *
 * @param      {string}  url       The url
 * @param      {string}  name      The name
 * @param      {object}  features  The features
 */
export function openWindow (url, name = null, options = {}) {
  let features = []
  options = Object.assign({}, defaultWindowFeatures, options)

  if (windowObjectReference[name] == null || windowObjectReference[name].closed) {
    _.mapValues(options, (value, key) => {
      value = (value === false) ? 'no' : (value === true) ? 'yes' : value
      features.push(key + '=' + value)
    })
    features = features.join(',')

    windowObjectReference[name] = window.open(url, name, features)

    return windowObjectReference[name]
  } else {
    return windowObjectReference[name].foucs()
  }
}
