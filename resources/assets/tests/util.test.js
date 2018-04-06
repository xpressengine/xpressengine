window.xeBaseURL = 'http://xpressengine.io/'
import {assert} from 'chai'
import * as Utils from '../core/common/js/utils'

describe('url', function () {
  it('getUri', function () {
    window.xeBaseURL = 'http://xpressengine.io/'
    assert.equal(Utils.getUri('http://xpressengine.io/test.css'), '/test.css')
    assert.equal(Utils.getUri('http://xpressengine.io/assets/test.css'), '/assets/test.css')

    window.xeBaseURL = 'http://xpressengine.io/subdir/'
    assert.equal(Utils.getUri('http://xpressengine.io/subdir/test.css'), '/test.css')
    assert.equal(Utils.getUri('http://xpressengine.io/test.css'), '../test.css')
  })
})
