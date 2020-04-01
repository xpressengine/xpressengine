<div class="row">
    <div class="col-sm-12">
        <div class="card-group">
            <form id="fSetting" method="post" action="{{ route('settings.user.setting') }}">

                <div class="card">
                    <div class="card-header">
                        <h3>{{xe_trans('xe::joinSettings')}}</h3>
                    </div>

                    <div class="card-body">
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
