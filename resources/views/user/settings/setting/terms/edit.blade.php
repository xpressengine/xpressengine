{{ XeFrontend::css('assets/core/xe-ui/css/xe-ui-without-base.css')->load() }}

<div class="container-fluid container-fluid--part">
    <div class="panel-group">
        <div class="panel">
            <form method="post" action="{{ route('settings.user.setting.terms.update', $term->id) }}">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">{{xe_trans('xe::termsSettings')}}</h3>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="form-group">
                                <label>{{ xe_trans('xe::title') }}</label>
                                {!! uio('langText', ['langKey'=> $term->title, 'name'=>'title']) !!}
                            </div>
                            <div class="form-group">
                                <label class="xu-label-checkradio">
                                    <input type="radio" name="is_require" value="require" @if ($term->isRequire() === true) checked @endif>
                                    <span class="xu-label-checkradio__helper"></span>
                                    <span class="xu-label-checkradio__text">필수 약관</span>
                                </label>
                                <label class="xu-label-checkradio">
                                    <input type="radio" name="is_require" value="optional" @if ($term->isRequire() === false) checked @endif>
                                    <span class="xu-label-checkradio__helper"></span>
                                    <span class="xu-label-checkradio__text">선택 약관</span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label>{{ xe_trans('xe::description') }}</label>
                                {!! uio('langText', ['langKey'=> $term->description, 'name'=>'description']) !!}
                            </div>
                            <div class="form-group">
                                <label>{{ xe_trans('xe::content') }}</label>
                                {!! uio('langTextArea', ['langKey'=> $term->content, 'name'=>'content']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary btn-lg">{{xe_trans('xe::save')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
