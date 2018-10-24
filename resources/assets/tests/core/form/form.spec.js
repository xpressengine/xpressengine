import { expect } from 'chai'
import Form, { getForm } from 'xe/form'
import FormEntity from 'xe/form/entity'

/* global describe, it */

describe('Form', function () {
  const appForm = new Form()

  describe('appName', function () {
    it('appName', function () {
      expect(Form.appName()).to.be.equal('Form')
    })
  })

  describe('instance', function () {
    it('EventEmitter 확장', function () {
      expect(appForm).to.have.property('$$on').that.is.a('function')
    })
  })

  describe('get', function () {
    it('Form Element를 FormEntity instance를 반환', function () {
      const element = document.createElement('form')
      expect(appForm.get(element)).to.be.instanceof(FormEntity)
    })
  })

  describe('getForm', function () {
    it('Form Element를 FormEntity instance를 반환', function () {
      const element = document.createElement('form')
      expect(getForm(element)).to.be.instanceof(FormEntity)
    })
  })
})
