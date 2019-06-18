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

/**
* @class 미디어 매니저
* @extends App
*/
class MediaManager extends App {
  constructor () {
    super()

    this.componentBooted = false
  }

  static appName () {
    return 'MediaManager'
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
    return new Promise((resolve) => {
      this.componentBooted = true
      renderMode = options.renderMode

      const ddd = new Vue({
        el: '#media-manager',
        store,
        router,
        components: {
          App: ComponentApp
        },
        data: function () {
          return {
            renderMode: 'inline',
            selectedMedia: []
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

            $(function () {
              if (typeof $.fn.fileupload !== 'undefined') {
                $('.form-control--file').fileupload({
                  dataType: 'json',
                  maxChunkSize: 1000000,
                  formData: () => $('.form-control--file').closest('form').serializeArray(),
                  done: function (e, data) {
                    $.each(data.result.files, function (index, file) {
                      $('<p/>').text(file.name).appendTo(document.body)
                    })
                    store.dispatch('media/addMedia', data.result)
                  }
                })
              } else {
                console.error('파일 업로더가 없음')
              }
            })
          })
        },
        methods: {
          putSelectedMedia: function (item) {
            this.selectedMedia.push(item.media.id)
          },
          removeSelectedMedia: function (item) {
            if (this.selectedMedia.length) {
              this.selectedMedia.splice(this.selectedMedia.findIndex(v => item.media.id === v), 1)
            }
          },
          remove: function () {
            if (this.selectedMedia.length) {
              window.XE.delete('/media_library/file', { file_id: this.selectedMedia })
                .then(() => {
                  this.selectedMedia.forEach(function (item) {
                    store.state.media.media.splice(store.state.media.media.findIndex(v => v.id === item), 1)
                  })
                  this.selectedMedia = []
                })
            }
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
      resolve(ddd)
    })
  }

  /**
  * 페이지 내 대상 Element에 UI 출력
  * @fires mediaManager.show
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
  open () {
    return new Promise((resolve) => {
      this._componentBoot({
        renderMode: 'modal'
      }).then((ddd) => {
        resolve(ddd)
        // show.modal
      })
    })
  }
}

export default MediaManager
