import { expect } from 'chai'
import { requestInstance } from 'xe/request'
import Config from 'xe/request/config'
import ResponseEntity from 'xe/request/response_entity'
import { routerInstance } from 'xe/router'
import moxios from 'moxios'
import sinon from 'sinon'

describe('Request', function () {
  let onFulfilled
  let onRejected

  beforeEach(function () {
    onFulfilled = sinon.spy()
    onRejected = sinon.spy()
    moxios.install(requestInstance.axiosInstance)
  })

  afterEach(function () {
    moxios.uninstall(requestInstance.axiosInstance)
  })

  describe('setup(options)', function () {
    const baseURL = 'http://localhost'

    requestInstance.setup({ baseURL })

    it('Config instance를 반환해야 함', function () {
      expect(requestInstance.config).to.be.an.instanceof(Config)
    })

    it('baseURL 등 주요 설정이 적용되어야 함', function () {
      expect(requestInstance.config.get('baseURL')).to.be.equal(baseURL)
    })
  })

  describe('response', function () {
    it('정상 응답', function (done) {
      requestInstance.get('/response').then(onFulfilled)

      moxios.wait(function () {
        let mox = moxios.requests.mostRecent()
        mox.respondWith({
          status: 200
        }).then(function () {
          it('onFulfilled 호출되고 ResponseEntity instance를 반환해야 함', function () {
            expect(onFulfilled.called).to.be.true

            let response = onFulfilled.getCall(0).args[0]
            expect(response).to.be.an.instanceOf(ResponseEntity)
          })
          done()
        })
      })
    })

    it('비정상 응답', function (done) {
      requestInstance.get('/error').then(onFulfilled, onRejected)

      moxios.wait(function () {
        let mox = moxios.requests.mostRecent()
        mox.respondWith({
          status: 404
        }).then(function () {
          it('onFulfilled는 호출하지 않음', function () {
            expect(onFulfilled.called).to.be.false
          })

          it('onRejected 호출 함', function () {
            expect(onRejected.called).to.be.true
          })

          it('Error instance를 반환 함', function () {
            let response = onRejected.getCall(0).args[0]
            expect(response).to.be.instanceOf(Error)
          })

          done()
        })
      })
    })
  })

  describe('Router 연동', function () {
    it('route URI로 URL을 얻어 요청하고 응답을 받아야 함', function (done) {
      routerInstance.setup('http://localhost')

      routerInstance.addRoutes({'module/board@board.slug':
        {
          'uri': '{url}/{slug}',
          'methods': ['GET', 'HEAD'],
          'params': {'url': 'freeboard', 'instanceId': '7975edc8'}
        }
      })

      moxios.stubRequest('http://localhost/freeboard/slug-string', {
        status: 200
      })

      requestInstance.get(['module/board@board.slug', {slug: 'slug-string'}]).then(onFulfilled, onRejected)

      moxios.wait(function () {
        expect(onFulfilled.called).to.be.true
        expect(onRejected.called).to.be.false
        done()
      })
    })
  })
})
