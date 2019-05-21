<div class="col-sm-6">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="media">
                <div class="media-left">
                    <a href="#">
                        <img class="media-object" src="{{$plugin->icon}}" alt="..." width="120" height="120">
                    </a>
                </div>
                <div class="media-body">
                    <div class="media-heading-box">
                        <h4 class="media-heading text-primary">{{$plugin->title}}</h4>
                        <span>
                        @if($handler->getPlugin(data_get($plugin, 'plugin_id')))
                                <span class="text-muted">{{ xe_trans('xe::installed') }}</span>
                            @else
                                @if(data_get($plugin, 'is_purchased'))
                                    <button class="xe-btn xe-btn-secondary text-primary plugin-install" data-target="{{$plugin->plugin_id}}">{{ xe_trans('xe::installNow') }}</button>
                                @elseif(data_get($plugin, 'is_free') === false)
                                    <a href="{{ data_get($plugin, 'link') }}" class="btn-link" target="_blank">{{ xe_trans('xe::goToBuy') }}</a>
                                @else
                                    <button class="xe-btn xe-btn-secondary text-primary plugin-install" data-target="{{$plugin->plugin_id}}">{{ xe_trans('xe::installNow') }}</button>
                                @endif
                            @endif
                        </span>
                    </div>
                    <small class="text-muted">{{$plugin->author}}</small>
                    <p>{{$plugin->latest_release->description}}</p>
                </div>
            </div>
        </div>
        <div class="panel-footer" style="padding:15px;font: -apple-system-body;">
            ⬇️️ {{$plugin->downloadeds}}
            <span class="text-muted" style="margin-left:20px;">{{implode(', ', $plugin->category_titles)}}</span>
        </div>
    </div>
</div>
