import { expect } from 'chai'
import Request from 'xe/request'
import Config from 'xe/request/config'
import ResponseEntity from 'xe/request/response_entity'
import Router from 'xe/router'
import moxios from 'moxios'
import sinon from 'sinon'
import XE from 'xe'

/* global describe, it, beforeEach, afterEach */

describe('Request', function () {
  let onFulfilled
  let onRejected
  const requestInstance = new Request()
  const routerInstance = new Router()

  const baseURL = 'http://localhost'

  XE.$$once('setup', ({options}) => {
    routerInstance.boot(XE, options)
    requestInstance.boot(XE, options)
  })
  XE.setup({ baseURL })

  beforeEach(function () {
    onFulfilled = sinon.spy()
    onRejected = sinon.spy()
    requestInstance.setup(XE.options)
    moxios.install(requestInstance.axiosInstance)
  })

  afterEach(function () {
    moxios.uninstall(requestInstance.axiosInstance)
  })

  describe('setup(options)', function () {
    it('Config instance를 반환해야 함', function () {
      expect(requestInstance.config).to.be.an.instanceof(Config)
    })

    it('baseURL 등 주요 설정이 적용되어야 함', function () {
      expect(requestInstance.config.get('baseURL')).to.be.equal(baseURL)
    })
  })

  describe('response', function () {
    describe('정상 응답', function () {
      it('onFulfilled 호출하고 ResponseEntity instance를 반환해야 함', function (done) {
        moxios.stubRequest(/.+/, { status: 200, response: {} })
        requestInstance.put('res').then(onFulfilled, onRejected)
        moxios.wait(function () {
          expect(onFulfilled.called).to.be.true
          let response = onFulfilled.getCall(0).args[0]
          expect(response).to.be.an.instanceOf(ResponseEntity)
          done()
        })
      })

      it('data 및 statusText 등을 반환해야 함', function (done) {
        moxios.stubRequest(/.+/, {
          status: 200,
          statusText: 'OK',
          method: 'post',
          response: { val: 'TRUE' }
        })
        requestInstance.post('res').then(onFulfilled, onRejected)
        moxios.wait(function () {
          let response = onFulfilled.getCall(0).args[0]
          expect(response.status).to.be.equal(200)
          expect(response.statusText).to.be.equal('OK')
          expect(response.method).to.be.equal('post')
          expect(response.data.val).to.be.equal('TRUE')
          done()
        })
      })

      it('exposed가 있으면 데이터를 반환해야 함', function (done) {
        moxios.stubRequest(/.+/, { status: 200, response: { '_XE_': { assets: { js: [], css: [] } } } })
        requestInstance.get('res').then(onFulfilled, onRejected)
        moxios.wait(function () {
          let response = onFulfilled.getCall(0).args[0]
          expect(response.exposed).to.be.an('object')
          expect(response.exposed.assets.js).to.be.an('array')
          expect(response.exposed.assets.css).to.be.an('array')
          done()
        })
      })
    })

    describe('error', function () {
      it('onRejected 호출', function (done) {
        moxios.stubRequest(/.+/, { status: 404, response: { msg: '@@@@' } })
        requestInstance.head('/error').then(onFulfilled, onRejected)
        moxios.wait(function () {
          expect(onFulfilled.called).to.be.false
          expect(onRejected.called).to.be.true
          done()
        })
      })

      it('Error instance를 반환 함', function (done) {
        moxios.stubRequest(/.+/, { status: 404, response: { msg: '@@@@' } })
        requestInstance.delete('/error').then(onFulfilled, onRejected)
        moxios.wait(function () {
          let response = onRejected.getCall(0).args[0]
          expect(response).to.be.instanceOf(Error)
          done()
        })
      })
    })
  })

  describe('Router 연동', function () {
    it('route URI로 URL을 얻어 요청하고 응답을 받아야 함', function (done) {
      routerInstance.boot(XE)
      routerInstance.setup('http://localhost')

      routerInstance.addRoutes({
        'module/board@board.slug': {
          'uri': '{url}/{slug}',
          'methods': [],
          'params': {'url': 'freeboard'}
        }
      })

      moxios.stubRequest('http://localhost/freeboard/slug-string', { status: 200, response: { '_XE_': {js: []} } })

      requestInstance.get(['module/board@board.slug', {slug: 'slug-string'}]).then(onFulfilled)

      moxios.wait(function () {
        const response = onFulfilled.getCall(0).args[0]
        expect(onFulfilled.called).to.be.true
        done()
      })
    })
  })
})
