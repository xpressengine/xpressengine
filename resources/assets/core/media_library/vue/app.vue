<script>
import SettingsHeaderTool from "./components/settings/header-tool.vue";
import MainContainer from "./components/main-container.vue";

export default {
  props: ["renderMode"],
  components: {
    SettingsHeaderTool,
    MainContainer
  },
  computed: {},
  mounted: function() {
    if (this.renderMode === "modal") {
      $("#media-manager-modal-container").xeModal("show");
    }
  },
  data() {
    return {};
  }
};
</script>

<template>
  <div class="xe-modal fade" id="media-manager-modal-container" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" v-if="$props.renderMode === 'modal'">
    <div class="xe-modal-dialog" role="document">
      <div class="xe-modal-content">
        <div class="xe-modal-header">
          <h4 class="xe-modal-title" id="myModalLabel">Media Manager</h4>
        </div>
        <div class="xe-modal-body">
          <div class="panel">
            <div class="panel-heading">
              <h3>미디어 매니저 (settings)</h3>
            </div>

            <div class="panel-body">
              <main-container></main-container>
            </div>

            <div class="panel-footer">
              <div>modal 푸터</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <main-container v-else></main-container>
</template>
