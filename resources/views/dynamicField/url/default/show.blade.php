<div class="xe-form-group xe-dynamicField">
    <label class="__xe_df __xe_df_url __xe_df_url_{{$config->get('id')}}">{{xe_trans($config->get('label'))}}</label>

    @if ($config->get('skinHrefActivate') === 'on')
    <a href="{{ $data['url'] }}" @if ($config->get('skinHrefTarget')) target="{{ $config->get('skinHrefTarget') }}" @endif>
    @endif

    <span class="__xe_df __xe_df_url __xe_df_url_{{$config->get('id')}}">{{$data['url']}}</span>

    @if ($config->get('skinHrefActivate') === 'on')
    </a>
    @endif
</div>

