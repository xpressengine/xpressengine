<script>
import MainContainer from './components/main-container.vue'
import DetailContainer from './components/detail-container.vue'
import $ from 'jquery'

export default {
  props: ['renderMode'],
  components: {
    MainContainer,
    DetailContainer
  },
  methods: {
    importMedia() {
      const mediaList = []

      this.$root.selectedMedia.forEach(item => {
        const media = this.$store.getters['media/media'](item)
        media.thumbnailUrl = '/storage/app/' + media.file.path + '/' + media.file.filename
        mediaList.push(media)
      })

      window.XE.MediaLibrary.$$emit('media.import', mediaList)

      if (this.$root.renderMode === 'modal') {
        $('#media-manager-modal-container').hide()
      }
    }
  },

  data() {
    return {
    }
  }
}
</script>

<template>
  <div>
    <div
      id="media-manager-modal-container"
      class="media-library-layer-popup media-library-layer-popup--media-library"
      tabindex="-1"
      role="dialog"
      v-if="$props.renderMode === 'modal'"
    >
      <div class="media-library-layer-popup-content">
        <div class="media-library-layer-popup-header">
          <h3 class="blind">미디어 라이브러리 레이어팝업</h3>
        </div>
        <div class="media-library-layer-popup-body">
          <main-container></main-container>
        </div>
        <div class="media-library-layer-popup-footer">
          <button @click="$root.closeModal" type="button" class="media-library__button media-library__button--subtle">닫기</button>
          <button @click="importMedia" type="button" class="media-library__button media-library__button--primary">삽입</button>
        </div>
      </div>
    </div>

    <main-container v-else></main-container>

    <detail-container></detail-container>
  </div>
</template>
