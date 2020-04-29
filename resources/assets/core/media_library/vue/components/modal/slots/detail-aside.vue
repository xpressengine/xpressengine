<template>
  <div class="media-library-layer-popup-detail-info">
    <div class="media-library-layer-popup-detail-info__inner">
      <div class="media-library-layer-popup-detail-info-file">
        <dl>
          <dt>파일명</dt>
          <dd>{{ media.file.clientname }}</dd>
          <dt>파일 형식</dt>
          <dd>{{ media.file.mime }}</dd>
          <dt>파일 크기</dt>
          <dd>{{ filesize }}</dd>
          <dt v-if="media.file.url">파일 URL</dt>
          <dd v-if="media.file.url">
            <div class="media-library__input-group">
              <input
                @click="urlCopy($event)"
                type="text"
                class="media-library__input-text"
                :value="media.file.url"
                readonly
              />
            </div>
          </dd>
          <dt>업로드 날짜</dt>
          <dd>{{ media.created_at }}</dd>
          <dt v-if="media.file.width && media.file.height">규격</dt>
          <dd
            v-if="media.file.width && media.file.height"
          >{{ media.file.width }}x{{ media.file.height }}</dd>
        </dl>
      </div>
      <div class="media-library-layer-popup-detail-info-content">
        <dl>
          <dt>
            <label for="mediaLibraryDetailFileTitle">제목</label>
          </dt>
          <dd>
            <div class="media-library__input-group">
              <input
                type="text"
                class="media-library__input-text"
                id="mediaLibraryDetailFileTitle"
                placeholder="제목 입력..."
                v-model="media.title"
              />
            </div>
          </dd>
          <dt>
            <label for="mediaLibraryDetailFileAltText">대체 텍스트</label>
          </dt>
          <dd>
            <div class="media-library__input-group">
              <input
                type="text"
                class="media-library__input-text"
                id="mediaLibraryDetailFileAltText"
                placeholder="대체 텍스트 입력..."
                v-model="media.alt_text"
              />
            </div>
          </dd>
          <dt>
            <label for="mediaLibraryDetailFileCaption">캡션</label>
          </dt>
          <dd>
            <div class="media-library__input-group">
              <textarea
                class="media-library__textarea"
                id="mediaLibraryDetailFileCaption"
                rows="3"
                placeholder="캡션 입력..."
                v-model="media.caption"
              ></textarea>
            </div>
          </dd>
          <dt>
            <label for="mediaLibraryDetailFileDescription">설명</label>
          </dt>
          <dd>
            <div class="media-library__input-group">
              <input
                type="text"
                class="media-library__input-text"
                id="mediaLibraryDetailFileDescription"
                placeholder="설명 입력..."
                v-model="media.description"
              />
            </div>
          </dd>
        </dl>
      </div>
    </div>
    <div class="media-library-layer-popup-detail-info-footer">
      <button @click="closeModal" type="button" class="media-library__button media-library__button--subtle">취소</button>
      <button @click="save" type="button" class="media-library__button media-library__button--primary">저장하기</button>
    </div>
  </div>
</template>

<script>
import EventBus from '../../eventBus'
import filesize from 'filesize'

export default {
  props: ['media'],
  methods: {
    closeModal () {
      EventBus.$emit('modal.close')
    },
    save () {
      return new Promise((resolve, reject) => {
        window.XE.put(['media_library.update_file', { mediaLibraryFileId: this.media.id }], {
          file_id: this.media.id,
          title: this.media.title,
          caption: this.media.caption,
          alt_text: this.media.alt_text,
          description: this.media.description
        })
          .then((response) => {
            XE.toast('success', response.data.message)
            resolve()
          })
      })
    },
    urlCopy (e) {
      $(e.target).select();
      if (typeof document.execCommand === "function") {
          document.execCommand('copy');
      }else{ //ie 대응
          window.clipboardData.setData('Text', this.media.file.url);
      }
    },
  },
  computed: {
    thumbnailUrl() {
      return this.$props.media.file.url
    },
    userName() {
      if (this.$props.media.user) {
        return this.$props.media.user.display_name || ''
      }
      return ''
    },
    userProfileImage() {
      if (this.$props.media.user) {
        return this.$props.media.user.profile_image_url || ''
      }
      return ''
    },
    filesize() {
      return filesize(this.$props.media.file.size)
    }
  },
  data() {
    return {}
  }
}
</script>
