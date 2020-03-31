<template>
  <div class="media-library-layer-popup-detail-info">
    <div class="media-library-layer-popup-detail-info__inner">
      <div
        class="media-library-layer-popup-detail-info-content media-library-layer-popup-detail-info-content--edit-mode"
      >
        <dl v-if="!modeCommand">
          <dt>
            <label for="mediaLibraryDetailImageSize">이미지 크기 조정</label>
          </dt>
          <dd>
            <div class="media-library-layer-popup-detail-info-content__description-box">
              <p
                class="media-library-layer-popup-detail-info-content__description-text"
              >원본 이미지를 비율대로 크기를 줄일 수 있습니다.</p>
              <p class="media-library-layer-popup-detail-info-content__description-text">
                원본크기 :
                <span
                  class="media-library-layer-popup-detail-info-content__size-text"
                >{{ media.file.width }}x{{ media.file.height }}</span>
              </p>
            </div>
            <div class="media-library__input-group">
              <input
                type="text"
                class="media-library__input-text"
                id="mediaLibraryDetailImageSize"
                style="width: 80px;"
                :value="imageWidth"
              />
            </div>
            <span class="media-library-layer-popup-detail-info-content__etc-text">x</span>
            <div class="media-library__input-group">
              <input
                type="text"
                class="media-library__input-text"
                style="width: 80px;"
                :value="imageHeight"
              />
            </div>
            <button
              type="button"
              class="media-library__button media-library__button--primary media-library__button--icon"
            >
              <span class="media-library__button-icon media-library__button-icon--check"></span>
            </button>
          </dd>
        </dl>

        <dl v-if="modeCommand === 'crop'">
          <dt>
            <label for="mediaLibraryDetailImageCut">이미지 자르기</label>
          </dt>
          <dd>
            <div class="media-library-layer-popup-detail-info-content__description-box">
              <p
                v-if="false"
                class="media-library-layer-popup-detail-info-content__description-text"
              >픽셀 사이즈를 입력해서 이미지를 자를 수 있습니다. 이미지를 클릭하고 드래그하세요.</p>
            </div>

            <div class="media-library__input-group">
              <input
                @change="changeCropSize('width', $event)"
                :value="cropWidth"
                type="text"
                class="media-library__input-text"
                id="mediaLibraryDetailImageCut"
                style="width: 80px;"
                disabled
              />
            </div>
            <span class="media-library-layer-popup-detail-info-content__etc-text">x</span>
            <div class="media-library__input-group">
              <input
                @change="changeCropSize('height', $event)"
                :value="cropHeight"
                type="text"
                class="media-library__input-text"
                style="width: 80px;"
                disabled
              />
            </div>
          </dd>
        </dl>
      </div>
    </div>
    <div class="media-library-layer-popup-detail-info-footer">
      <button @click="recovery" type="button" class="media-library__button media-library__button--subtle">취소</button>
      <button @click="saveImage" type="button" class="media-library__button media-library__button--primary">저장하기</button>
    </div>
  </div>
</template>

<script>
import te from './MediaEditImageSlotBody.vue'
import EventBus from '../eventBus'

export default {
  props: ['media'],
  data: function() {
    return {
      modeCommand: null,
      imageWidth: null,
      imageHeight: null,
      aspectRatio: NaN,
      cropWidth: null,
      cropHeight: null,
      cropLeft: 0,
      cropTop: 0
    }
  },
  mounted: function() {
    this.cropWidth = this.imageWidth = this.media.file.width
    this.cropHeight = this.imageHeight = this.media.file.height

    EventBus.$on('photoeditor.image.change', payload => {
      if (payload.command === 'crop') {
        this.cropWidth = this.imageWidth = payload.width
        this.cropHeight = this.imageHeight = payload.height
        this.cropLeft = payload.left
        this.cropTop = payload.top
      }
    })

    EventBus.$on('saved.photoeditor', payload => {
      EventBus.$emit('photoeditor.complete')
    })

    EventBus.$on('photoeditor.modeCommand', payload => {
      this.modeCommand = payload.command
    })
  },
  methods: {
    changeCropSize(type, event) {
      EventBus.$emit('photoeditor.form.change', {
        command: 'crop',
        [type]: Math.round(event.target.value)
      })
    },
    saveImage () {
      EventBus.$emit('photoeditor.saveImage')
    },
    recovery() {
      this.$store.dispatch('media/replaceMedia', {
        id: this.$props.media.id,
        data: {
          objectURL: null
        }
      })
      EventBus.$emit('photoeditor.complete')
    }
  }
}
</script>
