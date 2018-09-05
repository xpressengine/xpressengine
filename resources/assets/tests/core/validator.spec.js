import { expect } from 'chai'
import $ from 'jquery'
import Validator from 'xe/validator'
import XE from 'xe'
import { xeSetupOptions } from './sample'

/* global describe, it */

describe('Validator', function () {
  const validator = new Validator()

  describe('Instance', function () {
    it('$$.eventify 메소드를 가져야 함', function () {
      expect(validator).to.have.property('$$on').that.is.a('function')
    })

    it('아직 테스트하지 않은 메소드가 존재해야 함', function () {
      expect(validator).to.have.property('setRules').that.is.a('function')
      expect(validator).to.have.property('getRuleName').that.is.a('function')
      expect(validator).to.have.property('check').that.is.a('function')
      expect(validator).to.have.property('checkRuleContainers').that.is.a('function')
      expect(validator).to.have.property('formValidate').that.is.a('function')
      expect(validator).to.have.property('validate').that.is.a('function')
      expect(validator).to.have.property('errorClear').that.is.a('function')
      expect(validator).to.have.property('error').that.is.a('function')
    })

    it('deprecated 메소드를 유지해야 함', function () {
      expect(validator).to.have.property('init').that.is.a('function')
    })
  })

  describe('boot(XE)', function () {
    XE.setup(xeSetupOptions)

    it('locale 멤버를 가져야 함', function () {
      expect(validator).to.have.property('locale').is.equal('ko')
    })
  })

  describe('extendAlertType()', function () {
    it('alert type을 추가할 수 있음', function () {
      validator.extendAlertType('testAlert', function () { return 'testAlertFunction' })
      expect(validator.getAlertType).is.a('function')
      expect(validator.getAlertType('testAlert')()).to.be.equal('testAlertFunction')
    })
  })

  describe('putEvaluator()', function () {
    it('evaluator를 추가할 수 있음', function () {
      validator.putEvaluator('testEvaluator', () => 'returnTestEvaluator')
      expect(validator.getEvaluator('testEvaluator')()).to.be.equal('returnTestEvaluator')
    })
  })

  describe('hasEvaluator()', function () {
    it('evaluator가 있으면 true', function () {
      expect(validator.hasEvaluator('testEvaluator')).to.be.true
    })

    it('evaluator가 없으면 false', function () {
      expect(validator.hasEvaluator('notFoundEvaluator')).to.be.false
    })
  })

  describe('getEvaluator()', function () {
    it('evaluator를 반환해야 함', function () {
      validator.putEvaluator('testEvaluator', () => 'returnTestEvaluator')
      expect(validator.getEvaluator).to.be.a('function')
      expect(validator.getEvaluator('testEvaluator')).to.be.a('function')
    })

    it('evaluator가 없으면 null을 반환', function () {
      expect(validator.getEvaluator('notFoundEvaluator')).to.be.null
    })
  })

  describe('getValue()', function () {
    describe('input type=checkbox', function () {
      it('checked 항목의 값을 반환해야 함', function () {
        expect(validator.getValue($('<input type="checkbox" checked value="yes" />'))).to.be.equal('yes')
      })
      it('checked 항목이 없으면 빈 값을 반환', function () {
        expect(validator.getValue($('<input type="checkbox" value="yes" />'))).to.be.equal('')
      })
    })

    describe('input type=checkbox', function () {
      it('selected 항목의 값을 반환해야 함', function () {
        expect(validator.getValue($('<select><option value="11">1</option><option value="22">2</option><option value="33">3</option></select>'))).to.be.equal('11')
      })
      it('selected 항목이 없으면 첫번째 option의 값을 반환', function () {
        expect(validator.getValue($('<select><option value="11">1</option><option value="22" selected>2</option><option value="333">3</option></select>'))).to.be.equal('22')
      })
    })
  })
})
