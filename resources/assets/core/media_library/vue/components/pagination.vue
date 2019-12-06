<template>
  <div v-if="paginate" class="media-library-paging">
    <VuePaginate
      v-model="paginate.current"
      :page-count="paginate.last"
      :click-handler="pageMove"
      :container-class="'media-library-paging__box media-library-paging__box--normal'"
      :page-class="'media-library-paging-item'"
      :page-link-class="'media-library-paging-item'"
      :prev-class="'media-library-paging-item media-library-paging-item--prev'"
      :next-class="'media-library-paging-item media-library-paging-item--next'"
      :active-class="'media-library-paging-item--active'"
      :prev-text="'<i class=xi-angle-left-min></i>'"
      :next-text="'<i class=xi-angle-right-min></i>'"
      >
    </VuePaginate>
  </div>
</template>

<script>
import PaginationItem from './pagination-item.vue'
import VuePaginate from 'vuejs-paginate'

export default {
  components: {
    PaginationItem,
    VuePaginate
  },
  data() {
    return {
      paginate: null
    }
  },
  methods: {
    pageMove (page) {
      if (page < 1) {
        page = 1
      } else if (page > this.paginate.last) {
        page = this.paginate.last
      }

      this.$store.dispatch('media/setFilter', { filter: {file_page: page} })
    }
  },
  mounted: function () {
    this.$store.watch((state, getters) => {
      this.paginate = this.$store.getters['media/paginate']
    })

    this.$store.subscribe((mutation) => {
      if (mutation.type === 'media/SET_PAGINATE') {
        this.paginate = this.$store.getters['media/paginate']
      }
    })
  }
};
</script>
