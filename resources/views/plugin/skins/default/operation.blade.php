@foreach($operation['runnings'] as $package => $version)
<li class="list-group-item off __xe_operation">
    <div class="left-group">
        <a href="#" target="_blank" class="plugin-title">{{ data_get($operation['runningsInfo'], $package.'.title') }}</a>
        <dl>
            <dt class="sr-only">version</dt>
            <dd>Version {{ $version }}</dd>
            <dt class="sr-only">{{ xe_trans('xe::author') }}</dt>
            <dt class="sr-only">{{ xe_trans('xe::installPath') }}</dt>
            <dd>plugins/{{ data_get($operation['runningsInfo'], $package.'.pluginId') }}</dd>
        </dl>
    </div>
    <div class="btn-right">
        <span class="btn-link">
            @if($operation['failed'])
                설치실패
                @if($operation['expired'])
                    (제한시간 초과)
                @endif
            @else
                설치중..
            @endif
        </span>
    @if($operation['failed'])
            <a class="btn-link __xe_deleteOperation" href="{{ route('settings.plugins.operation.delete') }}">삭제</a>
        @endif
    </div>
</li>
@endforeach

{!! app('xe.frontend')->html('plugin.delete-operation')->content("
<script>
    $(function($) {
        $('.__xe_deleteOperation').click(function(){
            $.ajax({
                url: this.href,
                type: 'DELETE',
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    XE.toast('success', data.message);
                    $('.__xe_operation').remove();
                },
                error: function (data, textStatus, errorThrown) {
                    XE.toast('fail', data.message);
                }
            });
            return false;
        })
    });
</script>
")->load() !!}
