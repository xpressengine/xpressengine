<div class="row">
    <div class="col-sm-12">
        <div class="panel-group">
            <div class="panel">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">회원 가입/로그인 스킨</h3>
                    </div>
                    <div class="pull-right">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="btn-link panel-toggle pull-right"><i class="xi-angle-down"></i><i class="xi-angle-up"></i><span class="sr-only">메뉴닫기</span></a>
                    </div>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in">
                    {!! $authSkinSection !!}
                </div>
            </div>

            <div class="panel">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">마이페이지 스킨</h3>
                    </div>
                    <div class="pull-right">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="btn-link panel-toggle pull-right"><i class="xi-angle-down"></i><i class="xi-angle-up"></i><span class="sr-only">메뉴닫기</span></a>
                    </div>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse in">
                    {!! $settingsSkinSection !!}
                </div>
            </div>

            <div class="panel">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">프로필 스킨</h3>
                    </div>
                    <div class="pull-right">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="btn-link panel-toggle pull-right"><i class="xi-angle-down"></i><i class="xi-angle-up"></i><span class="sr-only">메뉴닫기</span></a>
                    </div>
                </div>
                <div id="collapseThree" class="panel-collapse collapse in">
                    {!! $profileSkinSection !!}
                </div>
            </div>

        </div>
    </div>
</div>
