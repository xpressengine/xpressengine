<div class="profile_page __xe_profilePage" style="padding: 100px;background-size: cover; background-position: center;">
    <div class="xo-container">
        <!-- content area -->
        <div class="profile_wrap">
            <h1 class="blind">프로필정보</h1>

            <!--기본프로필 -->
            <div class="profile xo-profile __xe_profileBox">
                @if($grant['modify'])
                    <form class="form" name="fMemberEdit" method="post" action="{{ route('member.profile.update', [$member->getId()]) }}" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        @endif
                        <dl>
                            <dt class="blind">프로필 사진</dt>
                            <!--[D] 모바일 대응을 위해 실제 이미지 사이즈 240*240-->
                            <dd class="profile_img">

                                @if($grant['modify'])
                                    {{--<img src="{{ $member->getProfileImage() }}" width="120" height="120" alt="프로필사진">
                                    <div class="btn_file __xe_imgUploadBox" style="display: none;"><input type="file" name="profileImgFile"></div>--}}
                                    {!! $profileImageHtml !!}
                                @else
                                    <img src="{{ $member->getProfileImage() }}" width="120" height="120" alt="프로필사진">
                                @endif
                            </dd>
                            <dt class="blind"><label for="nick">닉네임</label></dt>
                            <dd class="inpt_nick"><input class="__xe_nameInput" type="text" name="displayName" placeholder="이름을 입력하세요." value="{{ $member->getDisplayName() }}" readonly></dd>

                            @if($grant['manage'])
                                <dt class="blind">그룹정보</dt>
                                <dd class="txt_gray">
                                    @foreach($member->groups as $group)
                                        {{ $group->name }}
                                    @endforeach
                                </dd>
                            @endif

                            <dt class="blind"><label for="intro">한줄소개</label></dt>
                            <dd class="inpt_intro">
                                <p class="__xe_introView">{!! $member->introduction or '자신을 멋지게 표현해보세요!' !!}</p>
                                @if($grant['modify'])
                                    <input class="__xe_introInput" style="display: none;" type="text" name="introduction" placeholder="간단한 자기소개를 입력하세요." value="{{ $member->introduction }}">
                                @endif
                            </dd>

                            {{--<dt class="blind">연동한 소셜로그인 정보</dt>
                            <dd class="connect_sns">
                                <!--[D] sns 클릭 시 연동된 sns페이지로 이동 -->
                                <a href="#"><i class="xi-twitter"></i></a>
                                <a href="#"><i class="xi-github"></i></a>
                            </dd>--}}
                        </dl>

                        @if($grant['modify'])
                            <div class="profile_btn_area">
                                <button type="button" class="__xe_profileEditBtn">프로필 수정</button>
                                <button type="submit" class="__xe_profileSaveBtn btn_blue" style="display: none;">저장</button>
                                <button type="button" class="__xe_profileEditCancelBtn" style="display: none;">취소</button>
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
