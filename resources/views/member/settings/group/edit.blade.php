<div class="row">
    <div class="col-sm-12">
        <div class="panel-group">
            <div class="panel">
                <form name="fGroupCreate" method="post" action="{{ route('manage.group.edit', ['id' => $group->id]) }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">그룹 수정</h3>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                {!! uio('formText', ['label'=>'그룹명', 'placeholder'=>'이름을 입력하세요', 'value'=>$group->name, 'name'=>'name']) !!}
                            </div>
                            <div class="col-sm-12">
                                {!! uio('formTextarea', ['label'=>'소개글', 'placeholder'=>'설명을 작성해 주세요', 'value'=>$group->description, 'name'=>'description']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="pull-right">
                            <a href="{{ route('manage.group.index') }}" class="btn btn-default btn-lg">취소</a>
                            <button type="submit" class="btn btn-primary btn-lg">저장</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
