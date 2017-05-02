@if($code !== null)
    <input type="hidden" name="code" value="{{ $code }}">
@else
<h4>이메일 인증 코드 확인</h4>
<div>
    <form action="{{ route('auth.register.confirm') }}" method="post" data-submit="xe-ajax" data-callback="confirmCode">
        <p>{{ $token->email }}로 인증 이메일이 전송되었습니다. 회원가입을 계속하시려면 인증 이메일에 명시된 인증코드를 입력하시거나, 이메일에서 [회원가입 계속하기] 링크를 클릭하세요.</p>
        <input type="hidden" name="email" value="{{ $token->email }}">
        {{ uio('formText', ['name'=>'code', 'label'=>'인증코드', 'description'=>'수신한 인증 이메일에 명시된 인증코드를 입력하세요.']) }}
    </form>
</div>
<hr>
@endif
