import {assert, should, expect} from 'chai'
import XE from 'xe'

describe('XE', function () {
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

  it('route', function () {
    XE.Router.setup('http://localhost')
    XE.Router.addRoutes({
      'module/board@board.edit': {
        uri: '{url}/edit/{id}',
        params: {url: 'freeboard', id: 123}
      }
    })

    expect(XE.route('module/board@board.edit', {url: 'cats'})).to.be.equal('http://localhost/cats/edit/123')
  })

  it('isSameHost', function () {
    XE.Router.setup('http://xpressengine.io/')

    assert.equal(XE.isSameHost('http://xpressengine.io'), true)
    assert.equal(XE.isSameHost('http://xpressengine.io:80'), true)
    assert.equal(XE.isSameHost('http://xpressengine.io/docs'), true)
    assert.equal(XE.isSameHost('http://xpressengine.io/~docs'), true)

    assert.equal(XE.isSameHost('http://xpressengine.io:8080/'), false)
    assert.equal(XE.isSameHost('https://xpressengine.io/'), false)
    assert.equal(XE.isSameHost('http://www.xpressengine.io/'), false)
    assert.equal(XE.isSameHost('http://docs.xpressengine.io/'), false)

    XE.Router.setup('http://xpressengine.io:8080/')

    assert.equal(XE.isSameHost('http://xpressengine.io:8080'), true)
    assert.equal(XE.isSameHost('http://xpressengine.io'), false)
    assert.equal(XE.isSameHost('http://xpressengine.io:1234'), false)

    XE.Router.setup('https://xpressengine.io:4433/')

    assert.equal(XE.isSameHost('https://xpressengine.io:4433/board'), true)
    assert.equal(XE.isSameHost('http://xpressengine.io:4433/board'), true)

    assert.equal(XE.isSameHost('https://xpressengine.io:443/board'), false)
    assert.equal(XE.isSameHost('https://xpressengine.io/board'), false)

    XE.Router.setup('https://xpressengine.io:443/')

    assert.equal(XE.isSameHost('https://xpressengine.io/board'), true)
  })
})
