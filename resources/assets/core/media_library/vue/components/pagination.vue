<template>
  <div v-if="paginate" class="media-library-paging">
      <h4 class="blind">데이터 페이징</h4>
      <div class="media-library-paging__box media-library-paging__box--normal">
          <a v-if="paginate.prevUrl" :href="paginate.prevUrl" @click="pageMove(paginate.current - 1, $event)" class="media-library-paging-item media-library-paging-item--prev" title="이전"><i class="xi-angle-left-min"></i></a>
          <!-- <pagination-item v-for="page in paginate" v-bind:key="paginate.id"></pagination-item> -->
          <a v-if="paginate.nextUrl" :href="paginate.nextUrl" @click="pageMove(paginate.current + 1, $event)" class="media-library-paging-item media-library-paging-item--next" title="다음"><i class="xi-angle-right-min"></i></a>
      </div>

      <div class="media-library-paging__box media-library-paging__box--simple">
          <a v-if="paginate.prevUrl" :href="paginate.prevUrl" @click="pageMove(paginate.current - 1, $event)" class="media-library-paging-item media-library-paging-item--prev" title="이전"><i class="xi-angle-left-min"></i></a>
          <span class="media-library-paging__box-items"><strong class="media-library-paging-item media-library-paging-item--active">{{ paginate.current }}</strong> / <span class="media-library-paging-item">{{ paginate.last }}</span></span>
          <a v-if="paginate.nextUrl" :href="paginate.nextUrl" @click="pageMove(paginate.current + 1, $event)" class="media-library-paging-item media-library-paging-item--next" title="다음"><i class="xi-angle-right-min"></i></a>
      </div>
  </div>
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
    return {
      paginate: null
    }
  },
  methods: {
    pageMove (page, event) {
      if (page < 1) {
        page = 1
      } else if (page > this.paginate.last) {
        page = this.paginate.last
      }

      this.$store.dispatch('media/loadData', { file_page: page })
      event.preventDefault()
    }
  },
  mounted: function () {
    this.$store.subscribe((mutation) => {
      if (mutation.type === 'media/SET_PAGINATE') {
        this.paginate = this.$store.getters['media/paginate']
        this.pageGroup = () => {
          const items = []
          // do {

          // } while () {

          // }
          return items
        }
        console.debug('paginate', this.paginate)
      }
    })
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
