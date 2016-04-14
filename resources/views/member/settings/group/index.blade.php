<div class="row">
    <div class="col-sm-12">
        <div class="panel-group">
        <form id="__xe_fList" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="panel">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">그룹 관리<small>{{ $groups->count() }}개의 그룹이 존재합니다.</small></h3>
                    </div>
                    <div class="pull-right">
                        <a href="{{ route('manage.group.create') }}" class="btn btn-primary"><i class="xi-plus"></i><span>새그룹 추가</span></a>
                    </div>
                </div>

                <div class="panel-heading">
                    <div class="pull-left">
                        <div class="btn-group" role="group">
                            <button type="button" class="__xe_remove btn btn-default">선택그룹 삭제</button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col"><input type="checkbox" id="__xe_check-all"></th>
                            <th scope="col">그룹명</th>
                            <th scope="col">설명</th>
                            {{--<th scope="col">기본그룹</th>--}}
                            <th scope="col">소속 회원수</th>
                            <th scope="col">관리</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($groups as $group)
                            <tr>
                                <td><input type="checkbox" name="id[]" value="{{ $group->id }}" class="__xe_checkbox" /></td>
                                <td>{{ $group->name }}</td>
                                <td>{{ $group->description }}</td>
                                {{--<td><input type="radio"></td>--}}
                                <td>{{ $group->count }}</td>
                                <td><a href="{{ route('manage.group.edit', ['id' => $group->id]) }}" class="btn btn-default btn-sm">{{ xe_trans('xe::management') }}</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>

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

