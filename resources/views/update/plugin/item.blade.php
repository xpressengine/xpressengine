<li class="list-group-item off">
    <div class="list-group-item-checkbox">
        <label class="xe-label">
            <input type="checkbox" name="plugin[{{ $plugin->getId() }}][update]" value="1">
            <span class="xe-input-helper"></span>
            <span class="xe-label-text xe-sr-only">체크박스</span>
        </label>
    </div>
    <div class="left-group">
        <span class="plugin-title">{{ $plugin->getTitle() }}</span>
        <dl>
            <dt class="sr-only">version</dt>
            <dd>Version {{ $plugin->getVersion() }}</dd>
            <dt class="sr-only">{{ xe_trans('xe::author') }}</dt>
            <dd>By
                @if($authors = $plugin->getAuthors())
                    <a href="{{ array_get(reset($authors),'homepage', array_get(reset($authors),'email')) }}">
                        {{ reset($authors)['name'] }}
                    </a>
                @endif
            </dd>
            <dt class="sr-only">{{ xe_trans('xe::installPath') }}</dt>
            <dd>plugins/{{ $plugin->getId() }}</dd>
        </dl>
        <p class="ellipsis">{{ $plugin->getDescription() }}</p>

        <hr>
        <p>
            {{ xe_trans('xe::updateVersion') }}:
            <select name="plugin[{{ $plugin->getId() }}][version]">
                @foreach(array_reverse($plugin->getVersions()) as $release)
                    <option value="{{$release->version}}">ver.{{ $release->version }}</option>
                @endforeach
            </select>
        </p>

    </div>
</li>
