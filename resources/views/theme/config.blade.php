
@section('page_title')
    <h2>{{ $theme->getTitle() }} 설정</h2>
@stop

@section('page_description')
    <p>테마를 설정합니다. <br><br></p>

@stop

<div class="row">
    <div class="col-sm-12">
        <form role="form" action="{{ route('settings.theme.config', ['theme'=>request()->get('theme')]) }}" method="post" enctype="multipart/form-data">
            <div class="panel-group">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">설정 선택</h3>
                            <p>{{ count($configList) }}개의 저장된 설정이 있습니다.</p>
                        </div>
                        <div class="pull-right">
                            <button type="button" data-toggle="modal" data-target="#addConfig" class="btn btn-primary">설정 추가</button>
                        </div>
                    </div>
                    <div class="panel-body">
                        {{ uio('formSelect', ['label'=>'설정을 선택하세요.', 'id'=> '__xe_selectConfig', 'name'=>'_configId', 'options'=> $configList, 'selected'=>request()->get('theme')]) }}

                        {{ uio('formText', ['name'=>'_configTitle', 'value' => $config->get('_configTitle', '기본'), 'label'=>'설정 이름 변경']) }}
                    </div>
                </div>
            </div>

            {!! $theme->getSettingView() !!}

            {{ csrf_field() }}

            <div class="pull-right">
                <button type="submit" class="btn btn-primary">저장</button>
            </div>
        </form>
    </div>
</div>

<div id="addConfig" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <form action="{{ route('settings.theme.config.create') }}" method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">새 설정 추가</h4>
            </div>
            <div class="modal-body">
                    <input type="hidden" name="theme" value="{{ $theme->getId() }}">
                    {{ csrf_field() }}
                    {{ uio('formText', ['label'=>'설정 이름', 'name'=>'title']) }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">취소</button>
                <button type="submit" class="btn btn-primary">추가</button>
            </div>
        </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>

    jQuery(function($) {
        var $configUrl = '{{ route('settings.theme.config') }}'
        $('#__xe_selectConfig').change(function(){
            var themeId = this.value;
            location.href = $configUrl + '?theme=' + themeId;
        });
    });

</script>
