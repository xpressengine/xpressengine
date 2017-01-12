
{{ uio('formText', ['name'=>'q', 'value'=>request()->get('q'), 'label'=>'검색어']) }}

<div class="row">
    <div class="col-sm-12">
        <div class="panel-group" id="accordion">
            <div class="panel">

                {{-- plugin list --}}
                <ul class="list-group list-plugin">

                @foreach($plugins as $plugin)
                    <!--[D] 플러그인 비활성화  상태off, 업데이트 필요 시 update 클래스 추가 -->
                    <li class="list-group-item">
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
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
