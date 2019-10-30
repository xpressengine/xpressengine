import $ from 'jquery'
import App from 'xe/app'
import Vue from 'vue'
import Vuex from 'vuex'
import EventBus from './vue/components/eventBus'

import { module as media } from './store'
// import RouteMap from './route_map'
import ComponentApp from './vue/app'

import ComponentAttachment from './vue/attachment'

Vue.use(Vuex)
// Vue.use(VueRouter)

const store = new Vuex.Store({
  modules: {
    media
  }
})

// const router = new VueRouter(RouteMap)

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

    const that = this

    return new Promise((resolve) => {
      this.componentBooted = true
      renderMode = options.renderMode

      let $ground = $('#media-library')

      if (!$ground.length) {
        $('body').append('<div id="media-library">')
      }
      that.$$xe.DynamicLoadManager.cssLoad('/assets/core/media_library/css/media-library.css')
      that.$$xe.DynamicLoadManager.cssLoad('/resources/assets/node_modules/cropperjs/dist/cropper.min.css')

      const componentAppInstance = new Vue({
        el: '#media-library',
        store,
        // router,
        components: {
          App: ComponentApp
        },
        data: function () {
          return {
            renderMode: 'inline',
            selectedMedia: [],
            showMedia: null,
            dialog: null,
            currentMedia: null,
            showModal: false
          }
        },
        computed: {
          isSelectedMedia: function () {
            return !!this.selectedMedia.length
          }
        },
        created: function () {
          this.renderMode = renderMode
          Promise.all([window.XE.Router, window.XE.Lang]).then(() => {
            this.$emit('init')
          })
        },
        mounted: function () {
          this.$options._subscribeEvent()

          $('.media-library').on('hide.mobilePanel', function () {
            $('.media-library-dimmed').hide()
          })

          $('.media-library').on('click', '.media-library-dimmed', function () {
            $('.media-library').trigger('hide.mobilePanel')
          })

          this.$on('init', () => {
            store.dispatch('media/loadData').then(() => {
              this.$emit('loaded')
              EventBus.$emit('data.loaded')

              $(function () {
                if (typeof $.fn.fileupload !== 'undefined') {
                  $('.form-control--file').fileupload({
                    url: window.XE.route('media_library.upload'),
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
                      data.submit()
                    },
                    done: function (e, data) {
                      $.each(data.result.files, function (index, file) {
                        $('<p/>').text(file.name).appendTo(document.body)
                      })
                      store.dispatch('media/loadData', {
                        folder_id: window.XE.config.getters['mediaLibrary/currentFolder'].id
                      })
                    }
                  })
                } else {
                  console.error('파일 업로더가 없음')
                }
              })
            })
          })
        },
        methods: {
          showDetailMedia (id) {
            this.showMedia = id
            this.showModal = true
            this.currentMedia = store.getters['media/media'](id)
            this.$emit('show-detail-media', id, store.getters['media/media'](id))
          },
          hideDetailMedia () {
            this.showMedia = null
            this.currentMedia = null
            this.showModal = false
            this.$emit('show-detail-media-closed')
          },
          putSelectedMedia (item) {
            this.selectedMedia.push(item.media.id)
          },
          clearSelectedMedia () {
            this.selectedMedia = []
            $('.media-library-content-list > li').removeClass('active')
            $('.media-library-content-list > li').find('.media-library__input-checkbox').prop('checked', false)
          },
          deleteMedia (id) {
            return that.$$xe.delete('media_library.drop', { target_ids: id })
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
              that.$$xe.delete('media_library.drop', { target_ids: this.selectedMedia })
                .then(() => {
                  this.selectedMedia.forEach(function (item) {
                    store.state.media.media.splice(store.state.media.media.findIndex(v => v.id === item), 1)
                  })
                  this.selectedMedia = []
                })
            }
          },
          showDialog (dialog) {
            this.dialog = dialog
          },
          closeModal () {
            $('#media-manager-modal-container').hide()
          }
        },
        render (h) {
          return h(ComponentApp, {
            propsData: {
              renderMode: this.renderMode,
              currentMedia: this.currentMedia
            }
          })
        },
        _subscribeEvent () {
          EventBus.$on('modal.open', () => {

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
      this._componentBoot({
        renderMode: 'modal'
      }).then((ddd) => {
        if (renderMode === 'modal') {
          $('#media-manager-modal-container').show()
        }

        resolve(ddd)
      })
    })
  }

  render (options) {
    const a = new Vue({
      el: '.ckeditor-fileupload-area',
      components: {
        ComponentAttachment
      },
      data: function () {
        return {
          files: []
        }
      },
      mounted () {
        console.debug('render mounted')
      },
      render (h) {
        return h(ComponentAttachment, {
          propsData: {
            files: this.files
          }
        })
      }
    })

    return this
  }
}

export default MediaLibrary
