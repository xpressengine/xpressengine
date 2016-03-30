<div class="__xe_skinSetting" data-instance-id="{{ $skinInstanceId }}" data-skin-id="{{ $selectedSkin->getId() }}">


    <div class="__xe_skinIndicator">
        {{--skin type--}}
        <span class="label label-default">{{ $mode !== 'mobile' ? '기본' : '모바일' }}</span>
        {{--skin title--}}
        <b><span class="__xe_skinTitle">{{ $selectedSkin->getTitle() }}</span></b>

        {{--btns--}}
        <a href="#" class="pull-right __xe_editBtn">수정</a>
        <a href="#"  style="display: none;" class="pull-right __xe_saveBtn">저장</a>
        <a href="#"  style="display: none;" class="pull-right __xe_cancelBtn">취소</a>
    </div>
    <div class="__xe_skinSetter mg-top" style="display: none;">
        <div class="well">
            <form class="__xe_skinForm" role="form" id="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="instanceId" value="{{ $skinInstanceId }}">
                <input type="hidden" name="mode" value="{{ $mode }}">
                {{--skin select box--}}
                <div class="__xe_skinSelector">
                    {!! uio('formSelect', ['class'=>'__xe_skin', 'label'=>'스킨 선택', 'name'=>'skinId', 'options'=> $skins]) !!}
                </div>
                {{--skin setting forms--}}
                <div class="__xe_skinForms">
                    @if($settingView !== null)
                        {!! $settingView !!}
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>










