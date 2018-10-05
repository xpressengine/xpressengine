import { expect } from 'chai'
import Aspect from 'xe/aspect'

/* global describe, it */

function tsetFunction1 () { return 'returnTsetFunction1' }

const dummy = {
  data: {
    before: [],
    after: []
  },
  tsetFunction () { return 'returnTsetFunction2' }
}

describe('Aspect', function () {
  describe('static aspect()', function () {
    it('함수를 노출해야 함', function () {
      expect(Aspect.aspect).is.a('function')
    })

    const instance = Aspect.aspect('tsetFunction', tsetFunction1)

    it('instance를 반환해야 함', function () {
      expect(instance).is.instanceof(Aspect)
    })

    it('instance에 proxy 속성이 있어야 함', function () {
      expect(instance).have.property('proxy')
    })

    it('instance에 before 등의 interface를 노출해야 함', function () {
      expect(instance).have.property('before').that.is.a('function')
      expect(instance).have.property('after').that.is.a('function')
      // expect(instance).have.property('around').that.is.a('function')
      // expect(instance).have.property('afterReturning').that.is.a('function')
      // expect(instance).have.property('afterThrowing').that.is.a('function')
    })
  })

  describe('before()', function () {
    // const instance = Aspect.aspect('dummy.tsetFunction', dummy.tsetFunction)
    // dummy.tsetFunction = instance.proxy
    // let adviceArgs

    // function adviceBeforeTsetFunction1 (args) {
    //   dummy.data.before.push('dataBeforeTsetFunction1')
    //   adviceArgs = args
    // }

    // it('advice를 등록하고 getAdvice()로 등록된 advice를 확인할 수 있어야 함', function () {
    //   instance.before('beforeTsetFunction1', adviceBeforeTsetFunction1)
    //   expect(instance.getAdvice('before', 'beforeTsetFunction1')).is.equal(adviceBeforeTsetFunction1)
    // })

    // describe('target이 실행되면', function () {
    //   const callArgs = ['argsText1', 'argsText2', ['argsArrayItem']]
    //   adviceBeforeTsetFunction1(callArgs)

    //   it('before advice가 동작해야 함', function () {
    //     expect('dataBeforeTsetFunction1').to.be.oneOf(dummy.data.before)
    //   })

    //   it('target 호출 시 arguments가 advice에 첫번째 argument에 전달되어야 함 ', function () {
    //     expect(adviceArgs).to.be.equal(callArgs)
    //   })
    // })
  })

  // describe('afterReturning()', function () {
  //   describe('target이 무엇도 반환하지 않는다면', function () {
  //     let res = null
  //     var noresultFunction = function () { }
  //     const instance = Aspect.aspect('noresultFunction', noresultFunction)
  //     noresultFunction = instance.proxy

  //     it('advisor가 동작하지 않아야 함', function () {
  //       instance.afterReturning('adviceafterReturning', (args, result) => { res = 'result' })
  //       noresultFunction()
  //       expect(res).to.be.null
  //     })
  //   })

  //   describe('target이 결과를 반환하면', function () {
  //     let res = null
  //     let returnFunction = function (a) { return 'result1' }
  //     const instance = Aspect.aspect('returnFunction', returnFunction)
  //     returnFunction = instance.proxy
  //     instance.afterReturning('adviceafterReturning', (args, result) => { res = result })
  //     returnFunction('argText')

  //     it('advisor에 result가 전달되어야 함', function () {
  //       expect(res).to.be.equal('result1')
  //     })
  //   })
  // })

  // describe('afterThrowing()', function () {
  //   describe('target이 무엇도 반환하지 않는다면', function () {
  //     let res = null
  //     var noresultFunction = function () { }
  //     const instance = Aspect.aspect('noresultFunction', noresultFunction)
  //     noresultFunction = instance.proxy

  //     it('advisor가 동작하지 않아야 함', function () {
  //       instance.afterReturning('adviceafterReturning', (args, result) => { res = 'result' })
  //       noresultFunction()
  //       expect(res).to.be.null
  //     })
  //   })
  // })
})
