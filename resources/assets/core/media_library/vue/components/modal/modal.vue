<template>
  <div
    v-if="visible"
    class="media-library-layer-popup media-library-layer-popup--align-center media-library-layer-popup--media-detail"
  >
    <div class="media-library-layer-popup-content">
      <div class="media-library-layer-popup-content-inner">
        <div class="media-library-layer-popup-header">
          <h3 class="media-library-layer-popup-header__title">
            <slot name="headerTitle">타이틀</slot>
            <span class="blind">레이어 팝업</span>
          </h3>
          <!-- [D] 모바일에서 class="media-library-layer-popup__button-close" 버튼 클릭 시 팝업 닫기 기능 적용 (PC 에서는 해당 버튼 숨겨짐) -->
          <button @click="closeModal" type="button" class="media-library-layer-popup__button-close">
            <span class="blind">파일 상세정보 레이어 팝업 닫기</span>
            <span class="media-library-layer-popup__button-close-image"></span>
          </button>

          <!-- 툴바 -->
          <slot name="toolbar">툴바</slot>
        </div>

        <div class="media-library-layer-popup-body">
          <div class="media-library-layer-popup-detail">
            <slot name="body">
              <div class="media-library-layer-popup-detail-view">
                <div class="media-library-layer-popup-detail-view__inner">slot:body</div>
              </div>
            </slot>


              <slot v-if="showAside" name="aside"></slot>
          </div>
        </div>

        <div v-if="showFooter" class="media-library-layer-popup-footer">
          <slot name="footer"></slot>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import EventBus from '../eventBus'

export default {
  data() {
    return {
      visible: false,
      showFooter: false,
      showAside: true,
      showBody: true
    }
  },
  methods: {
    nextMedia() {
      EventBus.$emit('modal.nextMedia')
    },
    prevMedia() {
      EventBus.$emit('modal.prevMedia')
    },
    closeModal() {
      EventBus.$emit('modal.close')
    }
  },
  created: function() {
    EventBus.$on('modal.open', (mediaId, slots = {}, options = {}) => {
      this.visible = true
    })

    EventBus.$on('modal.close', () => {
      this.visible = false
    })
  }
}
</script>
