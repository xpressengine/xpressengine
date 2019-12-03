<template>
  <div v-if="indexMode === 1" class="media-library-breadcrumbs">
      <h3 class="blind">현재 폴더 정보</h3>
      <div class="media-library-breadcrumbs-info">
          <span class="media-library-breadcrumbs-info__image"></span>
          <path-item v-for="path in items" :key="path.id" :path="path"></path-item>
      </div>
  </div>
</template>

<script>
import PathItem from './path-item.vue'

const types = {
  'DELETE_FOLDER' : 'DELETE_FOLDER'
}

export default {
  props: ['pathItems', 'indexMode'],
  components: {
    PathItem
  },
  data () {
    return {}
  },
  methods: {
    view (event) {
      this.$store.dispatch('media/setFilter', { filter: {folder_id: this.folder.id} })
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
