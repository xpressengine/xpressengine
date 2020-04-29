<script>
import SettingsHeaderTool from './settings/header-tool.vue'
import MediaListContainer from './media-list-container.vue'
import DiskList from './disk-list.vue'

export default {
  props: ['mediaItems', 'folderList', 'pathItems'],
  components: {
    SettingsHeaderTool,
    MediaListContainer,
    DiskList
  },
  data() {
    return {}
  }
}
</script>

<template>
  <div class="media-library">
    <div class="media-library-upload">
      <form method="post" enctype="multipart/form-data">
        <span class="update-message">여기에 선택한 파일을 드래그해 업로드 하거나 파일을 선택하세요.</span>
        <br />
        <div class="media-library__button media-library__button--primary fileinput-button">
          파일선택
          <input type="file" name="file" multiple class="form-control--file" />
        </div>
      </form>
    </div>

    <!-- 좌측, 우측 컨텐츠 묶은 영역 -->
    <div class="media-library-box">
      <!-- [D] 저장소가 1개만 있을 경우 class="state-one" 추가 (화살표 노출 및 PC 에서 영역 제거) -->
      <disk-list v-if="$root.user.rating == 'super'" :listMode="$root.listMode"></disk-list>

      <MediaListContainer></MediaListContainer>
    </div>

    <!-- [D] 딤드가 필요할 때는 해당 딤드 display: block 적용 -->
    <div class="media-library-dimmed" style="display: none;"></div>
  </div>
</template>
