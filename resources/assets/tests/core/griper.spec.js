import { expect } from 'chai'
import griper from 'xe-common/griper'

/* global describe, it */

describe('griper', function () {
  it('아직 테스트하지 않았지만 메소드는 존재해야 함', function () {
    expect(griper).to.have.property('toast').that.is.a('function')
    expect(griper.toast).to.have.property('fn').that.is.a('object')
    expect(griper).to.have.property('form').that.is.a('function')
    expect(griper.form).to.have.property('fn').that.is.a('object')
  })
})
