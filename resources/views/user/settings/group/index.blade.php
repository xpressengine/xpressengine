<div class="container-fluid container-fluid--part">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel-group">
            <form id="__xe_fList" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">{{xe_trans('xe::groupManagement')}}<small>{{xe_trans('xe::groupManagementSummary', ['count' => $groups->count()])}}</small></h3>
                        </div>
                        <div class="pull-right">
                            <a href="{{ route('manage.group.create') }}" class="btn btn-primary"><i class="xi-plus"></i><span>{{xe_trans('xe::addNewGroup')}}</span></a>
                        </div>
                    </div>

                    <div class="panel-heading">
                        <div class="pull-left">
                            <div class="btn-group" role="group">
                                <button type="button" class="__xe_remove btn btn-default">{{xe_trans('xe::deleteSelected')}}</button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col"><input type="checkbox" id="__xe_check-all"></th>
                                <th scope="col">{{xe_trans('xe::groupName')}}</th>
                                <th scope="col">{{xe_trans('xe::description')}}</th>
                                <th scope="col">{{xe_trans('xe::defaultGroup')}}</th>
                                <th scope="col">{{xe_trans('xe::groupUserCount')}}</th>
                                <th scope="col">{{xe_trans('xe::management')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($groups as $group)
                                <tr>
                                    <td><input type="checkbox" name="id[]" @if($joinGroup === $group->id) disabled="disabled" @endif value="{{ $group->id }}" class="__xe_checkbox" /></td>
                                    <td>{{ $group->name }}</td>
                                    <td>{{ $group->description }}</td>
                                    <td><input class="__xe_check_join_group" name="join_group" type="radio" value="{{ $group->id }}" @if($joinGroup === $group->id) checked="checked" @endif ></td>
                                    <td>{{ $group->count }}</td>
                                    <td><a href="{{ route('manage.group.edit', ['id' => $group->id]) }}" class="btn btn-default">{{ xe_trans('xe::management') }}</a></td>
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
</div>

<script type="text/javascript">
    $(function () {

        $('.__xe_check_join_group').change(function () {
            var join_group = $(this).val();
            XE.ajax({
                type: 'post',
                url: '{{ route('manage.group.update.join') }}',
                cache: false,
                data: {'join_group':join_group},
                dataType: 'json',
                success: function (data) {

                    $('.__xe_checkbox').each(function(){this.disabled = false})
                    $('.__xe_checkbox[value='+join_group+']').attr('disabled','disabled');
                    XE.toast(data.type, data.message);
                },
                error: function (data) {
                    XE.toast(data.type, data.message);
                }
            });
        });

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

