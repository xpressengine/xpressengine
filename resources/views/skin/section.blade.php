
<ul class="skin-setting-list">
    @foreach($skinList as $skin)
    <!--[D] 스킨 선택 시  li에 .on 추가-->
    <li class="on">
        <div class="skin-select-btn">
            <!--[D] 스킨 선택 시  btn 클래스에 .on 추가-->
            <!--[D] js추가: 버튼 마우스 오버 시 desktop, mobile 각각 버튼 클래스에 모두(열단위) .hover 추가-->
            <button type="button" class="__xe_assign-btn __xe_skin-desktop btn btn-default btn-sm @if($selectedSkin['desktop']->getId() === $skin->getId()) on @endif" data-skin-type="desktop" data-skin-assign-link="{{ route('settings.skin.section.assign', ['skinId'=>$skin->getId(), 'instanceId'=>$skinInstanceId, 'mode'=>'desktop' ]) }}"><i class="xi-tv visible-xs"></i><span class="hidden-xs"><i class="xi-check"></i>Desktop</span></button>
        </div>
        <div class="skin-select-btn">
            <button type="button" class="__xe_assign-btn __xe_skin-mobile btn btn-default btn-sm @if($selectedSkin['mobile']->getId() === $skin->getId()) on @endif" data-skin-type="mobile" data-skin-assign-link="{{ route('settings.skin.section.assign', ['skinId'=>$skin->getId(), 'instanceId'=>$skinInstanceId, 'mode'=>'mobile' ]) }}"><i class="xi-mobile visible-xs"></i><span class="hidden-xs"><i class="xi-check"></i>Mobile</span></button>
        </div>
        <div class="skin-desc">
            <img src="{{ asset($skin->getScreenshot() ?: 'assets/core/common/img/default_image_196x140.jpg') }}" alt="screenshot" class="hidden-xs">
            <strong class="ellipsis">{{ $skin->getTitle() }}</strong>
            <p class="ellipsis">{{ $skin->getDescription() }}</p>
            <div class="btn-right">
                <button type="button" class="__xe_skin-setting-btn btn btn-link" data-toggle="xe-page-modal" data-url="{{ route('settings.skin.section.setting', ['skinId'=>$skin->getId(), 'instanceId'=>$skinInstanceId]) }}"><i class="xi-cog"></i><span class="hidden-xs">{{xe_trans('xe::settings')}}</span></button>
            </div>
        </div>
    </li>
    @endforeach
</ul>
