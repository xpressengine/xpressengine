{{ XeFrontend::js('/assets/core/widgetbox/js/widgetbox.js')->appendTo("head")->load() }}
{{ XeFrontend::js('/assets/core/widgetbox/js/widgetboxSnb.js')->appendTo("head")->load() }}
{{ XeFrontend::js('/assets/core/widgetbox/js/widgetAdder.js')->appendTo("head")->load() }}
{{ XeFrontend::js('assets/vendor/bootstrap/js/bootstrap.min.js')->load() }}
{{ XeFrontend::js('assets/vendor/jqueryui/jquery-ui.js')->appendTo("head")->load() }}


{{ XeFrontend::css('assets/vendor/XEIcon/xeicon.min.css')->load() }}
{{ XeFrontend::css([
    '/assets/vendor/jqueryui/jquery-ui.css',
    '/assets/vendor/bootstrap/css/bootstrap.css',
    '/assets/core/widgetbox/css/widgetbox.css',
])->load() }}

<div class="widget-wrap">
    <header>
        <h1><a href="#"><i class="xi-xpressengine"></i><span class="brand-title"><span
                            class="xe-sr-only">xe3 widgetbox</span></span></a></h1>
        <div class="xe-pull-right">
            @if($permission !== null)
            <button type="button" class="xe-btn __xe_btnPermission" data-target="#permission-modal" data-toggle="modal">권한설정</button>
            @endif
            <button type="button" class="xe-btn btnPreview">미리보기</button>
            <button type="button" class="xe-btn xe-btn-primary btnUpdatePage"><i class="xi-check"></i>저장</button>
        </div>
    </header>
    <div class="widget-snb">
        <div class="snb-section">
            <h2>{{ $widgetbox->title }}</h2>
            <p>{{ $widgetbox->title }} 위젯박스를 편집합니다.</p>
        </div>
        <div class="snb-section">
            <h3>Device mode <i class="xi-help-o" data-toggle="xe-tooltip" data-placement="bottom"
                               title="모바일에서는 모든 셀이 12col을 차지하도록하여 추가 옵션을 지원 하지 않습니다."></i></h3>
            <div class="xe-btn-group xe-btn-group-justified">
                <div class="xe-btn-group">
                    <!--[D] 활성화 시 .xe-btn-primary 추가-->
                    <button class="xe-btn xe-btn-sm btnMode" data-toggle="xe-tooltip" data-placement="bottom"
                            data-mode="mobile" title="모바일 모드는 지원하지 않습니다."><i class="xi-mobile"></i>Mobile
                    </button>
                </div>
                <div class="xe-btn-group">
                    <button class="xe-btn xe-btn-sm xe-btn-primary btnMode" data-mode="desktop"><i class="xi-tv"></i>Desktop
                    </button>
                </div>
            </div>
        </div>
        <div class="snb-section">
            <h3>셀관리 <i class="xi-help-o" data-toggle="xe-tooltip" data-placement="bottom"
                       title="편집영역에 셀 레이아웃을 추가하거나 셀을 선택하여 수직/수평으로 분할하여 레이아웃을 편집할 수 있습니다."></i></h3>
            <div class="cell-config-btn">
                <div class="xe-form-inline">
                    <div class="xe-form-group">
                        <!--[D] 기본 dropdown 구조에서 .vertical-list 추가-->
                        <div class="xe-btn-group vertical-list">
                            <button type="button" class="xe-btn xe-btn-sm btnDivision" data-direction="vertical"><span
                                        class="text-vertical">수직분할</span> (<span id="divisionTypeView">6:6</span>)
                            </button>
                            <button type="button" class="xe-btn xe-btn-sm xe-dropdown-toggle" data-toggle="xe-dropdown">
                                <span class="caret"></span>
                                <span class="xe-sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="xe-dropdown-menu">
                                <ul id="selectDivision">
                                    <li>
                                        <a href="#" data-type="6|6" data-display="6:6">
                                            <span class="xe-col-xs-6"><em>6</em></span>
                                            <span class="xe-col-xs-6"><em>6</em></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" data-type="4|8" data-display="4:8">
                                            <span class="xe-col-xs-4"><em>4</em></span>
                                            <span class="xe-col-xs-8"><em>8</em></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" data-type="4|4|4" data-display="4:4:4">
                                            <span class="xe-col-xs-4"><em>4</em></span>
                                            <span class="xe-col-xs-4"><em>4</em></span>
                                            <span class="xe-col-xs-4"><em>4</em></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" data-type="3|3|3|3" data-display="3:3:3:3">
                                            <span class="xe-col-xs-3"><em>3</em></span>
                                            <span class="xe-col-xs-3"><em>3</em></span>
                                            <span class="xe-col-xs-3"><em>3</em></span>
                                            <span class="xe-col-xs-3"><em>3</em></span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="xe-input-group xe-input-group-sm">
                                    <input id="inputVerticalSize" type="text" class="xe-form-control">
                                    <span class="xe-input-group-btn">
                                        <button id="btnAddDivisionType" class="xe-btn" type="button">분할</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="xe-btn xe-btn-sm xe-btn-primary-outline" id="btnAddRow">셀추가</button>
                    </div>
                </div>
                <div>
                    <button type="button" class="xe-btn xe-btn-sm btnDivision" data-direction="horizontal"><span
                                class="text-horizontal">수평분할</span></button>
                    <button type="button" class="xe-btn xe-btn-sm" id="btnDeselectAll">선택 취소</button>
                    <button type="button" class="xe-btn xe-btn-sm" id="btnDelBlock">삭제</button>
                </div>
            </div>
        </div>
        <div class="snb-section">
            <h3>위젯 관리 <i class="xi-help-o" data-toggle="xe-tooltip" data-placement="bottom"
                         title="위젯을 추가할 셀을 선택한 후 위젯 추가 버튼을 클릭하여 설정을 등록하면 위젯이 추가됩니다."></i></h3>
            <a href="#" class="xe-btn xe-btn-primary xe-btn-sm xe-btn-block btn-widget-add"><i class="xi-layout-o"></i>위젯
                추가</a>
        </div>
    </div>
    <div class="widget-container">
        <div class="widget-content">
            <h3>편집 영역 <i class="xi-help-o" data-toggle="xe-tooltip" data-placement="bottom"
                         title="각 셀에 출력되는 번호는 셀이 출력되는 순서입니다. 생성된 위젯은 drag &amp; drop 으로 순서를 변경하거나  다른셀로 이동이 가능합니다.셀을 클릭하여 선택하거나 삭제가 가능합니다."></i>
            </h3>
            <!-- editor area -->
            <div class="editor xe-container-fluid"></div>
            <!-- editor area -->
        </div>
    </div>
    <!--widget layer  -->
    <!--[D] .open 추가 시 layer 펼침 -->
    <div class="widget-layer">
        {{ uio('widget', ['id'=>'widgetGen', 'show_code'=>false]) }}

        <div class="btn-center">
            <input type="hidden" id="widgetCode"
                   value="{{ "<xewidget id='widget/banner' title='상단배너'><banner_count>2</banner_count><banner_size>2</banner_size></xewidget>" }}"/>
            <button type="button" class="xe-btn xe-btn-secondary btnCloseLayer">취소</button>
            <button type="button" class="xe-btn xe-btn-primary btnPlaceWidget">확인</button>
        </div>
    </div>
    <!--// widget layer  -->
</div>

@if($permission !== null)
<div class="modal permission-modal fade" id="permission-modal">
    <div class="modal-dialog modal-lg">
        <form id="__xe_widgetboxPermission" action="{{ route('widgetbox.permission', ['id'=>$widgetbox->id]) }}">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">권한 설정</h4>
            </div>

            <div class="modal-body">
                <p><strong>{{ $widgetbox->title }} 위젯박스</strong>를 편집할 수 있는 사용자를 지정합니다.</p>
                <hr>
                {{ uio('permission', $permission) }}
            </div>
            <div class="modal-footer">
                <button type="button" class="xe-btn xe-btn-secondary" data-dismiss="modal">취소</button>
                <button type="submit" class="xe-btn xe-btn-primary">저장</button>
            </div>
        </div>
        </form>
    </div>
</div>
@endif

<div class="dimd"></div>

{{ XeFrontend::html('widgetbox')->content("
<script type=\"text/javascript\">
    WidgetBox.init({
        widgetboxId: '$widgetbox->id',
        previewUrl: '".route('widgetbox.preview', ['id' => $widgetbox->id])."',
        codeUrl: '".route('widgetbox.code', ['id' => $widgetbox->id])."',
        updateUrl: '".route('widgetbox.update', ['id' => $widgetbox->id])."'
    });
    WidgetSnb.init();
    WidgetAdder.init();

</script>")->load() }}

@if($permission !== null)
{!!  XeFrontend::html('widgetbox.permission')->content("<script>
    $(function($) {
        $('#__xe_widgetboxPermission').submit(function(){
            var form = $(this);

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                dataType: 'json',
                success: function (data) {
                    XE.toast('success', data.message);
                    $('#permission-modal').modal('hide');
                }
            });

        return false;
    })

    });
</script>")->load() !!}
@endif
