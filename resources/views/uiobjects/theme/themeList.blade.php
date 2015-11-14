<div class="row">
    @foreach($themes as $id => $theme)
        <div class="col-md-3 col-sm-6">
            <div class="box box-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-white" style="height:200px; background: url('{{ $theme->getScreenshot() }}') no-repeat top center; background-size: cover; ">
                    @if($theme->getScreenshot() === null)
                        {{ xe_trans('xe::noScreenshot') }}
                    @endif
                </div>
                <div class="box-footer">
                    {{ $theme->getTitle() }}
                    @if($theme->getSettingsURI()) <a class="pull-right" href="{{ $theme->getSettingsURI() }}" target="_blank">Setting</a> @endif
                    <a class="pull-right" href="{{ route('settings.theme.edit', ['theme'=>$theme->getId()]) }}" target="_blank">Edit</a>
                    <div class="radio">
                        <label  @if($theme->supportDesktop() === false)class="text-muted" @endif>
                            <input type="radio" name="{{ $prefix }}desktop" value="{{ $theme->getId() }}"
                               @if($theme->supportDesktop() === false)disabled @endif @if($selectedThemeId['desktop'] === $theme->getId()) checked @endif> {{ xe_trans('xe::desktop') }}
                        </label>
                    </div>
                    <div class="radio">
                        <label  @if($theme->supportMobile() === false)class="text-muted" @endif>
                            <input type="radio" name="{{ $prefix }}mobile" value="{{ $theme->getId() }}"
                               @if($theme->supportMobile() === false)disabled @endif @if($selectedThemeId['mobile'] === $theme->getId()) checked @endif> Mobile
                        </label>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

</div>
