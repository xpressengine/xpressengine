
@section('page_setting_menu')
    <a href="{{ route('manage.group.create') }}" class="btn btn_blue pull-right">새그룹 추가</a>
@endsection

<form id="__xe_fList" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="panel panel-default">
        <table class="table table-striped">
            <tbody><tr>
                <th>그룹명</th>
                <th>설명</th>
                <th>소속된 회원수</th>
                <th>생성일</th>
                <th>수정</th>
                <th class="text-right"><input type="checkbox" id="__xe_check-all"/></th>
            </tr>
            @foreach($groups as $group)
                <tr>
                    <td>{{ $group->name }}</td>
                    <td>{{ $group->description }}</td>
                    <td>{{ $group->count }}</td>
                    <td>{!! Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $group->createdAt)->format('y-m-d') !!}</td>
                    <td><a href="{{ route('manage.group.edit', ['id' => $group->id]) }}" class="btn btn-default btn-sm">edit</a></td>
                    <td class="text-right"><input type="checkbox" name="id[]" class="__xe_checkbox" value="{{ $group->id }}" /></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</form>
<div class="row">
    <div class="col-sm-12 text-right">
        <div class="btn-group btn-group-sm">
            <a href="{{ route('manage.group.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> 신규추가</a>
            <button type="button" class="btn btn-danger __xe_remove"><i class="fa fa-trash"></i> 선택그룹 삭제</button>
        </div>
    </div>
</div>

{{-- page navigation--}}
<nav class="text-center">{!! $groups->render() !!}</nav>

<script type="text/javascript">
    $(function () {

        $('#__xe_check-all').change(function () {
            if ($(this).is(':checked')) {
                $('input.__xe_checkbox:not(disabled)').prop('checked', true);
            } else {
                $('input.__xe_checkbox:not(disabled)').prop('checked', false);
            }
        });

        $('.__xe_remove').click(function (e) {
            if (!$('input.__xe_checkbox:checked').is('input')) {
                return false;
            }
            var $f = $('#__xe_fList');
            $f.attr('action', "{{ route('manage.group.destroy') }}");
            $('<input type="hidden" name="_method" value="DELETE">').prependTo($f);
            $f.submit();
        });
    })
</script>

{!! uio('uiobject/xpressengine@chakIt', 'Settings:회원그룹') !!}
