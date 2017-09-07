<div class="row">
    <div class="col-sm-12">
        <div class="panel-group">
        <form id="fSetting" class="form" method="post" action="{{ route('settings.user.setting.join') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="panel">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">{{xe_trans('xe::joinSettings')}}</h3>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label>{{xe_trans('xe::permitSignUp')}}</label>
                        <div class="list-group-item">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="joinable" value="true" @if($config->get('joinable')) checked="checked" @endif> {{xe_trans('xe::allow')}}
                                </label>
                                <label>
                                    <input type="radio" name="joinable" value="false" @if(!$config->get('joinable')) checked="checked" @endif> {{xe_trans('xe::deny')}}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>회원가입 인증방식</label>
                        <p>회원가입시 별도의 인증을 거친 사용자만 회원가입을 가능하도록 합니다. 인증을 사용할 경우 사용자는 아래의 인증방식 중 하나를 선택하여 인증한 후에 회원가입을 할 수 있습니다</p>
                        <div class="list-group-item">
                            <div class="radio">
                                <label>
                                    <input type="radio" class="__xe_select_guard_forced" name="guard_forced" value="true" @if($config->get('guard_forced')) checked="checked" @endif> 인증 사용
                                </label>
                                <label>
                                    <input type="radio" class="__xe_select_guard_forced" name="guard_forced" value="false" @if(!$config->get('guard_forced')) checked="checked" @endif> 인증 사용안함
                                </label>
                            </div>
                        </div>
                        <div class="list-group-item __xe_guard_selector" @if(!$config->get('guard_forced')) style="display: none" @endif >
                            @include('user.settings.setting.guards')
                        </div>
                    </div>

                    <div class="form-group">
                        <label>회원가입 폼양식</label>
                        <div class="list-group-item">
                            @include('user.settings.setting.forms')
                        </div>
                    </div>

                </div>
                <div class="panel-footer">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary btn-lg">{{xe_trans('xe::save')}}</button>
                    </div>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>

{!!
    XeFrontend::html('toggle-guard')->content("
    <script>
    $(function($) {
        $('.__xe_select_guard_forced').change(function(){
            if(this.value == 'false') {
                $('.__xe_guard_selector').slideUp();
            } else {
                $('.__xe_guard_selector').slideDown();
            }
        });
    });
    </script>
    ")->load();
!!}
