import {assert, expect} from 'chai'
import XE from 'xe'
import Component from 'xe/component'
import DynamicLoadManager from 'xe/dynamic-load-manager'
import Lang from 'xe/lang'
import Request from 'xe/request'
import Router from 'xe/router'
import Validator from 'xe/validator'
import { xeSetupOptions, xeLegacySetupOptions } from './sample'

/* global describe, it */

describe('XE', function () {
  XE.setup(xeSetupOptions)

  describe('EventEmitter', function () {
    it('eventify', function () {
      expect(XE).to.have.property('$$emit').that.is.a('function')
      expect(XE).to.have.property('$$on').that.is.a('function')
      expect(XE).to.have.property('$$once').that.is.a('function')
      expect(XE).to.have.property('$$off').that.is.a('function')
      expect(XE).to.have.property('$$offAll').that.is.a('function')
    })
  })

  describe('properties', function () {
    describe('options', function () {
      it('options 멤버를 가짐', function () {
        expect(XE).to.have.property('options').that.is.a('object')
      })

      it('configure()로 옵션 설정이 가능 함', function () {
        XE.configure({customProperty: true})
        expect(XE.options.customProperty).to.be.true
      })
    })

    describe('locale', function () {
      describe('local/locales 속성을 가지고', function () {
        it('값을 확인할 수 있어야 함', function (done) {
          XE.$$once('setup', function () {
            assert.equal(XE.locale, 'ko')
            assert.equal(XE.getLocale(), 'ko') // @deprecated

            assert.equal(XE.defaultLocale, 'en')
            assert.equal(XE.getDefaultLocale(), 'en') // @deprecated

            done()
          })
          XE.setup(xeLegacySetupOptions)
        })
      })
    })
  })

  describe('moduels/functions', function () {
    it('설정된 서브 모듈의 instance를 가져야 함', function () {
      expect(XE).to.have.property('Utils')
      expect(XE).to.have.property('Validator').that.is.instanceof(Validator)
      expect(XE).to.have.property('Lang').that.is.instanceof(Lang)
      expect(XE).to.have.property('Request').that.is.instanceof(Request)
      expect(XE).to.have.property('Component').that.is.instanceof(Component)
      expect(XE).to.have.property('DynamicLoadManager').that.is.instanceof(DynamicLoadManager)
      expect(XE).to.have.property('Router').that.is.instanceof(Router)
      expect(XE).to.have.property('Progress')
      expect(XE).to.have.property('Translator')
      expect(XE).to.have.property('moment') // @deprecated
      expect(XE).to.have.property('Translator') // @deprecated
    })

    it('functions', function () {
      expect(XE).to.have.property('isSameHost')
      expect(XE).to.have.property('toast')
      expect(XE).to.have.property('toastByStatus')
      expect(XE).to.have.property('formError')
      expect(XE).to.have.property('formErrorClear')
      expect(XE).to.have.property('formValidate')
      expect(XE).to.have.property('cssLoad') // @deprecated
      expect(XE).to.have.property('jsLoad') // @deprecated
      expect(XE).to.have.property('ajax') // @deprecated
      expect(XE).to.have.property('getLocale') // @deprecated
      expect(XE).to.have.property('getDefaultLocale') // @deprecated
    })
  })

  describe('setup', function () {
    it('event emitting', function (done) {
      XE.$$once('setup', function () {
        done()
      })
      XE.setup({
        locale: 'ko',
        translation: {
          locales: ['ko', 'en']
        }
      })
    })
  })

  describe('function', function () {
    it('locale', function () {
      XE.configure({
        locale: 'ko',
        defaultLocale: 'en',
        translation: {
          locales: ['ko', 'en']
        }
      })

      assert.equal(XE.locale, 'ko')
      assert.equal(XE.defaultLocale, 'en')

      XE.locale = 'en'
      assert.equal(XE.locale, 'en')
    })

    describe('isSameHost', function () {
      it('slash 및 protocol 생략해도 true', function (done) {

        XE.$$once('setup', function () {
          assert.equal(XE.isSameHost('http://localhost'), true)
          assert.equal(XE.isSameHost('http://localhost/'), true)
          assert.equal(XE.isSameHost('http://localhost/public'), true)
          assert.equal(XE.isSameHost('http://localhost//'), true)
          assert.equal(XE.isSameHost('http://localhost//public'), true)
          assert.equal(XE.isSameHost('//localhost/public'), true)
          done()
        })
        XE.setup({
          baseURL: 'http://localhost'
        })
      })

      it('폴더만 붙은 경우 true', function () {
        assert.equal(XE.isSameHost('http://localhost/docs'), true)
        assert.equal(XE.isSameHost('http://localhost/~docs'), true)
      })

      it('기본 port는 true', function () {
        assert.equal(XE.isSameHost('http://localhost:80'), true)
      })

      it('port가 다르면 false', function () {
        assert.equal(XE.isSameHost('http://localhost:8080/'), false)
      })

      it('protocol 다르면 false', function () {
        assert.equal(XE.isSameHost('https://localhost/'), false)
      })

      it('subdomain이 다르면 false', function () {
        assert.equal(XE.isSameHost('http://www.localhost/'), false)
        assert.equal(XE.isSameHost('http://docs.localhost/'), false)
      })

      describe('port가 지정된 경우', function () {
        it('port가 지정되거나 다르면 false', function () {
          XE.config.dispatch('router/changeOrigin', 'http://localhost:8080')
          assert.equal(XE.isSameHost('http://localhost:8080'), true)
          assert.equal(XE.isSameHost('http://localhost'), false)
          assert.equal(XE.isSameHost('http://localhost:80'), false)
        })

        it('https + custom protocol', function () {
          XE.config.dispatch('router/changeOrigin', 'https://localhost:4433')
          assert.equal(XE.isSameHost('https://localhost:4433/board'), true)
          assert.equal(XE.isSameHost('http://localhost:4433/board'), false)
          assert.equal(XE.isSameHost('//localhost:4433/board'), true)
          assert.equal(XE.isSameHost('https://localhost:443/board'), false)
          assert.equal(XE.isSameHost('https://localhost/board'), false)
        })

        it('기본 port 나열 및 생략 가능', function () {
          XE.config.dispatch('router/changeOrigin', 'http://localhost:443')
          assert.equal(XE.isSameHost('https://localhost:443/board'), true)
          assert.equal(XE.isSameHost('https://localhost/board'), true)
        })
      })
    })
  })
})
