import { expect } from 'chai'
import Router from 'xe/router'
import Route from 'xe/router/route'

/* global describe, it */

describe('Route', function () {
  let routerinstance = new Router()

  describe('Router의 baseURL을 참조하여 URL을 반환 함', function () {
    routerinstance.setup('http://localhost')
    const route = new Route(routerinstance, 'route.name', { uri: 'user/profile' })
    expect(route.url()).to.be.equal('http://localhost/user/profile')
    routerinstance.setup('')
    expect(route.url()).to.be.equal('/user/profile')
  })

  routerinstance.setup('', 'p', 's')

  describe('isAllow(method)는 method 허용여부를 반환 함', function () {
    it('route에 methods가 없으면 항상 true를 반환해야 함', function () {
      const route = new Route(routerinstance, 'route.name', { uri: 'user/profile' })
      expect(route.allowedMethods()).to.be.empty
      expect(route.isAllow('GET')).to.be.true
      expect(route.isAllow('PUT')).to.be.true
    })

    it('route에 methods와 비교하여 허용하는지 반환해야 함', function () {
      const route = new Route(routerinstance, 'route.name', {
        uri: 'user/profile',
        methods: ['GET', 'POST']
      })

      expect(route.allowedMethods()).to.not.be.empty
      expect(route.isAllow('get')).to.be.true
      expect(route.isAllow('GET')).to.be.true
      expect(route.isAllow('post')).to.be.true
      expect(route.isAllow('HEAD')).to.be.false
    })
  })

  describe('getParams()', function () {
    it('전달한 params를 담고 반환할 수 있어야 함', function () {
      const route = new Route(routerinstance, 'route.name', {
        uri: '{url}/edit/{id?}',
        params: {url: 'freeboard', id: 123}
      })

      expect(route.getParams()).to.not.be.empty
      expect(route.getParams()).to.include({url: 'freeboard', id: 123})
    })
  })

  describe('url(params)', function () {
    const route = new Route(routerinstance, 'route.name', {
      uri: '{url}/edit/{id?}',
      params: {url: 'freeboard', id: 123}
    })

    describe('params를 지정하지 않으면', function () {
      it('route의 params로 URL을 반환해야 함', function () {
        expect(route.url()).to.be.equal('/freeboard/edit/123')
      })
    })

    describe('params를 지정하면', function () {
      it('route의 params와 병합하여 URL을 반환해야 함', function () {
        expect(route.url({url: 'cats', id: 456})).to.be.equal('/cats/edit/456')
      })
    })

    describe('params 일부를 제거하면', function () {
      it('필수 parameter이면 route의 pamras를 사용', function () {
        expect(route.url({url: null})).to.be.equal('/freeboard/edit/123')
        expect(route.url({url: null, id: 456})).to.be.equal('/freeboard/edit/456')
      })

      it('필수가 아닌 parameter이면 비우고 반환', function () {
        expect(route.url({id: null})).to.be.equal('/freeboard/edit')
        expect(route.url({url: 'cats', id: null})).to.be.equal('/cats/edit')
      })
    })
  })
})
