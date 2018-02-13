<div class="member">
    <h1>부가 정보 입력</h1>
    <form action="{{ route('auth.register.add') }}" method="post" data-rule="add-info" data-rule-alert-type="toast">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <fieldset>
            <h4>사이트를 이용하기 위해서 다음 정보를 등록하여야 합니다.</h4>

            @foreach($fields as $field)
                <div class="control-group">{!! $field->getSkin()->create(request()->all()) !!}</div>
            @endforeach

            <button type="submit" class="xe-btn xe-btn-primary xe-btn-block">{{xe_trans('xe::save')}}</button>
        </fieldset>
    </form>
</div>
