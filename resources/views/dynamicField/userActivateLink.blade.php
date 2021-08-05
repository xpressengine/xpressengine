@if (\Illuminate\Support\Str::is('settings.user.*', request()->route()->getAction() ['as']))
    <div>
        <small>
            <a href="{{ route('settings.register.getSetting') }}">설정 > 가입 설정 > 사용자 정의 항목 <i class="xi-external-link"></i></a>
            <span>{{ $message ?? '사용하고 싶다면 설정을 변경하세요.' }}</span>
        </small>
    </div>
@endif