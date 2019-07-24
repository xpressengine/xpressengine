<template>
  <!--
    [D] PC화면에서 리스트 클릭 시(li 클릭 시) class="active" 추가, class="active" 추가 될 때 class="media-library__input-checkbox" 체크박스에 체크 및 체크해제 적용!!
    PC화면에서 리스트 더블 클릭 시 편집하기 창 노출

    [D] 모바일화면에서 체크박스 선택 시 class="active" 추가, 체크박스 체크 및 해제 적용
    모바일화면에서 리스트 클릭 시 (li 클릭 시) 편집하기 창 노출
  -->
  <li class="media-library-content-list__item--folder">
    <div class="media-library__input-group media-library-content-list__checkbox">
      <label class="media-library__label">
        <input type="checkbox" class="media-library__input-checkbox">
        <span class="media-library__input-helper"></span>
      </label>
    </div>
    <div @click="view" class="media-library-content-list__icon">
      <div class="media-library-content-list__icon-thumb media-library-content-list__icon-folder"></div>
    </div>
    <div class="media-library-content-list__content-box">
      <div class="media-library-content-list__title">
        <span @click="view" class="media-library-content-list__text">{{ name }}</span>
      </div>
      <div class="media-library-content-list__writer">
      </div>
      <div class="media-library-content-list__size">
        <span class="media-library-content-list__text">{{ fileCount }} 개</span>
      </div>
      <div class="media-library-content-list__date">
        <span class="media-library-content-list__text">{{ folder.created_at }}</span>
      </div>
    </div>
    <div v-if="false" class="media-library-content-list__more">
      <button type="button" class="media-library__button-ellipsis">
        <span class="blind">폴더 관리</span>
      </button>
      <ul class="media-library-content-list__more-list">
        <li>
          <button type="button" class="media-library-content-list__more-list-button">편집하기</button>
        </li>
        <li>
          <button type="button" class="media-library-content-list__more-list-button media-library-content-list__more-list-button--delete">삭제</button>
        </li>
      </ul>
    </div>
  </li>
</template>

<script>
export default {
  props: ['folder'],
  data() {
    return {}
  },
  methods: {
    view (event) {
      this.$parent.viewFolder(this.folder.id)
    },
    deleteFolder (event) {
      this.$store.dispatch('media/deleteFolder', this.folder.id)
    }
  },
  computed: {
    name ({ $props }) {
      return $props.folder.name
    },
    fileCount ({ $props }) {
      return $props.folder.file_count
    },
    date ({ $props }) {
      return moment($props.created_at).format('L')
    }
  }
}
</script>
