import { expect } from 'chai'
import * as $$ from 'xe/utils'

/* global describe, it */

describe('Utils', function () {
  it('lodash functions', function () {
    expect($$).to.have.property('curry').that.is.a('function')
    expect($$).to.have.property('debounce').that.is.a('function')
    expect($$).to.have.property('find').that.is.a('function')
    expect($$).to.have.property('forEach').that.is.a('function')
    expect($$).to.have.property('mapValues').that.is.a('function')
    expect($$).to.have.property('throttle').that.is.a('function')
    expect($$).to.have.property('trim').that.is.a('function')
    expect($$).to.have.property('trimEnd').that.is.a('function')
    expect($$).to.have.property('trimStart').that.is.a('function')
  })

  it('export', function () {
    expect($$).to.have.property('setBaseURL').that.is.a('function')
    expect($$).to.have.property('eventify').that.is.a('function')
    expect($$).to.have.property('asset').that.is.a('function')
  })

  describe('isImage()', function () {
    it('websafe', function () {
      expect($$.isImage('image/jpeg')).to.be.true
      expect($$.isImage('jpeg')).to.be.false
    })
  })

  describe('isVideo()', function () {
    it('websafe', function () {
      expect($$.isVideo('video/mp4')).to.be.true
      expect($$.isVideo('mp4')).to.be.false
    })
  })

  describe('isAudio()', function () {
    it('websafe', function () {
      expect($$.isAudio('audio/mpeg')).to.be.true
      expect($$.isAudio('mpeg')).to.be.false
    })
  })

  describe('formatSizeUnits(byte)', function () {
    it('return', function () {
      expect($$.formatSizeUnits(1048576)).to.be.equal('1.00MB')
      expect($$.formatSizeUnits(0)).to.be.equal('0MB')
    })
  })

  describe('sizeFormatToBytes(str)', function () {
    it('return', function () {
      expect($$.sizeFormatToBytes('1.00MB')).to.be.equal(1048576)
      expect($$.sizeFormatToBytes('0MB')).to.be.equal(0)
    })
  })

  describe('isURL(url)', function () {
    it('return', function () {
      expect($$.isURL('http://localhost')).to.be.true
      expect($$.isURL('/path')).to.be.false
    })
  })

  describe('asset', function () {
    $$.setBaseURL('http://localhost')

    it('eq', function () {
      expect($$.asset('http://localhost/script.js')).to.be.equal('http://localhost/script.js')
      expect($$.asset('script.js')).to.be.equal('http://localhost/script.js')
      expect($$.asset('/script.js')).to.be.equal('http://localhost/script.js')
      expect($$.asset('http://localhost/script.js#asdf')).to.be.equal('http://localhost/script.js')
    })
  })
})
