import $ from 'jquery'
import App from 'xe/app'
import Vue from 'vue'
import Vuex from 'vuex'
import VueRouter from 'vue-router'

import { module as media } from './store'
import RouteMap from './route_map'
import ComponentApp from './vue/app'

Vue.use(Vuex)
Vue.use(VueRouter)

const store = new Vuex.Store({
  modules: {
    media
  }
})

const router = new VueRouter(RouteMap)

let renderMode = 'inline'

let componentAppInstance = null

/**
* @class 미디어 매니저
* @extends App
*/
class MediaLibrary extends App {
  constructor () {
    super()

    this.componentBooted = false
  }

  static appName () {
    return 'MediaLibrary'
  }

  boot (XE, config) {
    if (this.booted()) {
      return Promise.resolve(this)
    }

    return new Promise((resolve) => {
      super.boot(XE)
      resolve(this)
    })
  }

  /**
  * vue 컴포넌트 초기화
  * @returns {Promise}
  */
  _componentBoot (options) {
    if (this.componentBooted) {
      return Promise.resolve(componentAppInstance)
    }

    return new Promise((resolve) => {
      this.componentBooted = true
      renderMode = options.renderMode

      let $ground = $('#media-library')

      if (!$ground.length) {
        $('body').append('<div id="media-library">')
      }
      window.XE.DynamicLoadManager.cssLoad('/assets/core/media_library/css/media-library.css')

      const componentAppInstance = new Vue({
        el: '#media-library',
        store,
        router,
        components: {
          App: ComponentApp
        },
        data: function () {
          return {
            renderMode: 'inline',
            selectedMedia: [],
            showMedia: null,
            dialog: null
          }
        },
        computed: {
          isSelectedMedia: function () {
            return !!this.selectedMedia.length
          }
        },
        created: function () {
          this.renderMode = renderMode

          store.dispatch('media/loadData').then(() => {
            router.push({ name: 'home' })

            this.$emit('loaded')

            $(function () {
              if (typeof $.fn.fileupload !== 'undefined') {
                $('.form-control--file').fileupload({
                  url: '/media_library/file',
                  dataType: 'json',
                  sequentialUploads: true,
                  // maxChunkSize: 1000000,
                  formData: () => {
                    return [
                      {
                        name: '_token',
                        value: window.XE.options.userToken
                      },
                      {
                        name: 'folder_id',
                        value: window.XE.config.getters['mediaLibrary/currentFolder'].id
                      }
                    ]
                  },
                  add: function (e, data) {
                    console.debug('JF::add', data)
                    data.submit()
                  },
                  done: function (e, data) {
                    $.each(data.result.files, function (index, file) {
                      $('<p/>').text(file.name).appendTo(document.body)
                    })
                    // store.dispatch('media/addMedia', data.result)
                    store.dispatch('media/loadData', () => {
                      return {
                        folder_id: window.XE.config.getters['mediaLibrary/currentFolder'].id
                      }
                    })
                  }
                })
              } else {
                console.error('파일 업로더가 없음')
              }
            })
          })
        },
        methods: {
          showDetailMedia (id) {
            this.showMedia = id
            this.$emit('show-detail-media', id, store.getters['media/media'](id))
          },
          hideDetailMedia () {
            this.showMedia = null
            this.$emit('show-detail-media-closed')
          },
          createFolder (name, parent = null, disk = null) {
            return window.XE.post('/media_library/folder', {
              name: name,
              parent_id: parent || this.$store.getters['media/currentFolder'].id,
              disk: 'media'
            })
              .then((response) => {
                this.$store.dispatch('media/loadData', { folder_id: response.data[0].parent_id })
              })
          },
          putSelectedMedia (item) {
            this.selectedMedia.push(item.media.id)
          },
          clearSelectedMedia () {
            this.selectedMedia = []
          },
          deleteMedia (id) {
            return window.XE.delete('/media_library', { target_ids: id })
              .then(() => {
                store.state.media.media.splice(store.state.media.media.findIndex(v => v.id === id), 1)
              })
          },
          removeSelectedMedia (item) {
            if (this.selectedMedia.length) {
              this.selectedMedia.splice(this.selectedMedia.findIndex(v => item.media.id === v), 1)
            }
          },
          remove () {
            if (this.selectedMedia.length) {
              window.XE.delete('/media_library', { target_ids: this.selectedMedia })
                .then(() => {
                  this.selectedMedia.forEach(function (item) {
                    store.state.media.media.splice(store.state.media.media.findIndex(v => v.id === item), 1)
                  })
                  this.selectedMedia = []
                })
            }
          },
          showDialog (dialog) {
            console.debug('showDialog', dialog)
            this.dialog = dialog
          }
        },
        render (h) {
          return h(ComponentApp, {
            props: {
              renderMode
            }
          })
        }
      })

      resolve(componentAppInstance)
    })
  }

  /**
  * 페이지 내 대상 Element에 UI 출력
  * @returns {Promise}
  */
  show () {
    return new Promise((resolve) => {
      this._componentBoot({
        renderMode: 'inline'
      }).then((ddd) => {
        resolve(ddd)
      })
    })
  }

  /**
  * 팝업 UI로 열기
  * @returns {Promise}
  */
  open (options) {
    return new Promise((resolve) => {
      console.debug('ML:open()', options)
      this._componentBoot({
        renderMode: 'modal'
      }).then((ddd) => {
        if (renderMode === 'modal') {
          $('#media-manager-modal-container').show()
        }

        resolve(ddd)
        this.$$emit('modal.open', 'test')
      })
    })
  }
}

export default MediaLibrary
