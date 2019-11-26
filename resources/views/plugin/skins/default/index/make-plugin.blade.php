<form action="{{ route('settings.plugins.manage.make.plugin') }}" method="post">
    {{ csrf_field() }}
    <div class="xe-modal-header">
        <button type="button" class="btn-close" data-dismiss="xe-modal" aria-label="Close"><i class="xi-close"></i></button>
        <strong class="xe-modal-title">{{ xe_trans('xe::plugin') }} {{ xe_trans('xe::create') }}</strong>
    </div>
    <div class="xe-modal-body">
        <div class="xe-lypop-plugin">

            <div class="input-group">
                <label>{{ xe_trans('xe::plugin') }} {{ xe_trans('xe::name') }}</label>
                <input type="text" class="form-control" name="name" placeholder="ex) my_plugin">
                <p class="help-block"></p>
            </div>
            <div class="input-group">
                <label>{{ xe_trans('xe::vendor') }} {{ xe_trans('xe::name') }}</label>
                <input type="text" class="form-control" name="vendor" placeholder="ex) my_name">
                <p class="help-block"></p>
            </div>

            <p class="xe-lypop-plugin-text">
                <button type="button" class="btn btn-link __xe_opt-btn"><i class="xi-angle-right-min"></i> {{ xe_trans('xe::option') }}</button>
            </p>
            <div class="xe-lypop-plugin-check version __xe_opt-box" style="display: none;">

                <div class="input-group">
                    <label>{{ xe_trans('xe::namespace') }}</label>
                    <input type="text" class="form-control" name="namespace" placeholder="ex) MyName\XePlugin\PluginName">
                    <p class="help-block"></p>
                </div>
                <div class="input-group">
                    <label>{{ xe_trans('xe::plugin') }} {{ xe_trans('xe::title') }}</label>
                    <input type="text" class="form-control" name="title">
                    <p class="help-block"></p>
                </div>

            </div>
        </div>
    </div>
    <div class="xe-modal-footer">
        <button type="button" class="xe-btn xe-btn-secondary" data-dismiss="xe-modal">{{ xe_trans('xe::cancel') }}</button>
        <button type="submit" class="xe-btn xe-btn-primary" >{{ xe_trans('xe::create') }}</button>
    </div>
</form>

<script>
  jQuery(function ($) {
    $('.__xe_opt-btn').click(function () {
      $('.__xe_opt-box').toggle();
      $('i', this).toggleClass('xi-angle-right-min xi-angle-down-min');
    })
  });
</script>