<template>
  <div class="media-library-dialog-popup-content">
    <!-- header -->
    <div class="media-library-dialog-popup-header">
      <h3 class="media-library-dialog-popup-header__title">파일 삭제</h3>
    </div>

    <!-- body -->
    <div class="media-library-dialog-popup-body">
      <div class="media-library__input-group-box">
        <span class="media-library__input-group-title">
          <p>파일을 삭제하시겠습니까?<br>삭제한 파일은 복구할 수 없습니다.</p>
        </span>
      </div>
    </div>

    <!-- footer -->
    <div class="media-library-dialog-popup-footer">
      <button
        @click="close"
        type="button"
        class="media-library__button media-library__button--subtle"
      >취소</button>
      <button
        @click="deleteFile"
        type="button"
        class="media-library__button media-library__button--subtle"
      >삭제</button>
    </div>
  </div>
</template>

<script>
import EventBus from '../eventBus'

export default {
  props: ['media'],
  data: function() {
    return {}
  },
  methods: {
    close() {
      EventBus.$emit('dialog.close')
    },
    deleteFile() {
      let target_ids = []

      if (this.media && this.media.id) {
        target_ids.push(this.media.id)
      } else {
        target_ids = [...this.$root.selectedMedia]
      }

      window.XE.delete('media_library.drop', { target_ids: target_ids })
        .then(() => {
          EventBus.$emit('dialog.close')
          EventBus.$emit('modal.close')
          this.$store.dispatch('media/deleteMedia', target_ids)
        })
    }
  }
}
</script>
