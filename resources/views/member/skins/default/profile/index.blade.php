<div class="profile-page __xe_profilePage" style="padding: 100px;background-size: cover; background-position: center;">
    <div class="xe-container">
        <!-- content area -->
        <div class="profile-wrap">
            <h1 class="xe-sr-only">프로필정보</h1>

            <!--기본프로필 -->
            <div class="profile xe-profile __xe_profileBox">
                @if($grant['modify'])
                    <form class="form" name="fMemberEdit" method="post" action="{{ route('member.profile.update', [$user->getId()]) }}" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        @endif
                        <dl>
                            <dt class="xe-sr-only">프로필 사진</dt>
                            <!--[D] 모바일 대응을 위해 실제 이미지 사이즈 240*240-->
                            <dd class="profile-img">

                                @if($grant['modify'])
                                    {{--<img src="{{ $user->getProfileImage() }}" width="120" height="120" alt="프로필사진">
                                    <div class="btn-file __xe_imgUploadBox" style="display: none;"><input type="file" name="profileImgFile"></div>--}}
                                    {!! $profileImageHtml !!}
                                @else
                                    <img src="{{ $user->getProfileImage() }}" width="120" height="120" alt="프로필사진">
                                @endif
                            </dd>
                            <dt class="xe-sr-only"><label for="nick">닉네임</label></dt>
                            <dd class="input-nick"><input class="__xe_nameInput" type="text" name="displayName" placeholder="이름을 입력하세요." value="{{ $user->getDisplayName() }}" readonly></dd>

                            @if($grant['manage'])
                                <dt class="xe-sr-only">그룹정보</dt>
                                <dd class="text-gray">
                                    @foreach($user->groups as $group)
                                        {{ $group->name }}
                                    @endforeach
                                </dd>
                            @endif

                            <dt class="xe-sr-only"><label for="intro">한줄소개</label></dt>
                            <dd class="input-intro">
                                <p class="__xe_introView">{!! $user->introduction or '자신을 멋지게 표현해보세요!' !!}</p>
                                @if($grant['modify'])
                                    <input class="__xe_introInput" style="display: none;" type="text" name="introduction" placeholder="간단한 자기소개를 입력하세요." value="{{ $user->introduction }}">
                                @endif
                            </dd>

                            {{--<dt class="xe-sr-only">연동한 소셜로그인 정보</dt>
                            <dd class="connect-sns">
                                <!--[D] sns 클릭 시 연동된 sns페이지로 이동 -->
                                <a href="#"><i class="xi-twitter"></i></a>
                                <a href="#"><i class="xi-github"></i></a>
                            </dd>--}}
                        </dl>

                        @if($grant['modify'])
                            <div class="profile-btn-area">
                                <button type="button" class="xe-btn __xe_profileEditBtn">프로필 수정</button>
                                <button type="submit" class="xe-btn xe-btn-primary-outline __xe_profileSaveBtn" style="display: none;">저장</button>
                                <button type="button" class="xe-btn __xe_profileEditCancelBtn xe-btn" style="display: none;">취소</button>
                            </div>
                        @endif

                        @if($grant['modify'])
                    </form>
                @endif

            </div>
            <!--//기본프로필 -->

        </div>
        <!-- //content area -->
    </div>
</div>
