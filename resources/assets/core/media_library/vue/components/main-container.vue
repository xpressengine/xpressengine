<script>
import SettingsHeaderTool from "./settings/header-tool.vue"
import DiskList from './disk-list.vue'

export default {
  props: ["mediaItems", "folderList", "pathItems"],
  components: {
    SettingsHeaderTool,
    DiskList
  },
  data() {
    return {};
  }
};
</script>

<template>
  <div class="media-library">
    <!-- 좌측, 우측 컨텐츠 묶은 영역 -->
    <div class="media-library-box">
      <!-- [D] 저장소가 1개만 있을 경우 class="state-one" 추가 (화살표 노출 및 PC 에서 영역 제거) -->
      <disk-list></disk-list>

      <router-view></router-view>
    </div>

    <!-- [D] 딤드가 필요할 때는 해당 딤드 display: block 적용 -->
    <div class="media-library-dimmed" style="display: none;"></div>
  </div>
</template>
