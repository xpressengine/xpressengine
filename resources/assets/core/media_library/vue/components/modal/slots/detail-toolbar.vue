<template>
  <div class="media-library-layer-popup_button-box" style="display: flex;">
    <!-- 편집 -->
    <button
      v-if="editable"
      @click="editImage"
      type="button"
      class="media-library__button media-library__button--subtle media-library__button--icon"
    >
      <span class="media-library__button-icon media-library__button-icon--edit"></span>
    </button>
    <!-- 다운로드 -->
    <button
      @click="downloadAsset"
      type="button"
      class="media-library__button media-library__button--subtle media-library__button--icon"
    >
      <span class="media-library__button-icon media-library__button-icon--download"></span>
    </button>
    <!-- 삭제 -->
    <button
      @click="deleteFile"
      type="button"
      class="media-library__button media-library__button--subtle media-library__button--icon"
    >
      <span class="media-library__button-icon media-library__button-icon--trash"></span>
    </button>
    <!--
      [D] 내부 class="media-library__button" 클릭 시 버튼 영역에 class="button-selected" 추가하고,
      class="media-library-button-data" 영역에 class="open" 추가
      class="open" 추가 시 리스트 영역 레이어 노출 됨
    -->
    <div class="media-library-button-data">
      <button
        type="button"
        class="media-library__button media-library__button--subtle media-library__button--icon"
      >
        <span class="media-library__button-icon media-library__button-icon--ellipsis"></span>
      </button>
      <ul class="media-library-button-data__list">
        <li>
          <button type="button" class="media-library-button-data__button">새 창에서 열기</button>
        </li>
        <li>
          <button type="button" class="media-library-button-data__button">이동</button>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import EventBus from '../../eventBus'
import MediaEditImageSlotBody from '../../media/MediaEditImageSlotBody.vue'
import MediaEditImageSlotToolbar from '../../media/MediaEditImageSlotToolbar.vue'
import MediaEditImageSlotAside from '../../media/MediaEditImageSlotAside.vue'
import DialogDeleteFile from '../../dialogs/DialogDeleteFile.vue'

export default {
  props: ['media'],
  data() {
    return {}
  },
  methods: {
    editImage() {
      EventBus.$emit('modal.open', this.media.id, {
        headerTitle: '이미지 편집',
        body: MediaEditImageSlotBody,
        toolbar: MediaEditImageSlotToolbar,
        aside: MediaEditImageSlotAside
      })
    },
    downloadAsset() {
      window.location.href = this.media.file.download_url
    },
    deleteFile() {
      EventBus.$emit('dialog.open', DialogDeleteFile)
    }
  },
  computed: {
    editable () {
      return ['gif', 'png', 'jpeg', 'jpg'].includes(this.$props.media.ext)
    },
  }
}
</script>
