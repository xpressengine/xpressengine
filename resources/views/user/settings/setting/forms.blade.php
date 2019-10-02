{{ XeFrontend::css('https://gitcdn.github.io/bootstrap-toggle/2.2.0/css/bootstrap-toggle.min.css')->before('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css')->load() }}
{{ XeFrontend::js('https://gitcdn.github.io/bootstrap-toggle/2.2.0/js/bootstrap-toggle.min.js')->appendTo('head')->before('https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js')->load() }}
{{ XeFrontend::js('/assets/vendor/jqueryui/jquery-ui.min.js')->appendTo('head')->load() }}



<!-- 드래그 리스트 -->
<ul class="sort-list sort-list--custom-item __ui-sortable">
    @foreach($parts as $idx => $arr)
        @foreach ($arr as $key => $part)
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
                        <input type="checkbox" name="forms[{{ $key }}]" vlaue="on" @if($idx === 0) checked="checked" @endif>
                        <span class="xu-label-checkradio__helper"></span>
                    </label>
                </div>
                <div class="sort-list__checkradio">
                    <label class="xu-label-checkradio">
                        <input type="checkbox" name="@FIXME" vlaue="@FIXME">
                        <span class="xu-label-checkradio__helper"></span>
                    </label>
                </div>
                <div class="sort-list__button">
                    <button type="button" class="xu-button xu-button--subtle xu-button--icon __user-dfield-edit">
                        <span class="xu-button__icon">
                            <i class="xi-pen"></i>
                        </span>
                    </button>
                </div>
                <div class="sort-list__button">
                    <button type="button" class="xu-button xu-button--subtle xu-button--icon __user-dfield-delete">
                        <span class="xu-button__icon">
                            <i class="xi-trash"></i>
                        </span>
                    </button>
                </div>
            </li>
        @endforeach
    @endforeach
</ul>





<div class="table-responsive item-setting">
    <table class="table table-sortable">
        <colgroup>
            <col width="200">
            <col>
            <col>
        </colgroup>
        <tbody>
            @foreach($parts as $idx => $arr)
            @foreach ($arr as $key => $part)
            <tr>
                <td>
                    <button class="btn handler"><i class="xi-drag-vertical"></i></button>
                    <em class="item-title">{{ xe_trans($part::NAME) }}</em>
                </td>
                <td>
                    <span class="item-subtext">{{ xe_trans($part::DESCRIPTION) }}</span>
                </td>
                <td>
                    <div class="xe-btn-toggle pull-right">
                        <label>
                            <span class="sr-only">toggle</span>
                            @if($part::isImplicit())
                            <input type="checkbox" checked="checked" disabled />
                            @else
                            <input type="checkbox" name="forms[{{ $key }}]" value="on" @if($idx === 0) checked="checked" @endif />
                            @endif
                            <span class="toggle"></span>
                        </label>
                    </div>
                    @if($part::isImplicit())
                    <input type="hidden" name="forms[{{$key}}]" value="on" >
                    @endif
                </td>
            </tr>
            @endforeach
            @endforeach
        </tbody>
    </table>
</div>
