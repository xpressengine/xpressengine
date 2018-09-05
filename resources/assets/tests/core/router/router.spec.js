import { expect } from 'chai'
import { routerInstance } from 'xe/router'
import { requestInstance } from 'xe/request'
import Route from 'xe/router/route'
import XE from 'xe'
import { RouteNotFoundError } from 'xe/router/errors/route.error'

/* global describe, it */

describe('Router', function () {
  requestInstance.boot(XE)
  routerInstance.boot(XE)
  requestInstance.$$emit('exposed', [
    {"manage.dynamicField.index":{"uri":"settings\/dynamicField","methods":["GET","HEAD"],"params":[]}}
  ])

  describe('setup(baseURL, fixed, settings)', function () {
    describe('fixed, settings는 지정하지 않아도 됨', function () {
      routerInstance.setup('http://localhost')
      expect(routerInstance).to.have.property('baseURL').that.is.equal('http://localhost')

      it('fixed의 기본 값은 plugin', function () {
        routerInstance.setup('http://localhost', 'p')
        expect(routerInstance).to.have.property('fixedPrefix').that.is.equal('p')
        routerInstance.setup('http://localhost')
        expect(routerInstance).to.have.property('fixedPrefix').that.is.equal('plugin')
      })

      it('settings는 기본 값이 없음', function () {
        routerInstance.setup('http://localhost')
        expect(routerInstance).to.have.property('settingsPrefix').that.is.equal('')
        routerInstance.setup('http://localhost', 'p', 's')
        expect(routerInstance).to.have.property('settingsPrefix').that.is.equal('s')
      })
    })
  })

  describe('addRoutes(routes)', function () {
    routerInstance.addRoutes({ 'user.profile': { uri: 'user/profile' } })

    it('has()는 route가 추가되었는지 확인할 수 있음', function () {
      expect(routerInstance.has('user.profile')).to.be.true
    })

    it('get()은 route instance를 반환', function () {
      expect(routerInstance.get('user.profile')).to.be.instanceof(Route)
    })

    it('RouteNotFoundError', function () {
      expect(() => routerInstance.get('route.notfound')).to.be.throw(RouteNotFoundError)
    })
  })
})
