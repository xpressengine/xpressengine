<template>
  <div>
    <div class>
      <input style="text" placeholder="검색">
      |
      <span v-if="$root.isSelectedMedia">
        <button type="button" @click="$root.remove">삭제</button>
        <button type="button">이동</button>
      </span>
      |
      <button type="button">썸네일 보기</button>
      <button type="button">목록 보기</button>
      |
      <button type="button">새폴더</button>
      <button type="button">업로드</button>
    </div>
    <div>
      <div class="folder-create">
        <input type="text" placeholder="새 폴더 이름" v-model="createFolderName">
        <button type="button" @click="createFolder">{{ createFolderName }} 폴더 생성</button>
      </div>
    </div>
    <div class="fileupload-form">
      <form action="/media_manager/file/upload">
        <input type="hidden" name="_token" :value="csrfToken">
        <input name="folder_id" type="hidden" :value="currentFolder">
        <input type="file" name="file" class="form-control--file" data-url="/media_manager/file/upload" multiple>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: "SettingsHeaderTool",
  props: ["todo"],
  methods: {
    createFolder(event) {
      window.XE.post("/media_manager/folder", {
        disk: "media",
        name: this.createFolderName,
        parent_id: this.$store.getters["media/currentFolder"].id
      }).then(response => {
        this.$store.dispatch("media/addFolder", response.data[0]);
      });
    }
  },
  computed: {
    currentFolder: function() {
      if(this.$store.getters["media/currentFolder"]) {
        return this.$store.getters["media/currentFolder"].id
      }
      return null
    }
  },
  data() {
    return {
      createFolderName: "",
      csrfToken: XE.options.userToken
    };
  }
};
</script>
