<template>
  <div class="media-library-dialog-popup-content">
    <!-- header -->
    <div class="media-library-dialog-popup-header">
      <h3 class="media-library-dialog-popup-header__title">새 폴더</h3>
    </div>

    <!-- body -->
    <div class="media-library-dialog-popup-body">
      <div class="media-library__input-group-box">
        <span class="media-library__input-group-title">
          <label for="createFolderName">폴더 이름</label>
        </span>
        <div class="media-library__input-group">
          <input type="text" class="media-library__input-text" v-model="folderName" />
        </div>
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
        @click="create"
        type="button"
        class="media-library__button media-library__button--subtle"
      >만들기</button>
    </div>
  </div>
</template>

<script>
import EventBus from '../eventBus'

export default {
  data: function() {
    return {
      folderName: ''
    }
  },
  mounted() {},
  methods: {
    close() {
      EventBus.$emit('dialog.close')
    },
    create() {
      window.XE.post('media_library.store_folder', {
        name: this.folderName,
        parent_id: this.$store.getters['media/currentFolder'].id,
        disk: 'media'
      })
      .then(response => {
        this.folderName = ''
        this.close()
        this.$store.dispatch('media/loadData', { folder_id: response.data[0].parent_id })
      })
    }
  }
}
</script>
