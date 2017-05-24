<div class="panel">
    <div class="panel-body">
        <ul class="nav nav-pills">
            <li role="presentation" @if($installType === 'fetched') class="active"@endif><a href="{{ route('settings.plugins') }}">자료실 플러그인</a></li>
            <li role="presentation" @if($installType === 'self-installed') class="active"@endif><a href="{{ route('settings.plugins.self') }}">직접 설치한 플러그인</a></li>
        </ul>
    </div>
</div>
