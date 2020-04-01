<div class="row">
    <div class="col-sm-12">
        <div class="card-group">
        <form id="fSetting" class="form" method="post" action="{{ route('settings.user.setting.join') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-header">
                    <div class="pull-left">
                        <h3 class="card-title">{{xe_trans('xe::joinSettings')}}</h3>
                    </div>
                </div>
                <div class="card-body">
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
                        <label>{{ xe_trans('xe::emailConfirm') }}</label>
                        {{--<p></p>--}}
                        <div class="list-group-item">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="guard_forced" value="true" @if($config->get('guard_forced')) checked="checked" @endif> {{xe_trans('xe::use')}}
                                </label>
                                <label>
                                    <input type="radio" name="guard_forced" value="false" @if(!$config->get('guard_forced')) checked="checked" @endif> {{xe_trans('xe::disuse')}}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>회원가입 폼양식</label>
                        <div class="list-group-item">
                            @include('user.settings.setting.forms')
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary btn-lg">{{xe_trans('xe::save')}}</button>
                    </div>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>
