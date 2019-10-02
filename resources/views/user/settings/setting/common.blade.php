{{ XeFrontend::css('assets/core/xe-ui/css/xe-ui-without-base.css')->load() }}
{{ XeFrontend::css('assets/core/settings/css/admin.css')->load() }}

{{ \var_dump($config) }}

<!-- container-fluid--part (max-width: 960px, 설정 또는 서비스), container-fluid--all (max-width: none, 회원 또는 테마/익스텐션) -->
<div class="container-fluid container-fluid--part">
    <div class="row">
        <div class="col-sm-12">
            <div class="setting-area-group">
                <form id="fSetting" method="post" action="{{ route('settings.user.setting') }}">
                    <!-- 각 세팅 박스 -->
                    <section class="setting-area">
                        <div class="setting-area__header">
                            <h3 class="setting-area__header-title">{{ xe_trans('xe::joinSettings') }}</h3>
                        </div>
                        <div class="setting-area__body">
                            <div class="setting-box">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h4 class="setting-box__sub-title">가입설정</h4>
                                    </div>
                                    <div class="col-sm-9">
                                        <label class="xu-label-checkradio">
                                            <input type="checkbox" name="joinable" value="true" @if($config->get('joinable')) checked @endif>
                                            <span class="xu-label-checkradio__helper"></span>
                                            <span class="xu-label-checkradio__text">로그인/회원 가입 사용</span>
                                        </label>
                                        <p class="setting-box__text-info" style="padding-left: 24px;">로그인 및 회원 가입 버튼을 표시합니다.<br> 이를 해제하게되면 로그인, 회원가입 버튼이 표시되지 않으며, 페이지는 특정한 경로(예: 회원 권한이 필요한 메뉴에서 로그인)로 로그인 가능</p>
                                    </div>
                                </div>
                            </div>

                            <div class="setting-box">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h4 class="setting-box__sub-title">가입절차</h4>
                                    </div>
                                    <div class="col-sm-9">
                                        <div>
                                            <label class="xu-label-checkradio">
                                                <input type="radio" name="register_process" value="activated" @if($config->get('register_process') === 'activated') checked @endif>
                                                <span class="xu-label-checkradio__helper"></span>
                                                <span class="xu-label-checkradio__text">자동가입</span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="xu-label-checkradio">
                                                <input type="radio" name="register_process" value="@FIXME">
                                                <span class="xu-label-checkradio__helper"></span>
                                                <span class="xu-label-checkradio__text">관리자 승인 후 가입</span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="xu-label-checkradio">
                                                <input type="radio" name="register_process" value="@FIXME">
                                                <span class="xu-label-checkradio__helper"></span>
                                                <span class="xu-label-checkradio__text">이메일 인증 후 가입</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="setting-box">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h4 class="setting-box__sub-title">약관동의</h4>
                                    </div>
                                    <div class="col-sm-9">
                                        <div>
                                            <label class="xu-label-checkradio">
                                                <input type="radio" name="term_agree_type" value="@FIXME">
                                                <span class="xu-label-checkradio__helper"></span>
                                                <span class="xu-label-checkradio__text">가입시 약관 동의 단계 거치기(권장)</span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="xu-label-checkradio">
                                                <input type="radio" name="term_agree_type" value="@FIXME">
                                                <span class="xu-label-checkradio__helper"></span>
                                                <span class="xu-label-checkradio__text">약관 동의 단계 대신 회원정보 입력 하단에 약관동의 문구 표시</span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="xu-label-checkradio">
                                                <input type="radio" name="term_agree_type" value="@FIXME">
                                                <span class="xu-label-checkradio__helper"></span>
                                                <span class="xu-label-checkradio__text">약관 동의를 사용하지 않음</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="setting-box">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h4 class="setting-box__sub-title">가입안내</h4>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="xu-form-group" style="margin-bottom: 8px;">
                                            <div class="xu-form-group__box" style="width: 100%;">
                                                <textarea name="@FIXME" value="@FIXME" class="xu-form-group__control" cols="33" rows="3" placeholder="예 : 아래 항목을 빠짐없이 입력해 주세요.">{{ $config->get('register_guide') }}</textarea>
                                            </div>
                                        </div>
                                        <p class="setting-box__text-info">회원가입시 정보입력 단계 상단에 표시될 내용입니다. (여러줄 입력 가능)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="setting-area__footer">

                        </div>
                    </section>

                    <section class="setting-area">
                        <div class="setting-area__header">
                            <h3 class="setting-area__header-title">가입 폼 관리</h3>
                        </div>
                        <div class="setting-area__body">
                            <div class="table-scroll">
                                <table class="admin-table admin-table__signup">
                                    <colgroup>
                                        <col class="col1" />
                                        <col class="col2" />
                                        <col class="col3" />
                                        <col class="col4" />
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th>항목</th>
                                            <th class="text-align--center">로그인 계정</th>
                                            <th class="text-align--center">사용</th>
                                            <th class="text-align--center">필수</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>이메일 주소</td>
                                            <td class="text-align--center">
                                                <label class="xu-label-checkradio">
                                                    <input type="radio" name="">
                                                    <span class="xu-label-checkradio__helper"></span>
                                                </label>
                                            </td>
                                            <td class="text-align--center">
                                                <label class="xu-label-checkradio">
                                                    <input type="checkbox" name="">
                                                    <span class="xu-label-checkradio__helper"></span>
                                                </label>
                                            </td>
                                            <td class="text-align--center">
                                                <label class="xu-label-checkradio">
                                                    <input type="checkbox" name="">
                                                    <span class="xu-label-checkradio__helper"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>아이디</td>
                                            <td class="text-align--center">
                                                <label class="xu-label-checkradio">
                                                    <input type="radio" name="">
                                                    <span class="xu-label-checkradio__helper"></span>
                                                </label>
                                            </td>
                                            <td class="text-align--center">
                                                <!-- [D] disabled 해제 방법 : class="xu-label-checkradio--disabled" 제거, input에 disabled 속석 제거 -->
                                                <label class="xu-label-checkradio xu-label-checkradio--disabled">
                                                    <input type="checkbox" name="" disabled="disabled">
                                                    <span class="xu-label-checkradio__helper"></span>
                                                </label>
                                            </td>
                                            <td class="text-align--center">
                                                <label class="xu-label-checkradio xu-label-checkradio--disabled">
                                                    <input type="checkbox" name="" disabled="disabled">
                                                    <span class="xu-label-checkradio__helper"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>이름 <button type="submit" class="xu-button xu-button--default" style="margin-left: 12px;">수정</button></td>
                                            <td></td>
                                            <td class="text-align--center">
                                                <label class="xu-label-checkradio">
                                                    <input type="checkbox" name="">
                                                    <span class="xu-label-checkradio__helper"></span>
                                                </label>
                                            </td>
                                            <td class="text-align--center">
                                                <label class="xu-label-checkradio xu-label-checkradio--disabled">
                                                    <input type="checkbox" name="" disabled="disabled">
                                                    <span class="xu-label-checkradio__helper"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <!-- 이름 수정 버튼 클릭 시 노출 -->
                                        <tr>
                                            <td>
                                                <div class="xu-form-group" style="display: inline-block;">
                                                    <div class="xu-form-group__box" style="width: 150px;">
                                                        <input type="text" name="componentSingle1" class="xu-form-group__control" value="홍길동">
                                                    </div>
                                                </div>
                                                <button type="button" class="xu-button xu-button--link">
                                                    <span class="xu-button__text">기본값으로</span>
                                                </button>
                                                <div style="padding-top: 8px;">
                                                    <button type="button" class="xu-button xu-button--primary">
                                                        <span class="xu-button__text">확인</span>
                                                    </button>
                                                    <button type="button" class="xu-button xu-button--link">
                                                        <span class="xu-button__text">취소</span>
                                                    </button>
                                                </div>
                                            </td>
                                            <td></td>
                                            <td class="text-align--center">
                                                <label class="xu-label-checkradio">
                                                    <input type="checkbox" name="">
                                                    <span class="xu-label-checkradio__helper"></span>
                                                </label>
                                            </td>
                                            <td class="text-align--center">
                                                <label class="xu-label-checkradio xu-label-checkradio--disabled">
                                                    <input type="checkbox" name="" disabled="disabled">
                                                    <span class="xu-label-checkradio__helper"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <!-- //이름 수정 버튼 클릭 시 노출 -->
                                        <tr>
                                            <td>비밀번호 <button type="submit" class="xu-button xu-button--default" style="margin-left: 12px;">정책수정</button></td>
                                            <td></td>
                                            <td class="text-align--center">
                                                <label class="xu-label-checkradio">
                                                    <input type="checkbox" name="">
                                                    <span class="xu-label-checkradio__helper"></span>
                                                </label>
                                            </td>
                                            <td class="text-align--center">
                                                <label class="xu-label-checkradio xu-label-checkradio--disabled">
                                                    <input type="checkbox" name="" disabled="disabled">
                                                    <span class="xu-label-checkradio__helper"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <!-- 비밀번호 정책수정 버튼 클릭 시 노출 -->
                                        <tr>
                                            <td>
                                                비밀번호 <span class="admin-table__required">*</span>
                                                <div style="margin-top: 16px;">
                                                    최소 비밀번호 글자 수
                                                    <div class="xu-form-group" style="display: inline-block;">
                                                        <div class="xu-form-group__box" style="width: 80px;">
                                                            <input type="text" name="" class="xu-form-group__control" value="6">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="margin-top: 16px;">
                                                    <div>
                                                        <label class="xu-label-checkradio">
                                                            <input type="checkbox" checked="checked">
                                                            <span class="xu-label-checkradio__helper"></span>
                                                            <span class="xu-label-checkradio__text">비밀번호에 숫자 포함</span>
                                                        </label>
                                                    </div>
                                                    <div>
                                                        <label class="xu-label-checkradio">
                                                            <input type="checkbox" checked="checked">
                                                            <span class="xu-label-checkradio__helper"></span>
                                                            <span class="xu-label-checkradio__text">비밀번호에 대문자 포함</span>
                                                        </label>
                                                    </div>
                                                    <div>
                                                        <label class="xu-label-checkradio">
                                                            <input type="checkbox" checked="checked">
                                                            <span class="xu-label-checkradio__helper"></span>
                                                            <span class="xu-label-checkradio__text">비밀번호에 특수문자 포함</span>
                                                        </label>
                                                    </div>
                                                    <div>
                                                        <label class="xu-label-checkradio">
                                                            <input type="checkbox">
                                                            <span class="xu-label-checkradio__helper"></span>
                                                            <span class="xu-label-checkradio__text">반복 없는 비밀번호</span>
                                                        </label>
                                                    </div>
                                                    <div>
                                                        <label class="xu-label-checkradio">
                                                            <input type="checkbox">
                                                            <span class="xu-label-checkradio__helper"></span>
                                                            <span class="xu-label-checkradio__text">선(-,–,—,_) 없는 비밀번호</span>
                                                        </label>
                                                    </div>
                                                </div>

                                                <div style="padding-top: 8px;">
                                                    <button type="button" class="xu-button xu-button--primary">
                                                        <span class="xu-button__text">확인</span>
                                                    </button>
                                                    <button type="button" class="xu-button xu-button--link">
                                                        <span class="xu-button__text">취소</span>
                                                    </button>
                                                </div>
                                            </td>
                                            <td></td>
                                            <td class="text-align--center">
                                                <label class="xu-label-checkradio">
                                                    <input type="checkbox" name="">
                                                    <span class="xu-label-checkradio__helper"></span>
                                                </label>
                                            </td>
                                            <td class="text-align--center">
                                                <label class="xu-label-checkradio xu-label-checkradio--disabled">
                                                    <input type="checkbox" name="" disabled="disabled">
                                                    <span class="xu-label-checkradio__helper"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        {{-- <!-- //비밀번호 정책수정 버튼 클릭 시 노출 --> --}}
                                    </tbody>
                                </table>
                            </div>

                            <!-- 사용자 정의 항목 -->
                            @include('user.settings.setting.dynamicFields')
                        </div>
                        <div class="setting-area__footer">

                        </div>
                    </section>

                    <!-- 전체 페이지 버튼 영역 -->
                    <div class="setting-button-box" style="text-align: right;">
                        <button type="submit" class="xu-button xu-button--primary xu-button--large">{{xe_trans('xe::save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('.container-fluid .container-fluid').parent('.container-fluid').removeClass('container-fluid')
    })
</script>
