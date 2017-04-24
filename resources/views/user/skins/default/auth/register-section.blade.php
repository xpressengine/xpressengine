<h3>이메일 인증으로 회원가입하기</h3>

<form action="{{ route('auth.register') }}">
    {{ uio('formText', ['name'=>'email', 'label'=>'이메일']) }}
</form>
