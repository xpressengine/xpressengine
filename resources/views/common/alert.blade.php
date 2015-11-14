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
            XE.toast('{{ $errors['type'] }}', '잘못 입력되었습니다. <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li>@endforeach</ul>');
        });
    </script>
@endif