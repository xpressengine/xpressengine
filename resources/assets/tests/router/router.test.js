import { expect } from 'chai'
import Router from 'xe/router'
import Route from 'xe/router/route'

describe('Router', function () {
  describe('setup(baseURL, fixed, settings)', function () {
    describe('fixed, settings는 지정하지 않아도 됨', function () {
      Router.setup('http://localhost')
      expect(Router).to.have.property('baseURL').that.is.equal('http://localhost')

      it('fixed의 기본 값은 plugin', function () {
        Router.setup('http://localhost', 'p')
        expect(Router).to.have.property('fixedPrefix').that.is.equal('p')
        Router.setup('http://localhost')
        expect(Router).to.have.property('fixedPrefix').that.is.equal('plugin')
      })

      it('settings는 기본 값이 없음', function () {
        Router.setup('http://localhost')
        expect(Router).to.have.property('settingsPrefix').that.is.equal('')
        Router.setup('http://localhost', 'p', 's')
        expect(Router).to.have.property('settingsPrefix').that.is.equal('s')
      })
    })
  })

  describe('addRoutes(routes)', function () {
    Router.addRoutes({ 'user.profile': { uri: 'user/profile' } })

    it('has()는 route가 추가되었는지 확인할 수 있음', function () {
      expect(Router.has('user.profile')).to.be.true
    })

    it('get()은 route instance를 반환', function () {
      expect(Router.get('user.profile')).to.be.instanceof(Route)
    })
  })
})
