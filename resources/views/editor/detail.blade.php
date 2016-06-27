@section('page_title')
    <h2>Editor 설정</h2>
@endsection

@section('page_description')
    <small>Editor 설정페이지 입니다.</small>
@endsection

@section('content_bread_crumbs')

@endsection

<div class="panel-group" role="tablist" aria-multiselectable="true">
    <div class="panel">
        <div class="panel-heading">
            <div class="pull-left">
                <h3 class="panel-title">상세 설정</h3>
            </div>
        </div>
        <div class="panel-collapse collapse in">
            <form method="post" action="{{ route('settings.editor.setting.detail', $instanceId) }}">
                {{ csrf_field() }}
                <div class="panel-body">

                    <div class="panel">
                        <div class="panel-heading">
                            <div class="pull-left">
                                <h4 class="panel-title">기본설정</h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="clearfix">
                                            <label>
                                                에디터 높이
                                                <small> 단위: px</small>
                                            </label>
                                        </div>
                                        <input type="text" class="form-control" name="height" value="{{ $config->get('height') }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="clearfix">
                                            <label>
                                                문서 글자 크기
                                                <small>12px, 1em등 단위까지 포함해서 입력해주세요.</small>
                                            </label>
                                        </div>
                                        <input type="text" class="form-control" name="fontSize" value="{{ $config->get('fontSize') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="clearfix">
                                            <label>
                                                글꼴
                                                <small>콤마(,)로 여러 글꼴을 지정할 수 있습니다.</small>
                                            </label>
                                        </div>
                                        <input type="text" class="form-control" name="fontFamily" value="{{ $config->get('fontFamily') }}" placeholder="Ex) Tahoma, Geneva, sans-serif">
                                    </div>
                                </div>
                            </div>


                            <div class="panel">
                                <div class="panel-heading">
                                    <div class="pull-left">
                                        <h4 class="panel-title">html 편집 권한</h4>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    {!! uio('permission', $permArgs['html']) !!}
                                </div>
                            </div>

                            <div class="panel">
                                <div class="panel-heading">
                                    <div class="pull-left">
                                        <h4 class="panel-title">기본 도구 사용 권한</h4>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    {!! uio('permission', $permArgs['tool']) !!}
                                </div>
                            </div>


                        </div>
                    </div>


                    <div class="panel">
                        <div class="panel-heading">
                            <div class="pull-left">
                                <h4 class="panel-title">파일</h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="clearfix">
                                            <label>
                                                업로드 사용
                                            </label>
                                        </div>
                                        <label>
                                            <input type="checkbox" name="uploadActive" value="1" {{ $config->get('uploadActive') ? 'checked' : '' }}>
                                            에디터에서 파일을 업로드 할 수 있습니다.
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="clearfix">
                                            <label>
                                                허용 확장자
                                                <small>콤마(,)로 여러 확장자를 지정할 수 있습니다. 예) * or jpg,gif</small>
                                            </label>
                                        </div>
                                        <input type="text" class="form-control" name="extensions" value="{{ $config->get('extensions') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="clearfix">
                                            <label>
                                                파일 크기 제한
                                                <small>하나의 파일에 대해 최고 용량을 지정할 수 있습니다.</small>
                                            </label>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="fileMaxSize" value="{{ $config->get('fileMaxSize') }}">
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" value="단위: MB" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="clearfix">
                                            <label>
                                                문서 첨부 제한
                                                <small>하나의 문서에 첨부할 수 있는 최고 용량을 지정할 수 있습니다.</small>
                                            </label>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="attachMaxSize" value="{{ $config->get('attachMaxSize') }}">
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" value="단위: MB" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel">
                                <div class="panel-heading">
                                    <div class="pull-left">
                                        <h4 class="panel-title">업로드 권한</h4>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    {!! uio('permission', $permArgs['upload']) !!}
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-heading">
                            <div class="pull-left">
                                <h4 class="panel-title">부가기능</h4>
                            </div>
                        </div>

                        <ul class="list-group item-setting">
                            @foreach ($items as $id => $item)
                                <li class="list-group-item">
                                    <button class="btn handler"><i class="xi-bullet-point"></i></button>
                                    <em class="item-title">{{ $item['class']::getComponentInfo('name') }}</em>
                                    <span class="item-subtext">{{ $item['class']::getComponentInfo('description') }}</span>
                                    <div class="xe-btn-toggle pull-right">
                                        <label>
                                            <span class="sr-only">toggle</span>
                                            <input type="checkbox" name="tools[]" value="{{ $id }}" {{$item['activated'] ? 'checked' : ''}}>
                                            <span class="toggle"></span>
                                        </label>
                                    </div>
                                    <div class="pull-right">
                                        @if($uri = $item['class']::getInstanceSettingURI($instanceId))
                                            <a href="{{ $uri }}">설정</a>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                    </div>

                </div>
                <div class="panel-footer">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary">저장</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div class="panel">
        <div class="panel-heading">
            <div class="pull-left">
                <h3 class="panel-title">{{ xe_trans('xe::skin') }}</h3>
            </div>
            <div class="pull-right">
                <a data-toggle="collapse" data-parent="#accordion" href="#commentSkinSection" class="btn-link panel-toggle pull-right"><i class="xi-angle-down"></i><i class="xi-angle-up"></i><span class="sr-only">메뉴닫기</span></a>
            </div>
        </div>
        <div id="commentSkinSection" class="panel-collapse collapse in">
            <div class="panel-body">
                {!! $skinSection !!}
            </div>
        </div>
    </div>
</div>