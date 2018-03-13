{{ XeFrontend::js('/assets/core/widgetbox/js/widgetbox.js')->appendTo("head")->load() }}

{{ XeFrontend::js('assets/vendor/bootstrap/js/bootstrap.min.js')->load() }}
{{ XeFrontend::js('assets/vendor/jqueryui/jquery-ui.js')->appendTo("head")->load() }}


{{ XeFrontend::css('assets/vendor/XEIcon/xeicon.min.css')->load() }}
{{ XeFrontend::css([
    '/assets/vendor/jqueryui/jquery-ui.css',
    '/assets/vendor/bootstrap/css/bootstrap.css',
    '/assets/core/widgetbox/css/widgetbox.css',
])->load() }}
<style>
    .editor .widget-config-btn .xe-btn {padding: 3px; color:#656973; font-size: 15px;}
    .editor .xe-well {margin: 5px; padding:7px 15px; background-color: #fff; border:1px solid #C8C9CC;}
    .editor .xe-well strong {font-weight: normal; font-size: 14px; line-height: 33px;}
    .editor .widgetarea {min-height: 140px; background: #e6e6e6; padding-top: 5px; padding-bottom: 15px;}
    .editor .wb-row-header {height: 25px; background: #fff; border-bottom: 1px solid #C8C9CC; padding: 2px 2px;}
    .editor .wb-row-header button {font-size: 12px; padding: 1px 5px;}
    .editor .wb-col-header {height: 25px; background: #fff; border-bottom: 1px solid #C8C9CC; padding: 2px 2px;}
    .editor .wb-col-header button {font-size: 12px; padding: 1px 5px;}

    .editor .wb-row {width: 100%; border: 1px solid #c9c9c9; min-height: 140px; margin-bottom: 5px;}
    .editor .wb-col {display: inline-block; padding: 2px 2px; min-height: 140px; vertical-align: top;}
    .editor .wb-row.selected {background-color: #FFB0B6;}
    .editor .wb-row.selected>.wb-row-header {background-color: #FFB0B6;}
    .editor .wb-col.selected {background-color: #B8DBFD;}
    .editor .wb-col.selected>.wb-col-header {background-color: #B8DBFD;}
    .editor .wb-col .wb-row-header {display: none;}
    .editor .drop-placeholder {height: 49px; margin:5px; background: #F7F999}

    /* style by bootstrap tags (https://github.com/maxwells/bootstrap-tags) */
    .tag {font-size: 10px; padding: .3em .4em .4em; margin: 0 .1em;}
    .tag a {color: #bbb; cursor: pointer; opacity: 0.6; font-size: 12px;}
    .tag a:hover {opacity: 1.0}
    .tag .remove {vertical-align: bottom; top: 0;}
    .tag a {margin: 0 0 0 .3em;}
    .tag a .glyphicon-white {color: #fff; margin-bottom: 2px;}
</style>
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
            <form id="__xe_widgetboxPermission" action="{{ route('widgetbox.permission', ['id'=>$widgetbox->id]) }}">
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
