<template>
  <div v-if="$root.dialog === 'create-folder'" class="media-library-dialog-popup">
    <div class="media-library-dialog-popup-table">
      <div class="media-library-dialog-popup-table-cell">
        <div class="media-library-dialog-popup-content-box">
          <div class="media-library-dialog-popup-content">
            <div class="media-library-dialog-popup-header">
              <h3 class="media-library-dialog-popup-header__title">
                새 폴더
                <span class="blind">레이어 팝업</span>
              </h3>
            </div>
            <div class="media-library-dialog-popup-body">
              <div class="media-library__input-group-box">
                <span class="media-library__input-group-title">
                  <label for="createFolderName">폴더 이름</label>
                </span>
                <div class="media-library__input-group">
                  <input type="text" id="createFolderName" class="media-library__input-text" v-model="name" />
                </div>
              </div>
            </div>
            <div class="media-library-dialog-popup-footer">
              <button @click="close" type="button" class="media-library__button media-library__button--subtle">취소</button>
              <button @click="create" type="button" class="media-library__button media-library__button--primary">만들기</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      name: null
    }
  },
  methods: {
    close () {
      this.$root.dialog = null;
    },
    create () {
      this.$root.createFolder(this.name, this.$store.getters['media/currentFolder'].id).then(() => {
        this.name = null
        this.close()
      })
    }
  }
}
</script>
