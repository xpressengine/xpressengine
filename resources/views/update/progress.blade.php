@section('error_label')
@if($operator->isFailed())
    <span class="label label-danger">{{ xe_trans('xe::fail') }}</span>
@elseif($operator->isExpired())
    <span class="label label-danger">{{ xe_trans('xe::fail') }}({{ xe_trans('xe::timeoutExceeded') }})</span>
@endif
@endsection

@if($operator->isCore())
    <li class="list-group-item">
        <div class="left-group">
            <p style="color: #303030;font-size: 14px;">
                {{ xe_trans('xe::updating') }}...
                @yield('error_label')
            </p>
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
                <p style="color: #303030;font-size: 14px;">
                    {{ xe_trans('xe::installing') }}...
                    @yield('error_label')
                </p>
                @foreach($installs as $name => $version)
                    <p>Installing {{ $name }} {{ $version }}</p>
                @endforeach
            </div>
        </li>
    @endif
    @if(!empty($updates = $operation->getUpdate()))
        <li class="list-group-item">
            <div class="left-group">
                <p style="color: #303030;font-size: 14px;">
                    {{ xe_trans('xe::updating') }}...
                    @yield('error_label')
                </p>
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
                <p style="color: #303030;font-size: 14px;">
                    {{ xe_trans('xe::removing') }}...
                    @yield('error_label')
                </p>
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
                <p style="color: #303030;font-size: 14px;">
                    {{ xe_trans('xe::installing') }}...
                    @yield('error_label')
                </p>
                @foreach($installs as $name => $version)
                    <p>Installing {{ $name }}</p>
                @endforeach
            </div>
        </li>
    @endif
    @if(!empty($updates = $operation->getUpdate()))
        <li class="list-group-item">
            <div class="left-group">
                <p style="color: #303030;font-size: 14px;">
                    {{ xe_trans('xe::updating') }}...
                    @yield('error_label')
                </p>
                @foreach($updates as $name => $version)
                    <p>Updating {{ $name }}</p>
                @endforeach
            </div>
        </li>
    @endif
    @if(!empty($uninstalls = $operation->getUninstall()))
        <li class="list-group-item">
            <div class="left-group">
                <p style="color: #303030;font-size: 14px;">
                    {{ xe_trans('xe::removing') }}...
                    @yield('error_label')
                </p>
                @foreach($uninstalls as $name)
                    <p>Removing {{ $name }}</p>
                @endforeach
            </div>
        </li>
    @endif
@endif
