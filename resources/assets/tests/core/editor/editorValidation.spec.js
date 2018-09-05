import { expect } from 'chai'
import { EditorDefineError, EditorToolDefineError } from 'xe/editor/errors/editor.error'
import EditorValidation, { requireOptions } from 'xe/editor/editorValidation'

/* global describe, it */

describe('EditorValidation', function () {
  describe('Editor 정의', function () {
    it('validation에 실패하면 EditorDefineError를 throw', function () {
      expect(() => EditorValidation.isValidEditorOptions({}, {})).to.throw(EditorDefineError)
    })

    it('이미 정의한 이름으로 에디터를 정의하면 throw', function () {
      const interfaces = {}
      Object.entries(requireOptions.interfaces).forEach(element => {
        interfaces[element[1]] = () => {}
      })

      // MyEditor 에디터를 정의하고
      window.XEeditor.editorSet['MyEditor'] = {}

      // 같은 이름으로 다시 정의
      expect(() => EditorValidation.isValidEditorOptions({ name: 'MyEditor' }, interfaces)).to.throw(EditorDefineError)
    })
  })

  describe('EditorTool 정의', function () {
    const events = {}
    Object.entries(requireOptions.tools.events).forEach(element => {
      events[element[1]] = () => {}
    })

    it('validation에 실패하면 EditorToolDefineError를 throw', function () {
      expect(() => EditorValidation.isValidToolsObject({ })).to.throw(EditorToolDefineError)
    })
  })
})
