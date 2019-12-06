<template>
  <div class="media-library-layer-popup-detail-view" style="position: relative;">
    <div
      class="media-library-layer-popup-detail-view__inner"
      style="padding: 10px; padding-bottom: 60px;"
    >
      <div class="media-library-layer-popup-detail-view__image-box" style="width: 100%;">
        <img
          ref="image"
          id="image-preview"
          :src="srcUrl"
          class="media-library-layer-popup-detail-view__image"
          style="max-width: 100%;"
        />
      </div>
    </div>

    <div
      v-if="modeCommand"
      class="editor-toolbar"
      style="position: absolute; bottom: 20px; left: 0; width: 100%; text-align: center;"
    >
      <div v-if="modeCommand === 'crop'">
        <button @click="completeCrop" type="button">자르기</button>
      </div>
    </div>
  </div>
</template>

<script>
import Cropper from 'cropperjs'
import EventBus from '../eventBus'

export default {
  props: ['media'],
  data: function() {
    return {
      modeCommand: null,
      srcUrl: null
    }
  },
  methods: {
    setMode(mode) {
      EventBus.$emit('photoeditor.setMode', mode)
    },
    commandRotate() {
      const canvas = convertImageToCanvas(document.getElementById('image-preview'))

      canvas.toBlob(blob => {
        const objectURL = URL.createObjectURL(blob)
      })
    },
    completeCrop() {
      this.cropper.getCroppedCanvas().toBlob(blob => {
        const objectURL = URL.createObjectURL(blob)

        this.$store.dispatch('media/replaceMedia', {
          id: this.$props.media.id,
          data: {
            objectURL
          }
        })

        this.srcUrl = objectURL

        this.cropper.destroy()
        this.cropper = null
        this.modeCommand = null
      })

      EventBus.$emit('photoeditor.modeCommand', {
        command: null
      })
    },
    completeEdit() {
      EventBus.$emit('photoeditor.complete')
    },
    enableCrop() {
      this.modeCommand = 'crop'
      EventBus.$emit('photoeditor.modeCommand', {
        command: 'crop'
      })

      if (this.cropper) {
        return
      }

      const that = this
      const image = document.getElementById('image-preview')

      this.cropper = new Cropper(image, {
        viewMode: 2,
        dragMode: 'move',
        zoomable: false,
        autoCropArea: 1,
        ready() {
          that.aspectRatio = this.naturalWidth / this.naturalHeight
          that.zoomRatio = this.width / this.naturalWidth
        },
        zoom(event) {
          that.zoomRatio = event.detail.ratio
        },
        crop(event) {
          const data = event.detail

          EventBus.$emit('photoeditor.image.change', {
            command: 'crop',
            width: Math.round(data.width),
            height: Math.round(data.height),
            left: Math.round(data.x),
            top: Math.round(data.y)
          })
        }
      })
    }
  },
  mounted: function() {
    this.srcUrl = this.thumbnailUrl
    const that = this
    const image = document.getElementById('image-preview')
    this.cropper = null

    window.cropper = this.cropper

    EventBus.$on('photoeditor.setMode', function(mode) {
      if (mode === 'crop') {
        that.cropper.enable()
      } else if (mode === 'resize') {
        that.cropper.destroy()
      }
    })

    EventBus.$on('photoeditor.cropper.crop', payload => {
      this.enableCrop()

      let cropboxRatio = NaN
      const imageData = this.cropper.getImageData()
      const width = imageData.naturalWidth * this.zoomRatio
      const height = imageData.naturalHeight * this.zoomRatio * payload.ratio

      if (payload.ratio === 'original') {
        cropboxRatio = this.aspectRatio
      } else if (payload.ratio === 'free') {
        cropboxRatio = NaN
      } else if (payload.ratio) {
        cropboxRatio = payload.ratio
      }
      this.cropper.setAspectRatio(cropboxRatio)
      this.cropper.crop()
    })

    EventBus.$on('photoeditor.form.change', function(payload) {
      this.enableCrop()

      let width = payload.width || null
      let height = payload.height || null

      if (width) {
        width = width * that.zoomRatio
      }

      if (height) {
        height = height * that.zoomRatio
      }

      that.cropper.setCropBoxData({
        width: width || null,
        height: height || null,
        left: payload.left || null,
        top: payload.top || null
      })
    })

    EventBus.$on('photoeditor.cropper.setDragMode', function(mode) {
      that.cropper.setDragMode(mode)
    })

    EventBus.$on('photoeditor.cropper.rotate', function(degree) {
      const canvas = rotateImage(document.getElementById('image-preview'), degree)

      canvas.toBlob(blob => {
        const objectURL = URL.createObjectURL(blob)
        document.getElementById('image-preview').src = objectURL
      })
    })

    EventBus.$on('photoeditor.saveImage', () => {
      const canvas = convertImageToCanvas(document.getElementById('image-preview'))
      const dataUrl = canvas.toDataURL('image/jpeg')
      const blob = dataURItoBlob(dataUrl)
      blob.name = 'test.jpg'

      let formData = new FormData()
      formData.append('file', blob, 'test.jpg')

      XE.Request.axiosInstance.request({
        url: window.XE.route('media_library.modify_file', { mediaLibraryFileId: this.$props.media.id }),
        data: formData,
        method: 'post',
        headers: {
          'X-CSRF-TOKEN': XE.options.userToken,
          'Content-Type': `multipart/form-data`
        }
      }).then(res => {
        EventBus.$emit('photoeditor.complete')
        XE.toast('success', '저장했습니다.')
      })
    })
  },
  computed: {
    thumbnailUrl() {
      return this.$props.media.file.url
    }
  }
}

const convertImageToCanvas = function(image, degree) {
  const canvas = document.createElement('canvas')
  const width = image.naturalWidth
  const height = image.naturalHeight
  canvas.width = width
  canvas.height = height

  const context = canvas.getContext('2d')
  context.save()
  context.drawImage(image, 0, 0)
  context.restore()

  return canvas
}

const rotateImage = function(image, degree) {
  const canvas = document.createElement('canvas')
  const width = image.naturalWidth
  const height = image.naturalHeight
  canvas.width = height
  canvas.height = width

  const context = canvas.getContext('2d')
  context.save()
  context.translate(canvas.width / 2, canvas.height / 2)
  context.rotate((degree * Math.PI) / 180)
  context.drawImage(image, -width / 2, -height / 2)
  context.restore()

  return canvas
}

function dataURItoBlob(dataURI) {
  var byteString = atob(dataURI.split(',')[1])
  var mimeString = dataURI
    .split(',')[0]
    .split(':')[1]
    .split(';')[0]
  var ab = new ArrayBuffer(byteString.length)
  var ia = new Uint8Array(ab)
  for (var i = 0; i < byteString.length; i++) {
    ia[i] = byteString.charCodeAt(i)
  }

  var bb = new Blob([ab], { type: mimeString })
  return bb
}
</script>
