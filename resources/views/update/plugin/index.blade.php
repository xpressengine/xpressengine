<h3>{{ xe_trans('xe::updatePlugin') }}</h3>
@if(count($plugins) < 1)
<div class="panel">
    <div class="panel-body">
        <p class="help-block">{{ xe_trans('xe::noPluginsToUpdate') }}</p>
        <a href="{{ route('settings.plugins.install.index') }}" >{{ xe_trans('xe::installNewPlugin') }}</a>
    </div>
</div>
@else
<form id="__xe_form-update-plugins" action="{{ route('settings.plugins.manage.update') }}" method="post">
    {{ csrf_field() }}
    <div class="panel">

        <div class="panel-body">
            <p class="help-block">
                {{ xe_trans('xe::selectPluginToUpdateAndClick') }}
            </p>
            <button type="submit" class="xe-btn xe-btn-positive-outlin xe-btn-lg">{{ xe_trans('xe::updatePlugin') }}</button>
        </div>

        <div style="padding: 14px 20px;">
            <label class="xe-label">
                <input type="checkbox" class="__xe_chk-all">
                <span class="xe-input-helper"></span>
                <span class="xe-label-text">{{ xe_trans('xe::selectAll') }}</span>
            </label>
        </div>

        <ul class="list-group list-plugin">
            @foreach($plugins as $plugin)
                @include('update.plugin.item')
            @endforeach
        </ul>

    </div>
</form>

<script>
    jQuery(function ($) {
      $('.__xe_chk-all', '#__xe_form-update-plugins').change(function () {
        var $items = $('input[type=checkbox]', $(this).closest('form')).not(this);
        if ($(this).is(':checked')) {
          $items.prop('checked', true);
        } else {
          $items.prop('checked', false);
        }
      });
      $('#__xe_form-update-plugins').submit(function (e) {
        var $items = $('input[type=checkbox]:checked', this).not('.__xe_chk-all');
        if ($items.length < 1) {
          e.preventDefault();
          return false;
        }
      });
    })
</script>
@endif