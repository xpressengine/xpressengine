<div class="user">
    <h1>{{ xe_trans('xe::enterAdditionalInfo') }}</h1>
    <form action="{{ route('auth.register.add') }}" method="post" data-rule="add-info" data-rule-alert-type="toast">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <fieldset>
            <h4>{{ xe_trans('xe::descEnterAdditionalInfo') }}</h4>

            @foreach($fields as $field)
                <div class="control-group">{!! $field->getSkin()->edit($userData) !!}</div>
            @endforeach

            <button type="submit" class="xe-btn xe-btn-primary xe-btn-block">{{xe_trans('xe::save')}}</button>
        </fieldset>
    </form>
</div>
