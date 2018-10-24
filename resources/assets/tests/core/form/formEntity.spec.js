import { expect } from 'chai'
import FormEntity from 'xe/form/entity'

/* global describe, it */

describe('FormEntity', function () {
  const formEl = document.createElement('form')

  describe('instance', function () {
    const form = new FormEntity(formEl)

    it('EventEmitter 확장', function () {
      expect(form).to.have.property('$$on').that.is.a('function')
    })

    describe('생성', function () {
      describe('DOM', function () {
        it('HTMLFormElement로 FormEntity instance 생성', function () {
          const element = document.createElement('form')
          const instance = new FormEntity(element)
          expect(instance).to.be.instanceof(FormEntity)
          expect(instance).to.have.property('element')
          expect(instance.element).to.be.instanceof(HTMLFormElement)
        })

        it('하위 Element 전달 시 상위 HTMLFormElement로 FormEntity instance 생성', function () {
          const element = document.createElement('form')
          const input = document.createElement('input')
          element.appendChild(input)
          const instance = new FormEntity(input)
          expect(instance).to.be.instanceof(FormEntity)
          expect(instance).to.have.property('element')
          expect(instance.element).to.be.instanceof(HTMLFormElement)
        })
      })

      describe('jQuery Object', function () {
        it('Form Element를 담은 jQuery Object에서 FormEntity instance 생성', function () {
          const element = document.createElement('div')
          element.appendChild(document.createElement('form'))
          const instance = new FormEntity($('form', element))
          expect(instance).to.be.instanceof(FormEntity)
          expect(instance).to.have.property('element')
          expect(instance.element).to.be.instanceof(HTMLFormElement)
        })

        it('하위 Element 전달 시 상위 Form을 찾아 FormEntity instance 생성', function () {
          const element = document.createElement('form')
          element.appendChild(document.createElement('input'))
          const instance = new FormEntity($('input', element))
          expect(instance).to.be.instanceof(FormEntity)
          expect(instance).to.have.property('element')
          expect(instance.element).to.be.instanceof(HTMLFormElement)
        })
      })
    })
  })


  describe('event', function () {
    describe('submit', function () {
      const form = document.createElement('form')
      const instance = new FormEntity(form)
      it('preventSubmit', function (done) {
        instance.$$on('submit', function (eventName, element, event, preventSubmit) {
          preventSubmit()
        })

        instance.$$emit('submit', instance.element, {}, instance.preventSubmit.bind(instance))
          .then(function () {
            expect(instance.preventedSubmit).to.be.true
            done()
          })
      })
    })
  })
})
