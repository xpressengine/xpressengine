<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="panel">
        <div class="panel-heading">
            <div class="row">
                <p class="txt_tit">인증페이지 스킨</p>

                <div class="right_btn pull-right" role="button" data-toggle="collapse" data-parent="#accordion" data-target="#authSkinSection">
                    <!-- [D] 메뉴 닫기 시 버튼 클래스에 card_close 추가 및 item_container none/block 처리-->
                    <button class="btn_clse ico_gray pull-left"><i class="xi-angle-down"></i><i class="xi-angle-up"></i><span class="blind">메뉴닫기</span></button>
                </div>

            </div>
        </div>
        <div id="authSkinSection" class="panel-collapse collapse in" role="tabpanel">
            <div class="panel-body panel-collapse collapse in">
                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        {!! $authSkinSection !!}
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="panel">
        <div class="panel-heading">
            <div class="row">
                <p class="txt_tit">개인설정 스킨</p>

                <div class="right_btn pull-right" role="button" data-toggle="collapse" data-parent="#accordion" data-target="#settingsSkinSection">
                    <!-- [D] 메뉴 닫기 시 버튼 클래스에 card_close 추가 및 item_container none/block 처리-->
                    <button class="btn_clse ico_gray pull-left"><i class="xi-angle-down"></i><i class="xi-angle-up"></i><span class="blind">메뉴닫기</span></button>
                </div>
            </div>
        </div>
        <div id="settingsSkinSection" class="panel-collapse collapse" role="tabpanel">
            <div class="panel-body">
                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        {!! $settingsSkinSection !!}
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-heading">
            <div class="row">
                <p class="txt_tit">프로필페이지 스킨</p>

                <div class="right_btn pull-right" role="button" data-toggle="collapse" data-parent="#accordion" data-target="#profileSkinSection">
                    <!-- [D] 메뉴 닫기 시 버튼 클래스에 card_close 추가 및 item_container none/block 처리-->
                    <button class="btn_clse ico_gray pull-left"><i class="xi-angle-down"></i><i class="xi-angle-up"></i><span class="blind">메뉴닫기</span></button>
                </div>
            </div>
        </div>
        <div id="profileSkinSection" class="panel-collapse collapse" role="tabpanel">
            <div class="panel-body">
                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        {!! $profileSkinSection !!}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
