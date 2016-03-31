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

                <div class="panel">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-4"><h5>{{ xe_trans('xe::menu') }}</h5></div>
                            <div class="col-sm-4"><h5>{{ xe_trans('xe::description') }}</h5></div>
                            <div class="col-sm-3"><h5>{{ xe_trans('xe::on') }}/{{ xe_trans('xe::off') }}</h5></div>
                        </div>
                    </div>
                    <ul class="list-group __xe_sortable_items">
                        @forelse($items as $key => $data)
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-1"><i class="xi-bullet-point"></i></div>
                                    <div class="col-sm-4">{{ $data['item']::getName() }}</div>
                                    <div class="col-sm-4">{{ $data['item']::getDescription() }}</div>
                                    <div class="col-sm-3"><input type="checkbox" name="items[]" value="{{ $key }}" @if($data['activated']) checked @endif data-toggle="toggle" data-size="small" data-onstyle="info"></div>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-center">
                                <h4>{{ xe_trans('xe::noMenu') }}</h4>
                            </li>
                        @endforelse
                    </ul>
                </div>

                <p>
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary"><i class="xi-download"></i>{{ xe_trans('xe::save') }}</button>
                    </div>
                </p>

            </div>
            <div class="col-sm-1">&nbsp;</div>
        </div>

    </form>

<script type="text/javascript">
    $(function() {

        $("#__xe_toggleMenu_{{$typeIdable}}_{{$instanceId}} .__xe_sortable_items").sortable({handle: ".xi-bullet-point"});
        $("#__xe_toggleMenu_{{$typeIdable}}_{{$instanceId}} .__xe_sortable_items").disableSelection();

        $('#__xe_toggleMenu_{{$typeIdable}}_{{$instanceId}}').submit(function () {
            $('<input>').attr('type', 'hidden').attr('name', 'redirect').val(location.href).appendTo(this);
        });
    });
</script>
