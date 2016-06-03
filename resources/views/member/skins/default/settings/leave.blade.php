
<div class="row">
    <div class="col-md-10 col-md-offset-1">

        <div class="well well-lg" style="margin: 50px;">

            <form action="{{ route('member.leave') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h1>회원탈퇴</h1>
                        <hr>
                    </div>
                    <div class="col-sm-12">
                        <div class="xe-form-group">
                            <input type="text" class="xe-form-control" name="email" value="{{ $member->email }}" readonly />
                        </div>
                        <div class="xe-form-group">
                            <input type="password" class="xe-form-control" placeholder="비밀번호를 입력하세요" name="password" />
                        </div>
                        <div class="xe-form-group">
                            <button type="submit" class="xe-form-control btn btn-primary btn-block">탈퇴</button>
                        </div>
                    </div>
                    <div class="hidden-md hidden-lg text-center">
                        <p>- OR -</p>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

