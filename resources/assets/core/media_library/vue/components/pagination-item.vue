<template>
  <a href="#" class="media-library-paging-item media-library-paging-item--active">@1</a>
</template>

<script>
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
  }
}
</script>
