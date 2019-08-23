<template>
  <div class="media-library-dialog-popup-content">
    <!-- header -->
    <div class="media-library-dialog-popup-header">
      <h3 class="media-library-dialog-popup-header__title">
        <span class="blind">dialog</span>
      </h3>
    </div>

    <!-- body -->
    <div class="media-library-dialog-popup-body">
      <div class="media-library__input-group-box">
        slot:body
      </div>
    </div>

    <!-- footer -->
    <div class="media-library-dialog-popup-footer">
        <button
          @click="close"
          type="button"
          class="media-library__button media-library__button--subtle"
        >취소</button>
    </div>
  </div>
</template>

<script>
import EventBus from '../eventBus'

export default {
  data: function() {
    return {
      name: null
    }
  },
  mounted() {
    EventBus.$on('dialog.open.createFolder', () => {
      EventBus.$emit('dialog.open', this)
    })
  },
  methods: {
    close() {
      EventBus.$emit('dialog.close')
      EventBus.$emit('dialog.close.createFolder')
    },
    create() {
      this.$root.createFolder(this.name, this.$store.getters['media/currentFolder'].id).then(() => {
        this.name = null
        this.close()
      })
    }
  }
}
</script>
