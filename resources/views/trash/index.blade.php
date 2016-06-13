<section class="contain">

    <div class="row">
        <div class="col-sm-12">
            <!-- function button -->
            <div class="btn-group pull-left mg-bottom mg-right-sm __xe_function_buttons">
                <button type="button" class="btn btn-default __xe_button __xe_trash_dump_all" data-mode="destroy">
                    <i class="fa fa-times"></i>
                    {{xe_trans('xe::emptyTrash')}}
                </button>
            </div>
            <!-- /function button -->
        </div>
    </div>

    <!-- table -->
    <div class="box box-primary mg-bottom">
        <form class="__xe_form_list" method="post" action="{{ route('manage.trash.clean') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col"><input type="checkbox" title="Check All" class="__xe_check_all"></th>
                        <th scope="col">{{xe_trans('xe::name')}}</th>
                        <th scope="col">{{xe_trans('xe::summary')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($wastes as $waste)
                        <tr>
                            <td><input type="checkbox" name="ids[]" class="__xe_checkbox" value="{{ $waste }}"></td>
                            <td>{{ $waste::name() }}</td>
                            <td>{{ $waste::summary() }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </div>
    <!-- /table -->
</section>


<script type="text/javascript">
    $(function () {

        $('.__xe_check_all').click(function () {
            if ($(this).is(':checked')) {
                $('input.__xe_checkbox').click();
            } else {
                $('input.__xe_checkbox').removeAttr('checked');
            }
        });

        $('.__xe_trash_dump_all').click(function () {
            // 여기를 ajax 로 처리 할 수 있게 .... progress 처리 해야 한다.
            // 이건 trash interface 를 따르는 녀석들이 해줘야 하니까...
            // 인터페이스를 더 추가해야 겠네..
            var $f = $('.__xe_form_list');
            $f.submit();
        });
    });
</script>