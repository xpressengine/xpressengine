<li class="list-group-item">
    <div class="text-right">
        @if($handler->getPlugin(data_get($plugin, 'plugin_id')))
            설치됨
        @else
            <label>
                <input type="checkbox" value="{{ data_get($plugin, 'plugin_id') }}" class="__xe_checkbox" data-title="{{ data_get($plugin, 'title') }}" data-id="{{ data_get($plugin, 'plugin_id') }}">
                설치
            </label>
        @endif
    </div>
    <div class="left-group">
        <a href="{{ data_get($plugin, 'link') }}" class="plugin-title">{{ data_get($plugin, 'title') }}</a>
        <dl>
            <dt class="sr-only">version</dt>
            <dd>Version {{ data_get($plugin, 'latest_release.version') }}</dd>
            <dt class="sr-only">{{ xe_trans('xe::author') }}</dt>
            <dd>By
                @if($authors = data_get($plugin, 'latest_release.authors', []))
                    @foreach($authors as $author)
                        {{ data_get($author, 'name') }}
                    @endforeach
                @endif
            </dd>
            <dt class="sr-only">{{ xe_trans('xe::installPath') }}</dt>
            <dd>plugins/{{ data_get($plugin, 'plugin_id') }}</dd>
        </dl>
        <p class="ellipsis">{{ data_get($plugin, 'description') }}</p>

        {{-- component list --}}
        @foreach(data_get($plugin, 'latest_release.components') as $key => $component)
            <span class="label label-{{ array_get($color, $component->type, 'default') }}" title="{{ $component->name }}" data-toggle="tooltip">{{ $component->type }}</span>
        @endforeach
    </div>
    <div class="btn-right">
        @if(data_get($plugin, 'price') === 0)
            Free
        @else
        <a href="#" class="btn-link">
            ￦{{ number_format(data_get($plugin, 'price')) }} 구매하기
        </a>
        @endif
    </div>
</li>
