<template>
  <div class="media-manager-main">
    <div class="media-manager-header">
      <!-- [D] 저장소명 적용 (PC 에서만 노출, 모바일은 aside 영역의 class="media-manager-aside__mobile-button" 에 적용된 내용이 노출 됨) -->
      <h3 class="media-manager-header__title">Main Assets</h3>
      <!-- [D] 모바일에서 검색버튼(class="media-manager__button-icon--search") 클릭 시 class="search-open" 추가 -->
      <div class="media-manager__search">
        <div class="media-manager__input-group">
          <input type="text" class="media-manager__input-text" placeholder="미디어 검색...">
          <button type="button" class="media-manager__button-text-remove">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              xmlns:xlink="http://www.w3.org/1999/xlink"
              width="24"
              height="24"
              viewBox="0 0 24 24"
            >
              <defs>
                <path
                  id="icon-text-remove"
                  d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm4.674 13.104l-1.572 1.571-3.103-3.103-3.104 3.103-1.572-1.571L10.426 12 7.323 8.896l1.572-1.572 3.104 3.103 3.103-3.103 1.572 1.572L13.57 12l3.104 3.103v.001z"
                ></path>
              </defs>
              <g fill="none" fill-rule="evenodd">
                <path d="M0 0h24v24H0z"></path>
                <mask id="icon-text-remove-mask" fill="#fff">
                  <use xlink:href="#icon-text-remove"></use>
                </mask>
                <g class="media-manager__svg" fill="#424242" mask="url(#icon-text-remove-mask)">
                  <path d="M0 0h24v24H0z"></path>
                </g>
              </g>
            </svg>
          </button>
        </div>
        <button
          type="button"
          class="media-manager__button media-manager__button-icon media-manager__button-icon--search"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            width="17"
            height="17"
            viewBox="0 0 17 17"
          >
            <defs>
              <path
                id="a"
                d="M15.042 8.313a6.73 6.73 0 1 0-13.459 0 6.73 6.73 0 0 0 13.459 0zm-6.73 5.145a5.151 5.151 0 0 1-5.145-5.146 5.152 5.152 0 0 1 5.146-5.145 5.152 5.152 0 0 1 5.145 5.146 5.152 5.152 0 0 1-5.146 5.145zm4.741.735l1.137-1.137 3.216 3.217-1.136 1.137-3.217-3.217z"
              ></path>
            </defs>
            <g fill="none" fill-rule="evenodd">
              <path d="M-10-10h36v36h-36z"></path>
              <g transform="translate(-1 -1)">
                <path d="M0 0h19v19H0z"></path>
                <mask id="b" fill="#fff">
                  <use xlink:href="#a"></use>
                </mask>
                <g fill="#505F79" mask="url(#b)">
                  <path d="M0 0h19v19H0z"></path>
                </g>
              </g>
            </g>
          </svg>
        </button>
        <button type="button" class="media-manager__button media-manager__button-search-cancel">취소</button>
      </div>
      <!-- [D] 하단 리스트에서 아이템 선택 시 노출 display: block 적용, class="media-manager-header__button-box" -->
      <div
        class="media-manager-header__button-box media-manager-header__button-box--state-item-check"
        style="display: none;"
      >
        <div class="media-manager-header__button-box-inner">
          <button type="button" class="media-manager__button media-manager__button--danger">
            <span class="media-manager__icon media-manager__icon-delete"></span>
            삭제
          </button>
          <div class="media-manager__button-group">
            <button type="button" class="media-manager__button media-manager__button--default">
              <span class="media-manager__icon media-manager__icon-move"></span>
              이동
            </button>
            <button type="button" class="media-manager__button media-manager__button--default">
              <span class="media-manager__icon media-manager__icon-deselect"></span>
              선택해제
            </button>
          </div>
        </div>
      </div>
      <div class="media-manager__button-group-radio">
        <!-- [D] 선택 시 class="button-selected" 추가 -->
        <!-- 카드형 버튼 -->
        <button type="button" class="media-manager__button">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            width="15"
            height="12"
            viewBox="0 0 15 12"
          >
            <defs>
              <path
                id="icon-card"
                d="M0 0h3.947v5.25H0V0zm0 6.75h3.947V12H0V6.75zM5.526 0h3.948v5.25H5.526V0zm0 6.75h3.948V12H5.526V6.75zM11.053 0H15v5.25h-3.947V0zm0 6.75H15V12h-3.947V6.75z"
              ></path>
            </defs>
            <g fill="none" fill-rule="evenodd">
              <mask id="icon-card-mask" fill="#fff">
                <use xlink:href="#icon-card"></use>
              </mask>
              <use fill="#B3BAC5" xlink:href="#icon-card"></use>
              <g class="media-manager__svg" fill="#505F79" mask="url(#icon-card-mask)">
                <path d="M0 0h15v12H0z"></path>
              </g>
            </g>
          </svg>
        </button>
        <!-- 리스트형 버튼 -->
        <button type="button" class="media-manager__button button-selected">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            width="16"
            height="11"
            viewBox="0 0 16 11"
          >
            <defs>
              <path
                id="icon-list"
                d="M4 0h12v2.2H4V0zm0 4.4h12v2.2H4V4.4zm0 4.4h12V11H4V8.8zM0 0h2.4v2.2H0V0zm0 4.4h2.4v2.2H0V4.4zm0 4.4h2.4V11H0V8.8z"
              ></path>
            </defs>
            <g fill="none" fill-rule="evenodd">
              <mask id="icon-list-mask" fill="#fff">
                <use xlink:href="#icon-list"></use>
              </mask>
              <use fill="#505F79" xlink:href="#icon-list"></use>
              <g class="media-manager__svg" fill="#505F79" mask="url(#icon-list-mask)">
                <path d="M0 0h16v11H0z"></path>
              </g>
            </g>
          </svg>
        </button>
      </div>
      <!-- [D] 모바일에서 아이템 체크 시 class="open" 추가 -->
      <div class="media-manager__button-group media-manager__button-group--state-upload">
        <div class="media-manager__button-group-inner">
          <button type="button" class="media-manager__button media-manager__button--default">
            <span class="media-manager__icon media-manager__icon-folder"></span>
            새폴더
          </button>
          <button type="button" class="media-manager__button media-manager__button--default">
            <span class="media-manager__icon media-manager__icon-upload"></span>
            업로드
          </button>
        </div>
      </div>
      <!-- 모바일 리스트 형에서 검색, sort 버튼 노출 영역 -->
      <div class="media-manager-header-mobile-search-area"></div>
    </div>
    <div class="media-manager-content">
      <!-- 리스트 - 리스트형 -->
      <div class="media-manager-content__list-type">
        <!-- 리스트형 모바일에서 sort 팝업 노출 버튼 -->
        <!-- 2019/06/14, 스타일 미적용, 스타일 적용 예정, html 도 변경 될 수 있음 -->
        <div class="media-manager-content-sort">
          <button type="button" class="media-manager-content__button-sort">
            제목순
            <span class="blind">리스트 정렬 버튼</span>
          </button>
          <ul class="media-manager-content-sort__list">
            <li>
              <button type="button">제목순</button>
            </li>
            <li>
              <button type="button">글쓴이순</button>
            </li>
            <li>
              <button type="button">업로드 글순</button>
            </li>
            <li>
              <button type="button">파일 크기순</button>
            </li>
            <li>
              <button type="button">날짜순</button>
            </li>
          </ul>
        </div>
        <!-- //리스트형 모바일에서 sort 팝업 노출 버튼 -->
        <div class="media-manager-content-header">
          <div class="media-manager-content-header__title">
            <button type="button" class="media-manager-content-header__button">제목</button>
          </div>
          <div class="media-manager-content-header__writer">
            <button type="button" class="media-manager-content-header__button">글쓴이</button>
          </div>
          <div class="media-manager-content-header__size">
            <button type="button" class="media-manager-content-header__button">파일 크기</button>
          </div>
          <div class="media-manager-content-header__date">
            <button type="button" class="media-manager-content-header__button">날짜</button>
          </div>
          <div class="media-manager-content-header__more"></div>
        </div>
        <div class="media-manager-content-list-box">
          <ul :class="containerClass">
            <li class="media-list__header">
              <div>썸네일</div>
              <div>제목</div>
              <div>글쓴이</div>
              <div>파일크기</div>
              <div>수정한 날자</div>
            </li>
          </ul>
          <ul class="media-manager-content-list">
            <!--
              [D] 리스트가 폴더일 때 class="media-manager-content-list__item--folder" 추가,
              리스트가 상위폴더 일 때 class="media-manager-content-list__item--folder-depth-up" 추가
            -->
            <li class="media-manager-content-list__item--folder-depth-up">
              <!--
                [D] PC : label 영역을 리스트영역에 크게 적용하여 라벨 클릭 시 체크박스 class="media-manager__input-checkbox" 에 자동으로 체크 되도록 적용하였습니다.
                모바일 : 체크박스 영역을 체크해야 체크 되도록 라벨 영역의 크기를 줄여 좋았습니다.
              -->
              <div class="media-manager__input-group media-manager-content-list__checkbox">
                <label class="media-manager__label">
                  <input type="checkbox" class="media-manager__input-checkbox">
                  <span class="media-manager__input-helper"></span>
                </label>
              </div>

              <div class="media-manager-content-list__icon">
                <!-- [D] 이미지 클래스 정보
                  폴더 이미지 : media-manager-content-list__icon-folder,
                  이미지(jpg, png 등등) 이미지 : media-manager-content-list__icon-image
                -->
                <div
                  class="media-manager-content-list__icon-thumb media-manager-content-list__icon-folder"
                ></div>
              </div>
              <div class="media-manager-content-list__content-box">
                <div class="media-manager-content-list__title">
                  <span class="media-manager-content-list__text">..</span>
                </div>
                <div class="media-manager-content-list__writer">
                  <span class="media-manager-content-list__text"></span>
                </div>
                <div class="media-manager-content-list__size">
                  <span class="media-manager-content-list__text"></span>
                </div>
                <div class="media-manager-content-list__date">
                  <span class="media-manager-content-list__text"></span>
                </div>
              </div>
              <div class="media-manager-content-list__more"></div>
            </li>
            <folder-item v-for="folder in folderList" :key="folder.id" :folder="folder"></folder-item>
            <media-item v-for="media in mediaItems" :key="media.id" :media="media"></media-item>
          </ul>
        </div>
        <!-- <pagination :paginate="paginate"></pagination> -->
      </div>
      <!-- //리스트 - 리스트형 -->
    </div>
    <path-breadcrumb :pathItems="pathItems"></path-breadcrumb>
  </div>
</template>

<script>
import FolderItem from "./folder-item.vue";
import MediaItem from "./media-item.vue";
import PathBreadcrumb from "./path-breadcrumb.vue";
// import Pagination from "./pagination.vue";

export default {
  components: {
    FolderItem,
    MediaItem,
    PathBreadcrumb
    // Pagination
  },
  data() {
    return {
      listStyle: "gallery",
      filter: {
        folder_id: null,
        page: 1
      }
    };
  },
  computed: {
    containerClass() {
      return "media-list media-list--" + this.listStyle;
    },
    mediaItems() {
      return this.$store.state.media.media;
    },
    folderList() {
      return this.$store.state.media.folder;
    },
    pathItems() {
      return this.$store.state.media.path;
    }
  }
};
</script>

<style lang="scss">
.clearfix {
  zoom: 1;
  clear: both;
  &:after {
    content: "";
    display: block;
    clear: both;
  }
}

.media-list {
  @extend .clearfix;

  display: table;
  width: 100%;
  table-layout: auto;
  border-collapse: collapse;

  &__header {
    display: table-row;
    background: #eee;

    > div {
      display: table-cell;
      border: 1px solid black;
    }
  }

  &--gallery {
    display: flex;
    flex-wrap: wrap;

    .media-list {
      &__header {
        display: none;
      }
    }

    .media-item,
    .folder-item {
      display: block;
      overflow: hidden;
      width: 25%;
      padding: 20px;
      > div {
        display: block;
        border: 0;
      }
    }
  }
}
</style>
