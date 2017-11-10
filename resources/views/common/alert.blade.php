@if(isset($_alert))
    <script type="text/javascript">
        $(function() {
            XE.toast('{{ $_alert['type'] }}', '{{ $_alert['message'] }}');
        });
    </script>
@elseif(isset($_errors))
    <script type="text/javascript">
        $(function() {
            XE.toast('{{ $_errors['type'] }}', '{{xe_trans('xe::wrongInput')}} <ul>@foreach ($_errors->all() as $error) <li>{{ $error }}</li>@endforeach</ul>');
        });
    </script>
@endif

@if($alert = Session::get('alert') && isset($alert['statusCode']))
    <script type="text/javascript">
        $(function() {
            XE.toastByStatus('{{ $alert['statusCode'] }}', '{{ $alert['message'] }}');
        });
    </script>
@elseif($alert = Session::get('alert'))
    <script type="text/javascript">
        $(function() {
            XE.toast('{{ $alert['type'] }}', '{{ $alert['message'] }}');
        });
    </script>
@elseif($errors = Session::get('errors'))
    <script type="text/javascript">
        $(function() {
            XE.toast('danger', '<ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li>@endforeach</ul>');
        });
    </script>
@endif

