<template>
  <div>
    <div>미디어 디테일</div>
    <div class="row">
      <div class="col-md-8">
        <img :src="imageUrl" style="max-width: 90%;" />
      </div>
      <div class="col-md-4">
        폼
        <ul>
          <li>파일명 : {{ media.title }}</li>
          <li>파일형식 : {{ media.file.mime }}</li>
          <li>파일크기 : {{ media.file.size }}</li>
          <li>파일URL : ...</li>
          <li>업로드날짜 : {{ media.created_at }}</li>
          <li>규격 : ...x...</li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
const types = {
  'DELETE_FOLDER' : 'DELETE_FOLDER'
}

export default {
  data () {
    return {}
  },
  methods: {
  },
  mutations: {
    // [types.DELETE_FOLDER] (state, folder) {
    // }
  },
  computed: {
    media () {
      return this.$store.getters['media/media'](this.$route.params.id)
    },
    imageUrl () {
      const media = this.media
      return '/storage/app/' + media.file.path + '/' + media.file.filename
    },
    // name ({ $props }) {
    //   const folder = $props.folder
    //   return folder.name
    // },
  }
}
</script>
