<h3>이메일 인증으로 회원가입하기</h3>

<div class="confirmEmail">
    <form action="{{ route('auth.register.confirm') }}" method="post">
        {{ csrf_field() }}
        {{ uio('formText', ['name'=>'email', 'label'=>'이메일', 'description'=>'인증을 완료한 후, 회원 등록될 때 입력하신 이메일 정보로 등록됩니다']) }}
        <button type="submit">인증메일 전송</button>
    </form>
</div>
