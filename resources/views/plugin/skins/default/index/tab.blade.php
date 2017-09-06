<div class="row">
    <div class="col-sm-12">
        <div class="panel admin-tab">
            <ul class="admin-tab-list">
                <li @if($installType === 'fetched') class="on" @endif><a href="{{ route('settings.plugins', ['install_type' => 'fetched']) }}">자료실 플러그인</a></li>
                <li @if($installType === 'self-installed') class="on" @endif><a href="{{ route('settings.plugins', ['install_type' => 'self-installed']) }}">직접 설치한 플러그인</a></li>
            </ul>
        </div>
    </div>
</div>
