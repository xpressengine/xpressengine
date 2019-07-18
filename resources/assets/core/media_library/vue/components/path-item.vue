<template>
  <a href="#" class="media-library-breadcrumbs-info__link" @click="view"><span class="media-library-breadcrumbs-info__link-text">{{ pathName }}</span></a>
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
      event.preventDefault()
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
