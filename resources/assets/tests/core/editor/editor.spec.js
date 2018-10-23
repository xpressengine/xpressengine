import { expect } from 'chai'
import Editor from 'xe/editor'
import { EditorDefineError } from 'xe/editor/errors/editor.error'
import { requireOptions } from '../../../core/editor/editorValidation'
import EditorDefine from '../../../core/editor/editorDefine'
import { EditorToolDefineError } from '../../../core/editor/errors/editor.error'
import sinon from 'sinon'

/* global describe, it */

describe('Editor', function () {
  describe('legacy instance', function () {
    // @deprecated
    it('window.XEeditor를 노출해야 함', function () {
      expect(window.XEeditor).to.be.an.instanceof(Editor)
    })
    // it('tools define/get 메소드를 가짐', function () {
    //   expect(window.XEeditor.tools).to.be.an('object')
    //   expect(window.XEeditor.tools).to.respondTo('define')
    //   expect(window.XEeditor.tools).to.respondTo('get')
    // })
    // it('몇가지 메소드를 유지해야 함', function () {
    //   expect(window.XEeditor).to.respondTo('getDomSelector')
    // })
  })

  // describe('instance', function () {
  //   it('instance', function () {
  //     expect(Editor).to.be.an.instanceof(Editor.constructor)
  //   })
  // })

  describe('interface', function () {
    beforeEach(function () {
      sinon.stub(console, 'error')
    })

    afterEach(function () {
      console.error.restore()
    })

    describe('Editor 정의', function () {
      const editorInstance = new Editor()
      it('validation 실패 시 console.error 출력', function () {
        editorInstance.define({ editorSettings: {}, interfaces: {} })
        expect(console.error.called).to.be.true
      })

      it('이미 정의한 이름으로 에디터를 정의하면 output error', function () {
        const editorOptions = {
          editorSettings: { name: 'MyEditor' },
          interfaces: {}
        }
        Object.entries(requireOptions.interfaces).forEach(element => {
          editorOptions.interfaces[element[1]] = () => {}
        })

        // MyEditor 에디터를 정의하고
        editorInstance.define(editorOptions)

        // 이름이 같은 에디터를 다시 정의
        editorInstance.define(editorOptions)
        expect(console.error.called).to.be.true
      })

      describe('이름으로 정의된 에디터를 가져올 수 있음', function () {
        it('getEditor()는 Promise를 반환 함', function () {
          expect(editorInstance.getEditor('MyEditor')).to.be.an.instanceof(Promise)
        })

        it('getEditor() onFulfilled 시 EditorDefine instance를 argument로 전달 받음', function (done) {
          editorInstance.getEditor('MyEditor').then((isEditorInstance) => {
            expect(isEditorInstance).to.be.an.instanceof(EditorDefine)
            done()
          })
        })
      })
    })

    describe('EditorTool 정의', function () {
      const editorInstance = new Editor()
      const editorToolOptions = {
        id: 'MyEditorTool',
        events: {}
      }
      Object.entries(requireOptions.tools.events).forEach(element => {
        editorToolOptions.events[element[1]] = () => {}
      })

      it('validation 실패하면 console error 출력', function () {
        editorInstance.defineTool({})
        expect(console.error.called).to.be.true
      })
    })
  })
})
