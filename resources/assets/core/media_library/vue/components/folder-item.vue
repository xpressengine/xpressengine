<template>
  <!--
    [D] 리스트 클릭 시(li 클릭 시) class="active" 추가, class="active" 추가 될 때 class="media-manager__input-checkbox" 체크박스에 체크 및 체크해제 적용!!
    [D] 리스트 더블 클릭 시 편집하기 창 노출
  -->
  <li>
    <label class="media-manager-content-list__checkbox-label" for="test"></label>
    <div class="media-manager__input-group media-manager-content-list__checkbox">
      <input type="checkbox" id="test" class="media-manager__input-checkbox">
    </div>
    <div class="media-manager-content-list__icon">
      <div class="media-manager-content-list__icon-thumb media-manager-content-list__icon-folder"></div>
    </div>
    <div class="media-manager-content-list__content-box">
      <div class="media-manager-content-list__title">
        <span class="media-manager-content-list__text" @click="view">{{ name }}</span>
      </div>
      <div class="media-manager-content-list__writer">
        <span class="media-manager-content-list__text">-</span>
      </div>
      <div class="media-manager-content-list__size">
        <span class="media-manager-content-list__text">@10 개</span>
      </div>
      <div class="media-manager-content-list__date">
        <span class="media-manager-content-list__text">-</span>
        <button type="button" @click="deleteFolder">삭제</button>
      </div>
    </div>
    <div class="media-manager-content-list__more">
      <span>모어</span>
    </div>
  </li>
</template>

<script>
const types = {
  DELETE_FOLDER: "DELETE_FOLDER"
};

export default {
  props: ["folder"],
  data() {
    return {};
  },
  methods: {
    view(event) {
      this.$store.dispatch("media/viewFolder", this.folder.id);
    },
    deleteFolder(event) {
      this.$store.dispatch("media/deleteFolder", this.folder.id);
    }
  },
  mutations: {
    [types.DELETE_FOLDER](state, folder) {}
  },
  computed: {
    name({ $props }) {
      const folder = $props.folder;
      return folder.name;
    }
  }
};
</script>


<style lang="scss">
// .folder-item {
//   display: table-row;

//   > div {
//     display: table-cell;
//     border: 1px solid black;
//   }
// }
</style>
