import $ from 'jquery'
import App from 'xe/app'
import Vue from 'vue'
import Vuex from 'vuex'
import EventBus from './vue/components/eventBus'
import _ from 'lodash'

import { module as media } from './store'
// import RouteMap from './route_map'
import ComponentApp from './vue/app'
import DialogDeleteFile from './vue/components/dialogs/DialogDeleteFile.vue'

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

const LIST_MODE_ADMIN = 1
const LIST_MODE_USER = 2

/**
* @class 미디어 매니저
* @extends App
*/
class MediaLibrary extends App {
  constructor () {
    super()

    this.componentBooted = false
    this.componentAppInstance = null
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
      _.forEach(options, (val, key) => {
        this.componentAppInstance[key] = val
      })

      if (options.importMode) {
        store.dispatch('media/changeImportMode', options.importMode)
      }

      return Promise.resolve(this.componentAppInstance)
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

      that.componentAppInstance = new Vue({
        el: '#media-library',
        store,
        components: {
          App: ComponentApp
        },
        data: function () {
          return {
            headerTitle: '',
            renderMode: 'inline',
            importMode: options.importMode || 'download', // 'download', 'embed'
            fileFilter: [], // array 'image', 'video'
            listMode: options.listMode || LIST_MODE_ADMIN,
            selectedMedia: [],
            showMedia: null,
            showUpload: false,
            dialog: null,
            currentMedia: null,
            showModal: false,
            user: options.user || { id: null, rating: 'guest' },
            orderTarget: 1,
            orderType: 'up',
            ...options
          }
        },
        computed: {
          isSelectedMedia: function () {
            return !!this.selectedMedia.length
          }
        },
        created: function () {
          this.renderMode = renderMode
          this.headerTitle = (this.listMode === 1) ? 'Main Assets' : '내 최근 파일'
          store.commit('media/SET_IMPORT_MODE', this.importMode)
          store.commit('media/SET_LIST_MODE', this.listMode)

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
            store.dispatch('media/loadData', { fileFilter: this.importMode }).then(() => {
              this.clearSelectedMedia()
              this.$emit('loaded')
              EventBus.$emit('data.loaded')

              if (this.renderMode !== 'widget') {
                that.setupDropzone($('.media-library .form-control--file'), { dropZone: $('.media-library') })
              }
            })
          })

          this.$store.subscribe((mutation) => {
            if (mutation.type === 'media/SET_FILTER') {
              this.clearSelectedMedia()
            }
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
          viewMyFiles (subject) {
            this.listMode = 2
            this.headerTitle = subject
            store.dispatch('media/changeListMode', 2)
          },
          viewDisk (disk, subject) {
            this.listMode = 1
            this.headerTitle = subject
            store.dispatch('media/changeListMode', 1)
          },
          deleteMedia (id) {
            return that.$$xe.delete('media_library.drop', { target_ids: id })
              .then(() => {
                store.state.media.media.splice(store.state.media.media.findIndex(v => v.id === id), 1)
                window.XE.toast('success', '삭제했습니다.')
              })
          },
          removeSelectedMedia (item) {
            if (this.selectedMedia.length) {
              this.selectedMedia.splice(this.selectedMedia.findIndex(v => item.media.id === v), 1)
            }
            this.clearSelectedMedia()
          },
          removeConfirm () {
            EventBus.$emit('dialog.open', DialogDeleteFile)
          },
          remove () {
            if (this.selectedMedia.length) {
              that.$$xe.delete('media_library.drop', { target_ids: this.selectedMedia })
                .then(() => {
                  this.selectedMedia.forEach(function (item) {
                    store.state.media.media.splice(store.state.media.media.findIndex(v => v.id === item), 1)
                  })
                  this.clearSelectedMedia()
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
        }
      })

      resolve(that.componentAppInstance)
    })
  }

  /**
  * 페이지 내 대상 Element에 UI 출력
  * @returns {Promise}
  */
  show (options) {
    return new Promise((resolve) => {
      this._componentBoot({
        renderMode: 'inline',
        listMode: 1,
        ...options
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
    var config = {
      renderMode: 'modal',
      ...options
    }
    return new Promise((resolve) => {
      this._componentBoot(config).then((instance) => {
        if (renderMode === 'modal') {
          $('#media-manager-modal-container').show()
          $('#media-manager-modal-container').find('.media-library-upload').addClass('active')
        }

        resolve(instance)
      })
    })
  }

  createUploader ($el, data, options) {
    var that = this
    var formData = $.extend({}, {
      _token: window.XE.options.userToken,
      instance_id: null
    }, data)

    $(function () {
      var setup = {
        url: window.XE.route('media_library.upload'),
        dataType: 'json',
        sequentialUploads: true,
        // maxChunkSize: 1000000,
        formData: formData,
        progressall: function (e, data) {
          if (data.loaded === data.total) {
            that.$$emit('done.progress.editor', { data })
          } else {
            that.$$emit('update.progress.editor', { data })
          }
        },
        add: function (e, data) {
          data.submit()
        },
        done: function (e, data) {
          that.$$emit('done.upload.editor', {
            file: data.result[0],
            form: data.form
          })
        },
        fail: function (e, data) {
        }
      }

      setup = { ...setup, ...options }

      if (typeof $.fn.fileupload !== 'undefined') {
        $el.fileupload(setup)
      } else {
        console.error('파일 업로더가 초기화되지 않음')
      }
    })
  }

  setupDropzone ($el, options) {
    var that = this
    var $dropZone = $('.media-library')
    $(function () {
      var setup = {
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
        progressall: function (e, data) {
          if (data.loaded === data.total) {
            that.$$emit('done.progress', { data })
          } else {
            that.$$emit('update.progress', { data })
          }
        },
        add: function (e, data) {
          data.submit()
        },
        done: function (e, data) {
          $.each(data.result.files, function (index, file) {
            $('<p/>').text(file.name).appendTo(document.body)
            window.XE.MediaLibrary.$$emit('media.uploaded', file)
          })
          store.dispatch('media/loadData', {
            folder_id: window.XE.config.getters['mediaLibrary/currentFolder'].id
          }).then(() => {
            window.XE.MediaLibrary.$$emit('media.uploaded', store.getters['media/media'](data.result[0].id))
          })
          that.$$emit('done.upload', data.result[0])
        },
        dropZone: $dropZone,
        dragover: function () {
          that.$$emit('on.dropzone')
        },
        dragleave: function () {
          that.$$emit('off.dropzone')
        },
        drop: function () {
          that.$$emit('off.dropzone')
        }
      }

      that.$$on('on.dropzone', function () {
        $dropZone.addClass('dropzone--active')
      })
      that.$$on('off.dropzone', function () {
        $dropZone.removeClass('dropzone--active')
      })

      $.extend(setup, options)

      if (typeof $.fn.fileupload !== 'undefined') {
        $el.fileupload(setup)
      } else {
        console.error('파일 업로더가 없음')
      }
    })
  }
}

export default MediaLibrary
