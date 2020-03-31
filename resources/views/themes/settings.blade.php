<div class="admin-wrap admin-page-wrap">
    <aside class="admin-page-side-menu __admin-page-menu">
        <div class="admin-page-side-menu-inner">
            {{-- <h2 class="blind">관리자 메뉴</h2> --}}
            <div class="admin-page-side-menu-info-box __admin-page-side-menu-info">
                <div class="admin-page-side-menu-title">
                    <div class="admin-page-side-menu-title__link-box">
                        <a href="{{ url('/') }}" target="_blank" class="admin-page-side-menu-title__link admin-page-side-menu-title__link--text __admin-page-side-menu-link">
                            <img src="{{ asset('assets/core/settings/img/logo.png') }}" width="28" height="28" alt="admin logo">
                            {{ $siteTitle or 'XpressEngine3' }}
                        </a>

                        <!-- [D] class="admin-page-side-menu-title__link" 호버 시 display: block; -->
                        <span class="admin-page-side-menu-title__link-icon __admin-page-side-menu-link-icon" style="display: none;">
                            <i class="xi-external-link"></i>
                        </span>
                    </div>
                    <!-- [D] class="admin-page-side-menu-title__link" 호버 시 display: none; -->
                    <div class="admin-page-side-menu-title__lang-dropdown __admin-page-side-menu-lang" style="display: block;">
                        <button type="button" class="admin-page-side-menu-title__lang-button __admin-page-side-menu-lang-button">
                            <i class="{{XeLang::getLocale()}} xe-flag"></i>
                        </button>

                        <!-- [D] class="admin-page-side-menu-title__lang-button" 클릭 시 노출 -->
                        <ul class="admin-page-side-menu-title__lang-list __admin-page-side-menu-lang-list" title="언어설정 리스트">
                            <!-- [D] 선택된 언어 li 에 class="on" 추가 -->
                            @foreach ( XeLang::getLocales() as $locale )
                                <li @if(XeLang::getLocale() == $locale) class="on" @endif>
                                    <a href="{{ locale_url($locale) }}" class="admin-page-side-menu-title__lang-link">
                                        <i class="{{ $locale }} xe-flag" data-locale="{{ $locale }}"></i>
                                        {{ XeLang::getLocaleText($locale) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <nav class="admin-page-menu __admin-menu">
                <ul class="admin-page-menu-list">
                    {{-- main menu --}}
                    @foreach($menu as $topId => $top)
                        @if(data_get($top, 'display', true))
                            {{-- depth 1--}}
                            <li class="{{ $topId }}
                                @if($top->hasVisibleChild())sub-depth @endif
                                @if($top->isSelected() && $top->hasVisibleChild())open @endif
                                @if($top->isSelected() && !$top->hasVisibleChild())on @endif"
                            >
                                <a href="{{ $top->link() ?: '#'}}" class="admin-page-menu__link __admin-menu-link">
                                    <i class="admin-page-menu__link-icon xi-apps"></i>
                                    <span class="admin-page-menu__text">{{xe_trans($top->title)}}</span>
                                    <i class="admin-page-menu__link-icon--arrow xi-angle-right-min __admin-menu-icon-arrow"></i>
                                </a>

                                @if($top->hasVisibleChild())
                                    {{-- depth 2 --}}
                                    {{--loop for middle--}}
                                    <!-- [D] 하단에 메뉴가 선택되면 부모 ul 에 display: block 적용 -->
                                    <ul class="admin-page-menu-list__depth-list--second" @if($top->isSelected() && $top->hasVisibleChild()) style="display: block;" @endif>
                                        @foreach($top->getChildren() as $midId => $middle)
                                            <!-- [D] 현재 선택된 메뉴 li 에 class="on" 추가 -->
                                            <!-- [D] 외부 링크로 해당 메뉴 바로 선택 시
                                                1. 해당 메뉴 li에 class="on" 추가
                                                2. 해당 메뉴가 포함된 부모 ul style="display: block" 적용
                                                3. 해당 메뉴가 포함된 부모 ul 의 부모 li 에 class="open" 추가
                                            -->
                                            @if(data_get($middle, 'display', true))

                                                <li class="@if($middle->hasVisibleChild()) sub-depth @endif @if($middle->isSelected() && $middle->hasVisibleChild())open @endif @if($middle->isSelected() && !$middle->hasVisibleChild()) on @endif">
                                                    <a href="{{ $middle->link() ?:'#' }}" class="admin-page-menu__link __admin-menu-link">
                                                        <span class="admin-page-menu__text">{{xe_trans($middle->title)}}</span>
                                                        <i class="admin-page-menu__link-icon--arrow xi-angle-right-min __admin-menu-icon-arrow"></i>
                                                    </a>

                                                    @if($middle->hasVisibleChild())
                                                        {{-- depth 3 --}}
                                                        <ul class="admin-page-menu-list__depth-list--third">
                                                            @foreach($middle->getChildren() as $bottomId => $bottom)
                                                                @if(data_get($bottom, 'display', true))
                                                                    <li @if($bottom->isSelected()) class="on" @endif>
                                                                        <a href="{{ $bottom->link()?:'#' }}" class="admin-page-menu__link __admin-menu-link">
                                                                            <span class="admin-page-menu__text">{{xe_trans($bottom->title)}}</span>
                                                                            <i class="admin-page-menu__link-icon--arrow xi-angle-right-min __admin-menu-icon-arrow"></i>
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endif
                    @endforeach
                </ul>
            </nav>

            <div class="admin-page-user-info-box __admin-page-user-info">
                <div class="xu-dropup admin-page-user-info">
                    <button type="button" class="xu-button admin-page-user-info__button" data-toggle="xu-dropdown">
                        <!-- 회원 이미지 -->
                        <!-- [D] 호스팅에서는 고정 아이콘 이미지로 적용 -->
                        <span class="admin-page-user-info__image" style="background-image: url('{{ $user->getProfileImage() }}');"></span>
                        <span class="admin-page-user-info__name">
                            <span class="xu-button__text admin-page-user-info__name-text">{{ $user->getDisplayName() }}</span>
                        </span>
                    </button>
                    <ul class="xu-dropdown-menu">
                        <li class="xu-dropdown-menu__item">
                            <a href="{{ route('logout') }}">{{ xe_trans('xe::logout') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- 모바일 메뉴 노출 시 사용되는 딤드 -->
        <div class="admin-page-dimmed __admin-page-menu-close"></div>
    </aside>

    <div id="content" class="layout-content">
        <div class="ct">
            <div class="admin-page-title">
                <button type="button" class="admin-page-title__menu-button __admin-page-menu-button">
                    {{-- <span class="blind">모바일 메뉴 버튼 열림</span> --}}
                </button>

                @section('section_title')
                    <h1 class="admin-page-title__title">Header</h1>
                @show

                <!-- --- [D] 주요기능 버튼 이 있을 때 노출 --- -->
                <div class="admin-page-title__button-box">
                    <!-- [D] 버튼 추가시 해당 button 태그 추가 -->
                    @section('section_links')
                    {{-- <a href="#" class="xu-button xu-button--primary admin-page-title__button">
                        <span class="xu-button__text">주요기능 버튼</span>
                    </a> --}}
                    @show
                </div>
                <!-- --- //주요기능 버튼 이 있을 때 노출 --- -->
            </div>

            <div class="title-area container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        @section('page_title')
                            <h2>{{ xe_trans(data_get($selectedMenu ? $selectedMenu->getParent() : [], 'title', 'xe::enterTitle')) }}</h2>
                        @show

                        @section('page_description')
                            @php
                                $description = xe_trans(data_get($selectedMenu ? $selectedMenu->getParent() : [], 'description', ''));
                            @endphp

                            @if ($description != '')
                                <small>{{ $description }}</small>
                            @endif
                        @show
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                @if($errors = session('bootfail'))
                    @foreach($errors as $name => $info)
                        <!--[D] notice 데이터 알림 관련해서 구조 새롭게 추가 -->
                        <!--[D] notice 는 기본, 상황에 맞춰 앞에 바 컬러 노출, 배경색 노출, 닫기 버튼 노출 -->
                        <!--[D] is-dissmiss (X 닫기버튼 노출 유무, 공통), 해당 클래스들은 원하는 기능만큼 중복으로 적용해주면 됩니다.
                            빨간색 : notice-danger (왼쪽바), notice-danger-bg (박스 배경색)
                            노란색 : notice-warning (왼쪽바), notice-warning-bg (박스 배경색)
                            녹색 : notice-success (왼쪽바), notice-success-bg (박스 배경색)
                        -->
                        <!-- [D] 메시지 하단 구조는 제목은 h4, 내용은 p 태그로 적용해주면 됩니다. -->
                        <div class="notice notice-danger is-dissmiss">
                            <h4>{{ $info['entity']->getTitle() }} {{ xe_trans('xe::pluginError') }}</h4>
                            <p>
                                {{ xe_trans('xe::errorPluginWasDeactivated', ['name' => $info['entity']->getTitle()]) }}
                            </p>
                            <p>
                                {{ $info['exception']->getMessage() }} ({{ str_replace(base_path(), '', $info['exception']->getFile()) }}:{{ $info['exception']->getLine() }})
                            </p>
                            <button type="button" class="notice__button-close"><i class="xi-close-thin"></i><span class="sr-only">notice 닫기</span></button>
                        </div>
                    @endforeach
                @endif

                <!--어드민 컨텐츠 영역 col-sm-"n" n:1~12에 따라 그리드 사용가능-->
                {!! $content !!}
            </div>
        </div>
    </div>

    <div class="footer">
        <span>Copyright ©2015 <a href="http://xpressengine.io">XpressEngine.</a> All rights reserved.</span>
        <em class="pull-r">Version {{ __XE_VERSION__ }} @if($installedVersion !== __XE_VERSION__)
                (installed Version: {{ $installedVersion }} - <a href="{{ route('settings.coreupdate.show') }}">update XE</a>) @endif </em>
    </div>
</div>
<div class="dim"></div>


<script>
    /* 2019/12/04 메뉴 리뉴얼 스크립트 */

    $(document).ready(function () {
      // --- 호스팅 CP 좌측 메뉴 스크립트 ---
      if($('.__admin-menu').length > 0) {
        // 하단에 뎁스가 있을 경우 화살표 노출 스크립트
        $('.__admin-menu').find('li > ul').closest('li').find('> a > .__admin-menu-icon-arrow').css('display','block');

        $('.__admin-menu-link').on('click', function() {
          var $eUl = $(this).siblings('ul');

          if($eUl.length > 0) {
            if($eUl.is(':visible')) {
              // 메뉴 닫힘
              $(this).closest('li').removeClass('open');
              $eUl.slideUp('fast', function() {
                // 메뉴 열고 닫힐 때 하단 로그인 영역 위치 계산
                var windowHeight = $window.height();
                scrollCheck(windowHeight)
              });

              return false;
            } else {
              // 메뉴 열림
              $(this).closest('li').addClass('open');
              $eUl.slideDown('fast', function() {
                var windowHeight = $window.height();
                scrollCheck(windowHeight)
              });

              return false;
            }
          }
        })
      }
      // --- //호스팅 CP 좌측 메뉴 스크립트 ---

      var $window = $(window)
      var $header = $('.admin-page-title')
      var throttle = 16
      $window.scroll(throttled(throttle, function () {
        $window.triggerHandler('throttle.scroll', {
          top: $window.scrollTop()
        })
      }))

      $window.resize(throttled(throttle, function () {
        $window.triggerHandler('throttle.resize', {
          width: window.innerWidth,
          height: window.innerHeight
        })
      }))

      // ============ 헤더 움직임 ============
      $window.on('throttle.scroll', function (e, data) {
        var st = (typeof data !== 'undefined') ? data.top : $window.scrollTop()

        // if (st > headerHeight){
        if (st > 56) {
          // Scroll Down
          $header.addClass('sticky')
        } else {
          // Scroll Up
          $header.removeClass('sticky')
        }
      })
      $window.triggerHandler('throttle.scroll')
      // ============ //헤더 움직임 ============


      /**
       * throttle
       * @param {number} delay
       * @param {function} fn
       */
      function throttled (delay, fn) {
          var lastCall = 0
          return function () {
            var now = (new Date()).getTime()
            var args = arguments
            if (now - lastCall < delay) {
              return
            }
            lastCall = now

            return fn(args)
          }
      }

      // ================= 모바일 메뉴 로그인 버튼 움직임 ==============
      //페이지 리사이징 될 때
      var mobileScrollFlag = true // 모바일에서 메뉴가 닫혀 있을 때 로그인버튼 위치 계산되지 않도록 하기위한 플래그, PC, 모바일 항상 돌아야 되어서 true 로 고정
      $(window).on('throttle.resize', function (e, data) {
        var height = (typeof data !== 'undefined') ? data.height : $window.height()
        if (mobileScrollFlag) {
          scrollCheck(height)
        }
      })

      // 비 로그인 시 로그인 버튼 스크롤에 따라 움직이게 하는 함수
      function scrollCheck(pHeight) {
        var gnbFooterHeight = $('.__admin-page-user-info').outerHeight(true);	// GNB푸터 영역
        var listGnbHeight = $('.__admin-menu').outerHeight();	// GNB메뉴 영역
        var listGnbMoreHeight = $('.__admin-page-side-menu-info').outerHeight();    // GNB 메뉴를 제외한 추가 영역 (상황에 따라 넣고 빼기)
        listGnbHeight = listGnbHeight + gnbFooterHeight + listGnbMoreHeight;

        if(pHeight < listGnbHeight) {
          // GNB 영역 스크롤 될때
          $('.__admin-page-user-info').css('position', 'static');
          $('.__admin-page-user-info').css('bottom','initial');
        } else {
          // GNB 영역 스크롤 되지 않을때
          $('.__admin-page-user-info').css('position', 'absolute');
          setTimeout(function(){
            $('.__admin-page-user-info').css('bottom',0);
          }, 100);
        }
      }

      // 페이지 처음 뜰 때
      if($('.__admin-page-user-info').length > 0) {
        var windowHeight = $window.height();
        scrollCheck(windowHeight)
      }
      // ================= //모바일 메뉴 로그인 버튼 움직임 ==============

      // 모바일 메뉴 노출 스크립트
      $('.__admin-page-menu-button, .__admin-page-menu-close').on('click', function() {
        $('.__admin-page-menu').toggleClass('menu-open')
      })

      // mediaMatch 에서 resize 이용 시 변경 될 때 한번만 동작하도록 flag 적용
      var mediaMatchChangeFlag = true;       // 변경 되는 flag
      var mediaMatchCheckMobileFlag = false;  // mobile flag
      var mediaMatchCheckPcFlag = false;      // pc flag

      $(window).resize(function() {
          mediaMatchExcute();
      }).triggerHandler('resize');

      // 화면 리사이즈 시 matchMedia 로 체크된 내용 한번만 동작하도록하는 함수
      function mediaMatchExcute () {
          if(!matchMedia("screen and (min-width: 992px)").matches) {
              // 992 이하
              mediaMatchCheckMobileFlag = true;
              if(mediaMatchCheckPcFlag) {
                  mediaMatchChangeFlag = true;
                  mediaMatchCheckPcFlag = false;
              }

              if(mediaMatchChangeFlag) {
                  // 동작 정의

                  mediaMatchChangeFlag = false;
              }
          } else {
              // 992 이상
              mediaMatchCheckPcFlag = true;
              if(mediaMatchCheckMobileFlag) {
                  mediaMatchChangeFlag = true;
                  mediaMatchCheckMobileFlag = false;
              }

              if(mediaMatchChangeFlag) {
                  // 동작 정의
                  // 모바일 메뉴가 열려진 상태에서 PC 화면 되었을 때 메뉴 닫기 동작
                  $('.__admin-page-menu').removeClass('menu-open')

                  mediaMatchChangeFlag = false;
              }
          }
      }

      // --- 코어 어드민에서만 사용 됨 ---
      // --- 메뉴 상단 로고 타이틀 링크 영역 스크립트 ---
      $('.__admin-page-side-menu-link').on('mouseenter focusin', function() {
        $('.__admin-page-side-menu-link-icon').css('display', 'block')
        $('.__admin-page-side-menu-lang').css('display', 'none')
      })

      $('.__admin-page-side-menu-link').on('mouseleave focusout', function() {
        $('.__admin-page-side-menu-link-icon').css('display', 'none')
        $('.__admin-page-side-menu-lang').css('display', 'block')
      })
      // --- //메뉴 상단 로고 타이틀 링크 영역 스크립트 ---

      $('.__admin-page-side-menu-lang-button').on('click', function() {
        $(this).closest('.admin-page-side-menu-title__lang-dropdown').toggleClass('admin-page-side-menu-title__lang-dropdown--open')
      })
      // --- //코어 어드민에서만 사용 됨 ---
    })

    /* //2019/12/04 메뉴 리뉴얼 스크립트 */
    </script>
