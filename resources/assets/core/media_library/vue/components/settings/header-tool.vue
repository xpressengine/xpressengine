<template>
  <!-- 우측 상단 영역 -->
  <!--
    [D] 모바일에서 스크롤 시 화면 위에 메뉴가 붙어서 노출되는 기능 적용하려면 스크롤 이동 시 특정 위치에서 class="sticky" 추가, 제거하면 됩니다.
    디자인 파일 : 리스트 타입 -> 스크롤 UI
  -->
  <div class="media-library-header">
    <!-- [D] 저장소명 적용 (PC 에서만 노출, 모바일은 aside 영역의 class="media-library-aside__mobile-button" 에 적용된 내용이 노출 됨) -->
    <h3 class="media-library-header__title">Main Assets</h3>
    <!-- [D] 모바일에서 검색버튼(class="media-library__button-icon--search") 클릭 시 class="search-open" 추가 -->
    <div class="media-library__search">
      <div class="media-library__input-group">
        <input v-model="searchKeyword" @keyup.13="search" type="text" class="media-library__input-text" placeholder="미디어 검색...">
        <button type="button" class="media-library__button-text-remove"></button>
      </div>
      <button @click="search" type="button" class="media-library__button media-library__button-icon media-library__button-icon--search">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="17" height="17" viewBox="0 0 17 17">
          <defs>
            <path id="a" d="M15.042 8.313a6.73 6.73 0 1 0-13.459 0 6.73 6.73 0 0 0 13.459 0zm-6.73 5.145a5.151 5.151 0 0 1-5.145-5.146 5.152 5.152 0 0 1 5.146-5.145 5.152 5.152 0 0 1 5.145 5.146 5.152 5.152 0 0 1-5.146 5.145zm4.741.735l1.137-1.137 3.216 3.217-1.136 1.137-3.217-3.217z"></path>
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
      <button @click="clearSearch" type="button" class="media-library__button media-library__button-search-cancel">취소</button>
    </div>

    <!--
      [D] 하단 리스트에서 아이템 선택 시 class="media-library-header__button-box--state-item-check" 영역에 class="open" 적용,
      PC 에서는 무조건 노출됨
    -->
    <div v-if="$root.selectedMedia && $root.selectedMedia.length" class="media-library-header__button-box media-library-header__button-box--state-item-check open">
      <div class="media-library-header__button-box-inner">
        <button @click="$root.remove()" type="button" class="media-library__button media-library__button--danger">
          <span class="media-library__icon media-library__icon-delete"></span>
          삭제
        </button>
        <div class="media-library__button-group">
          <button type="button" class="media-library__button media-library__button--default">
            <span class="media-library__icon media-library__icon-move"></span>
            이동
          </button>
          <button type="button" @click="clearSelected" class="media-library__button media-library__button--default">
            <span class="media-library__icon media-library__icon-deselect"></span>
            선택해제
          </button>
        </div>
      </div>
    </div>

    <div class="media-library__button-group-radio">
      <!-- [D] 선택 시 class="button-selected" 추가 -->
      <!-- 카드형 버튼 -->
      <button type="button" :class="{ 'media-library__button': true, 'button-selected': $parent.listType === 'card' }" @click="$parent.changeListType('card')">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="15" height="12" viewBox="0 0 15 12">
          <defs>
            <path id="icon-card" d="M0 0h3.947v5.25H0V0zm0 6.75h3.947V12H0V6.75zM5.526 0h3.948v5.25H5.526V0zm0 6.75h3.948V12H5.526V6.75zM11.053 0H15v5.25h-3.947V0zm0 6.75H15V12h-3.947V6.75z"></path>
          </defs>
          <g fill="none" fill-rule="evenodd">
            <mask id="icon-card-mask" fill="#fff">
              <use xlink:href="#icon-card"></use>
            </mask>
            <use fill="#B3BAC5" xlink:href="#icon-card"></use>
            <g class="media-library__svg" fill="#505F79" mask="url(#icon-card-mask)">
              <path d="M0 0h15v12H0z"></path>
            </g>
          </g>
        </svg>
      </button>
      <!-- 리스트형 버튼 -->
      <button type="button" :class="{ 'media-library__button': true, 'button-selected': $parent.listType === 'list' }" @click="$parent.changeListType('list')">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="11" viewBox="0 0 16 11">
          <defs>
            <path id="icon-list" d="M4 0h12v2.2H4V0zm0 4.4h12v2.2H4V4.4zm0 4.4h12V11H4V8.8zM0 0h2.4v2.2H0V0zm0 4.4h2.4v2.2H0V4.4zm0 4.4h2.4V11H0V8.8z"></path>
          </defs>
          <g fill="none" fill-rule="evenodd">
            <mask id="icon-list-mask" fill="#fff">
              <use xlink:href="#icon-list"></use>
            </mask>
            <use fill="#505F79" xlink:href="#icon-list"></use>
            <g class="media-library__svg" fill="#505F79" mask="url(#icon-list-mask)">
              <path d="M0 0h16v11H0z"></path>
            </g>
          </g>
        </svg>
      </button>
    </div>

    <!-- [D] 모바일에서 버튼 class="media-library-header-mobile-upload-button" (아래 html 구조에 있음) 클릭 시 class="open" 추가 -->
    <div class="media-library__button-group media-library__button-group--state-upload">
      <div class="media-library__button-group-inner">
        <button @click="dialogCreateFolder" type="button" class="media-library__button media-library__button--default">
          <i class="xi-folder-o"></i>
          새폴더
        </button>
        <button @click="toggleAttachArea" type="button" class="media-library__button media-library__button--default">
          <i class="xi-upload"></i>
          업로드
        </button>
      </div>
    </div>

    <!-- [D] 버튼 노출 시 class="open" 추가 (css 에니메이션 적용 되어 있음) -->
    <button @click="showMobileUploadPanel" type="button" class="media-library-header-mobile-upload-button open">
      <span class="blind">모바일 화면 새폴더, 업로드 팝업 노출</span>
    </button>
    <!-- //모바일 플로팅 버튼 (새폴더, 업로드 노출) -->

    <!-- 모바일 리스트 형에서 검색, sort 버튼 노출 영역 -->
    <div class="media-library-header-mobile-search-area"></div>
    <!-- 모바일 플로팅 버튼 (새폴더, 업로드 노출) -->

    <!-- 리스트형 모바일에서 sort 팝업 노출 버튼 (모바일에서 fixed 적용 되어야 되어 class="media-library-header" 영역으로 이동) -->
    <!--
      [D] class="media-library-content__button-sort" 버튼 클릭 시 class="media-library-content-sort" 영역에 class="open" 추가
      그리고 딤드영역 적용을 위해 class="media-library-dimmed" 영역 display: block 적용
    -->
    <div class="media-library-content-sort">
      <!-- [D] 첫번째 클릭 오름차순 class="active-sort--up" 적용, 두번째 클릭 내림차순 class="active-sort--down" 적용, 항목 변경 시 두 클래스 삭제 -->
      <button type="button" class="media-library-content__button-sort">
        제목순
        <span class="blind">리스트 정렬 버튼</span>
        <span class="media-library-sort-arrow">
          <span class="blind">정렬 화살표</span>
        </span>
      </button>

      <ul class="media-library-content-sort__list">
        <!-- [D] 버튼 선택 시 li 에 class="on" 추가 (체크 표시 노출 됨) -->
        <li class="on">
          <button type="button" class="media-library-content-sort__list-button">제목순</button>
        </li>
        <li class>
          <button type="button" class="media-library-content-sort__list-button">글쓴이순</button>
        </li>
        <li class>
          <button type="button" class="media-library-content-sort__list-button">업로드 글순</button>
        </li>
        <li class>
          <button type="button" class="media-library-content-sort__list-button">파일 크기순</button>
        </li>
        <li class>
          <button type="button" class="media-library-content-sort__list-button">날짜순</button>
        </li>
      </ul>
    </div>
    <!-- //리스트형 모바일에서 sort 팝업 노출 버튼 -->
  </div>
  <!-- //우측 상단 영역 -->
</template>

<script>
import EventBus from '../eventBus'
import DialogCreateFolder from '../dialogs/DialogCreateFolder.vue'

export default {
  name: 'SettingsHeaderTool',
  props: ['todo'],
  methods: {
    createFolder(event) {
      window.XE.post('/media_manager/folder', {
        disk: 'media',
        name: this.createFolderName,
        parent_id: this.$store.getters['media/currentFolder'].id
      }).then(response => {
        this.$store.dispatch('media/addFolder', response.data[0]);
      });
    },
    moveFolder (folder_id) {
      window.XE.post(['media_library.move_folder', { folder_id }], {
        disk: 'media',
        name: this.createFolderName,
        parent_id: this.$store.getters['media/currentFolder'].id
      }).then(response => {
        this.$store.dispatch('media/addFolder', response.data[0]);
      });
    },
    toggleAttachArea () {
      $('.media-library').trigger('hide.mobilePanel')
      $('.media-library-upload').toggleClass('active');
    },
    clearSelected () {
      this.$root.clearSelectedMedia()
    },
    dialogCreateFolder () {
      $('.media-library').trigger('hide.mobilePanel')
      EventBus.$emit('dialog.open', DialogCreateFolder)
    },
    search () {
      this.$store.dispatch('media/setFilter', { keyword: this.searchKeyword })
    },
    clearSearch () {
      this.searchKeyword = ''
      this.$store.dispatch('media/setFilter', { keyword: null })
    },
    showMobileUploadPanel () {
      $('.media-library__button-group--state-upload').addClass('open')
      $('.media-library-dimmed').show();

      $('.media-library').one('hide.mobilePanel', function () {
        $('.media-library__button-group--state-upload').removeClass('open')
      })
    }
  },
  computed: {
    currentFolder: function() {
      if (this.$store.getters['media/currentFolder']) {
        return this.$store.getters['media/currentFolder'].id;
      }
      return null;
    }
  },
  data() {
    return {
      createFolderName: '',
      csrfToken: XE.options.userToken,
      searchKeyword: '',
    };
  }
};
</script>
