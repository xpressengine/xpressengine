import {assert, should, expect} from 'chai'
import XE from 'xe'

describe('XE', function () {
  describe('EventEmitter', function () {
    it('eventify', function () {
      expect(XE).to.have.property('$emit').that.is.a('function')
      expect(XE).to.have.property('$on').that.is.a('function')
      expect(XE).to.have.property('$once').that.is.a('function')
      expect(XE).to.have.property('$off').that.is.a('function')
      expect(XE).to.have.property('$offAll').that.is.a('function')
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

    it('sub', function () {
      expect(XE).to.have.property('Utils')
      expect(XE).to.have.property('Validator')
      expect(XE).to.have.property('Lang')
      expect(XE).to.have.property('Request')
      expect(XE).to.have.property('Progress')
      expect(XE).to.have.property('Component')
      expect(XE).to.have.property('DynamicLoadManager')
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
      XE.$on('setup', function () {
        done()
      })
      XE.setup({})
    })
  })

  describe('function', function () {
    it('locale', function () {
      XE.configure({
        locale: 'ko',
        defaultLocale: 'en'
      })

      assert.equal(XE.locale, 'ko')
      assert.equal(XE.defaultLocale, 'en')

      XE.locale = 'en'
      assert.equal(XE.locale, 'en')
    })

    describe('isSameHost', function () {
      it('slash 및 protocol 생략해도 true', function () {
        window.xeBaseURL = 'http://localhost/'
        assert.equal(XE.isSameHost('http://localhost'), true)
        assert.equal(XE.isSameHost('http://localhost/'), true)
        assert.equal(XE.isSameHost('http://localhost/public'), true)
        assert.equal(XE.isSameHost('http://localhost//'), true)
        assert.equal(XE.isSameHost('http://localhost//public'), true)
        assert.equal(XE.isSameHost('//localhost/public'), true)
      })

      it('폴더만 붙은 경우 true', function () {
        window.xeBaseURL = 'http://localhost/'
        assert.equal(XE.isSameHost('http://localhost/docs'), true)
        assert.equal(XE.isSameHost('http://localhost/~docs'), true)
      })

      it('기본 port는 true', function () {
        window.xeBaseURL = 'http://localhost/'
        assert.equal(XE.isSameHost('http://localhost:80'), true)
      })

      it('port가 다르면 false', function () {
        window.xeBaseURL = 'http://localhost/'
        assert.equal(XE.isSameHost('http://localhost:8080/'), false)
      })

      it('protocol 다르면 false', function () {
        window.xeBaseURL = 'http://localhost/'
        assert.equal(XE.isSameHost('https://localhost/'), false)
      })

      it('subdomain이 다르면 false', function () {
        window.xeBaseURL = 'http://localhost/'
        assert.equal(XE.isSameHost('http://www.localhost/'), false)
        assert.equal(XE.isSameHost('http://docs.localhost/'), false)
      })

      describe('port가 지정된 경우', function () {
        it('port가 지정되거나 다르면 false', function () {
          window.xeBaseURL = 'http://localhost:8080/'
          assert.equal(XE.isSameHost('http://localhost:8080'), true)
          assert.equal(XE.isSameHost('http://localhost'), false)
          assert.equal(XE.isSameHost('http://localhost:80'), false)
        })

        it('https + custom protocol', function () {
          window.xeBaseURL = 'https://localhost:4433'
          assert.equal(XE.isSameHost('https://localhost:4433/board'), true)
          assert.equal(XE.isSameHost('http://localhost:4433/board'), false)
          assert.equal(XE.isSameHost('//localhost:4433/board'), true)
          assert.equal(XE.isSameHost('https://localhost:443/board'), false)
          assert.equal(XE.isSameHost('https://localhost/board'), false)
        })

        it('기본 port 나열 및 생략 가능', function () {
          window.xeBaseURL = 'https://localhost:443'
          assert.equal(XE.isSameHost('https://localhost:443/board'), true)
          assert.equal(XE.isSameHost('https://localhost/board'), true)
        })
      })
    })
  })
})
