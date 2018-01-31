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