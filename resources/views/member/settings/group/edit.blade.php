
@section('page_title')
    <h2>그룹수정</h2>
@endsection

@section('page_description')
    그룹을 수정하는 페이지 입니다.
@endsection

<div class="container">
    <form class="form-horizontal" name="fGroupCreate" method="post" action="{{ route('manage.group.edit', ['id' => $group->id]) }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <label for="inputName" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
                <input type="text" name="name" class="form-control" id="inputName" placeholder="Group name" value="{{ $group->name }}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputDesc" class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10">
                <input type="text" name="description" class="form-control" id="inputDesc" placeholder="Description" value="{{ $group->description }}">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">등록</button>
            </div>
        </div>
    </form>
</div>

{!! uio('uiobject/xpressengine@chakIt', 'Settings:회원그룹') !!}