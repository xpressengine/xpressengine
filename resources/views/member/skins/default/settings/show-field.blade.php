<a href="{{ route('user.settings.additions.edit', ['field'=>$id]) }}" data-toggle="xe-page" data-target=".__xe_settingAddition-{{ $id }} .setting-detail" data-callback="openSetting">
    <div class="setting-left">
        <div class="form-group has-feedback">
            {!! $fieldType->getSkin()->show($user->toArray()) !!}
        </div>
    </div>
</a>
