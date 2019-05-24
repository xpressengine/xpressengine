@section('page_title')
    <h2>{{ xe_trans('xe::adminAuth') }}</h2>
@endsection

<div class="panel-group">
    <div class="panel">
        <div class="panel-collapse collapse in">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="section-user-auth">
                            <h2 class="section-user-auth__title">{{ xe_trans('xe::adminAuth') }}</h2>
                            <div class="section-user-auth-info">
                                <em class="section-user-auth-info__info-title">{{ xe_trans('xe::msgAdminAuth') }}</em><br>
                                <p class="section-user-auth-info__info-text">{{ xe_trans('xe::msgAdminAuthDetail') }}</p>
                            </div>
                            <form action="{{ route('settings.auth.admin') }}" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="redirectUrl" value="{{ $redirectUrl or '' }}">
                                <fieldset>
                                    <legend>{{ xe_trans('xe::authenticate') }}</legend>
                                    <div class="section-user-auth-group">
                                        <label for="pwd" class="xe-sr-only">{{xe_trans('xe::password')}}</label>
                                        <input name="password" type="password" id="pwd" class="xe-form-control" placeholder="{{xe_trans('xe::password')}}">
                                    </div>
                                    <button type="submit" class="xe-btn xe-btn-primary xe-btn-block">{{xe_trans('xe::confirm')}}</button>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
