@if($operator->isCore())
    <li class="list-group-item">
        <div class="left-group">
            <p style="color: #303030;font-size: 14px;"> {{ xe_trans('xe::updating') }}...</p>
            <p>Updating xpressengine {{ app()->getInstalledVersion() }} -> {{$operator->getOperation()->getVersion()}}</p>
        </div>
    </li>
@elseif($operator->isPlugin())
    @inject('plugins', 'xe.plugin')
    @php
        $operation = $operator->getOperation()
    @endphp
    @if(!empty($installs = $operation->getInstall()))
        <li class="list-group-item">
            <div class="left-group">
                <p style="color: #303030;font-size: 14px;"> {{ xe_trans('xe::installing') }}...</p>
                @foreach($installs as $name => $version)
                    <p>Installing {{ $name }} {{ $version }}</p>
                @endforeach
            </div>
        </li>
    @endif
    @if(!empty($updates = $operation->getUpdate()))
        <li class="list-group-item">
            <div class="left-group">
                <p style="color: #303030;font-size: 14px;"> {{ xe_trans('xe::updating') }}...</p>
                @foreach($updates as $name => $version)
                    @php
                        $plugin = $plugins->getPlugin(str_replace('xpressengine-plugin/', '', $name));
                    @endphp
                    <p>Updating {{ $name }} {{ $plugin ? $plugin->getVersion() : 'Unknown' }} -> {{ $version }}</p>
                @endforeach
            </div>
        </li>
    @endif
    @if(!empty($uninstalls = $operation->getUninstall()))
        <li class="list-group-item">
            <div class="left-group">
                <p style="color: #303030;font-size: 14px;"> {{ xe_trans('xe::removing') }}...</p>
                @foreach($uninstalls as $name)
                    <p>Removing {{ $name }}</p>
                @endforeach
            </div>
        </li>
    @endif
@elseif($operator->isPrivate())
    @php
        $operation = $operator->getOperation()
    @endphp
    @if(!empty($installs = $operation->getInstall()))
        <li class="list-group-item">
            <div class="left-group">
                <p style="color: #303030;font-size: 14px;"> {{ xe_trans('xe::installing') }}...</p>
                @foreach($installs as $name => $version)
                    <p>Installing {{ $name }}</p>
                @endforeach
            </div>
        </li>
    @endif
    @if(!empty($updates = $operation->getUpdate()))
        <li class="list-group-item">
            <div class="left-group">
                <p style="color: #303030;font-size: 14px;"> {{ xe_trans('xe::updating') }}...</p>
                @foreach($updates as $name => $version)
                    <p>Updating {{ $name }}</p>
                @endforeach
            </div>
        </li>
    @endif
    @if(!empty($uninstalls = $operation->getUninstall()))
        <li class="list-group-item">
            <div class="left-group">
                <p style="color: #303030;font-size: 14px;"> {{ xe_trans('xe::removing') }}...</p>
                @foreach($uninstalls as $name)
                    <p>Removing {{ $name }}</p>
                @endforeach
            </div>
        </li>
    @endif
@endif