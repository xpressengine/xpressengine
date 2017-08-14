<div class="setting-detail-content">
    <div class="setting-left">
        <div class="form-group has-feedback">
            <form action="{{ route('user.settings.additions.update', ['field'=>$id]) }}" method="POST" data-submit="xe-ajax" data-callback="closeSetting">
                {{ method_field('put') }}
                {!! $fieldType->getSkin()->edit($user->toArray()) !!}
                <div class="xe-btn-group-all">
                    <button type="submit" class="xe-btn xe-btn-primary">{{ xe_trans('xe::applyModified') }}</button>
                    <button type="button" data-field="{{ $id }}" class="__xe_setting-close xe-btn xe-btn-secondary">{{ xe_trans('xe::cancel') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
