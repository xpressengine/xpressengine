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
                @if ($part::isImplicit())
                    <label class="xu-label-checkradio xu-label-checkradio--disabled">
                        <input type="hidden" value="on" name="forms[{{ $key }}]">
                        <input type="checkbox" checked="checked" disabled />
                        <span class="xu-label-checkradio__helper"></span>
                    </label>
                @elseif ($part::isAvailable() === false)
                    <label class="xu-label-checkradio xu-label-checkradio--disabled">
                        <input type="checkbox" disabled />
                        <span class="xu-label-checkradio__helper"></span>
                    </label>
                @else
                    <label class="xu-label-checkradio">
                        <input type="checkbox" name="forms[{{ $key }}]" value="on" @if(in_array($key, $activated)) checked="checked" @endif />
                        <span class="xu-label-checkradio__helper"></span>
                    </label>
                @endif
            </div>
        </li>
    @endforeach
</ul>
