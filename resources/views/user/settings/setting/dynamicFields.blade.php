@expose_route('manage.dynamicField.index')
@expose_route('manage.dynamicField.update')
@expose_route('manage.dynamicField.getEditInfo')
@expose_route('manage.dynamicField.destroy')
@expose_route('manage.dynamicField.getSkinOption')
@expose_route('manage.dynamicField.getAdditionalConfigure')

<!-- 사용자 정의 항목 -->
<div style="margin-top: 26px;" id="__xe_container_DF_setting_user">
    <!-- 드래그 리스트 항목 -->
    <ul class="sort-list sort-list--custom-item sort-list sort-list--custom-item-header">
        <li>
            <div class="sort-list__header-title">{{ xe_trans('xe::customItems') }}</div>
            <div class="sort-list__header-text">{{ xe_trans('xe::use') }}</div>
            <div class="sort-list__header-text">{{ xe_trans('xe::require') }}</div>
        </li>
    </ul>

    <!-- 드래그 리스트 -->
    <ul class="sort-list sort-list--custom-item __udfield-items">
        @foreach ($dynamicFields as $dynamicField)
            <li class="__udfield-item" data-field-id="{{ $dynamicField->getConfig()->get('id') }}" data-field-typeid="{{ $dynamicField->getConfig()->get('typeId') }}" data-field-skinid="{{ $dynamicField->getConfig()->get('skinId') }}">
                <div class="sort-list__handler">
                    <button type="button" class="xu-button xu-button--subtle-link xu-button--icon __handler">
                    <span class="xu-button__icon">
                        <i class="xi-drag-vertical"></i>
                    </span>
                    </button>
                </div>
                <p class="sort-list__text">{{ xe_trans($dynamicField->getConfig()->get('label')) }}</p>
                <div class="sort-list__button">
                    <button type="button" class="xu-button xu-button--subtle xu-button--icon __udfield-btn-edit">
                    <span class="xu-button__icon">
                        <i class="xi-pen"></i>
                    </span>
                    </button>
                </div>
                <div class="sort-list__button">
                    <button type="button" class="xu-button xu-button--subtle xu-button--icon __udfield-btn-delete">
                    <span class="xu-button__icon">
                        <i class="xi-trash"></i>
                    </span>
                    </button>
                </div>
                <div class="sort-list__checkradio">
                    <label class="xu-label-checkradio">
                        <input type="checkbox" class="__udfield-use" name="dynamic_fields[{{ $dynamicField->getConfig()->get('id') }}]" @if ($dynamicField->getConfig()->get('use') === true) checked @endif>
                        <span class="xu-label-checkradio__helper"></span>
                    </label>
                </div>
                <div class="sort-list__checkradio">
                    <label class="xu-label-checkradio">
                        <input type="checkbox" class="__udfield-require" name="df_required[{{ $dynamicField->getConfig()->get('id') }}]" @if ($dynamicField->getConfig()->get('required') === true) checked @endif>
                        <span class="xu-label-checkradio__helper"></span>
                    </label>
                </div>
            </li>
        @endforeach
    </ul>

    <div>
        <button type="button" class="xu-button xu-button--link __udfield-add" style="margin-top: 16px;">
            <span class="xu-button__text">{{ xe_trans('xe::customItems') }} {{ xe_trans('xe::add') }}</span>
        </button>
    </div>
</div>
