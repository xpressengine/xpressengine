<template>
  <div class="media-library-layer-popup-detail-view">
    <div class="media-library-layer-popup-detail-view__inner">
      <slot name="content">
        <button
          @click="prevMedia"
          type="button"
          class="media-library-layer-popup-detail-view__button-left"
        >
          <i class="xi-angle-left-min">
            <span class="blind">이전 파일 보기</span>
          </i>
        </button>

        <div v-if="isMedia" class="media-library-layer-popup-detail-view__image-box">
          <img :src="thumbnailUrl" class="media-library-layer-popup-detail-view__image" />
        </div>
        <div v-if="!isMedia" class="media-library-layer-popup-detail-view__image-box">
          <p>{{ media.file.clientname }}</p>
        </div>

        <button
          @click="nextMedia"
          type="button"
          class="media-library-layer-popup-detail-view__button-right"
        >
          <i class="xi-angle-right-min">
            <span class="blind">다음 파일 보기</span>
          </i>
        </button>

        <button
          v-if="editable"
          @click="editImage"
          type="button"
          class="media-library-layer-popup-detail-view__button-update"
        >이미지 편집</button>
      </slot>
    </div>
  </div>
</template>

<script>
import EventBus from '../../eventBus'
import MediaEditImageSlotBody from '../../media/MediaEditImageSlotBody.vue'
import MediaEditImageSlotToolbar from '../../media/MediaEditImageSlotToolbar.vue'
import MediaEditImageSlotAside from '../../media/MediaEditImageSlotAside.vue'

export default {
  props: ['media'],
  data() {
    return {}
  },
  mounted: function() {},
  methods: {
    prevMedia() {
      EventBus.$emit('modal.prevMedia')
    },
    nextMedia() {
      EventBus.$emit('modal.nextMedia')
    },
    editImage() {
      EventBus.$emit('modal.open', this.media.id, {
        headerTitle: '이미지 편집',
        body: MediaEditImageSlotBody,
        toolbar: MediaEditImageSlotToolbar,
        aside: MediaEditImageSlotAside
      })
    }
  },
  computed: {
    isMedia () {
      return this.editable
    },
    editable () {
      return ['gif', 'png', 'jpeg', 'jpg'].includes(this.$props.media.ext)
    },
    thumbnailUrl() {
      return this.$props.media.objectURL || this.$props.media.file.url
    }
  }
}
</script>
