<div class="profile-page __xe_profilePage" style="padding-top: 100px;">
    <div class="xe-container">
        <!-- content area -->
        <div class="profile-wrap">
            <h1 class="xe-sr-only">{{xe_trans('xe::profile')}}</h1>

            <!--기본프로필 -->
            <div class="profile xe-profile __xe_profileBox">
                @if($grant['modify'])
                    <form class="form" name="fMemberEdit" method="post" action="{{ route('user.profile.update', [$user->getId()]) }}" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        @endif
                        <dl>
                            <dt class="xe-sr-only">{{xe_trans('xe::profileImage')}}</dt>
                            <!--[D] 모바일 대응을 위해 실제 이미지 사이즈 240*240-->
                            <dd class="profile-img">

                                @if($grant['modify'])
                                    {{--<img src="{{ $user->getProfileImage() }}" width="120" height="120" alt="프로필사진">
                                    <div class="btn-file __xe_imgUploadBox" style="display: none;"><input type="file" name="profileImgFile"></div>--}}
                                    {!! $profileImageHtml !!}
                                @else
                                    <img src="{{ $user->getProfileImage() }}" width="120" height="120" alt="{{xe_trans('xe::profileImage')}}">
                                @endif
                            </dd>
                            <dt class="xe-sr-only"><label for="nick">{{xe_trans('xe::displayName')}}</label></dt>
                            <dd class="input-nick"><input class="__xe_nameInput" type="text" name="displayName" placeholder="{{xe_trans('xe::enterName')}}" value="{{ $user->getDisplayName() }}" readonly></dd>

                            @if($grant['manage'])
                                <dt class="xe-sr-only">{{xe_trans('xe::group')}}</dt>
                                <dd class="text-gray">
                                    @foreach($user->groups as $group)
                                        {{ $group->name }}
                                    @endforeach
                                </dd>
                            @endif

                            <dt class="xe-sr-only"><label for="intro">{{xe_trans('xe::introduction')}}</label></dt>
                            <dd class="input-intro">
                                <p class="__xe_introView">{!! $user->introduction or xe_trans('xe::enterIntroduction') !!}</p>
                                @if($grant['modify'])
                                    <input class="__xe_introInput" style="display: none;" type="text" name="introduction" placeholder="{{xe_trans('xe::enterIntroduction')}}" value="{{ $user->introduction }}">
                                @endif
                            </dd>
                        </dl>

                        @if($grant['modify'])
                            <div class="profile-btn-area">
                                <button type="button" class="xe-btn __xe_profileEditBtn">{{xe_trans('xe::profileEdit')}}</button>
                                <button type="submit" class="xe-btn xe-btn-primary-outline __xe_profileSaveBtn" style="display: none;">{{xe_trans('xe::save')}}</button>
                                <button type="button" class="xe-btn __xe_profileEditCancelBtn xe-btn" style="display: none;">{{xe_trans('xe::cancel')}}</button>
                            </div>
                        @endif

                        @if($grant['modify'])
                    </form>
                @endif

            </div>
            <!--//기본프로필 -->
            @if($widgetbox)
            <div class="card-wrap">
                <div class="xe-container">
                    {{ uio('widgetbox', ['id' => 'user-profile', 'link'=> xe_trans('xe::edit')]) }}
                </div>
            </div>
            @endif

        </div>
        <!-- //content area -->
    </div>
</div>
