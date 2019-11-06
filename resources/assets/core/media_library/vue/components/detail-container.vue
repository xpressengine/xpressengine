<template>
  <div v-if="media" class="media-library-layer-popup media-library-layer-popup--align-center media-library-layer-popup--media-detail">
    <div class="media-library-layer-popup-content">
      <div class="media-library-layer-popup-content-inner">
        <div class="media-library-layer-popup-header">
          <h3 class="media-library-layer-popup-header__title" v-bind:title="title">{{ title }} <span class="blind">레이어 팝업</span></h3>
          <!-- [D] 모바일에서 class="media-library-layer-popup__button-close" 버튼 클릭 시 팝업 닫기 기능 적용 (PC 에서는 해당 버튼 숨겨짐) -->
          <button @click="close" type="button" class="media-library-layer-popup__button-close">
            <span class="blind">파일 상세정보 레이어 팝업 닫기</span>
            <span class="media-library-layer-popup__button-close-image"></span>
          </button>
          <!-- 툴바 -->
          <div class="media-library-layer-popup_button-box">
            <!-- 편집 -->
            <!-- <button type="button" class="media-library__button media-library__button--subtle media-library__button--icon">
              <span class="media-library__button-icon media-library__button-icon--edit"></span>
            </button> -->
            <!-- 다운로드 -->
            <!-- <button type="button" class="media-library__button media-library__button--subtle media-library__button--icon">
              <span class="media-library__button-icon media-library__button-icon--download"></span>
            </button> -->
            <!-- 삭제 -->
            <button @click="remove" type="button" class="media-library__button media-library__button--subtle media-library__button--icon">
              <span class="media-library__button-icon media-library__button-icon--trash"></span>
            </button>
            <!--
                [D] 내부 class="media-library__button" 클릭 시 버튼 영역에 class="button-selected" 추가하고, class="media-library-button-data" 영역에 class="open" 추가
                class="open" 추가 시 리스트 영역 레이어 노출 됨
            -->
            <div v-if="false" class="media-library-button-data">
              <button type="button" class="media-library__button media-library__button--subtle media-library__button--icon">
                <span class="media-library__button-icon media-library__button-icon--ellipsis"></span>
              </button>
              <ul class="media-library-button-data__list">
                <li>
                  <button type="button" class="media-library-button-data__button">새 창에서 열기</button>
                </li>
                <li>
                  <button type="button" class="media-library-button-data__button">이동</button>
                </li>
              </ul>
            </div>
        </div>
      </div>
      <div class="media-library-layer-popup-body">
        <div class="media-library-layer-popup-detail">
          <div class="media-library-layer-popup-detail-view">
              <div class="media-library-layer-popup-detail-view__inner">
                <slot name="content">
                  <button type="button" class="media-library-layer-popup-detail-view__button-left"><i class="xi-angle-left-min"><span class="blind">이전 이미지 보기</span></i></button>

                  <div class="media-library-layer-popup-detail-view__image-box">
                      <img :src="thumbnailUrl" class="media-library-layer-popup-detail-view__image" alt="">
                  </div>

                  <button type="button" class="media-library-layer-popup-detail-view__button-right"><i class="xi-angle-right-min"><span class="blind">다음 이미지 보기</span></i></button>

                  <button type="button" class="media-library-layer-popup-detail-view__button-update">이미지 편집</button>
                </slot>
              </div>
          </div>
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
                                  <input @click="urlCopy($event)" type="text" class="media-library__input-text" :value="media.file.url" readonly="">
                              </div>
                          </dd>
                          <dt>업로드 날짜</dt>
                          <dd>{{ media.created_at }}</dd>
                          <dt v-if="media.file.width && media.file.height">규격</dt>
                          <dd v-if="media.file.width && media.file.height"> {{ media.file.width }}x{{ media.file.height }}</dd>
                      </dl>
                  </div>
                  <div class="media-library-layer-popup-detail-info-content">
                      <dl>
                          <dt><label for="mediaLibraryDetailFileTitle">제목</label></dt>
                          <dd>
                              <div class="media-library__input-group">
                                  <input type="text" class="media-library__input-text" id="mediaLibraryDetailFileTitle" placeholder="제목 입력..." v-model="media.title">
                              </div>
                          </dd>
                          <dt><label for="mediaLibraryDetailFileAltText">대체 텍스트</label></dt>
                          <dd>
                              <div class="media-library__input-group">
                                  <input type="text" class="media-library__input-text" id="mediaLibraryDetailFileAltText" placeholder="대체 텍스트 입력..." v-model="media.alt_text">
                              </div>
                          </dd>
                          <dt><label for="mediaLibraryDetailFileCaption">캡션</label></dt>
                          <dd>
                              <div class="media-library__input-group">
                                  <textarea class="media-library__textarea" id="mediaLibraryDetailFileCaption" rows="3" placeholder="캡션 입력..." v-model="media.caption"></textarea>
                              </div>
                          </dd>
                          <dt><label for="mediaLibraryDetailFileDescription">설명</label></dt>
                          <dd>
                              <div class="media-library__input-group">
                                <input type="text" class="media-library__input-text" id="mediaLibraryDetailFileDescription" placeholder="설명 입력..." v-model="media.description">
                              </div>
                          </dd>
                      </dl>
                  </div>
              </div>
                  <div class="media-library-layer-popup-detail-info-footer">
                      <button @click="close" type="button" class="media-library__button media-library__button--subtle">
                          취소
                      </button>

                      <button @click="save" type="button" class="media-library__button media-library__button--primary">
                          저장하기
                      </button>
                  </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import filesize from 'filesize'

export default {
  created: function () {
    this.$root.$on('show-detail-media', (id, media) => {
      // this.id = id
      // this.media = media
    })
    this.$root.$on('show-detail-media-closed', () => {
      this.id = null
      this.media = null
    })
  },
  data: () => {
    return {
      id: null,
      media: null,
      title: '파일 상세보기'
    }
  },
  computed: {
    thumbnailUrl () {
      return this.media.file.url;
      // return "/storage/app/public/media/" + this.media.file.path + "/" + this.media.file.filename;
    },
    userName () {
      return this.media.user.display_name;
    },
    userProfileImage () {
      return this.media.user.profile_image_url;
    },
    filesize () {
      return filesize(this.media.file.size);
    }
  },
  methods: {
    remove () {
      this.$root.deleteMedia(this.id).then((res) => {
        this.close()
      })
    },
    close () {
      this.$root.hideDetailMedia()
    },
    urlCopy (e) {
      $(e.target).select();
      if (typeof document.execCommand === "function") {
          document.execCommand('copy');
      }else{ //ie 대응
          window.clipboardData.setData('Text', this.media.file.url);
      }
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
    }
  }
}
</script>
