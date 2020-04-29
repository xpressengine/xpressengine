<template>
  <!-- 우측 상단 영역 -->
  <!--
    [D] 모바일에서 스크롤 시 화면 위에 메뉴가 붙어서 노출되는 기능 적용하려면 스크롤 이동 시 특정 위치에서 class="sticky" 추가, 제거하면 됩니다.
    디자인 파일 : 리스트 타입 -> 스크롤 UI
  -->
  <div class="media-library-header">
    <!-- [D] 저장소명 적용 (PC 에서만 노출, 모바일은 aside 영역의 class="media-library-aside__mobile-button" 에 적용된 내용이 노출 됨) -->
    <h3 class="media-library-header__title">{{ title }}</h3>
    <!-- [D] 모바일에서 검색버튼(class="media-library__button-icon--search") 클릭 시 class="search-open" 추가 -->
    <div class="media-library__search">
      <div class="media-library__input-group">
        <input v-model="searchKeyword" @keyup.13="search" type="text" class="media-library__input-text" placeholder="미디어 검색...">
        <button type="button" class="media-library__button-text-remove"></button>
      </div>
      <button @click="search" type="button" class="media-library__button media-library__button-icon media-library__button-icon--search">
        <i class="xi-search"></i>
      </button>
      <button @click="clearSearch" type="button" class="media-library__button media-library__button-search-cancel">취소</button>
    </div>

    <!--
      [D] 하단 리스트에서 아이템 선택 시 class="media-library-header__button-box--state-item-check" 영역에 class="open" 적용,
      PC 에서는 무조건 노출됨
    -->
    <div v-if="$root.selectedMedia && $root.selectedMedia.length" class="media-library-header__button-box media-library-header__button-box--state-item-check open">
      <div class="media-library-header__button-box-inner">
        <button @click="$root.removeConfirm()" type="button" class="media-library__button media-library__button--danger">
          <span class="media-library__icon media-library__icon-delete"></span>
          삭제
        </button>
        <div class="media-library__button-group">
          <button v-if="false" type="button" class="media-library__button media-library__button--default">
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
      <button type="button" :class="{ 'media-library__button': true, 'media-library__button-icon': true, 'button-selected': $parent.listType === 'card' }" @click="$parent.changeListType()">
        <i class="xi-view-module"></i>
      </button>
      <!-- 리스트형 버튼 -->
      <button type="button" :class="{ 'media-library__button': true, 'media-library__button-icon': true, 'button-selected': $parent.listType === 'list' }" @click="$parent.changeListType()">
        <i class="xi-view-list"></i>
      </button>
    </div>

    <!-- [D] 모바일에서 버튼 class="media-library-header-mobile-upload-button" (아래 html 구조에 있음) 클릭 시 class="open" 추가 -->
    <div class="media-library__button-group media-library__button-group--state-upload">
      <div class="media-library__button-group-inner">
        <button v-if="indexMode === 1" @click="dialogCreateFolder" type="button" class="media-library__button media-library__button--default">
          <i class="xi-folder-o"></i>
          새폴더
        </button>
        <button v-if="renderMode !== 'modal'" @click="toggleAttachArea" type="button" class="media-library__button media-library__button--default">
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
    <div v-if="false" class="media-library-content-sort">
      <!-- [D] 첫번째 클릭 오름차순 class="active-sort--up" 적용, 두번째 클릭 내림차순 class="active-sort--down" 적용, 항목 변경 시 두 클래스 삭제 -->
      <button type="button" class="media-library-content__button-sort active-sort--up">
        제목 순
        <span class="blind">리스트 정렬 버튼</span>
        <span class="media-library-sort-arrow">
          <span class="blind">정렬 화살표</span>
        </span>
      </button>

      <ul class="media-library-content-sort__list">
        <!-- [D] 버튼 선택 시 li 에 class="on" 추가 (체크 표시 노출 됨) -->
        <li :class="{ 'on': orderTarget === 3 }">
          <button type="button" class="media-library-content-sort__list-button" data-order-target="3">제목 순</button>
        </li>
        <li :class="{ 'on': orderTarget === 6 }">
          <button type="button" class="media-library-content-sort__list-button" data-order-target="6">글쓴이 순</button>
        </li>
        <li :class="{ 'on': orderTarget === 5 }">
          <button type="button" class="media-library-content-sort__list-button" data-order-target="5">업로드 글 순</button>
        </li>
        <li :class="{ 'on': orderTarget === 4 }">
          <button type="button" class="media-library-content-sort__list-button" data-order-target="4">파일 크기 순</button>
        </li>
        <li :class="{ 'on': orderTarget === 1 }">
          <button type="button" class="media-library-content-sort__list-button" data-order-target="1">날짜 순</button>
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
  props: ['title', 'orderTarget', 'orderType', 'indexMode', 'renderMode'],
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
      if (this.searchKeyword) {
        this.$store.dispatch('media/setFilter', { filter: {keyword: this.searchKeyword} })
      } else {
        $('.media-library__search').addClass('search-open')
      }
    },
    clearSearch () {
      this.searchKeyword = ''
      $('.media-library__search').removeClass('search-open')
      this.$store.dispatch('media/setFilter', { filter: {keyword: null} })
    },
    showMobileUploadPanel () {
      $('.media-library__button-group--state-upload').addClass('open')
      $('.media-library-dimmed').show();

      $('.media-library').one('hide.mobilePanel', function () {
        $('.media-library__button-group--state-upload').removeClass('open')
      })
    }
  },
  mounted: function () {
    this.$store.watch((state, getters) => {
      this.searchKeyword = this.$store.getters['media/filter'].keyword || ''
    })

    this.$store.subscribe((mutation) => {
      if (mutation.type === 'media/SET_PAGINATE') {
        this.searchKeyword = this.$store.getters['media/filter'].keyword || ''
      }
    })
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
      searchKeyword: ''
    };
  }
};
</script>
