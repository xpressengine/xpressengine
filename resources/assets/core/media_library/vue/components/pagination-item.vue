<template>
  <a href="#" class="media-library-paging-item media-library-paging-item--active ">@1</a>
</template>

<script>
const types = {
  // 'DELETE_FOLDER' : 'DELETE_FOLDER'
}

export default {
  props: ['item'],
  components: {
  },
  data () {
    return {}
  },
  methods: {
    view (event) {
      this.$store.dispatch('media/viewFolder', this.folder.id)
    }
  },
  mutations: {
    // [types.DELETE_FOLDER] (state, folder) {
    // }
  },
  computed: {
    // items ({ $props }) {
    //   return $props.pathItems
    // },
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
