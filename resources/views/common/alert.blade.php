@if(isset($_alert))
    <script type="text/javascript">
        System.import('xecore:/common/js/xe.bundle').then(function() {
            XE.$(function() {
                XE.toast('{{ $_alert['type'] }}', '{{ $_alert['message'] }}');
            });
        });
    </script>
@elseif(isset($_errors))
    <script type="text/javascript">
        System.import('xecore:/common/js/xe.bundle').then(function() {
            XE.$(function() {
                XE.toast('{{ $_errors['type'] }}', '잘못 입력되었습니다. <ul>@foreach ($_errors->all() as $error) <li>{{ $error }}</li>@endforeach</ul>');
            });
        });
    </script>
@endif

@if($alert = Session::get('alert') && isset($alert['statusCode']))
<script type="text/javascript">
    System.import('xecore:/common/js/xe.bundle').then(function() {
        XE.$(function() {
            XE.toastByStatus('{{ $alert['statusCode'] }}', '{{ $alert['message'] }}');
        });
    });
</script>
@elseif($alert = Session::get('alert'))
    <script type="text/javascript">
        System.import('xecore:/common/js/xe.bundle').then(function() {
            XE.$(function() {
                XE.toast('{{ $alert['type'] }}', '{{ $alert['message'] }}');
            });
        });
    </script>
@elseif($errors = Session::get('errors'))
    <script type="text/javascript">
        System.import('xecore:/common/js/xe.bundle').then(function() {
            XE.$(function() {
                XE.toast('danger', '잘못된 입력이 있습니다. <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li>@endforeach</ul>');
            });
        });
    </script>
@endif

