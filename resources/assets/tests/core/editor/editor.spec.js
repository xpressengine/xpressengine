import { expect } from 'chai'
import Editor from 'xe/editor'

/* global describe, it */

describe('Editor', function () {
  describe('legacy', function () {
    it('instance', function () {
      expect(window.XEeditor).to.be.an.instanceof(Editor.constructor) // @DEPRECATED
    })
  })

  describe('instance', function () {
    it('instance', function () {
      expect(Editor).to.be.an.instanceof(Editor.constructor)
    })
  })

  describe('interface', function () {
    it('interface', function () {
      expect(Editor.define).to.be.a('function')
      expect(Editor.getEditor).to.be.a('function')
    })
  })
})
