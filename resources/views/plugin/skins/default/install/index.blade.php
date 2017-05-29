
<div class="row">
    <div class="col-sm-12">
        <div class="panel-group" id="accordion">
            <div class="panel">
                <div class="panel-heading">
                    <div style="margin:17px 0" class="__xe_install_list">
                        <div class="row">
                            <div class="col-sm-9">
                                <p><span class="__xe_selected_count">0</span>의 플러그인이 선택되었습니다.</p>
                                <div class="well">
                                    <ul>

                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-3 text-right">
                                <button type="button" class="btn btn-primary __xe_install_btn" disabled>설치 시작</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body" style="display: none;">

                </div>
            </div>

            <div class="__xe_plugin_items" style="margin-top:20px;">
                @include($_skin::view('install.items'))
            </div>
        </div>
    </div>
</div>
