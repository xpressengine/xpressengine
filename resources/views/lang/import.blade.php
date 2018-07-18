<form action="{{ route('settings.lang.import') }}" method="post">
    {{ csrf_field() }}
    <div class="xe-modal-header">
        <button type="button" class="btn-close" data-dismiss="xe-modal" aria-label="Close"><i class="xi-close"></i></button>
        <strong class="xe-modal-title">{{ xe_trans('xe::multiLang') }} {{ xe_trans('xe::import') }}</strong>
    </div>
    <div class="xe-modal-body">
        <div class="xe-lypop-plugin">

            <p class="xe-lypop-plugin-text">
                <i class="xi-info"></i> {{ xe_trans('xe::applyMultiLangInFileToSystem') }}
            </p>

            <div class="input-group">
                <label>{{ xe_trans('xe::target') }}</label>
                <select name="name" class="form-control">
                    <option value="xe">XE Core</option>
                    @foreach($plugins as $plugin)
                        <option value="{{$plugin->getId()}}">{{ $plugin->getTitle() }}</option>
                    @endforeach
                </select>
                <p class="help-block"></p>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="force" value="1"> {{ xe_trans('xe::ifCheckOverwriteLangContents') }}
                </label>
            </div>

            <p class="xe-lypop-plugin-text">
                <button type="button" class="btn btn-link __xe_opt-btn"><i class="xi-angle-right-min"></i> {{ xe_trans('xe::option') }}</button>
            </p>
            <div class="xe-lypop-plugin-check version __xe_opt-box" style="display: none;">

                <div class="input-group">
                    <label>{{ xe_trans('xe::path') }}</label>
                    <input type="text" class="form-control" name="path" placeholder="ex) path/to/dir">
                    <p class="help-block">{{ xe_trans('xe::enterPathFromRootWhenFileInSpecificPath') }}</p>
                </div>

            </div>
        </div>
    </div>
    <div class="xe-modal-footer">
        <button type="button" class="xe-btn xe-btn-secondary" data-dismiss="xe-modal">{{ xe_trans('xe::cancel') }}</button>
        <button type="submit" class="xe-btn xe-btn-primary" >{{ xe_trans('xe::apply') }}</button>
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