{{ XeFrontend::js('/assets/core/widgetbox/js/widgetbox.js')->appendTo("head")->load() }}
{{ XeFrontend::js('/assets/core/widgetbox/js/widgetboxSnb.js')->appendTo("head")->load() }}
{{ XeFrontend::js('/assets/core/widgetbox/js/widgetAdder.js')->appendTo("head")->load() }}

{{ XeFrontend::css('http://cdn.jsdelivr.net/xeicon/2.0.0/xeicon.min.css')->load() }}
{{ XeFrontend::css('/assets/core/widgetbox/css/widgetbox.css')->load() }}

<div class="widget-wrap">
    <header>
        <h1><a href="#"><i class="xi-xpressengine"></i><span class="brand-title"><span class="xe-sr-only">xe3 widgetbox</span></span></a></h1>
        <div class="xe-pull-right">
            <button type="button" class="xe-btn">미리보기</button>
            <button type="button" class="xe-btn xe-btn-primary"><i class="xi-check"></i>저장</button>
        </div>
    </header>
    <div class="widget-snb">
        <div class="snb-section">
            <h2>메인 페이지</h2>
            <p>메인 페이지의 위젯을 편집합니다.</p>
        </div>
        <div class="snb-section">
            <h3>Device mode <i class="xi-question-o" data-toggle="xe-tooltip" data-placement="bottom" title="모바일에서는 모든 셀이 12col을 차지하도록하여 추가 옵션을 지원 하지 않습니다."></i></h3>
            <div class="xe-btn-group xe-btn-group-justified">
                <div class="xe-btn-group">
                    <!--[D] 활성화 시 .xe-btn-primary 추가-->
                    <button class="xe-btn xe-btn-sm btnMode" data-toggle="xe-tooltip" data-placement="bottom" data-mode="mobile" title="모바일 모드는 지원하지 않습니다."><i class="xi-mobile"></i>Mobile</button>
                </div>
                <div class="xe-btn-group">
                    <button class="xe-btn xe-btn-sm xe-btn-primary btnMode" data-mode="desktop"><i class="xi-tv"></i>Desktop</button>
                </div>
            </div>
        </div>
        <div class="snb-section">
            <h3>셀관리 <i class="xi-question-o" data-toggle="xe-tooltip" data-placement="bottom" title="편집영역에 셀 레이아웃을 추가하거나 셀을 선택하여 수직/수평으로 분할하여 레이아웃을 편집할 수 있습니다."></i></h3>
            <div class="cell-config-btn">
                <div class="xe-form-group">
                    <div class="xe-btn-group">
                        <!--[D] 셀 선택 후 텍스트 교체 ex)셀 레이아웃 삽입 => 3X2,  개발 미적용 시 버튼 제거-->
                        <button type="button" class="xe-btn xe-btn-sm xe-btn-primary" data-toggle="xe-dropdown"><i class="xi-grid"></i>셀 레이아웃 삽입</button>
                        <div class="xe-dropdown-menu drag-cell">
                            <ul>
                                <li class="hover"><span class="cell"></span></li>
                                <li class="hover"><span class="cell"></span></li>
                                <li class="hover"><span class="cell"></span></li>
                                <li><span class="cell"></span></li>
                                <li><span class="cell"></span></li>
                                <li><span class="cell"></span></li>
                                <li class="hover"><span class="cell"></span></li>
                                <li class="hover"><span class="cell"></span></li>
                                <li class="hover"><span class="cell"></span></li>
                                <li><span class="cell"></span></li>
                                <li><span class="cell"></span></li>
                                <li><span class="cell"></span></li>
                                <li><span class="cell"></span></li>
                                <li><span class="cell"></span></li>
                                <li><span class="cell"></span></li>
                                <li><span class="cell"></span></li>
                                <li><span class="cell"></span></li>
                                <li><span class="cell"></span></li>
                                <li><span class="cell"></span></li>
                                <li><span class="cell"></span></li>
                                <li><span class="cell"></span></li>
                                <li><span class="cell"></span></li>
                                <li><span class="cell"></span></li>
                                <li><span class="cell"></span></li>
                                <li><span class="cell"></span></li>
                                <li><span class="cell"></span></li>
                                <li><span class="cell"></span></li>
                                <li><span class="cell"></span></li>
                                <li><span class="cell"></span></li>
                                <li><span class="cell"></span></li>
                            </ul>
                            <button type="button" class="xe-btn xe-btn-sm">취소</button>
                            <button type="button" class="xe-btn xe-btn-primary xe-btn-sm">확인</button>
                        </div>
                    </div>

                    <button type="button" class="xe-btn xe-btn-sm xe-btn-primary-outline" id="btnAddRow">셀추가</button>
                </div>
                <div class="xe-form-inline">
                    <div class="xe-form-group">
                        <!--[D] 기본 dropdown 구조에서 .vertical-list 추가-->
                        <div class="xe-btn-group vertical-list">
                            <button type="button" class="xe-btn xe-btn-sm btnDivision" data-direction="vertical"><span class="text-vertical">수직분할</span> (<span id="divisionTypeView">6:6</span>)</button>
                            <button type="button" class="xe-btn xe-btn-sm xe-dropdown-toggle" data-toggle="xe-dropdown">
                                <span class="caret"></span>
                                <span class="xe-sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="xe-dropdown-menu">
                                <ul id="selectDivision">
                                    <li>
                                        <a href="#" data-type="6|6" data-display="6:6">
                                            <span style="width:77px">6</span>
                                            <span style="width:78px">6</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" data-type="4|8" data-display="4:8">
                                            <span style="width:52px">4</span>
                                            <span style="width:103px">8</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" data-type="4|4|4" data-display="4:4:4">
                                            <span style="width:50px">4</span>
                                            <span style="width:50px">4</span>
                                            <span style="width:50px">4</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" data-type="3|3|3|3" data-display="3:3:3:3">
                                            <span style="width:36px">3</span>
                                            <span style="width:36px">3</span>
                                            <span style="width:36px">3</span>
                                            <span style="width:37px">3</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="xe-input-group xe-input-group-sm">
                                    <input type="text" class="xe-form-control">
										<span class="xe-input-group-btn">
											<button class="xe-btn" type="button">분할</button>
										</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <button type="button" class="xe-btn xe-btn-sm btnDivision" data-direction="horizontal"><span class="text-horizontal">수평분할</span></button>
                    <button type="button" class="xe-btn xe-btn-sm" id="btnDeselectAll">선택 취소</button>
                    <button type="button" class="xe-btn xe-btn-sm" id="btnDelBlock">삭제</button>
                </div>
            </div>
        </div>
        <div class="snb-section">
            <h3>위젯 관리 <i class="xi-question-o" data-toggle="xe-tooltip" data-placement="bottom" title="위젯을 추가할 셀을 선택한 후 위젯 추가 버튼을 클릭하여 설정을 등록하면 위젯이 추가됩니다."></i></h3>
            <a href="#" class="xe-btn xe-btn-primary xe-btn-sm xe-btn-block btn-widget-add"><i class="xi-layout-o"></i>위젯 추가</a>
        </div>
    </div>
    <div class="widget-container">
        <div class="widget-content">
            <h3>편집 영역 <i class="xi-question-o" data-toggle="xe-tooltip" data-placement="bottom" title="각 셀에 출력되는 번호는 셀이 출력되는 순서입니다. 생성된 위젯은 drag &amp; drop 으로 순서를 변경하거나  다른셀로 이동이 가능합니다.셀을 클릭하여 선택하거나 삭제가 가능합니다."></i></h3>
            <!-- editor area -->
            <div class="editor xe-container-fluid">
                <div class="xe-row widgetarea-row">
                    <div class="xe-col-md-12">
                        <div class="widgetarea" data-height="140" style="height:140px">
                            <span class="order">0</span>
                            {{--<div class="xe-row"></div>--}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- editor area -->
        </div>
    </div>
    <!--widget layer  -->
    <!--[D] .open 추가 시 layer 펼침 -->
    <div class="widget-layer">
        <h1>h1 위젯 타이틀</h1>
        <button type="button" class="layer-close"><i class="xi-close"></i><span class="xe-sr-only">layer close</span></button>
        <p>콘텐츠를 다양한 형태로 출력하는 위젯입니다. 아래 필요한 값들을 입력한 후 추가 버튼을 누르면 페이지 내에 위젯이 삽입됩니다.</p>
        <div class="seciton">
            <div class="xe-form-group">
                <label class="xe-form-label">스킨</label>
                <div class="xe-form-inline">
                    <div class="xe-select-box xe-btn">
                        <label>기본 스타일 스킨(xet_default)</label>
                        <select>
                            <option selected="selected">xe-select-box</option>
                            <option>xe-select-boxxe-select-boxxe-select-box</option>
                            <option>xe-select-box</option>
                            <option>xe-select-boxxe-select-box</option>
                            <option>xe-select-box</option>
                        </select>
                    </div>
                    <button type="button" class="xe-btn">선택</button>
                </div>
            </div>
            <div class="xe-form-group">
                <label class="xe-form-label">위젯 타이틀 입력</label>
                <input type="text" class="xe-form-control">
                <p>서브텍스트를 넣을 수 있습니다.</p>
            </div>
            <div class="xe-form-group">
                <label class="xe-form-label">스킨</label>
                <div class="xe-form-inline">
                    <input type="text" class="xe-form-control">
                    <span>서브텍스트(인라인 스타일)</span>
                </div>
            </div>
        </div>
        <div class="seciton">
            <h2>h2 섹션 제목 <button type="button" class="btn-section-close"><i class="xi-angle-down"></i><span class="xe-sr-only">section toggle</span></button></h2>
            <div class="section-group">
                <div class="xe-form-group">
                    <label class="xe-form-label">스킨</label>
                    <div class="xe-select-box xe-btn">
                        <label>xe-select-box</label>
                        <select>
                            <option selected="selected">xe-select-box</option>
                            <option>xe-select-boxxe-select-boxxe-select-box</option>
                            <option>xe-select-box</option>
                            <option>xe-select-boxxe-select-box</option>
                            <option>xe-select-box</option>
                        </select>
                    </div>
                </div>
                <div class="xe-form-group">
                    <label class="xe-form-label">위젯 타이틀 입력</label>
                    <input type="text" class="xe-form-control">
                    <label class="xe-label">
                        <input type="checkbox">
                        <span class="xe-input-helper"></span>
                        <span class="xe-label-text">체크박스</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="seciton">
            <h2>h2 섹션 제목 <button type="button" class="btn-section-close"><i class="xi-angle-down"></i><span class="xe-sr-only">section toggle</span></button></h2>
            <div class="section-group">
                <div class="xe-form-group">
                    <label class="xe-form-label">스킨</label>
                    <div class="xe-select-box xe-btn">
                        <label>xe-select-box</label>
                        <select>
                            <option selected="selected">xe-select-box</option>
                            <option>xe-select-boxxe-select-boxxe-select-box</option>
                            <option>xe-select-box</option>
                            <option>xe-select-boxxe-select-box</option>
                            <option>xe-select-box</option>
                        </select>
                    </div>
                </div>
                <div class="xe-form-group">
                    <label class="xe-form-label">위젯 타이틀 입력</label>
                    <input type="text" class="xe-form-control">
                    <label class="xe-label">
                        <input type="checkbox">
                        <span class="xe-input-helper"></span>
                        <span class="xe-label-text">체크박스</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="btn-center">
            <input type="hidden" id="widgetCode" value="{{ "<xewidget id='widget/banner' title='상단배너'><banner_count>2</banner_count><banner_size>2</banner_size></xewidget>" }}" />
            <button type="button" class="xe-btn xe-btn-secondary">취소</button>
            <button type="button" class="xe-btn xe-btn-primary btnSetWidget">확인</button>
        </div>
    </div>
    <!--// widget layer  -->
</div>
<div class="dimd"></div>
<script type="text/javascript">
    // 마크업 테스트 코드
    $(document).ready(function(){

        $('[data-toggle="xe-tooltip"]').xeTooltip();

        $(".btn-section-close").click(function(){
            $(this).parents(".seciton").children(".section-group").toggle();
            $(this).parents(".seciton").toggleClass("close");
        });

        $('.dimd, .layer-close').on('click', function () {
            $(".widget-layer").removeClass("open");
            $(".dimd").hide();
            $("body").css("overflow", "");
        });

        $(".btnSetWidget").on("click", function() {
            var widgetCode = $("#widgetCode").val()
                , $widgetCode = $(widgetCode);

            var title = $widgetCode.attr("title");


            console.log(title);


        });

        WidgetBox.init();
        WidgetSnb.init();
        WidgetAdder.init();
    });
</script>