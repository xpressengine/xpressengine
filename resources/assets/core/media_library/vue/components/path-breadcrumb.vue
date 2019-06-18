<template>
  <ol class="media-list__path">
    <path-item v-for="path in items" :key="path.id" :path="path"></path-item>
  </ol>
</template>

<script>
import PathItem from './path-item.vue'
const types = {
  'DELETE_FOLDER' : 'DELETE_FOLDER'
}

export default {
  props: ['pathItems'],
  components: {
    PathItem
  },
  data () {
    return {}
  },
  methods: {
    view (event) {
      this.$store.dispatch('media/setFilter', { folder_id: this.folder.id })
    }
  },
  mutations: {
    [types.DELETE_FOLDER] (state, folder) {
    }
  },
  computed: {
    items ({ $props }) {
      return $props.pathItems
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
