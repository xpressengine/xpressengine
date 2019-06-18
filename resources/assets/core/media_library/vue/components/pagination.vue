<template>
  <ul class="media-list__pagination">
    <li v-for="item in items">
      @
    </li>
  </ul>
</template>

<script>
import PaginationItem from './pagination-item.vue'
const types = {
  'DELETE_FOLDER' : 'DELETE_FOLDER'
}

export default {
  props: ['paginate'],
  components: {
    PaginationItem
  },
  data () {
    return {}
  },
  methods: {
    view (event) {
      this.$store.dispatch('media/viewFolder', this.folder.id)
    },
    deleteFolder (event) {
      this.$store.dispatch('media/deleteFolder', this.folder.id)
    }
  },
  mutations: {
    [types.DELETE_FOLDER] (state, folder) {
    }
  },
  computed: {
    items ({ $props }) {
      return $props.paginate
    },
  }
}
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
