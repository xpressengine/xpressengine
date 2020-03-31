<form action="{{ route('settings.plugins.manage.make.theme') }}" method="post">
    {{ csrf_field() }}
    <div class="xe-modal-header">
        <button type="button" class="btn-close" data-dismiss="xe-modal" aria-label="Close"><i class="xi-close"></i></button>
        <strong class="xe-modal-title">{{ xe_trans('xe::theme') }} {{ xe_trans('xe::create') }}</strong>
    </div>
    <div class="xe-modal-body">
        <div class="xe-lypop-plugin">

            <div class="input-group">
                <label>{{ xe_trans('xe::plugin') }}</label>
                <select name="plugin" class="form-control">
                    @foreach ($plugins as $plugin)
                        <option value="{{ $plugin->getId() }}">{{ $plugin->getTitle() }}</option>
                    @endforeach
                </select>
                <p class="help-block">{{ xe_trans('xe::selectPluginWillLocated', ['name' => xe_trans('xe::theme')]) }}</p>
            </div>
            <div class="input-group">
                <label>{{ xe_trans('xe::theme') }} {{ xe_trans('xe::name') }}</label>
                <input type="text" class="form-control" name="name" placeholder="my_theme">
                <p class="help-block"></p>
            </div>

            <p class="xe-lypop-plugin-text">
                <button type="button" class="btn btn-link __xe_opt-btn"><i class="xi-angle-right-min"></i> {{ xe_trans('xe::option') }}</button>
            </p>
            <div class="xe-lypop-plugin-check version __xe_opt-box" style="display: none;">


                <div class="input-group">
                    <label>ID</label>
                    <input type="text" class="form-control" name="id" placeholder="ex) plugin@theme">
                    <p class="help-block"></p>
                </div>
                <div class="input-group">
                    <label>{{ xe_trans('xe::path') }}</label>
                    <input type="text" class="form-control" name="path" placeholder="ex) Theme/MyTheme">
                    <p class="help-block"></p>
                </div>
                <div class="input-group">
                    <label>{{ xe_trans('xe::class') }} {{ xe_trans('xe::name') }}</label>
                    <input type="text" class="form-control" name="class" placeholder="ex) MyTheme">
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