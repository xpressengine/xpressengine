{{ XeFrontend::js('/assets/core/widgetbox/js/widgetbox.js')->appendTo("head")->load() }}

{{ XeFrontend::js('assets/vendor/bootstrap/js/bootstrap.min.js')->load() }}
{{ XeFrontend::js('assets/vendor/jqueryui/jquery-ui.min.js')->appendTo("head")->load() }}


{{ XeFrontend::css('https://cdn.jsdelivr.net/npm/xeicon@2.3/xeicon.min.css')->load() }}
{{ XeFrontend::css([
    '/assets/vendor/jqueryui/jquery-ui.min.css',
    '/assets/vendor/bootstrap/css/bootstrap.min.css',
    '/assets/core/widgetbox/css/widgetbox.css',
])->load() }}

<div class="widget-wrap">
    <header>
        <h1><a href="#"><i class="xi-xpressengine"></i><span class="brand-title"><span
                            class="xe-sr-only">xe3 widgetbox</span></span></a></h1>
        <div class="xe-pull-right">
            @if($permission !== null)
                <button type="button" class="xe-btn __xe_btnPermission" data-target="#permission-modal" data-toggle="modal">{{ xe_trans('xe::permissionSettings') }}</button>
            @endif
            <button type="button" class="xe-btn" id="btn-preview" data-url="{{ route('widgetbox.preview', ['id' => $widgetbox->id]) }}">{{ xe_trans('xe::preview') }}</button>
            <button type="button" class="xe-btn xe-btn-primary" id="btn-save" data-url="{{ route('widgetbox.update', ['id' => $widgetbox->id]) }}"><i class="xi-check"></i>{{ xe_trans('xe::save') }}</button>
        </div>
    </header>
    <div class="widget-snb">
        <div class="snb-section">
            <h2>{{ $widgetbox->title }}</h2>
            <p>{{ $widgetbox->title }} {{ xe_trans('xe::doEditWidgetBox') }}</p>
        </div>
        <div class="snb-section">
            <h3>Presenter <i class="xi-help-o" data-toggle="xe-tooltip" data-placement="bottom"
                             title="{{ xe_trans('xe::descPresenter') }}"></i></h3>
            <div>
                <select class="xe-form-control" id="presenter">
                    @foreach ($presenters as $presenter)
                        <option value="{{ $presenter }}" data-cols="{{ $presenter::COLS }}">{{ $presenter::NAME }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="snb-section">
            <h3>Device mode <i class="xi-help-o" data-toggle="xe-tooltip" data-placement="bottom"
                               title="{{ xe_trans('xe::descDeviceMode') }}"></i></h3>
            <div class="xe-btn-group xe-btn-group-justified mode-btns">
                <div class="xe-btn-group">
                    <button class="xe-btn xe-btn-sm" data-mode="xs">
                        <i class="xi-mobile"></i>Mobile
                    </button>
                </div>
                <div class="xe-btn-group">
                    <button class="xe-btn xe-btn-sm" data-mode="sm">
                        <i class="xi-tablet"></i>Tablet
                    </button>
                </div>
            </div>
            <div class="xe-btn-group xe-btn-group-justified mode-btns">
                <div class="xe-btn-group">
                    <!--[D] 활성화 시 .xe-btn-primary 추가-->
                    <button class="xe-btn xe-btn-sm xe-btn-primary" data-mode="md">
                        <i class="xi-desktop"></i>Desktop
                    </button>
                </div>
                <div class="xe-btn-group">
                    <button class="xe-btn xe-btn-sm" data-mode="lg">
                        <i class="xi-tv"></i>Large Screen
                    </button>
                </div>
            </div>
        </div>
        <div class="snb-section">
            <h3>{{ xe_trans('xe::cellManagement') }} <i class="xi-help-o" data-toggle="xe-tooltip" data-placement="bottom"
                       title="{{ xe_trans('xe::descCellManagement') }}"></i></h3>
            <div class="cell-config-btn">
                <div>
                    <button type="button" class="xe-btn xe-btn-sm xe-btn-primary-outline xe-btn-block" id="btn-add-row">{{ xe_trans('xe::addRow') }}</button>
                </div>
                <div class="form-inline">
                    <div class="form-group" id="col-controls">
                        <select data-type="mode" class="form-control">
                            <option value="xs">mobile</option>
                            <option value="sm">tablet</option>
                            <option value="md" selected>desktop</option>
                            <option value="lg">large screen</option>
                        </select>
                        <select data-type="span" class="form-control">
                        </select>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-default" data-control="col">{{ xe_trans('xe::addCell') }}</button>
                            <button type="button" class="btn btn-sm btn-default" data-control="opt">{{ xe_trans('xe::addOption') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="snb-section">
            <h3>{{ xe_trans('xe::widgetManagement') }} <i class="xi-help-o" data-toggle="xe-tooltip" data-placement="bottom"
                         title="{{ xe_trans('xe::descWidgetManagement') }}"></i></h3>
            <button class="xe-btn xe-btn-primary xe-btn-sm xe-btn-block btn-widget-add" id="btn-add-widget">
                <i class="xi-layout-o"></i>{{ xe_trans('xe::addWidget') }}
            </button>
        </div>
    </div>
    <div class="widget-container">
        <div class="widget-content">
            <h3>{{ xe_trans('xe::editArea') }} <i class="xi-help-o" data-toggle="xe-tooltip" data-placement="bottom"
                         title="{{ xe_trans('xe::descEditArea') }}"></i>
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
            <button type="button" class="xe-btn xe-btn-secondary" id="btn-close-layer">{{ xe_trans('xe::cancel') }}</button>
            <button type="button" class="xe-btn xe-btn-primary" id="btn-place-widget">{{ xe_trans('xe::confirm') }}</button>
        </div>
    </div>
    <!--// widget layer  -->
</div>

@if($permission !== null)
    <div class="modal permission-modal fade" id="permission-modal">
        <div class="modal-dialog modal-lg">
            <form id="__xe_widgetboxPermission" method="post" data-submit="xe-ajax" data-callback="callbackWidgetboxPermission" action="{{ route('widgetbox.permission', ['id'=>$widgetbox->id]) }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">{{ xe_trans('xe::permissionSettings') }}</h4>
                    </div>

                    <div class="modal-body">
                        <p><strong>{{ $widgetbox->title }}</strong> {{ xe_trans('xe::specWhoCanEditWidgetBox') }}</p>
                        <hr>
                        {{ uio('permission', $permission) }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="xe-btn xe-btn-secondary" data-dismiss="modal">{{ xe_trans('xe::cancel') }}</button>
                        <button type="submit" class="xe-btn xe-btn-primary">{{ xe_trans('xe::save') }}</button>
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
        loadUrl: '".route('widgetbox.code', ['id' => $widgetbox->id])."',
    });

</script>")->load() }}

@if($permission !== null)
    {!!  XeFrontend::html('widgetbox.permission')->content("<script>
        function callbackWidgetboxPermission(res) {
            XE.toast('success', res.message);
            $('#permission-modal').modal('hide');
        }
    </script>")->load() !!}
@endif
