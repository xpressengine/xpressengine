<template>
  <div v-if="$root.dialog === 'delete-media'" class="media-library-dialog-popup media-library-dialog-popup--delete">
    <div class="media-library-dialog-popup-table">
      <div class="media-library-dialog-popup-table-cell">
        <div class="media-library-dialog-popup-content-box">
          <div class="media-library-dialog-popup-content">
            <div class="media-library-dialog-popup-header">
              <h3 class="media-library-dialog-popup-header__title">
                선택한 아이템을 삭제하시겠습니까?
                <span class="blind">레이어 팝업</span>
              </h3>
            </div>
            <div class="media-library-dialog-popup-body">
              <p class="media-library-dialog-popup__text">선택한 아이템이 영구적으로 삭제됩니다.</p>
            </div>
            <div class="media-library-dialog-popup-footer">
              <button @click="close" type="button" class="media-library__button media-library__button--subtle">취소</button>
              <button @click="deleteItems" type="button" class="media-library__button media-library__button--danger">삭제</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      name: null
    };
  },
  methods: {
    close() {
      this.$root.dialog = null;
    },
    deleteItems() {
      this.$root.remove()
    }
  }
};
</script>
