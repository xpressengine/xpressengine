import { expect } from 'chai'
import { eventify, EventEmitter } from 'xe/utils' // @FIXME https://github.com/xpressengine/xpressengine/issues/765

/* global describe, it */

describe('Utils', function () {
  describe('EventEmitter', function () {
    it('shortcut', function () {
      let targetObject = {}
      let TargetFunction = function () {}

      eventify(targetObject)
      eventify(TargetFunction)

      expect(targetObject).to.have.own.property('$$on').that.is.a('function')
      expect(TargetFunction.prototype).to.have.property('$$on').that.is.a('function')
    })

    it('extend object', function () {
      let target = {}

      EventEmitter.extend(target)

      expect(target).to.have.property('$$on').that.is.a('function')
      expect(target).to.have.property('$$emit').that.is.a('function')
      expect(target).to.have.property('$$once').that.is.a('function')
      expect(target).to.have.property('$$off').that.is.a('function')
      expect(target).to.have.property('$$offAll').that.is.a('function')
    })

    it('mixin function', function () {
      let TargetFunction = function () {}
      TargetFunction.prototype.funcA = () => {}

      EventEmitter.mixin(TargetFunction)

      expect(TargetFunction.prototype).to.have.property('$$on').that.is.a('function')
      expect(TargetFunction.prototype).to.have.property('$$emit').that.is.a('function')
      expect(TargetFunction.prototype).to.have.property('$$once').that.is.a('function')
      expect(TargetFunction.prototype).to.have.property('$$off').that.is.a('function')
      expect(TargetFunction.prototype).to.have.property('$$offAll').that.is.a('function')

      let targetObject = new TargetFunction()

      targetObject.$$on('eventify.mixin', function (eventName, data) {
        expect(eventName).to.be.equal('eventify.mixin')
      })
      targetObject.$$emit('eventify.mixin')
    })

    it('create instance', function () {
      let emitter = new EventEmitter()

      emitter.$$once('eventify', function (eventName, data) {
        expect(data).to.be.equal(10)
      })
      emitter.$$emit('eventify', 10)
    })

    it('extend class', function () {
      class ExtendEventEmitter extends EventEmitter {}
      let myEventEmitter = new ExtendEventEmitter()

      myEventEmitter.$$once('eventify', function (eventName, data) {
        expect(data).to.be.equal(10)
      })
      myEventEmitter.$$emit('eventify', 10)
    })
  })

  describe('emitter', function () {
    let eventifyObj = { myItem: 10 }
    EventEmitter.extend(eventifyObj)

    it('$$on', function () {
      eventifyObj.$$on('eventify', function (eventName, data) {
        expect(eventName).to.be.equal('eventify')
        expect(data).to.be.undefined
        expect(this).to.have.property('myItem').that.is.equal(10)
      })
      eventifyObj.$$emit('eventify')
    })

    it('$$on with data', function () {
      eventifyObj.$$on('eventify.data-number', function (eventName, data) {
        expect(eventName).to.be.equal('eventify.data-number')
        expect(data).to.be.equal(10)
      })
      eventifyObj.$$emit('eventify.data-number', 10)

      eventifyObj.$$on('eventify.data-object', function (eventName, data) {
        expect(data).to.be.a('object')
        expect(data).to.have.property('myValue').that.is.equal(20)
      })
      eventifyObj.$$emit('eventify.data-object', { myValue: 20 })

      eventifyObj.$$on('eventify.data-multiple', function (eventName, arg1, arg2, arg3) {
        expect(arg1).to.be.equal(10)
        expect(arg2).to.be.equal('20')
        expect(arg3).to.be.undefined
      })
      eventifyObj.$$emit('eventify.data-multiple', 10, '20')
    })

    it('$$on sort', function (done) {
      const arr = []
      eventifyObj.$$on('eventify.sort', function () { arr.push('eventify.sort.3rd') }, { name: 'eventify.sort.3rd' })
      eventifyObj.$$on('eventify.sort', function () { arr.push('eventify.sort.1st') }, { name: 'eventify.sort.1st', before: 'eventify.sort.2nd' })
      eventifyObj.$$on('eventify.sort', function () { arr.push('eventify.sort.2nd') }, { name: 'eventify.sort.2nd', before: 'eventify.sort.3rd' })
      eventifyObj.$$on('eventify.sort', function () { arr.push('eventify.sort.4th') }, { name: 'eventify.sort.4th' })
      eventifyObj.$$emit('eventify.sort').then(function () {
        expect(arr).to.deep.equal(['eventify.sort.1st', 'eventify.sort.2nd', 'eventify.sort.3rd', 'eventify.sort.4th'])
        done()
      })
    })

    it('$$on stop', function (done) {
      const arr = []
      eventifyObj.$$on('eventify.stop', function () { arr.push('eventify.stop.1st') })
      eventifyObj.$$on('eventify.stop', function () { arr.push('eventify.stop.2nd'); return Promise.resolve({stop: true}) })
      eventifyObj.$$on('eventify.stop', function () { arr.push('eventify.stop.3rd') })
      eventifyObj.$$emit('eventify.stop').then(function () {
        expect(arr).to.deep.equal(['eventify.stop.1st', 'eventify.stop.2nd'])
        done()
      })
    })

    it('$$once', function () {
      eventifyObj.$$once('eventify.once', function (eventName, data) {
        expect(data).to.be.equal(30)
      })
      eventifyObj.$$emit('eventify.once', 30)
      eventifyObj.$$emit('eventify.once', 300)
    })

    it('with context', function () {
      let Cat = function () {}

      eventifyObj.$$on('eventify.on.with-context', function (eventName, data) {
        expect(data).to.be.equal(30)
        expect(this).to.be.an.instanceof(Cat)
      }.bind(new Cat()))
      eventifyObj.$$emit('eventify.on.with-context', 30)

      eventifyObj.$$once('eventify.once.with-context', function (eventName, data) {
        expect(data).to.be.equal(30)
        expect(this).to.be.an.instanceof(Cat)
      }.bind(new Cat()))
      eventifyObj.$$emit('eventify.once.with-context', 30)
    })

    it('$$off', function () {
      let symbolOff = eventifyObj.$$on('eventify.off', function (eventName, data) {
        expect(data).to.be.equal(40)
      })
      eventifyObj.$$emit('eventify.off', 40)
      eventifyObj.$$off('eventify.off', symbolOff)
      eventifyObj.$$emit('eventify.off', 400)
    })

    it('$$offAll', function () {
      eventifyObj.$$on('eventify.offAll', function (eventName, data) {
        expect(data).to.be.equal(50)
      })
      eventifyObj.$$on('eventify.offAll', function (eventName, data) {
        expect(data).to.be.equal(50)
      })
      eventifyObj.$$emit('eventify.offAll', 50)
      eventifyObj.$$offAll('eventify.offAll')
      eventifyObj.$$emit('eventify.offAll', 500)
    })
  })
})
