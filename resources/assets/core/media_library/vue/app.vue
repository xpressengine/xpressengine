<script>
import MainContainer from './components/main-container.vue'
import DetailContainer from './components/detail-container.vue'
import DetailModal from './components/modal/modal.vue'
import DialogContainer from './components/dialogs/dialog.vue'
import DialogCreateFolder from './components/dialogs/DialogCreateFolder.vue'
import SlotDetailBody from './components/modal/slots/detail-body.vue'
import SlotDetailToolbar from './components/modal/slots/detail-toolbar.vue'
import SlotDetailAside from './components/modal/slots/detail-aside.vue'
import $ from 'jquery'
import EventBus from './components/eventBus'

export default {
  props: ['renderMode', 'currentMedia'],
  components: {
    MainContainer,
    DetailContainer,
    DetailModal,
    DialogContainer,
    DialogCreateFolder,
  },
  methods: {
    importMedia() {
      const mediaList = []

      this.$root.selectedMedia.forEach(item => {
        const media = this.$store.getters['media/media'](item)
        if (typeof media !== 'undefined') {
          media.thumbnailUrl = '/storage/app/' + media.file.path + '/' + media.file.filename
          mediaList.push(media)
        }
      })

      window.XE.MediaLibrary.$$emit('media.import', mediaList, {
        importMode: this.$root.importMode
      })

      if (typeof this.$root.selected === 'function') {
        this.$root.selected(mediaList)
      }

      if (this.$root.renderMode === 'modal') {
        $('#media-manager-modal-container').hide()
      }

      this.$root.clearSelectedMedia()
    }
  },
  mounted: function() {
    this.$root.$on('show-detail-media', (id, media) => {
      this.media = media
    })

    EventBus.$on('modal.open', (mediaId, slots = {}, options = {}) => {
      this.media = this.$store.getters['media/media'](mediaId)

      // 슬롯 교체
      _.forEach(slots, (slot, name) => {
        this.modal.slots[name] = slot
      })
    })

    EventBus.$on('photoeditor.complete', (payload) => {
      this.modal.slots.headerTitle = '파일 상세보기'
      this.modal.slots.body = SlotDetailBody
      this.modal.slots.aside = SlotDetailAside
      this.modal.slots.toolbar = SlotDetailToolbar
    })

    EventBus.$on('modal.close', () => {
      this.media = null
    })

    EventBus.$on('modal.prevMedia', () => {
      if (this.media && this.media.id) {
        this.media = this.$store.getters['media/prevMedia'](this.media.id)
      }
    })

    EventBus.$on('modal.nextMedia', () => {
      if (this.media && this.media.id) {
        this.media = this.$store.getters['media/nextMedia'](this.media.id)
      }
    })
  },
  data() {
    return {
      showModal: false,
      media: null,
      modal: {
        slots: {
          headerTitle: '타이틀',
          body: SlotDetailBody,
          toolbar: SlotDetailToolbar,
          aside: SlotDetailAside
        }
      }
    }
  }
}
</script>

<template>
  <div>
    <div
      ref="app"
      id="media-manager-modal-container"
      :class="{
        'media-library-layer-popup': true,
        'media-library-layer-popup--media-library': true,
        'media-library-layer-popup--sidebar': $root.user.rating == 'super',
        'media-library-layer-popup--upload': true
      }"
      tabindex="-1"
      role="dialog"
      v-if="$root.renderMode === 'modal'"
    >
      <div class="media-library-layer-popup-content">
        <div class="media-library-layer-popup-header">
          <h3 class="blind">미디어 라이브러리</h3>
        </div>
        <div class="media-library-layer-popup-body">
          <main-container></main-container>
        </div>
        <div class="media-library-layer-popup-footer">
          <button
            @click="$root.closeModal"
            type="button"
            class="media-library__button media-library__button--subtle"
          >닫기</button>
          <button
            @click="importMedia"
            type="button"
            class="media-library__button media-library__button--primary"
          >삽입</button>
        </div>
      </div>
    </div>
    <main-container v-else></main-container>

    <detail-container></detail-container>

    <detail-modal>
      <template v-slot:headerTitle>
        {{ modal.slots.headerTitle }}
      </template>
      <template v-slot:toolbar>
        <component :is="modal.slots.toolbar" :media="media"></component>
      </template>
      <template v-slot:body>
        <component :is="modal.slots.body" :media="media"></component>
      </template>
      <template v-slot:aside>
        <component :is="modal.slots.aside" :media="media"></component>
      </template>
    </detail-modal>

    <dialog-container :media="media"></dialog-container>
  </div>
</template>
