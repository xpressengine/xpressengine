<!-- 드래그 리스트 -->
<ul class="sort-list sort-list--custom-item __ui-sortable">
    @foreach($parts as $key => $part)
        <li>
            <div class="sort-list__handler">
                <button type="button" class="xu-button xu-button--subtle-link xu-button--icon __handler">
                    <span class="xu-button__icon">
                        <i class="xi-drag-vertical"></i>
                    </span>
                </button>
            </div>
            <p class="sort-list__text">{{ xe_trans($part::NAME) }} <small>{{ xe_trans($part::DESCRIPTION) }}</small></p>
            <div class="sort-list__checkradio">
                <label class="xu-label-checkradio">
                    @if($part::isImplicit())
                        <input type="checkbox" name="forms[{{ $key }}]" checked="checked" disabled />
                    @else
                        <input type="checkbox" name="forms[{{ $key }}]" value="on" @if(in_array($key, $activated)) checked="checked" @endif />
                    @endif
                    <span class="xu-label-checkradio__helper"></span>
                </label>
            </div>
        </li>
    @endforeach
</ul>
