{{ XeFrontend::css('https://gitcdn.github.io/bootstrap-toggle/2.2.0/css/bootstrap-toggle.min.css')->before('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css')->load() }}
{{ XeFrontend::js('https://gitcdn.github.io/bootstrap-toggle/2.2.0/js/bootstrap-toggle.min.js')->appendTo('head')->before('https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js')->load() }}
{{ XeFrontend::js('/assets/vendor/jqueryui/jquery-ui.js')->appendTo('head')->load() }}


    <form id="__xe_toggleMenu_{{$typeIdable}}_{{$instanceId}}" class="form-horizontal" method="post" action="{{ route('manage.toggleMenu.setting') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="type" value="{{ $type }}">
        @if($instanceId !== null)
        <input type="hidden" name="instanceId" value="{{ $instanceId }}">
        @endif

        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-4">{{ xe_trans('xe::menu') }}</div>
                            <div class="col-sm-4">{{ xe_trans('xe::description') }}</div>
                            <div class="col-sm-3">{{ xe_trans('xe::on') }}/{{ xe_trans('xe::off') }}</div>
                        </div>
                    </div>
                    <ul class="list-group __xe_sortable_items">
                        @foreach($items as $key => $data)
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-1"><i class="fa fa-arrows-v"></i></div>
                                    <div class="col-sm-4">{{ $data['item']::getName() }}</div>
                                    <div class="col-sm-4">{{ $data['item']::getDescription() }}</div>
                                    <div class="col-sm-3"><input type="checkbox" name="items[]" value="{{ $key }}" @if($data['activated']) checked @endif data-toggle="toggle" data-size="small" data-onstyle="info"></div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div><button type="submit" class="btn btn-primary">{{ xe_trans('xe::save') }}</button></div>

            </div>
            <div class="col-sm-1">&nbsp;</div>
        </div>

    </form>

<script type="text/javascript">
    XE.$(function($) {
        $("#__xe_toggleMenu_{{$typeIdable}}_{{$instanceId}}.__xe_sortable_items").sortable();
        $("#__xe_toggleMenu_{{$typeIdable}}_{{$instanceId}}.__xe_sortable_items").disableSelection();

        $('#__xe_toggleMenu_{{$typeIdable}}_{{$instanceId}}').submit(function () {
            $('<input>').attr('type', 'hidden').attr('name', 'redirect').val(location.href).appendTo(this);
        });
    });
</script>
