<script>
import SettingsHeaderTool from "./components/settings/header-tool.vue"
import MainContainer from "./components/main-container.vue"
import $ from 'jquery'

export default {
  props: ["renderMode"],
  components: {
    SettingsHeaderTool,
    MainContainer
  },
  computed: {},
  mounted: function() {

  },

  methods: {
    importMedia () {
      console.debug('import', this.$root.selectedMedia)
      const mediaList = []

      this.$root.selectedMedia.forEach((item) => {
        const media = this.$store.getters['media/media'](item)
        media.thumbnailUrl = "/storage/app/" + media.file.path + "/" + media.file.filename
        mediaList.push(media)
      })
      console.debug('mediaList', this, mediaList)

      window.XE.MediaManager.$$emit('media.import', mediaList)

      if (this.$root.renderMode === 'modal') {
        $('#media-manager-modal-container').xeModal('hide')
      }
    }
  },

  data () {
    return {};
  }
}
</script>

<template>
  <div class="xe-modal fade" id="media-manager-modal-container" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" v-if="$props.renderMode === 'modal'">
    <div class="xe-modal-dialog" role="document" style="width: 95%;">
      <div class="xe-modal-content">
        <div class="xe-modal-header">
          <h4 class="xe-modal-title" id="myModalLabel">Media Library</h4>
        </div>
        <div class="xe-modal-body">
          <div class="panel">
            <div class="panel-heading">
              <h3>미디어 라이브러리</h3>
            </div>

            <div class="panel-body">
              <main-container></main-container>
            </div>

            <div class="panel-footer">
              <div>
                <button type="button" @click="importMedia">가져오기</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <main-container v-else></main-container>
</template>
