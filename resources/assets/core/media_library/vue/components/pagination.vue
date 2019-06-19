<template>
  <!-- 페이징, 게시판 페이징 가져와서 수정 (리스트형, 카드형 공통 페이징) -->
  <div class="media-library-paging">
    <h4 class="blind">데이터 페이징</h4>
    <div class="media-library-paging__box media-library-paging__box--normal">
      <a class="media-library-paging-item media-library-paging-item--prev" title="이전">
        <i class="xi-angle-left-min"></i>
      </a>
      <pagination-item v-for="item in items" v-bind:key="item.id"></pagination-item>
      <a href="#" class="media-library-paging-item media-library-paging-item--next" title="다음">
        <i class="xi-angle-right-min"></i>
      </a>
    </div>

    <div class="media-library-paging__box media-library-paging__box--simple">
      <a class="media-library-paging-item media-library-paging-item--prev" title="이전">
        <i class="xi-angle-left-min"></i>
      </a>
      <span class="media-library-paging__box-items">
        <strong class="media-library-paging-item media-library-paging-item--active">1</strong> /
        <span class="media-library-paging-item">2</span>
      </span>
      <a href="#" class="media-library-paging-item media-library-paging-item--next" title="다음">
        <i class="xi-angle-right-min"></i>
      </a>
    </div>
  </div>
  <!-- //페이징 -->
</template>

<script>
import PaginationItem from "./pagination-item.vue";
const types = {
  DELETE_FOLDER: "DELETE_FOLDER"
};

export default {
  props: ["paginate"],
  components: {
    PaginationItem
  },
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
    items({ $props }) {
      return $props.paginate;
    }
  }
};
</script>


<style lang="scss">
.folder-item {
  display: table-row;

  > div {
    display: table-cell;
    border: 1px solid black;
  }
}
</style>
