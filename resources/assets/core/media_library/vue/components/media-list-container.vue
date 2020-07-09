<template>
  <div class="media-library-main">
    <header-tool :title="$root.headerTitle" :orderTarget="$root.orderTarget" :orderType="$root.orderType" :indexMode="indexMode" :renderMode="$root.renderMode"></header-tool>

    <!-- 우측 중앙 영역 (리스트, 페이징 포함)-->
    <div class="media-library-content" style="display: block;">
      <h3 class="blind">파일정보 리스트형, 카드형</h3>

      <!-- 리스트 - 리스트형 -->
      <div :class="'media-library-content__' + listType + '-type'">
        <!-- 2019/06/14, 스타일 미적용, 스타일 적용 예정, html 도 변경 될 수 있음 -->
        <div class="media-library-content-header">
          <!-- [D] PC에서 노출되는 리스트형 상단 정렬 버튼, 클릭 시 해당 내용으로 정렬 됨 -->
          <div class="media-library-content-header__title">
            <!-- [D] 첫번째 클릭 오름차순 class="active-sort--up" 적용, 두번째 클릭 내림차순 class="active-sort--down" 적용, 항목 변경 시 두 클래스 삭제 -->
            <button type="button" class="media-library-content-header__button">
              제목
              <span class="media-library-sort-arrow">
                <span class="blind">정렬 화살표</span>
              </span>
            </button>
          </div>
          <div class="media-library-content-header__writer">
            <button type="button" class="media-library-content-header__button">
              글쓴이
              <span class="media-library-sort-arrow">
                <span class="blind">정렬 화살표</span>
              </span>
            </button>
          </div>
          <div class="media-library-content-header__size">
            <button type="button" class="media-library-content-header__button">
              파일 크기
              <span class="media-library-sort-arrow">
                <span class="blind">정렬 화살표</span>
              </span>
            </button>
          </div>
          <div class="media-library-content-header__date">
            <button type="button" class="media-library-content-header__button">
              날짜
              <span class="media-library-sort-arrow">
                <span class="blind">정렬 화살표</span>
              </span>
            </button>
          </div>
          <div class="media-library-content-header__more"></div>
        </div>
        <div class="media-library-content-list-box">
          <ul class="media-library-content-list">
            <!--
              [D] 리스트가 폴더일 때 class="media-library-content-list__item--folder" 추가,
              리스트가 상위폴더 일 때 class="media-library-content-list__item--folder-depth-up" 추가
            -->
            <li v-if="parentFolder && parentFolder.id" @dblclick="viewParentFolder" class="media-library-content-list__item--folder-depth-up">
              <!--
                [D] PC : label 영역을 리스트영역에 크게 적용하여 라벨 클릭 시 체크박스 class="media-library__input-checkbox" 에 자동으로 체크 되도록 적용하였습니다.
                모바일 : 체크박스 영역을 체크해야 체크 되도록 라벨 영역의 크기를 줄여 좋았습니다.
              -->
              <div class="media-library__input-group media-library-content-list__checkbox">
                <label class="media-library__label">
                  <input type="checkbox" class="media-library__input-checkbox">
                  <span class="media-library__input-helper"></span>
                </label>
              </div>
              <div @click="viewParentFolder" class="media-library-content-list__icon">
                <!-- [D] 이미지 클래스 정보
                  폴더 이미지 : class="media-library-content-list__icon-folder",
                  기타 이미지 : class="media-library-content-list__icon-etc",
                  jpg, png 같은 이미지는 썸네일 적용 (background-image 적용)
                -->
                <div class="media-library-content-list__icon-thumb media-library-content-list__icon-folder"></div>
              </div>

              <!-- 상위 폴더 -->
              <div class="media-library-content-list__content-box">
                <div class="media-library-content-list__title">
                  <span @click="viewParentFolder" class="media-library-content-list__text">..</span>
                </div>
                <div class="media-library-content-list__writer">
                  <span class="media-library-content-list__text"></span>
                </div>
                <div class="media-library-content-list__size">
                  <span class="media-library-content-list__text"></span>
                </div>
                <div class="media-library-content-list__date">
                  <span class="media-library-content-list__text"></span>
                </div>
              </div>
              <!-- [D] class="media-library__button-ellipsis" 버튼 클릭 시 class="media-library-content-list__more" 영역에 class="open" 추가 (말줄임 버튼 컬러 변경 및 팝업 노출) -->
              <!-- <div class="media-library-content-list__more open">
                <button type="button" class="media-library__button-ellipsis">
                  <span class="blind">편집하기, 삭제 팝업 버튼</span>
                </button>
                <ul class="media-library-content-list__more-list">
                  <li>
                    <button type="button" class="media-library-content-list__more-list-button">편집하기</button>
                  </li>
                  <li>
                    <button
                      type="button"
                      class="media-library-content-list__more-list-button media-library-content-list__more-list-button--delete"
                    >삭제</button>
                  </li>
                </ul>
              </div> -->
            </li>

            <folder-item v-for="folder in folderList" :key="folder.id" :folder="folder"></folder-item>
            <media-item v-for="media in mediaItems" :key="media.id" :media="media"></media-item>
          </ul>
        </div>
      </div>
      <!-- //리스트 - 리스트형 -->

      <pagination></pagination>
    </div>
    <!-- //우측 중앙 영역 (리스트, 페이징 포함)-->
    <path-breadcrumb :pathItems="pathItems" :indexMode="indexMode"></path-breadcrumb>
  </div>
</template>

<script>
import HeaderTool from "./settings/header-tool.vue";
import FolderItem from "./folder-item.vue";
import MediaItem from "./media-item.vue";
import PathBreadcrumb from "./path-breadcrumb.vue";
import Pagination from "./pagination.vue";

export default {
  components: {
    HeaderTool,
    FolderItem,
    MediaItem,
    PathBreadcrumb,
    Pagination
  },
  data() {
    return {
      listType: 'card', // list, card
      filter: {
        folder_id: null,
        page: 1
      },
      indexMode: 2,
      parentFolder: {}
    };
  },
  methods: {
    changeListType (type = null) {
      if (type) {
        this.listType = type
      } else {
        this.listType = (this.listType === 'list') ? 'card' : 'list'
      }
    },
    viewFolder (folderId) {
      this.$store.dispatch("media/viewFolder", folderId).then((result) => {
        this.parentFolder = result
      })
    },
    viewParentFolder () {
      const parentFolder = this.$store.getters['media/parentFolder']
      this.$store.dispatch('media/viewFolder', parentFolder.id)
    }
  },
  mounted: function () {
    this.indexMode = this.$store.getters['media/listMode']
    this.paginate = this.$store.getters['media/paginate']
    this.parentFolder = this.$store.getters['media/parentFolder']

    this.$store.subscribeAction({
      after: (action, state) => {
        if (action.type === 'media/loadData') {
          this.parentFolder = this.$store.getters['media/parentFolder']
        }

        if (action.type === 'media/changeListMode') {
          this.indexMode = this.$store.getters['media/listMode']
        }
      }
    })
  },
  computed: {
    mediaItems () {
      return this.$store.state.media.media
    },
    folderList () {
      return this.$store.state.media.folder
    },
    pathItems () {
      return this.$store.state.media.path
    }
  }
};
</script>
