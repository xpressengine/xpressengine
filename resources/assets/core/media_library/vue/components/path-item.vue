<template>
  <li class="media-list__path-item" @click="view">
    {{ pathName }}
  </li>
</template>

<script>
const types = {
  'DELETE_FOLDER' : 'DELETE_FOLDER'
}

export default {
  props: ['path'],
  data () {
    return {}
  },
  methods: {
    view (event) {
      this.$store.dispatch('media/viewFolder', this.path.id)
    }
  },
  mutations: {
    [types.DELETE_FOLDER] (state, folder) {
    }
  },
  computed: {
    pathName ({ $props }) {
      return $props.path.name
    },
  }
}
</script>


<style lang="scss">
</style>
