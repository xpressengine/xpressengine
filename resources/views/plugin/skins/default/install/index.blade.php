@section('page_title')
    <h2>{{ xe_trans('xe::installPlugin') }}</h2>
@stop

<div class="__xe_plugin_items">
    @include($_skin::view('install.items'))
</div>

<form action="{{ route('settings.plugins.install') }}" method="POST" id="xe-install-plugin">
    {{ csrf_field() }}
    <input type="hidden" name="pluginId[]">
</form>
<script>
    $(function(){
        $(document).on('click','.plugin-install',function(){
            $("#xe-install-plugin").find('[name="pluginId[]"]').val($(this).data('target'));
            $("#xe-install-plugin").submit();
        })
        $(document).on('click','.search-group li a',function(){
            $(".search-group").find('input[type="text"]').attr('name',$(this).data('target'));
            $(".search-group").find('.selected-type').text($(this).text());
        })
    });
</script>
