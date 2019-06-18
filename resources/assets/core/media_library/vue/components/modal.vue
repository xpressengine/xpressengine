<template>
  <div class="xe-modal fade" id="media-manager-modal-container" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  >
    <div class="xe-modal-dialog" role="document">
      <div class="xe-modal-content">
        <div class="xe-modal-header">
          <h4 class="xe-modal-title" id="myModalLabel">Media Manager</h4>
        </div>
        <div class="xe-modal-body">
          <media-manager-container></media-manager-container>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import MediaManagerContainer from './media-manager-container'

export default {
  components: {
    MediaManagerContainer
  },
  data() {
    return {
    }
  },
  computed: {
  }
};
</script>
